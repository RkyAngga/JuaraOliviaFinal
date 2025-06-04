# VM5 - Dokumentasi Layanan Blockchain Bridge

## Fungsi Utama VM5

VM5 berfungsi sebagai jembatan (bridge) antara sistem database tradisional dan jaringan blockchain. Berikut adalah fungsi-fungsi utamanya:

1. **Sinkronisasi Data**
   - Mengambil data dari database MySQL
   - Memproses dan memformat data untuk blockchain
   - Mengirim data ke VM1 (node blockchain)
   - Memastikan konsistensi data

2. **Manajemen Data**
   - Melacak data yang sudah diproses
   - Mencegah duplikasi data
   - Memvalidasi integritas data
   - Menyimpan riwayat pemrosesan

3. **Integrasi Blockchain**
   - Menyiapkan data untuk blockchain
   - Mengirim transaksi ke jaringan blockchain
   - Memverifikasi status transaksi
   - Menangani kesalahan transaksi

4. **Monitoring dan Logging**
   - Mencatat semua aktivitas sistem
   - Memantau kesehatan layanan
   - Melacak kesalahan dan pengecualian
   - Menyediakan metrik performa

## Arsitektur Sistem

### Struktur Direktori
```
blockchain_bridge/
├── app/
│   ├── __init__.py      # Inisialisasi aplikasi Flask dan rute
│   ├── config.py        # Pengaturan konfigurasi
│   ├── database.py      # Koneksi database dan operasi
│   └── services.py      # Implementasi layanan blockchain
├── migrations/
│   └── create_last_processed_data_table.sql
├── logs/
│   └── blockchain_bridge.log
├── venv/                # Lingkungan virtual Python
├── run.py              # Titik masuk utama aplikasi
├── requirements.txt    # Dependensi Python
└── blockchain-bridge.service  # Konfigurasi layanan Systemd
```

## Source Code

### 1. Titik Masuk Aplikasi (`run.py`)
```python
from flask import Flask, jsonify
from app import create_app
from app.services import BlockchainService
from app.database import Database
import threading
import time
import logging
from datetime import datetime
import sys
import os

# Pastikan direktori logs ada
if not os.path.exists('logs'):
    os.makedirs('logs')

# Konfigurasi logging untuk file dan console
logging.basicConfig(
    level=logging.DEBUG,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('logs/blockchain_bridge.log'),
        logging.StreamHandler(sys.stdout)
    ]
)

logger = logging.getLogger(__name__)

# Inisialisasi aplikasi
app = create_app()
blockchain_service = BlockchainService()
db = Database()

def background_task():
    logger.info("Starting background task")
    while True:
        try:
            logger.info("Processing and distributing data...")
            blockchain_service.process_and_distribute_data()
            logger.info("Data processing completed, waiting for next cycle...")
            time.sleep(60)  # Tunggu 1 menit
        except Exception as e:
            logger.error(f"Error in background task: {str(e)}")
            time.sleep(300)  # Tunggu lebih lama jika error

@app.route('/health', methods=['GET'])
def health_check():
    logger.info("Health check endpoint called")
    return jsonify({"status": "healthy"})

@app.route('/check-data', methods=['GET'])
def check_data():
    logger.info("Check data endpoint called")
    try:
        data = db.fetch_laporan_data()
        if data:
            # Convert datetime objects to string for JSON serialization
            for item in data:
                for key, value in item.items():
                    if isinstance(value, datetime):
                        item[key] = value.strftime("%Y-%m-%d %H:%M:%S")
            
            logger.info(f"Successfully retrieved {len(data)} records")
            return jsonify({
                "status": "success",
                "count": len(data),
                "data": data
            })
        else:
            logger.info("No data found in database")
            return jsonify({
                "status": "success",
                "count": 0,
                "message": "No data found"
            })
    except Exception as e:
        logger.error(f"Error in check_data endpoint: {str(e)}")
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500

@app.route('/show-all-data', methods=['GET'])
def show_all_data():
    logger.info("Show all data endpoint called")
    try:
        data = db.fetch_laporan_data()
        if data:
            # Convert datetime objects to string for JSON serialization
            for item in data:
                for key, value in item.items():
                    if isinstance(value, datetime):
                        item[key] = value.strftime("%Y-%m-%d %H:%M:%S")
            
            logger.info(f"Successfully retrieved {len(data)} records")
            return jsonify({
                "status": "success",
                "count": len(data),
                "data": data
            })
        else:
            logger.info("No data found in database")
            return jsonify({
                "status": "success",
                "count": 0,
                "message": "No data found"
            })
    except Exception as e:
        logger.error(f"Error in show_all_data endpoint: {str(e)}")
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500

if __name__ == '__main__':
    try:
        # Jalankan background task
        logger.info("Starting background task thread")
        thread = threading.Thread(target=background_task)
        thread.daemon = True
        thread.start()
        # Jalankan Flask app
        logger.info("Starting Flask app on http://0.0.0.0:5000")
        print("\n=== Blockchain Bridge Service ===")
        print("Server is running on http://0.0.0.0:5000")
        print("Available endpoints:")
        print("- GET /health        : Health check endpoint")
        print("- GET /check-data    : Check database data")
        print("- GET /show-all-data : Show all data from database")
        print("\nPress Ctrl+C to stop the server")
        print("==============================\n")
        app.run(
            host='0.0.0.0',
            port=5000,
            debug=True,
            use_reloader=False,
            threaded=True
        )
    except KeyboardInterrupt:
        logger.info("Server stopped by user")
        print("\nServer stopped. Goodbye!")
    except Exception as e:
        logger.error(f"Server error: {str(e)}")
        print(f"\nError: {str(e)}")
        sys.exit(1)
```

### 2. Inisialisasi Aplikasi (`app/__init__.py`)
```python
from flask import Flask, jsonify
from app.config import Config
from app.services import BlockchainService
from app.database import Database

def create_app():
    app = Flask(__name__)
    
    # Initialize services
    blockchain_service = BlockchainService()
    db = Database()
    
    @app.route('/', methods=['GET'])
    def index():
        return jsonify({
            "status": "success",
            "message": "Blockchain Bridge API is running",
            "endpoints": {
                "root": "/",
                "health": "/health",
                "check_db": "/check-db",
                "show_data": "/show-data",
                "trigger_sync": "/trigger-sync (POST)"
            }
        })

    @app.route('/check-db', methods=['GET'])
    def check_database():
        try:
            # Test database connection
            cursor = db.connection.cursor()
            cursor.execute("SELECT 1")
            result = cursor.fetchone()
            cursor.close()
            
            if result:
                return jsonify({
                    "status": "success",
                    "message": "Database connection is working",
                    "config": {
                        "host": Config.DB_HOST,
                        "port": Config.DB_PORT,
                        "database": Config.DB_NAME,
                        "user": Config.DB_USER
                    }
                })
            else:
                return jsonify({
                    "status": "error",
                    "message": "Database connection test failed"
                }), 500
                
        except Exception as e:
            return jsonify({
                "status": "error",
                "message": f"Database connection failed: {str(e)}"
            }), 500

    @app.route('/show-data', methods=['GET'])
    def show_data():
        cursor = None
        try:
            # Fetch and return laporan data
            cursor = db.connection.cursor(dictionary=True)
            data = db.fetch_laporan_data()
            return jsonify({
                "status": "success",
                "count": len(data),
                "data": data
            })
        except Exception as e:
            return jsonify({
                "status": "error",
                "message": f"Error fetching data: {str(e)}"
            }), 500
        finally:
            if cursor:
                cursor.close()

    @app.route('/trigger-sync', methods=['POST'])
    def trigger_sync():
        try:
            # Process and send data to VM1
            blockchain_service.process_and_distribute_data()
            return jsonify({
                "status": "success",
                "message": "Data synchronization with VM1 completed successfully"
            })
        except Exception as e:
            return jsonify({
                "status": "error",
                "message": f"Error during data synchronization: {str(e)}"
            }), 500
    
    return app

# Export commonly used components
__all__ = ['create_app', 'BlockchainService', 'Database', 'Config']
```

### 3. Operasi Database (`app/database.py`)
```python
import mysql.connector
from app.config import Config
import logging
from datetime import datetime
import time
import json

class Database:
    def __init__(self):
        self.connection = None
        self.connect()
        self.create_tables()

    def connect(self):
        try:
            if self.connection:
                try:
                    self.connection.close()
                except:
                    pass
            
            logging.info(f"Attempting to connect to MySQL at {Config.DB_HOST}:{Config.DB_PORT}")
            self.connection = mysql.connector.connect(
                host=Config.DB_HOST,
                port=Config.DB_PORT,
                database=Config.DB_NAME,
                user=Config.DB_USER,
                password=Config.DB_PASS,
                connection_timeout=30,
                use_pure=True,
                autocommit=True,
                pool_name="mypool",
                pool_size=5,
                consume_results=True
            )
            logging.info("Database connection successful")
        except mysql.connector.Error as err:
            logging.error(f"Error connecting to database: {err}")
            if err.errno == mysql.connector.errorcode.ER_ACCESS_DENIED_ERROR:
                logging.error("Access denied - check username and password")
            elif err.errno == mysql.connector.errorcode.ER_BAD_DB_ERROR:
                logging.error("Database does not exist")
            else:
                logging.error(f"Error: {err}")
            raise

    def create_tables(self):
        cursor = None
        try:
            cursor = self.connection.cursor(buffered=True)
            cursor.execute("DROP TABLE IF EXISTS last_processed_timestamps")
            while cursor.nextset():
                pass
            cursor.execute("""
                CREATE TABLE IF NOT EXISTS last_processed_timestamps (
                    data_id INT PRIMARY KEY,
                    timestamp DATETIME NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            """)
            while cursor.nextset():
                pass
            self.connection.commit()
            logging.info("Created last_processed_timestamps table successfully")
        except Exception as e:
            logging.error(f"Error creating tables: {str(e)}")
            raise
        finally:
            if cursor:
                cursor.close()

    def ensure_connection(self, max_retries=3, retry_delay=1):
        for attempt in range(max_retries):
            try:
                if not self.connection:
                    logging.info("No connection exists, creating new connection...")
                    self.connect()
                    return True
                
                try:
                    cursor = self.connection.cursor(buffered=True)
                    cursor.execute("SELECT 1")
                    cursor.fetchall()
                    cursor.close()
                    logging.info("Connection test successful")
                    return True
                except Exception as e:
                    logging.error(f"Connection test failed: {str(e)}")
                    if attempt < max_retries - 1:
                        logging.info(f"Attempting to reconnect... (Attempt {attempt + 1}/{max_retries})")
                        time.sleep(retry_delay)
                        self.connect()
                    else:
                        raise
            except Exception as e:
                if attempt == max_retries - 1:
                    logging.error(f"Error ensuring connection after {max_retries} attempts: {str(e)}")
                    raise
                time.sleep(retry_delay)
        return False

    def fetch_laporan_data(self):
        cursor = None
        max_retries = 3
        retry_count = 0
        
        while retry_count < max_retries:
            try:
                if not self.ensure_connection():
                    raise Exception("Failed to establish database connection")
                
                cursor = self.connection.cursor(dictionary=True, buffered=True)
                query = """
                    SELECT 
                        lp.id as laporan_id,
                        lp.masyarakat_id,
                        lp.dinas_id,
                        lp.lokasi,
                        lp.latitude,
                        lp.longitude,
                        lp.deskripsi,
                        lp.status,
                        lp.timestamp,
                        lp.created_at,
                        tl.tracking_id,
                        tl.status as tracking_status,
                        tl.sub_status,
                        tl.keterangan,
                        tl.id_admin,
                        tl.created_at as tracking_created_at,
                        pl.penyelesaian_laporan_id,
                        pl.tanggal_mulai,
                        pl.tanggal_selesai,
                        pl.status as penyelesaian_status,
                        pl.alasan_penolakan,
                        pl.created_at as penyelesaian_created_at
                    FROM laporan_pengaduan lp
                    LEFT JOIN tracking_laporan tl ON lp.id = tl.pengaduan_id
                    LEFT JOIN penyelesaian_laporan pl ON lp.id = pl.pengaduan_id
                    ORDER BY lp.created_at DESC
                """
                logging.info("Executing query...")
                cursor.execute(query)
                results = cursor.fetchall()
                logging.info(f"Query returned {len(results)} results")
                return results
            except mysql.connector.Error as err:
                retry_count += 1
                logging.error(f"Error fetching data (attempt {retry_count}/{max_retries}): {err}")
                if retry_count < max_retries:
                    logging.info("Retrying connection...")
                    time.sleep(1)
                    self.connect()
                else:
                    logging.error("Max retries reached, giving up")
                    return []
            finally:
                if cursor:
                    cursor.close()

    def update_last_processed_timestamp(self, data_id, timestamp):
        cursor = None
        try:
            if not self.ensure_connection():
                raise Exception("Failed to establish database connection")
                
            query = "UPDATE last_processed_timestamps SET timestamp = %s WHERE data_id = %s"
            cursor = self.connection.cursor(buffered=True)
            cursor.execute(query, (timestamp, data_id))
            while cursor.nextset():
                pass
            self.connection.commit()
            logging.info(f"Updated last processed timestamp for data ID {data_id} to {timestamp}")
        except Exception as e:
            logging.error(f"Error updating last processed timestamp: {str(e)}")
            raise
        finally:
            if cursor:
                cursor.close()

    def get_last_processed_timestamp(self, data_id):
        cursor = None
        try:
            if not self.ensure_connection():
                raise Exception("Failed to establish database connection")
                
            query = "SELECT timestamp FROM last_processed_timestamps WHERE data_id = %s"
            cursor = self.connection.cursor(buffered=True)
            cursor.execute(query, (data_id,))
            result = cursor.fetchone()
            cursor.fetchall()
            if result:
                return result[0]
            else:
                return datetime(1970, 1, 1, 0, 0, 0)
        except Exception as e:
            logging.error(f"Error retrieving last processed timestamp: {str(e)}")
            return datetime(1970, 1, 1, 0, 0, 0)
        finally:
            if cursor:
                cursor.close()

    def close(self):
        if self.connection:
            try:
                self.connection.close()
                logging.info("Database connection closed successfully")
            except Exception as e:
                logging.error(f"Error closing database connection: {str(e)}")

    def get_last_processed_data(self, laporan_id):
        try:
            query = """
                SELECT * FROM last_processed_data 
                WHERE laporan_id = %s
            """
            self.cursor.execute(query, (laporan_id,))
            result = self.cursor.fetchone()
            return result
        except Exception as e:
            logging.error(f"Error getting last processed data: {str(e)}")
            return None

    def store_last_processed_data(self, laporan_id, data):
        try:
            data_json = json.dumps(data)
            
            query = """
                SELECT laporan_id FROM last_processed_data 
                WHERE laporan_id = %s
            """
            self.cursor.execute(query, (laporan_id,))
            exists = self.cursor.fetchone()
            
            if exists:
                query = """
                    UPDATE last_processed_data 
                    SET data = %s, processed_at = NOW()
                    WHERE laporan_id = %s
                """
                self.cursor.execute(query, (data_json, laporan_id))
            else:
                query = """
                    INSERT INTO last_processed_data 
                    (laporan_id, data, processed_at)
                    VALUES (%s, %s, NOW())
                """
                self.cursor.execute(query, (laporan_id, data_json))
            
            self.connection.commit()
            logging.info(f"Stored last processed data for laporan ID {laporan_id}")
        except Exception as e:
            logging.error(f"Error storing last processed data: {str(e)}")
            raise
```

### 4. Layanan Blockchain (`app/services.py`)
```python
import requests
import logging
from app.config import Config
from app.database import Database
from decimal import Decimal
from datetime import datetime
import time

class BlockchainService:
    def __init__(self):
        self.db = Database()
        self.setup_logging()

    def setup_logging(self):
        logging.basicConfig(
            filename='logs/blockchain_bridge.log',
            level=logging.INFO,
            format='%(asctime)s - %(levelname)s - %(message)s'
        )

    def process_and_distribute_data(self):
        try:
            # Fetch data from database
            laporan_data = self.db.fetch_laporan_data()
            
            for laporan in laporan_data:
                # Check if the data is new or has changed
                if self.is_data_new_or_changed(laporan):
                    # Format data
                    formatted_data = self.format_data(laporan)
                    # Send to VM1 for blockchain
                    self.send_to_vm('vm1', formatted_data)
                    # Store the last processed timestamp
                    self.store_last_processed_timestamp(laporan['laporan_id'], laporan['timestamp'])
                    # Log success
                    logging.info(f"Successfully processed and sent laporan ID: {laporan['laporan_id']}")
                else:
                    logging.info(f"Skipping laporan ID: {laporan['laporan_id']} as it has not changed.")
        except Exception as e:
            logging.error(f"Error in process_and_distribute_data: {str(e)}")
            raise

    def is_data_new_or_changed(self, data):
        try:
            # Get last processed data
            last_processed_data = self.db.get_last_processed_data(data['laporan_id'])
            
            # If no last processed data, consider it new
            if last_processed_data is None:
                return True
            
            # Check if any important fields have changed
            important_fields = [
                'status', 'deskripsi', 'lokasi', 'latitude', 'longitude',
                'penyelesaian_status', 'penyelesaian_created_at',
                'tracking_status', 'tracking_created_at'
            ]
            
            for field in important_fields:
                if data.get(field) != last_processed_data.get(field):
                    logging.info(f"Field {field} changed for laporan ID {data['laporan_id']}")
                    return True
            
            return False
        except Exception as e:
            logging.error(f"Error checking data changes: {str(e)}")
            return True

    def store_last_processed_timestamp(self, data_id, timestamp):
        try:
            self.db.update_last_processed_timestamp(data_id, timestamp)
            logging.info(f"Stored last processed timestamp for data ID {data_id}: {timestamp}")
        except Exception as e:
            logging.error(f"Error storing last processed timestamp: {str(e)}")
            raise

    def get_last_processed_timestamp(self, data_id):
        try:
            return self.db.get_last_processed_timestamp(data_id)
        except Exception as e:
            logging.error(f"Error getting last processed timestamp: {str(e)}")
            return datetime(1970, 1, 1, 0, 0, 0)

    def format_data(self, data):
        try:
            # Convert Decimal to float for latitude and longitude
            latitude = float(data['latitude']) if isinstance(data['latitude'], Decimal) else data['latitude']
            longitude = float(data['longitude']) if isinstance(data['longitude'], Decimal) else data['longitude']
            
            # Format timestamps
            timestamp = data['timestamp'].strftime("%a, %d %b %Y %H:%M:%S GMT") if data['timestamp'] else None
            created_at = data['created_at'].strftime("%a, %d %b %Y %H:%M:%S GMT") if data['created_at'] else None
            penyelesaian_created_at = data.get('penyelesaian_created_at').strftime("%a, %d %b %Y %H:%M:%S GMT") if data.get('penyelesaian_created_at') else None
            tracking_created_at = data.get('tracking_created_at').strftime("%a, %d %b %Y %H:%M:%S GMT") if data.get('tracking_created_at') else None
            tanggal_mulai = data.get('tanggal_mulai').strftime("%a, %d %b %Y %H:%M:%S GMT") if data.get('tanggal_mulai') else None
            tanggal_selesai = data.get('tanggal_selesai').strftime("%a, %d %b %Y %H:%M:%S GMT") if data.get('tanggal_selesai') else None
            
            # Create formatted data
            formatted_data = {
                "index": data['laporan_id'],
                "timestamp": time.time(),
                "data": {
                    "source": "VM5",
                    "type": "laporan",
                    "content": {
                        'alasan_penolakan': data.get('alasan_penolakan'),
                        'created_at': created_at,
                        'deskripsi': data['deskripsi'],
                        'dinas_id': data['dinas_id'],
                        'id': data['laporan_id'],
                        'id_admin': data.get('id_admin'),
                        'keterangan': data.get('keterangan'),
                        'latitude': str(latitude),
                        'lokasi': data['lokasi'],
                        'longitude': str(longitude),
                        'masyarakat_id': data['masyarakat_id'],
                        'penyelesaian_created_at': penyelesaian_created_at,
                        'penyelesaian_laporan_id': data.get('penyelesaian_laporan_id'),
                        'penyelesaian_status': data.get('penyelesaian_status'),
                        'status': data['status'],
                        'sub_status': data.get('sub_status'),
                        'tanggal_mulai': tanggal_mulai,
                        'tanggal_selesai': tanggal_selesai,
                        'timestamp': timestamp,
                        'tracking_created_at': tracking_created_at,
                        'tracking_id': data.get('tracking_id'),
                        'tracking_status': data.get('tracking_status')
                    }
                }
            }
            
            logging.info(f"Formatted data: {formatted_data}")
            return formatted_data
        except Exception as e:
            logging.error(f"Error formatting data: {str(e)}")
            raise

    def send_to_vm(self, vm_name, data):
        vm_config = getattr(Config, vm_name.upper())
        try:
            logging.info(f"Sending data to {vm_name} at {vm_config['url']}/api/blockchain")
            logging.info(f"Data to send: {data}")
            
            response = requests.post(
                f"{vm_config['url']}/api/blockchain",
                json=data,
                headers={
                    'Authorization': f"Bearer {vm_config['api_key']}",
                    'Content-Type': 'application/json'
                },
                timeout=30
            )
            
            logging.info(f"Response status code: {response.status_code}")
            logging.info(f"Response content: {response.text}")
            
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            logging.error(f"Error sending data to {vm_name}: {str(e)}")
            logging.error(f"Request details: URL={vm_config['url']}/api/blockchain, Headers={{'Authorization': 'Bearer ***', 'Content-Type': 'application/json'}}")
            raise
```

### 5. Konfigurasi (`app/config.py`)
```python
import os
from dotenv import load_dotenv

load_dotenv()

class Config:
    # Database Configuration
    DB_HOST = '127.0.0.1'
    DB_PORT = '3306'
    DB_NAME = 'juaraolivia_db'
    DB_USER = 'laraveluser'
    DB_PASS = 'Pa$$w0rdLaravel!'

    # VM Configurations
    VM1 = {
        'url': 'http://10.41.99.202:5000',
        'api_key': 'blockchain_secret_key_123'
    }
```

### 6. Konfigurasi Layanan Systemd (`blockchain-bridge.service`)
```ini
[Unit]
Description=Blockchain Bridge Service
After=network.target

[Service]
User=ninja5
WorkingDirectory=/home/ninja5/blockchain_bridge
Environment="PATH=/home/ninja5/blockchain_bridge/venv/bin"
ExecStart=/home/ninja5/blockchain_bridge/venv/bin/python run.py
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

### 7. Migrasi Database (`migrations/create_last_processed_data_table.sql`)
```sql
CREATE TABLE IF NOT EXISTS last_processed_data (
    laporan_id INT PRIMARY KEY,
    data JSON,
    processed_at DATETIME,
    FOREIGN KEY (laporan_id) REFERENCES laporan(id)
);
```

## Skema Database

### Tabel Utama
1. `laporan_pengaduan`
   - Tabel utama untuk data laporan
   - Berisi informasi inti laporan

2. `tracking_laporan`
   - Melacak status dan pembaruan laporan
   - Terhubung ke `laporan_pengaduan`

3. `penyelesaian_laporan`
   - Menyimpan informasi penyelesaian laporan
   - Terhubung ke `laporan_pengaduan`

4. `last_processed_timestamps`
   - Melacak data terakhir yang diproses
   - Mencegah pemrosesan duplikat

5. `last_processed_data`
   ```sql
   CREATE TABLE IF NOT EXISTS last_processed_data (
       laporan_id INT PRIMARY KEY,
       data JSON,
       processed_at DATETIME,
       FOREIGN KEY (laporan_id) REFERENCES laporan(id)
   );
   ```

## Manajemen Layanan

### Konfigurasi Layanan Systemd
```ini
[Unit]
Description=Blockchain Bridge Service
After=network.target

[Service]
User=ninja5
WorkingDirectory=/home/ninja5/blockchain_bridge
Environment="PATH=/home/ninja5/blockchain_bridge/venv/bin"
ExecStart=/home/ninja5/blockchain_bridge/venv/bin/python run.py
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

## Alur Data

1. **Pengumpulan Data**
   - Layanan secara terus menerus memantau database untuk catatan baru atau yang diperbarui
   - Data diambil dari tabel `laporan_pengaduan` dan tabel terkait

2. **Pemrosesan Data**
   - Validasi integritas data
   - Pemformatan untuk kompatibilitas blockchain
   - Pelacakan timestamp untuk mencegah pemrosesan duplikat

3. **Distribusi Data**
   - Data yang diformat dikirim ke VM1 untuk integrasi blockchain
   - Konfirmasi distribusi yang berhasil
   - Penanganan kesalahan dan mekanisme pengulangan

## Penanganan Kesalahan dan Pemulihan

1. **Kesalahan Database**
   - Koneksi ulang otomatis
   - Mekanisme pengulangan
   - Pencatatan log kesalahan

2. **Kesalahan Layanan**
   - Degradasi yang elegan
   - Pemulihan otomatis
   - Pelaporan kesalahan

3. **Kesalahan Jaringan**
   - Logika pengulangan permintaan
   - Penanganan timeout
   - Manajemen koneksi

## Pemantauan dan Pemeliharaan

1. **Pemeriksaan Kesehatan**
   - Pemantauan kesehatan layanan secara berkala
   - Verifikasi koneksi database
   - Ketersediaan endpoint API

2. **Pencatatan Log**
   - Pencatatan log kesalahan yang komprehensif
   - Metrik performa
   - Pelacakan operasi

3. **Pemeliharaan**
   - Pembersihan database berkala
   - Rotasi log
   - Pembaruan layanan

## Fitur Keamanan

1. **Keamanan API**
   - Autentikasi kunci API
   - Saluran komunikasi yang aman
   - Validasi permintaan

2. **Keamanan Database**
   - Penanganan koneksi yang aman
   - Manajemen kredensial
   - Kontrol akses

3. **Keamanan Data**
   - Validasi data
   - Sanitasi input
   - Penanganan kesalahan

## Optimasi Performa

1. **Optimasi Database**
   - Kumpulan koneksi
   - Optimasi query
   - Mekanisme caching

2. **Optimasi Layanan**
   - Pemrosesan tugas latar belakang
   - Penanganan data yang efisien
   - Manajemen sumber daya

## Peningkatan Masa Depan

1. **Skalabilitas**
   - Kemampuan penskalaan horizontal
   - Load balancing
   - Pemrosesan terdistribusi

2. **Fitur**
   - Pemantauan yang ditingkatkan
   - Analitik lanjutan
   - Integrasi blockchain tambahan

3. **Keamanan**
   - Autentikasi yang ditingkatkan
   - Enkripsi lanjutan
   - Pencatatan log audit

## Persyaratan Teknis

### Persyaratan Sistem
- Sistem operasi berbasis Linux
- Python 3.x
- MySQL/MariaDB
- Systemd

### Dependensi
- Flask
- MySQL-connector-python
- Requests
- Python-dotenv

### Persyaratan Jaringan
- Akses ke VM1 (Node Blockchain)
- Konektivitas database
- Aksesibilitas endpoint API