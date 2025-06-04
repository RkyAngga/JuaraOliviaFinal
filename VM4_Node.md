# Dokumentasi Node Blockchain VM4

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Tujuan dan Peran VM4](#tujuan-dan-peran-vm4)
3. [Struktur Sistem](#struktur-sistem)
4. [Arsitektur Node](#arsitektur-node)
5. [Komponen Utama](#komponen-utama)
6. [Alur Kerja](#alur-kerja)
7. [API Endpoints](#api-endpoints)
8. [Keamanan](#keamanan)
9. [Penyimpanan Data](#penyimpanan-data)
10. [Sistem Database](#sistem-database)
11. [Fitur Tambahan](#fitur-tambahan)
12. [Pengujian dan Monitoring](#pengujian-dan-monitoring)

## Pendahuluan

Node VM4 (IP: 10.41.99.225) adalah node peer dalam jaringan blockchain yang beroperasi pada port 5003. Node ini merupakan bagian dari sistem blockchain terdistribusi yang bekerja sama dengan node master (VM1) untuk menjaga integritas blockchain dan berpartisipasi dalam mekanisme konsensus.

### Stack Teknologi
- **Framework Web**: Flask 3.0.2
- **Database**: MySQL dengan SQLAlchemy 2.0.27
- **Driver Database**: PyMySQL 1.1.0
- **Keamanan**: Cryptography 42.0.2
- **Konfigurasi**: python-dotenv 1.0.1

## Tujuan dan Peran VM4

### 1. Peran dalam Jaringan Blockchain
- Berfungsi sebagai node peer yang berpartisipasi dalam jaringan blockchain
- Menjaga salinan lokal blockchain yang terdistribusi
- Berpartisipasi dalam mekanisme konsensus jaringan
- Memvalidasi dan memverifikasi transaksi
- Menyediakan redundansi data untuk keamanan jaringan

### 2. Fungsi Utama
1. **Sinkronisasi Data**
   - Menjaga konsistensi dengan node master (VM1)
   - Memastikan salinan blockchain selalu up-to-date
   - Menangani sinkronisasi otomatis dan manual

2. **Validasi dan Verifikasi**
   - Memvalidasi blok baru yang diterima
   - Memverifikasi integritas blockchain
   - Memastikan konsistensi data antar node

3. **Penyimpanan Data**
   - Menyimpan salinan lengkap blockchain
   - Mengelola penyimpanan transaksi
   - Menjaga redundansi data

4. **Komunikasi Jaringan**
   - Berkomunikasi dengan node master
   - Berinteraksi dengan node peer lainnya
   - Menyediakan API untuk akses data

### 3. Manfaat dan Kontribusi
- Meningkatkan keamanan jaringan melalui distribusi data
- Menyediakan redundansi untuk mencegah kehilangan data
- Meningkatkan performa jaringan melalui load balancing
- Memfasilitasi akses lokal ke data blockchain

## Struktur Sistem

### Struktur Direktori
```
├── app/                    # Direktori aplikasi utama
│   ├── api/               # Endpoint dan rute API
│   ├── blockchain/        # Implementasi inti blockchain
│   ├── database/          # Model dan konfigurasi database
│   ├── models/            # Model data
│   ├── services/          # Layanan logika bisnis
│   ├── scripts/           # Script utilitas
│   ├── __init__.py        # Inisialisasi aplikasi
│   └── config.py          # Pengaturan konfigurasi
├── blocks/                # Penyimpanan blockchain lokal
├── config/                # File konfigurasi
├── data/                  # Penyimpanan data
├── docs/                  # Dokumentasi
├── logs/                  # Log aplikasi
├── scripts/               # Script sistem
├── tests/                 # Kasus pengujian
├── venv/                  # Lingkungan virtual Python
├── block-sync.service     # Layanan systemd untuk sinkronisasi blok
├── requirements.txt       # Dependensi Python
└── run.py                 # Titik masuk aplikasi
```

## Arsitektur Node

### Konfigurasi Node
```python
# Konfigurasi Node Master (VM1)
MASTER_NODE = {
    'ip': '10.41.99.202',
    'port': 5000,
    'api_key': 'blockchain_secret_key_123'
}

# Konfigurasi Node Peer (VM4)
NODE_CONFIG = {
    'ip': '10.41.99.225',
    'port': 5003,
    'api_key': 'blockchain_secret_key_123',
    'role': 'peer'
}
```

## Komponen Utama

### 1. Implementasi Blockchain
Node menyimpan salinan lokal blockchain di direktori `blocks/`, di mana setiap blok disimpan sebagai file JSON. Implementasi blockchain mencakup:
- Struktur dan validasi blok
- Mekanisme konsensus
- Sinkronisasi blok dengan node master
- Pemrosesan transaksi

### 2. Lapisan API
Lapisan API (`app/api/`) menyediakan endpoint untuk:
- Sinkronisasi blok
- Pengiriman transaksi
- Kueri status blockchain
- Komunikasi antar node

### 3. Lapisan Database
Lapisan database (`app/database/`) mengelola:
- Penyimpanan transaksi
- Metadata blok
- Informasi status node
- Status jaringan

### 4. Layanan
Lapisan layanan (`app/services/`) mengimplementasikan:
- Layanan sinkronisasi blok
- Validasi transaksi
- Komunikasi jaringan
- Partisipasi dalam konsensus

## Alur Kerja

### 1. Inisialisasi Node
1. Node VM4 dijalankan melalui `run.py`
2. Sistem memuat konfigurasi dari `config.py`
3. Koneksi database diinisialisasi
4. API endpoints didaftarkan
5. Layanan sinkronisasi blok diaktifkan

### 2. Sinkronisasi dengan Node Master
1. Node VM4 secara berkala memeriksa status Node Master (VM1)
2. Meminta daftar blok terbaru dari VM1
3. Memvalidasi blok-blok yang diterima
4. Mengintegrasikan blok baru ke dalam rantai lokal
5. Menyimpan blok dalam format JSON di direktori `blocks/`

### 3. Pemrosesan Transaksi
1. Menerima transaksi baru melalui API
2. Memvalidasi format dan tanda tangan transaksi
3. Menyimpan transaksi dalam database lokal
4. Mengirim transaksi ke Node Master untuk diproses
5. Menunggu konfirmasi dari Node Master

## API Endpoints

### 1. Blockchain Operations
```python
@api.route('/blockchain', methods=['GET', 'POST'])
def handle_blockchain():
    # GET: Retrieve entire blockchain
    # POST: Add new block to chain

@api.route('/chain', methods=['GET'])
def get_chain():
    # GET: Retrieve blockchain

@api.route('/blockchain/status', methods=['GET'])
def get_status():
    # GET: Get blockchain status
```

### 2. Block Processing
```python
@api.route('/process', methods=['POST'])
def process_block():
    # POST: Process new block

@api.route('/blockchain', methods=['POST'])
def receive_block():
    # POST: Receive and store blocks directly
```

### 3. Synchronization
```python
@api.route('/sync', methods=['POST'])
def sync_chain():
    # POST: Synchronize with master node

@api.route('/blockchain/sync-db', methods=['POST'])
def sync_blocks_to_db():
    # POST: Sync blocks to database
```

## Keamanan

### 1. Autentikasi
- API Key validation untuk setiap request
- Enkripsi komunikasi antar node
- Verifikasi tanda tangan digital

### 2. Validasi Data
- Verifikasi hash blok
- Validasi transaksi
- Pencegahan serangan replay
- Proteksi dari serangan DoS

## Penyimpanan Data

### 1. Struktur Database
```python
class Block(Base):
    __tablename__ = 'blocks'
    
    id = Column(Integer, primary_key=True)
    block_index = Column(Integer, unique=True)
    hash = Column(String(255))
    previous_hash = Column(String(255))
    timestamp = Column(Float)
    data = Column(JSON)
    created_at = Column(String(255))
```

### 2. Penyimpanan File
- Blok disimpan sebagai file JSON di `blocks/`
- State blockchain disimpan di `state.json`
- Log aplikasi di direktori `logs/`

## Sistem Database

### 1. Arsitektur Database

#### 1.1 Konfigurasi Database (config/database.py)
```python
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
import os
from dotenv import load_dotenv

load_dotenv()

# Database Configuration
DB_USER = os.getenv('DB_USER', 'root')
DB_PASSWORD = os.getenv('DB_PASSWORD', '')
DB_HOST = os.getenv('DB_HOST', 'localhost')
DB_NAME = os.getenv('DB_NAME', 'blockchain_db')

DATABASE_URL = f"mysql+pymysql://{DB_USER}:{DB_PASSWORD}@{DB_HOST}/{DB_NAME}"

# Engine Configuration
engine = create_engine(
    DATABASE_URL,
    pool_pre_ping=True,
    pool_recycle=3600,
    pool_size=5,
    max_overflow=10,
    echo=True,
    connect_args={
        'connect_timeout': 10,
        'read_timeout': 30,
        'write_timeout': 30
    }
)

# Session Configuration
SessionLocal = sessionmaker(
    autocommit=False,
    autoflush=False,
    bind=engine,
    expire_on_commit=False
)
```

### 2. Model Database

#### 2.1 Model Definitions (app/database/models.py)
```python
from sqlalchemy import Column, Integer, String, JSON, Float, ForeignKey, DateTime
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import relationship
from datetime import datetime

Base = declarative_base()

class Block(Base):
    __tablename__ = 'blocks'
    
    id = Column(Integer, primary_key=True)
    block_index = Column(Integer, unique=True)
    hash = Column(String(255), unique=True)
    previous_hash = Column(String(255))
    timestamp = Column(Float)
    data = Column(JSON)
    created_at = Column(String(255))
    
    # Relationships
    transactions = relationship("Transaction", back_populates="block")
    
    def __repr__(self):
        return f"<Block(index={self.block_index}, hash={self.hash})>"

class Transaction(Base):
    __tablename__ = 'transactions'
    
    id = Column(Integer, primary_key=True)
    transaction_hash = Column(String(255), unique=True)
    block_hash = Column(String(255), ForeignKey('blocks.hash'))
    sender = Column(String(255))
    receiver = Column(String(255))
    amount = Column(Float)
    timestamp = Column(Float)
    status = Column(String(50))
    created_at = Column(String(255))
    
    # Relationships
    block = relationship("Block", back_populates="transactions")
    
    def __repr__(self):
        return f"<Transaction(hash={self.transaction_hash}, status={self.status})>"
```

### 3. Database Connection Management

#### 3.1 Connection Handler (app/database/connection.py)
```python
from sqlalchemy import create_engine, text
from sqlalchemy.orm import sessionmaker, scoped_session
from sqlalchemy.exc import SQLAlchemyError
import logging
from contextlib import contextmanager
from config.database import DATABASE_URL, engine
from app.database.models import Base

logger = logging.getLogger(__name__)

def init_db():
    """Initialize database tables"""
    try:
        Base.metadata.create_all(bind=engine)
        logger.info("Database tables created successfully")
    except SQLAlchemyError as e:
        logger.error(f"Failed to create database tables: {str(e)}")
        raise

@contextmanager
def get_db():
    """Database session context manager"""
    session = SessionLocal()
    try:
        # Test connection
        session.execute(text("SELECT 1"))
        logger.info("Database connection test successful")
        
        yield session
        session.commit()
        logger.info("Database transaction committed successfully")
    except SQLAlchemyError as e:
        session.rollback()
        logger.error(f"Database session error: {str(e)}")
        raise
    except Exception as e:
        session.rollback()
        logger.error(f"Unexpected error in database session: {str(e)}")
        raise
    finally:
        session.close()
        SessionLocal.remove()
```

### 4. Blockchain Database Operations

#### 4.1 Block Operations (app/blockchain/blockchain.py)
```python
import os
import json
import time
import requests
from .block import Block
from datetime import datetime
from app.config import Config
import logging
from flask import jsonify
from app.database.connection import get_db, init_db
from app.database.models import Block as DBBlock

class Blockchain:
    def __init__(self):
        self.chain_file = 'data/blockchain/chain.json'
        self.blocks_dir = 'data/blockchain/blocks'
        self.state_file = 'data/blockchain/state.json'
        self.chain = []
        self.ensure_data_directory()
        init_db()
        self.load_chain()
        self.sync_with_master()

    def ensure_data_directory(self):
        os.makedirs(self.blocks_dir, exist_ok=True)
        if not os.path.exists(self.state_file):
            with open(self.state_file, 'w') as f:
                json.dump({
                    "last_block_index": 0,
                    "total_blocks": 0,
                    "last_hash": "0",
                    "chain_valid": True,
                    "last_update": datetime.now().isoformat()
                }, f)

    def load_chain(self):
        if os.path.exists(self.chain_file):
            with open(self.chain_file, 'r') as f:
                data = json.load(f)
                if isinstance(data, dict) and 'chain' in data:
                    self.chain = data['chain']
                else:
                    self.chain = data
                self.save_all_blocks()

    def save_chain(self):
        try:
            self.save_all_blocks()
            with open(self.chain_file, 'w') as f:
                json.dump({"chain": self.chain}, f)
                logging.info(f"Successfully saved chain with {len(self.chain)} blocks")
        except Exception as e:
            logging.error(f"Error saving chain: {str(e)}")
            raise

    def save_all_blocks(self):
        try:
            for block in self.chain:
                if not isinstance(block, dict):
                    logging.warning(f"Invalid block format: {block}")
                    continue
                if 'index' not in block:
                    logging.warning(f"Block missing index: {block}")
                    continue
                block_file = os.path.join(self.blocks_dir, f"block_{block['index']}.json")
                try:
                    with open(block_file, 'w') as f:
                        json.dump(block, f, indent=4)
                        logging.info(f"Successfully saved block {block['index']}")
                except Exception as e:
                    logging.error(f"Error saving block {block['index']}: {str(e)}")
                    raise
        except Exception as e:
            logging.error(f"Error in save_all_blocks: {str(e)}")
            raise

    def add_block(self, block_data):
        try:
            logging.info(f"add_block called with data: {block_data}")
            if not self.chain:
                previous_hash = "0"
                index = 0
            else:
                previous_hash = self.chain[-1]["hash"]
                index = len(self.chain)

            if isinstance(block_data, dict) and 'data' in block_data:
                data = block_data
            else:
                data = {
                    'data': block_data,
                    'timestamp': time.time()
                }

            new_block = Block(index, data, time.time(), previous_hash)
            if self.is_block_valid(new_block):
                block_dict = new_block.to_dict()
                self.chain.append(block_dict)
                
                block_file = os.path.join(self.blocks_dir, f"block_{index}.json")
                with open(block_file, 'w') as f:
                    json.dump(block_dict, f, indent=4)
                
                self.save_block_to_db(block_dict)
                self.update_state()
                logging.info(f"Block {index} created successfully: {block_dict}")
                return new_block
            else:
                logging.warning(f"Block {index} is not valid")
                return None
        except Exception as e:
            logging.error(f"Error adding block: {str(e)}")
            raise

    def is_block_valid(self, block):
        if not self.chain:
            return block.previous_hash == "0"
        
        previous_block = self.chain[-1]
        
        if block.index != len(self.chain):
            logging.warning(f"Invalid block index. Expected {len(self.chain)}, got {block.index}")
            return False
            
        if block.previous_hash != previous_block["hash"]:
            logging.warning(f"Invalid previous hash")
            return False
            
        if block.hash != block.calculate_hash():
            logging.warning(f"Invalid block hash")
            return False
            
        return True

    def sync_with_master(self):
        try:
            logging.info(f"Attempting to sync with master node")
            status_response = requests.get(
                f"http://{Config.MASTER_NODE['ip']}:{Config.MASTER_NODE['port']}/api/blockchain/status",
                headers={'Authorization': f"Bearer {Config.MASTER_NODE['api_key']}"},
                timeout=10
            )
            
            if status_response.status_code == 200:
                status_data = status_response.json()
                master_total_blocks = status_data.get('total_blocks', 0)
                
                if master_total_blocks > len(self.chain):
                    chain_response = requests.get(
                        f"http://{Config.MASTER_NODE['ip']}:{Config.MASTER_NODE['port']}/api/chain",
                        headers={'Authorization': f"Bearer {Config.MASTER_NODE['api_key']}"},
                        timeout=30
                    )
                    
                    if chain_response.status_code == 200:
                        chain_data = chain_response.json()
                        master_chain = chain_data['chain'] if isinstance(chain_data, dict) and 'chain' in chain_data else chain_data
                        
                        self.chain = master_chain
                        self.save_chain()
                        
                        for block in master_chain:
                            self.save_block_to_db(block)
                        
                        self.update_state()
                        return True
                    else:
                        logging.error(f"Failed to get blockchain from master")
                else:
                    logging.info("Chain is already up to date")
            else:
                logging.error(f"Failed to get blockchain status from master")
                
        except Exception as e:
            logging.error(f"Error syncing with master: {str(e)}")
            
        return False

    def get_chain(self):
        return self.chain

    def get_status(self):
        return {
            "total_blocks": len(self.chain),
            "last_block_index": len(self.chain) - 1 if self.chain else 0,
            "last_hash": self.chain[-1]["hash"] if self.chain else "0",
            "chain_valid": True
        }
```

### 5. Database Maintenance Scripts

#### 5.1 Database Maintenance (app/scripts/db_maintenance.py)
```python
import logging
from sqlalchemy import text
from app.database.connection import get_db, engine
from datetime import datetime, timedelta

def cleanup_old_data(days_to_keep=30):
    """Clean up old data from database"""
    try:
        with get_db() as db:
            # Delete old transactions
            cutoff_date = (datetime.now() - timedelta(days=days_to_keep)).isoformat()
            db.execute(
                text("DELETE FROM transactions WHERE created_at < :cutoff"),
                {"cutoff": cutoff_date}
            )
            
            # Delete orphaned blocks
            db.execute(
                text("DELETE FROM blocks WHERE id NOT IN (SELECT DISTINCT block_id FROM transactions)")
            )
            
            db.commit()
            logging.info("Database cleanup completed successfully")
    except Exception as e:
        logging.error(f"Error during database cleanup: {str(e)}")
        raise

def optimize_database():
    """Optimize database tables and indexes"""
    try:
        with engine.connect() as conn:
            # Optimize tables
            conn.execute(text("OPTIMIZE TABLE blocks"))
            conn.execute(text("OPTIMIZE TABLE transactions"))
            
            # Analyze tables
            conn.execute(text("ANALYZE TABLE blocks"))
            conn.execute(text("ANALYZE TABLE transactions"))
            
            logging.info("Database optimization completed successfully")
    except Exception as e:
        logging.error(f"Error during database optimization: {str(e)}")
        raise

def backup_database():
    """Create database backup"""
    try:
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        backup_file = f"backup_{timestamp}.sql"
        
        # Create backup using mysqldump
        os.system(f"mysqldump -u {DB_USER} -p{DB_PASSWORD} {DB_NAME} > {backup_file}")
        
        logging.info(f"Database backup created: {backup_file}")
    except Exception as e:
        logging.error(f"Error creating database backup: {str(e)}")
        raise
```

### 6. Database Monitoring

#### 6.1 Monitoring Script (app/scripts/db_monitoring.py)
```python
import logging
from sqlalchemy import text
from app.database.connection import get_db, engine
import psutil
import time

def monitor_database_performance():
    """Monitor database performance metrics"""
    try:
        with get_db() as db:
            # Get database size
            size_result = db.execute(
                text("SELECT SUM(data_length + index_length) FROM information_schema.tables WHERE table_schema = :db_name"),
                {"db_name": DB_NAME}
            ).scalar()
            
            # Get table statistics
            stats = db.execute(
                text("""
                    SELECT table_name, table_rows, data_length, index_length
                    FROM information_schema.tables
                    WHERE table_schema = :db_name
                """),
                {"db_name": DB_NAME}
            ).fetchall()
            
            # Get connection count
            connections = db.execute(
                text("SHOW STATUS WHERE Variable_name = 'Threads_connected'")
            ).scalar()
            
            logging.info(f"Database size: {size_result} bytes")
            logging.info(f"Active connections: {connections}")
            logging.info("Table statistics:")
            for stat in stats:
                logging.info(f"  {stat.table_name}: {stat.table_rows} rows")
            
    except Exception as e:
        logging.error(f"Error monitoring database: {str(e)}")
        raise

def check_database_health():
    """Check database health and performance"""
    try:
        with get_db() as db:
            # Check connection
            db.execute(text("SELECT 1"))
            
            # Check table status
            db.execute(text("CHECK TABLE blocks, transactions"))
            
            # Check for long-running queries
            long_queries = db.execute(
                text("""
                    SELECT * FROM information_schema.processlist
                    WHERE time > 10 AND command != 'Sleep'
                """)
            ).fetchall()
            
            if long_queries:
                logging.warning(f"Found {len(long_queries)} long-running queries")
                
            return True
    except Exception as e:
        logging.error(f"Database health check failed: {str(e)}")
        return False
```

## Fitur Tambahan

### 1. Sinkronisasi Otomatis
- Layanan systemd untuk sinkronisasi berkala
- Penanganan kegagalan koneksi
- Retry mechanism untuk operasi gagal

### 2. Monitoring
- Logging aktivitas node
- Pemantauan performa sistem
- Pelacakan kesalahan
- Metrik operasional

## Pengujian dan Monitoring

### 1. Unit Testing
- Test cases di direktori `tests/`
- Validasi komponen individual
- Test integrasi

### 2. Monitoring
- Log aplikasi di `logs/`
- Pemantauan sistem melalui block-sync.service
- Pelacakan dan pelaporan kesalahan

### 3. Maintenance
- Rotasi log
- Optimasi database
- Manajemen penyimpanan blok
- Pembaruan keamanan
- Pemantauan performa

## Implementasi Blockchain

### 1. Block Implementation (app/blockchain/block.py)
```python
import hashlib
import json
import time

class Block:
    def __init__(self, index, data, timestamp, previous_hash):
        self.index = index
        self.timestamp = timestamp
        self.data = data
        self.previous_hash = previous_hash
        self.hash = self.calculate_hash()

    def calculate_hash(self):
        block_string = json.dumps({
            "index": self.index,
            "timestamp": self.timestamp,
            "data": self.data,
            "previous_hash": self.previous_hash
        }, sort_keys=True).encode()
        return hashlib.sha256(block_string).hexdigest()

    def to_dict(self):
        return {
            "index": self.index,
            "timestamp": self.timestamp,
            "data": self.data,
            "previous_hash": self.previous_hash,
            "hash": self.hash
        }
```

### 2. Blockchain Implementation (app/blockchain/blockchain.py)
```python
import os
import json
import time
import requests
from .block import Block
from datetime import datetime
from app.config import Config
import logging
from flask import jsonify
from app.database.connection import get_db, init_db
from app.database.models import Block as DBBlock

class Blockchain:
    def __init__(self):
        self.chain_file = 'data/blockchain/chain.json'
        self.blocks_dir = 'data/blockchain/blocks'
        self.state_file = 'data/blockchain/state.json'
        self.chain = []
        self.ensure_data_directory()
        init_db()
        self.load_chain()
        self.sync_with_master()

    def ensure_data_directory(self):
        os.makedirs(self.blocks_dir, exist_ok=True)
        if not os.path.exists(self.state_file):
            with open(self.state_file, 'w') as f:
                json.dump({
                    "last_block_index": 0,
                    "total_blocks": 0,
                    "last_hash": "0",
                    "chain_valid": True,
                    "last_update": datetime.now().isoformat()
                }, f)

    def load_chain(self):
        if os.path.exists(self.chain_file):
            with open(self.chain_file, 'r') as f:
                data = json.load(f)
                if isinstance(data, dict) and 'chain' in data:
                    self.chain = data['chain']
                else:
                    self.chain = data
                self.save_all_blocks()

    def save_chain(self):
        try:
            self.save_all_blocks()
            with open(self.chain_file, 'w') as f:
                json.dump({"chain": self.chain}, f)
                logging.info(f"Successfully saved chain with {len(self.chain)} blocks")
        except Exception as e:
            logging.error(f"Error saving chain: {str(e)}")
            raise

    def save_all_blocks(self):
        try:
            for block in self.chain:
                if not isinstance(block, dict):
                    logging.warning(f"Invalid block format: {block}")
                    continue
                if 'index' not in block:
                    logging.warning(f"Block missing index: {block}")
                    continue
                block_file = os.path.join(self.blocks_dir, f"block_{block['index']}.json")
                try:
                    with open(block_file, 'w') as f:
                        json.dump(block, f, indent=4)
                        logging.info(f"Successfully saved block {block['index']}")
                except Exception as e:
                    logging.error(f"Error saving block {block['index']}: {str(e)}")
                    raise
        except Exception as e:
            logging.error(f"Error in save_all_blocks: {str(e)}")
            raise

    def add_block(self, block_data):
        try:
            logging.info(f"add_block called with data: {block_data}")
            if not self.chain:
                previous_hash = "0"
                index = 0
            else:
                previous_hash = self.chain[-1]["hash"]
                index = len(self.chain)

            if isinstance(block_data, dict) and 'data' in block_data:
                data = block_data
            else:
                data = {
                    'data': block_data,
                    'timestamp': time.time()
                }

            new_block = Block(index, data, time.time(), previous_hash)
            if self.is_block_valid(new_block):
                block_dict = new_block.to_dict()
                self.chain.append(block_dict)
                
                block_file = os.path.join(self.blocks_dir, f"block_{index}.json")
                with open(block_file, 'w') as f:
                    json.dump(block_dict, f, indent=4)
                
                self.save_block_to_db(block_dict)
                self.update_state()
                logging.info(f"Block {index} created successfully: {block_dict}")
                return new_block
            else:
                logging.warning(f"Block {index} is not valid")
                return None
        except Exception as e:
            logging.error(f"Error adding block: {str(e)}")
            raise

    def is_block_valid(self, block):
        if not self.chain:
            return block.previous_hash == "0"
        
        previous_block = self.chain[-1]
        
        if block.index != len(self.chain):
            logging.warning(f"Invalid block index. Expected {len(self.chain)}, got {block.index}")
            return False
            
        if block.previous_hash != previous_block["hash"]:
            logging.warning(f"Invalid previous hash")
            return False
            
        if block.hash != block.calculate_hash():
            logging.warning(f"Invalid block hash")
            return False
            
        return True

    def sync_with_master(self):
        try:
            logging.info(f"Attempting to sync with master node")
            status_response = requests.get(
                f"http://{Config.MASTER_NODE['ip']}:{Config.MASTER_NODE['port']}/api/blockchain/status",
                headers={'Authorization': f"Bearer {Config.MASTER_NODE['api_key']}"},
                timeout=10
            )
            
            if status_response.status_code == 200:
                status_data = status_response.json()
                master_total_blocks = status_data.get('total_blocks', 0)
                
                if master_total_blocks > len(self.chain):
                    chain_response = requests.get(
                        f"http://{Config.MASTER_NODE['ip']}:{Config.MASTER_NODE['port']}/api/chain",
                        headers={'Authorization': f"Bearer {Config.MASTER_NODE['api_key']}"},
                        timeout=30
                    )
                    
                    if chain_response.status_code == 200:
                        chain_data = chain_response.json()
                        master_chain = chain_data['chain'] if isinstance(chain_data, dict) and 'chain' in chain_data else chain_data
                        
                        self.chain = master_chain
                        self.save_chain()
                        
                        for block in master_chain:
                            self.save_block_to_db(block)
                        
                        self.update_state()
                        return True
                    else:
                        logging.error(f"Failed to get blockchain from master")
                else:
                    logging.info("Chain is already up to date")
            else:
                logging.error(f"Failed to get blockchain status from master")
                
        except Exception as e:
            logging.error(f"Error syncing with master: {str(e)}")
            
        return False

    def get_chain(self):
        return self.chain

    def get_status(self):
        return {
            "total_blocks": len(self.chain),
            "last_block_index": len(self.chain) - 1 if self.chain else 0,
            "last_hash": self.chain[-1]["hash"] if self.chain else "0",
            "chain_valid": True
        }
```

### 3. API Routes (app/api/routes.py)
```python
from flask import Blueprint, jsonify, request
from app.blockchain.blockchain import Blockchain
from app.config import Config
import logging
import os
import json
from datetime import datetime

api = Blueprint('api', __name__, url_prefix='/api')
blockchain = Blockchain()
logger = logging.getLogger(__name__)

@api.route('/blockchain', methods=['GET', 'POST'])
def handle_blockchain():
    if request.method == 'GET':
        try:
            chain = blockchain.get_chain()
            return jsonify({"chain": chain}), 200
        except Exception as e:
            logger.error(f"Error getting chain: {str(e)}")
            return jsonify({"error": str(e)}), 500
    elif request.method == 'POST':
        try:
            data = request.get_json()
            if not data:
                return jsonify({"error": "No data provided"}), 400
            blockchain.add_block(data)
            return jsonify({"message": "Block added successfully"}), 201
        except Exception as e:
            logger.error(f"Error adding block: {str(e)}")
            return jsonify({"error": str(e)}), 500

@api.route('/process', methods=['POST'])
def process_block():
    try:
        data = request.get_json()
        if not data:
            return jsonify({"error": "No data provided"}), 400
        blockchain.process_block(data)
        return jsonify({"message": "Block processed successfully"}), 200
    except Exception as e:
        logger.error(f"Error processing block: {str(e)}")
        return jsonify({"error": str(e)}), 500

@api.route('/chain', methods=['GET'])
def get_chain():
    try:
        chain = blockchain.get_chain()
        return jsonify({"chain": chain}), 200
    except Exception as e:
        logger.error(f"Error getting chain: {str(e)}")
        return jsonify({"error": str(e)}), 500

@api.route('/blockchain/status', methods=['GET'])
def get_status():
    try:
        status = blockchain.get_status()
        return jsonify(status), 200
    except Exception as e:
        logger.error(f"Error getting status: {str(e)}")
        return jsonify({"error": str(e)}), 500

@api.route('/sync', methods=['POST'])
def sync_chain():
    try:
        if blockchain.sync_with_master():
            return jsonify({"message": "Chain synchronized successfully"}), 200
        return jsonify({"message": "Chain already up to date"}), 200
    except Exception as e:
        logging.error(f"Error syncing chain: {str(e)}")
        return jsonify({"error": str(e)}), 500

@api.route('/blockchain/sync-db', methods=['POST'])
def sync_blocks_to_db():
    try:
        if blockchain.sync_blocks_to_db():
            return jsonify({"message": "Blocks synced to database successfully"}), 200
        return jsonify({"error": "Failed to sync blocks to database"}), 500
    except Exception as e:
        logger.error(f"Error syncing blocks to database: {str(e)}")
        return jsonify({"error": str(e)}), 500 