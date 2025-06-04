# Dokumentasi Master Node (VM1) - Blockchain Network

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Struktur Sistem](#struktur-sistem)
3. [Arsitektur Node](#arsitektur-node)
4. [Komponen Utama](#komponen-utama)
5. [Alur Kerja](#alur-kerja)
6. [API Endpoints](#api-endpoints)
7. [Keamanan](#keamanan)
8. [Penyimpanan Data](#penyimpanan-data)
9. [Fitur Tambahan](#fitur-tambahan)
10. [Pengujian dan Monitoring](#pengujian-dan-monitoring)

## Pendahuluan

Master Node (VM1) adalah komponen utama dalam jaringan blockchain yang bertindak sebagai koordinator dan validator utama. Node ini memiliki peran kritis dalam memastikan integritas dan konsistensi data di seluruh jaringan blockchain.

### Peran Utama
- Validasi dan verifikasi data
- Koordinasi dengan node lain
- Penyimpanan data blockchain
- Distribusi blok ke node lain
- Manajemen rantai blok

### Spesifikasi Teknis
- IP: 10.41.99.202
- Port: 5000
- Framework: Flask
- Bahasa: Python 3.x
- Database: File-based JSON

## Struktur Sistem

```
master_node/
├── app/
│   ├── __init__.py
│   ├── config.py
│   ├── api/
│   │   └── routes.py
│   ├── blockchain/
│   │   ├── block.py
│   │   ├── blockchain.py
│   │   └── chain.py
│   └── services/
│       └── mining.py
├── data/
│   └── blockchain/
│       ├── blocks/
│       ├── chain.json
│       └── state.json
├── logs/
├── requirements.txt
└── run.py
```

### Penjelasan Struktur
- `app/`: Folder utama aplikasi
  - `config.py`: Konfigurasi sistem
  - `api/`: Endpoint API
  - `blockchain/`: Implementasi blockchain
  - `services/`: Layanan pendukung
- `data/`: Penyimpanan data blockchain
- `logs/`: File log sistem
- `requirements.txt`: Dependensi Python
- `run.py`: File utama untuk menjalankan aplikasi

## Arsitektur Node

### Master Node (VM1)
- IP: 10.41.99.202
- Port: 5000
- Peran: Koordinator utama
- Fungsi: Validasi dan distribusi blok

### Node Lain dalam Jaringan
1. **Bridge Node (VM5)**
   - IP: 10.41.99.226
   - Port: 5004
   - Peran: Penghubung dengan aplikasi eksternal

2. **Peer Nodes**
   - VM2 (Peer Dinas)
     - IP: 10.41.99.216
     - Port: 5001
   - VM3 (Peer Admin)
     - IP: 10.41.99.218
     - Port: 5002

3. **Verify Node (VM4)**
   - IP: 10.41.99.225
   - Port: 5003
   - Peran: Verifikasi tambahan

## Komponen Utama

### 1. File Utama (`run.py`)
```python
from app import create_app
import logging
import os

# Setup logging
logging.basicConfig(
    level=logging.DEBUG,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('/var/www/master_node/logs/app.log'),
        logging.FileHandler('/var/www/master_node/logs/mining.log'),
        logging.StreamHandler()
    ]
)

# Create logs directory if it doesn't exist
os.makedirs('/var/www/master_node/logs', exist_ok=True)

# Setup mining logger
mining_logger = logging.getLogger('mining')
mining_logger.setLevel(logging.DEBUG)
mining_handler = logging.FileHandler('/var/www/master_node/logs/mining.log')
mining_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))
mining_logger.addHandler(mining_handler)

app = create_app()

if __name__ == '__main__':
    logging.info("Starting Flask application...")
    app.run(host='0.0.0.0', port=5000)
```

### 2. Konfigurasi (`app/config.py`)
```python
import os
from dotenv import load_dotenv

load_dotenv()

class Config:
    # Master Node (VM1) Configuration
    MASTER_NODE = {
        'ip': '10.41.99.202',  # IP VM1
        'api_key': 'blockchain_secret_key_123'
    }

    # Bridge Node (VM5) Configuration
    BRIDGE_NODE = {
        'ip': '10.41.99.226',  # IP VM5
        'api_key': 'blockchain_secret_key_123'
    }

    # Other Node Configurations
    VM3 = {
        'url': 'http://10.41.99.218:5002',  # IP VM3 (Peer Admin)
        'api_key': 'blockchain_secret_key_123',
        'ip': '10.41.99.218'
    }
    
    VM4 = {
        'url': 'http://10.41.99.225:5003',  # IP VM4 (Node Verifikasi)
        'api_key': 'blockchain_secret_key_123',
        'ip': '10.41.99.225'
    }

    VM5 = {
        'url': 'http://10.41.99.226:5004',
        'api_key': 'blockchain_secret_key_123',
        'ip': '10.41.99.226'
    }
```

### 3. Block Class (`app/blockchain/block.py`)
```python
import hashlib
import time
import json
from datetime import datetime

class Block:
    def __init__(self, index, data, timestamp, previous_hash):
        self.index = index
        self.timestamp = timestamp
        self.data = self.validate_data(data)
        self.previous_hash = previous_hash
        self.hash = self.calculate_hash()
        self.created_at = datetime.now().isoformat()

    def validate_data(self, data):
        """Validate and structure the incoming data"""
        if not isinstance(data, dict):
            raise ValueError("Data must be a dictionary")

        # Skip validation for genesis block
        if data.get('type') == 'genesis':
            return data
        
        # Validate data structure from VM5
        if 'data' not in data or 'content' not in data['data']:
            raise ValueError("Invalid data structure: missing 'data' or 'content' field")
            
        content = data['data']['content']
        
        # Required fields validation
        required_fields = [
            'id', 'dinas_id', 'masyarakat_id', 'status', 'lokasi',
            'latitude', 'longitude', 'deskripsi', 'timestamp', 'created_at'
        ]
        
        for field in required_fields:
            if field not in content:
                raise ValueError(f"Missing required field: {field}")
        
        # Type validation
        if not isinstance(content['id'], int):
            raise ValueError("id must be an integer")
        if not isinstance(content['dinas_id'], int):
            raise ValueError("dinas_id must be an integer")
        if not isinstance(content['masyarakat_id'], int):
            raise ValueError("masyarakat_id must be an integer")
        if not isinstance(content['status'], str):
            raise ValueError("status must be a string")
        if not isinstance(content['lokasi'], str):
            raise ValueError("lokasi must be a string")
        if not isinstance(content['latitude'], str):
            raise ValueError("latitude must be a string")
        if not isinstance(content['longitude'], str):
            raise ValueError("longitude must be a string")
        if not isinstance(content['deskripsi'], str):
            raise ValueError("deskripsi must be a string")
            
        return data

    def calculate_hash(self):
        block_string = f"{self.index}{self.timestamp}{json.dumps(self.data)}{self.previous_hash}"
        return hashlib.sha256(block_string.encode()).hexdigest()

    def to_dict(self):
        return {
            'index': self.index,
            'timestamp': self.timestamp,
            'data': self.data,
            'previous_hash': self.previous_hash,
            'hash': self.hash,
            'created_at': self.created_at
        }
```

### 4. Blockchain Class (`app/blockchain/chain.py`)
```python
import time
import json
import os
from .block import Block
from datetime import datetime

class Blockchain:
    def __init__(self):
        self.chain_file = 'data/blockchain/chain.json'
        self.blocks_dir = 'data/blockchain/blocks'
        self.state_file = 'data/blockchain/state.json'
        self.difficulty = 4
        
        # Initialize chain
        self.chain = []
        
        # Ensure directories exist
        self.ensure_data_directory()
        
        # Load existing chain or create genesis block
        self.load_chain()
        if not self.chain:
            self.chain = [self.create_genesis_block()]

    def ensure_data_directory(self):
        """Ensure the blockchain data directory exists"""
        os.makedirs('data/blockchain', exist_ok=True)
        os.makedirs(self.blocks_dir, exist_ok=True)
        if not os.path.exists(self.state_file):
            with open(self.state_file, 'w') as f:
                json.dump({}, f)

    def create_genesis_block(self):
        genesis = Block(0, {
            'source': 'system',
            'type': 'genesis',
            'content': 'Genesis Block'
        }, time.time(), "0")
        self.save_block(genesis)
        self.update_state(genesis)
        return genesis

    def get_latest_block(self):
        return self.chain[-1]

    def is_data_duplicate(self, new_data):
        """Check if the data already exists in any block"""
        if not isinstance(new_data, dict) or 'data' not in new_data or 'content' not in new_data['data']:
            return False
            
        new_content = new_data['data']['content']
        
        # Skip check for genesis block
        if new_data.get('type') == 'genesis':
            return False
            
        # Check each block in the chain
        for block in self.chain:
            if not isinstance(block, dict):
                block_data = block.data
            else:
                block_data = block.get('data', {})
                
            if not isinstance(block_data, dict):
                continue
                
            block_content = block_data.get('data', {}).get('content', {})
            if not isinstance(block_content, dict):
                continue
                
            # Compare relevant fields
            if all(key in block_content and key in new_content for key in ['id', 'dinas_id', 'masyarakat_id', 'status', 'tracking_status', 'deskripsi']):
                if (block_content['id'] == new_content['id'] and 
                    block_content['dinas_id'] == new_content['dinas_id'] and 
                    block_content['masyarakat_id'] == new_content['masyarakat_id'] and
                    block_content['status'] == new_content['status'] and
                    block_content['tracking_status'] == new_content['tracking_status'] and
                    block_content['deskripsi'] == new_content['deskripsi']):
                    return True
                    
        return False

    def add_block(self, new_block):
        """Add a new block to the chain with validation"""
        if self.is_data_duplicate(new_block.data):
            raise ValueError("Data already exists in blockchain")
            
        if not self.is_block_valid(new_block):
            raise ValueError("Invalid block")

        new_block.previous_hash = self.get_latest_block().hash
        new_block.hash = new_block.calculate_hash()
        self.chain.append(new_block)
        
        self.save_block(new_block)
        self.save_chain()
        self.update_state(new_block)

    def save_block(self, block):
        """Save individual block to file"""
        block_file = os.path.join(self.blocks_dir, f"block_{block.index}.json")
        with open(block_file, 'w') as f:
            json.dump(block.to_dict(), f, indent=2)

    def update_state(self, block):
        """Update state based on block data"""
        try:
            with open(self.state_file, 'r') as f:
                state_data = json.load(f)
        except (FileNotFoundError, json.JSONDecodeError):
            state_data = {
                "last_block_index": 0,
                "total_blocks": 0,
                "last_hash": "0",
                "difficulty": self.difficulty,
                "mining_reward": 10,
                "pending_transactions": [],
                "network_nodes": {
                    "vm1": {"ip": "10.41.99.202", "port": 5000, "role": "master"},
                    "vm3": {"ip": "10.41.99.218", "port": 5002, "role": "peer"},
                    "vm4": {"ip": "10.41.99.225", "port": 5003, "role": "verify"},
                    "vm5": {"ip": "10.41.99.226", "port": 5005, "role": "bridge"}
                },
                "chain_valid": True,
                "last_update": datetime.now().isoformat()
            }

        block_files = [f for f in os.listdir(self.blocks_dir) if f.startswith('block_') and f.endswith('.json')]
        total_blocks = len(block_files)
        latest_block_index = max([int(f.split('_')[1].split('.')[0]) for f in block_files])

        state_data.update({
            "last_block_index": latest_block_index,
            "total_blocks": total_blocks,
            "last_hash": block.hash,
            "last_update": datetime.now().isoformat(),
            "chain_valid": self.is_chain_valid()
        })

        with open(self.state_file, 'w') as f:
            json.dump(state_data, f, indent=2)

    def is_block_valid(self, block):
        """Validate a block before adding it to the chain"""
        if not isinstance(block, Block):
            return False

        previous_block = self.get_latest_block()
        if block.index != previous_block.index + 1:
            return False

        if block.previous_hash != previous_block.hash:
            return False

        if block.hash != block.calculate_hash():
            return False

        return True

    def is_chain_valid(self):
        """Validate the entire chain"""
        for i in range(1, len(self.chain)):
            current_block = self.chain[i]
            previous_block = self.chain[i-1]

            if current_block.hash != current_block.calculate_hash():
                return False

            if current_block.previous_hash != previous_block.hash:
                return False

        return True
```

### 5. Mining Service (`app/services/mining.py`)
```python
import time
import requests
import os
import logging
from app.blockchain.chain import Blockchain
from app.blockchain.block import Block
from app.config import Config
from requests.adapters import HTTPAdapter
from urllib3.util.retry import Retry

class MiningService:
    def __init__(self, blockchain):
        self.logger = logging.getLogger('mining')
        self.blockchain = blockchain
        
        # Configure retry strategy
        self.retry_strategy = Retry(
            total=5,
            backoff_factor=2,
            status_forcelist=[500, 502, 503, 504],
            allowed_methods=["POST", "GET"]
        )
        
        # Create session with retry strategy
        self.session = requests.Session()
        adapter = HTTPAdapter(
            max_retries=self.retry_strategy,
            pool_connections=20,
            pool_maxsize=20,
            pool_block=False
        )
        self.session.mount("http://", adapter)
        self.session.mount("https://", adapter)
        
        self.session.timeout = (10, 30)

    def mine_block(self, data):
        """Mine a new block with data from VM5"""
        try:
            # Validate data format
            if not isinstance(data, dict) or 'data' not in data or 'content' not in data['data']:
                raise ValueError("Invalid data format from VM5")

            # Check for duplicate data
            if self.blockchain.is_data_duplicate(data):
                raise ValueError("Data already exists in blockchain")

            # Create new block
            previous_block = self.blockchain.get_latest_block()
            new_index = previous_block.index + 1
            
            if isinstance(data, dict) and 'index' in data:
                del data['index']
            
            new_block = Block(
                new_index,
                data,
                data.get('timestamp', time.time()),
                previous_block.hash
            )

            # Add to chain
            self.blockchain.add_block(new_block)

            # Distribute to nodes
            self.distribute_to_nodes(new_block)

            return new_block
        except Exception as e:
            self.logger.error(f"Error mining block: {str(e)}", exc_info=True)
            raise

    def distribute_to_nodes(self, block):
        """Distribute block to other nodes"""
        block_data = block.to_dict()
        
        # Send to Peer Node 1 (VM2)
        try:
            if not self.validate_node_ip(Config.VM2['ip']):
                raise Exception(f"Cannot reach Peer Node 1 at {Config.VM2['ip']}")
                
            response = self.session.post(
                f"{Config.VM2['url']}/api/process",
                json=block_data,
                headers={'Authorization': f"Bearer {Config.VM2['api_key']}"},
                timeout=10
            )
            response.raise_for_status()
        except Exception as e:
            self.logger.error(f"Error distributing to Peer Node 1: {str(e)}", exc_info=True)

        # Send to Peer Node 2 (VM3)
        try:
            if not self.validate_node_ip(Config.VM3['ip']):
                raise Exception(f"Cannot reach Peer Node 2 at {Config.VM3['ip']}")
                
            response = self.session.post(
                f"{Config.VM3['url']}/api/store",
                json=block_data,
                headers={'Authorization': f"Bearer {Config.VM3['api_key']}"},
                timeout=10
            )
            response.raise_for_status()
        except Exception as e:
            self.logger.error(f"Error distributing to Peer Node 2: {str(e)}", exc_info=True)

        # Send to Verify Node (VM4)
        try:
            if not self.validate_node_ip(Config.VM4['ip']):
                raise Exception(f"Cannot reach Verify Node at {Config.VM4['ip']}")
                
            response = self.session.post(
                f"{Config.VM4['url']}/api/blockchain",
                json=block_data,
                headers={'Authorization': f"Bearer {Config.VM4['api_key']}"},
                timeout=30
            )
            response.raise_for_status()
        except Exception as e:
            self.logger.error(f"Error distributing to Verify Node: {str(e)}", exc_info=True)

    def validate_node_ip(self, ip):
        """Validate if node is accessible"""
        try:
            response = os.system(f"ping -c 1 {ip}")
            return response == 0
        except Exception as e:
            self.logger.error(f"Error validating node IP {ip}: {str(e)}", exc_info=True)
            return False
```

### 6. API Routes (`app/api/routes.py`)
```python
from flask import Blueprint, jsonify, request
from app.services.mining import MiningService
from app.blockchain.chain import Blockchain
from app.blockchain.block import Block
from app.config import Config
import logging

api = Blueprint('api', __name__)
blockchain = Blockchain()
mining_service = MiningService(blockchain)

def validate_bridge_node():
    """Validate that request is coming from VM5 (Bridge Node)"""
    client_ip = request.remote_addr
    auth_header = request.headers.get('Authorization')
    
    if not auth_header or not auth_header.startswith('Bearer '):
        return False
        
    api_key = auth_header.split(' ')[1]
    
    return (client_ip == Config.BRIDGE_NODE['ip'] and 
            api_key == Config.BRIDGE_NODE['api_key'])

@api.route('/blockchain', methods=['GET', 'POST'])
def blockchain_endpoint():
    if request.method == 'GET':
        return jsonify({
            "status": "success",
            "chain": [block.to_dict() for block in blockchain.chain]
        })
    
    if not validate_bridge_node():
        logging.warning(f"Unauthorized access attempt from {request.remote_addr}")
        return jsonify({"status": "error", "message": "Unauthorized"}), 401
    
    data = request.json
    try:
        block = mining_service.mine_block(data)
        return jsonify({
            "status": "success",
            "block": block.to_dict()
        })
    except ValueError as e:
        if "already exists" in str(e):
            return jsonify({
                "status": "error",
                "message": str(e),
                "error_type": "duplicate"
            }), 409
        else:
            return jsonify({
                "status": "error",
                "message": str(e)
            }), 400
    except Exception as e:
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500

@api.route('/process', methods=['POST'])
def process_block():
    """Handle block distribution from master node"""
    try:
        auth_header = request.headers.get('Authorization')
        if not auth_header or not auth_header.startswith('Bearer '):
            return jsonify({"status": "error", "message": "Missing or invalid authorization header"}), 401
            
        api_key = auth_header.split(' ')[1]
        if api_key != Config.MASTER_NODE['api_key']:
            return jsonify({"status": "error", "message": "Invalid API key"}), 401
            
        block_data = request.json
        if not block_data:
            return jsonify({"status": "error", "message": "No block data provided"}), 400
            
        new_block = Block(
            block_data['index'],
            block_data['data'],
            block_data['timestamp'],
            block_data['previous_hash']
        )
        new_block.hash = block_data['hash']
        
        blockchain.add_block(new_block)
        
        return jsonify({
            "status": "success",
            "message": f"Block {block_data['index']} processed successfully"
        })
        
    except Exception as e:
        logging.error(f"Error processing block: {str(e)}")
        return jsonify({"status": "error", "message": str(e)}), 500

@api.route('/chain', methods=['GET'])
def get_chain():
    return jsonify({
        "chain": [block.to_dict() for block in blockchain.chain]
    })

@api.route('/blockchain/status', methods=['GET'])
def blockchain_status():
    """Get blockchain status"""
    try:
        return jsonify({
            "status": "success",
            "total_blocks": len(blockchain.chain),
            "last_block_index": blockchain.chain[-1].index if blockchain.chain else 0,
            "is_valid": blockchain.is_chain_valid()
        })
    except Exception as e:
        logging.error(f"Error getting blockchain status: {str(e)}")
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500

@api.route('/peers', methods=['GET'])
def get_peers():
    """Get list of connected peers"""
    try:
        return jsonify({
            "status": "success",
            "peers": {
                "master_node": Config.MASTER_NODE,
                "bridge_node": Config.BRIDGE_NODE,
                "peer_nodes": {
                    "vm2": Config.VM2,
                    "vm3": Config.VM3
                },
                "verify_node": Config.VM4
            }
        })
    except Exception as e:
        logging.error(f"Error getting peers: {str(e)}")
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500
```

## Alur Kerja

1. **Penerimaan Data**
   - Data diterima dari Bridge Node (VM5)
   - Validasi format dan struktur data
   - Pengecekan duplikasi

2. **Proses Mining**
   - Pembuatan blok baru
   - Validasi blok
   - Penambahan ke rantai

3. **Distribusi**
   - Pengiriman ke Peer Nodes
   - Pengiriman ke Verify Node
   - Konfirmasi penerimaan

4. **Penyimpanan**
   - Penyimpanan blok ke disk
   - Update state blockchain
   - Pencatatan log

## API Endpoints

### 1. `/blockchain`
- **Method**: GET, POST
- **Fungsi**: 
  - GET: Mendapatkan seluruh rantai
  - POST: Menambah blok baru

### 2. `/process`
- **Method**: POST
- **Fungsi**: Memproses blok dari node lain

### 3. `/chain`
- **Method**: GET
- **Fungsi**: Mendapatkan rantai blok

### 4. `/blockchain/status`
- **Method**: GET
- **Fungsi**: Mendapatkan status blockchain

### 5. `/peers`
- **Method**: GET
- **Fungsi**: Mendapatkan daftar peer

## Keamanan

### 1. Validasi API
```python
def validate_bridge_node():
    client_ip = request.remote_addr
    auth_header = request.headers.get('Authorization')
    api_key = auth_header.split(' ')[1]
    return (client_ip == Config.BRIDGE_NODE['ip'] and 
            api_key == Config.BRIDGE_NODE['api_key'])
```

### 2. Validasi Data
- Pengecekan format
- Validasi tipe data
- Pencegahan duplikasi

### 3. Keamanan Jaringan
- Validasi IP
- API key authentication
- Timeout handling

## Penyimpanan Data

### 1. Struktur Penyimpanan
```
data/blockchain/
├── blocks/
│   ├── block_0.json
│   ├── block_1.json
│   └── ...
├── chain.json
└── state.json
```

### 2. Format Data
- Blok: JSON
- State: JSON
- Log: Text

## Fitur Tambahan

### 1. Logging
```python
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
)
```

### 2. Retry Mechanism
```python
retry_strategy = Retry(
    total=5,
    backoff_factor=2,
    status_forcelist=[500, 502, 503, 504]
)
```

### 3. Error Handling
- Validasi input
- Penanganan exception
- Logging error

## Pengujian dan Monitoring

### 1. Status Blockchain
- Total blok
- Index terakhir
- Validitas rantai

### 2. Monitoring Node
- Konektivitas
- Status peer
- Performa sistem

### 3. Logging
- Aktivitas sistem
- Error dan warning
- Performa API

## Kesimpulan

Master Node (VM1) adalah komponen kritis dalam jaringan blockchain yang bertanggung jawab atas:
1. Validasi dan verifikasi data
2. Koordinasi dengan node lain
3. Penyimpanan data blockchain
4. Distribusi blok
5. Manajemen rantai

Sistem ini dirancang dengan fokus pada:
- Keamanan
- Skalabilitas
- Reliabilitas
- Performa
- Kemudahan maintenance 