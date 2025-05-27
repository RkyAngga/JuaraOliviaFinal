@extends('Dashboardstlhlogin.Dinas.Template.Template')
@section('title', 'Laporan Presisi Tinggi')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Loading Overlay */
    .loading-overlay {
        @apply fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center text-white z-[9999];
    }
    .spinner {
        @apply animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white;
    }

    /* Geolocation Status */
    .geo-status {
        @apply absolute top-2 right-2 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm;
    }

    /* Address Overlay */
    .address-overlay {
        @apply absolute bottom-2 left-2 right-2 bg-black bg-opacity-70 text-white p-3 rounded-lg text-xs;
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .geo-status {
            font-size: 10px;
            right: 5px;
            top: 5px;
            max-width: 60%;
        }

        .address-overlay div {
            font-size: 10px;
            line-height: 1.3;
        }
    }
</style>

<section class="min-h-screen p-4">
    <!-- Loading Screen -->
    <div id="loading" class="loading-overlay hidden">
        <div class="text-center">
            <div class="spinner mb-4"></div>
            <p>Menginisialisasi sistem...</p>
            <p class="text-sm opacity-75 mt-2" id="loading-detail"></p>
        </div>
    </div>

    <!-- Camera Interface -->
    <div id="cameraSection" class="hidden max-w-lg mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-4">
            <div class="relative">
                <video id="camera" class="w-full h-64 object-cover rounded-lg"></video>
                <div class="geo-status" id="geoStatus">
                    <span class="mr-2">🌍</span>Mencari GPS...
                </div>
            </div>
            <div class="mt-4 flex justify-center gap-4">
                    <button onclick="capturePhoto()" class="bg-kuning text-hitam px-6 py-2 rounded-full flex items-center gap-2 hover:bg-yellow-600 transition-colors">
                        <img src="{{ asset('img/logo/kamera.png') }}" alt="Camera Icon" class="w-5 h-5">
                        Ambil Foto
                    </button>
                    <button onclick="window.history.back()" class="bg-merah text-hitam px-6 py-2 rounded-full flex items-center gap-2 hover:bg-red-700 transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Form (Preview & Simpan) -->
    <div id="reportForm" class="hidden max-w-lg mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-4">
            <h2 class="text-xl font-bold mb-4">Preview Foto Laporan</h2>
            <div class="relative mb-4">
                <img id="capturedImage" class="w-full h-64 object-cover rounded-lg border-2 border-dashed">
                <div class="address-overlay">
                    <div id="fullAddress"></div>
                    <div class="mt-1" id="geoDetails"></div>
                </div>
            </div>
            <form id="uploadForm" action="{{ route('dinas.laporan.uploadFotoPenyelesaian', $id) }}" method="POST" enctype="multipart/form-data" style="display:none;">
                @csrf
                <input type="file" name="foto_penyelesaian" id="foto_penyelesaian_input" accept="image/*" style="display:none;">
                <input type="hidden" name="waktu_foto" id="waktu_foto_input">
                <input type="hidden" name="alamat_foto" id="alamat_foto_input">
            </form>

            <div class="flex justify-between">
                    <button onclick="retakePhoto()" class="bg-gray-500 hover:bg-kuning text-white px-4 py-2 rounded-full">
                        Ulangi Foto
                    </button>
                    <button onclick="submitReport()" class="bg-kuning hover:bg-yellow-700 text-white px-6 py-2 rounded-full">
                        Simpan & Lanjutkan
                    </button>
                </div>
        </div>
    </div>

    <!-- Initial Button -->
    <div id="initialScreen" class="text-center mt-12">
        <button onclick="startApp()"
            class="bg-kuning text-hitam font-semibold px-8 py-3 rounded-full text-lg hover:bg-yellow-600 transition-colors">
            Selesaikan Pelaporan
        </button>
    </div>
</section>

<script>
let stream = null;
let watchId = null;
let currentLocation = null;
let addressDetails = {};
let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
let capturedImageDataURL = null;

// Deteksi lingkungan
const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

const LAPORAN_ID = {{ $id }};

async function startApp() {
    try {
        // Validasi HTTPS untuk mobile
        if(!isLocalhost && window.location.protocol !== 'https:' && isMobile) {
            alert('Akses harus melalui HTTPS!');
            window.location.href = `https://${window.location.host}${window.location.pathname}`;
            return;
        }

        showLoading('Memulai sistem...');

        // 1. Cek kompatibilitas
        if(!checkCompatibility()) return;

        // 2. Minta izin
        await requestPermissions();

        // 3. Inisialisasi kamera dan lokasi
        await Promise.all([startCamera(), startGeoTracking()]);

        // Tampilkan UI
        hideLoading();
        document.getElementById('initialScreen').classList.add('hidden');
        document.getElementById('cameraSection').classList.remove('hidden');

    } catch (error) {
        hideLoading();
        alert(`Error: ${error.message}`);
    }
}

function checkCompatibility() {
    const errors = [];
    if(!navigator.geolocation) errors.push("- Geolokasi tidak didukung");
    if(!navigator.mediaDevices?.getUserMedia) errors.push("- Kamera tidak didukung");

    if(errors.length > 0) {
        alert("Browser tidak kompatibel:\n" + errors.join("\n"));
        return false;
    }
    return true;
}

async function requestPermissions() {
    try {
        // Izin lokasi
        const geoStatus = await navigator.permissions.query({ name: 'geolocation' });
        if(geoStatus.state === 'denied') throw new Error('Izin lokasi ditolak');

        // Izin kamera
        await navigator.mediaDevices.getUserMedia({ video: true });

    } catch (error) {
        throw new Error(`Permasalahan izin: ${error.message}`);
    }
}

function startGeoTracking() {
    return new Promise((resolve, reject) => {
        // Simulasi lokasi untuk desktop
        if(!isMobile && isLocalhost) {
            currentLocation = {
                latitude: -7.955413234953242,
                longitude: 112.61619107544553,
                accuracy: 3
            };
            updateGeoDisplay();
            resolve();
            return;
        }

        watchId = navigator.geolocation.watchPosition(
            position => {
                currentLocation = position.coords;
                updateGeoDisplay();

                if(currentLocation.accuracy <= 5) {
                    resolve();
                }
            },
            error => handleGeoError(error),
            {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 30000
            }
        );
    });
}

function updateGeoDisplay() {
    // Update tampilan GPS
    document.getElementById('geoStatus').innerHTML = `
        🌍 Akurasi: ${currentLocation.accuracy.toFixed(1)}m
        ${currentLocation.accuracy > 5 ? '⚠️' : '✅'}
    `;

    // Update koordinat
    document.getElementById('geoDetails').innerHTML = `
        Koordinat: <br>
        ${currentLocation.latitude.toFixed(6)},
        ${currentLocation.longitude.toFixed(6)}
    `;

    getAddressDetails();
}

async function getAddressDetails() {
    try {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${currentLocation.latitude}&lon=${currentLocation.longitude}&addressdetails=1`,
            {
                headers: {
                    'User-Agent': 'LaporanApp/1.0 (contact@example.com)'
                }
            }
        );

        const data = await response.json();
        addressDetails = parseAddress(data.address);

        document.getElementById('fullAddress').innerHTML = `
            <div>Jalan: ${addressDetails.jalan}</div>
            <div>Gang: ${addressDetails.gang}</div>
            <div>Desa: ${addressDetails.desa}</div>
            <div>Kec. ${addressDetails.kecamatan}</div>
            <div>${addressDetails.kota}, ${addressDetails.provinsi}</div>
        `;

    } catch (error) {
        console.error('Error alamat:', error);
    }
}

function parseAddress(address) {
    return {
        jalan: address.road || 'Tidak diketahui',
        gang: address.neighbourhood || '',
        desa: address.village || address.hamlet || '',
        kecamatan: address.suburb || address.county || '',
        kota: address.city || address.town || '',
        provinsi: address.state || ''
    };
}

async function startCamera() {
    try {
        const constraints = {
            video: {
                width: { ideal: 1280 },
                height: { ideal: 720 },
                facingMode: isMobile ? 'environment' : 'user'
            }
        };

        stream = await navigator.mediaDevices.getUserMedia(constraints);
        const video = document.getElementById('camera');

        // Optimasi untuk iOS
        video.playsInline = true;
        video.muted = true;

        video.srcObject = stream;
        await video.play();

    } catch (error) {
        throw new Error(`Gagal mengakses kamera: ${error.message}`);
    }
}

function capturePhoto() {
    const video = document.getElementById('camera');
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Watermark
    ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
    ctx.fillRect(20, canvas.height - 140, canvas.width - 40, 120);

    ctx.fillStyle = 'white';
    ctx.font = '14px Arial';
    ctx.textBaseline = 'top';
    ctx.fillText(`🕒 ${new Date().toLocaleString()}`, 30, canvas.height - 130);
    ctx.fillText(`📍 ${addressDetails.jalan}`, 30, canvas.height - 110);
    ctx.fillText(`🏘 ${addressDetails.desa}, ${addressDetails.kecamatan}`, 30, canvas.height - 90);
    ctx.fillText(`🌐 ${currentLocation.latitude.toFixed(6)}, ${currentLocation.longitude.toFixed(6)}`, 30, canvas.height - 70);

    // Tampilkan preview
    capturedImageDataURL = canvas.toDataURL('image/jpeg');
    document.getElementById('capturedImage').src = capturedImageDataURL;

    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('reportForm').classList.remove('hidden');

    const now = new Date();
    const waktuFoto = now.getFullYear() + '-' +
        String(now.getMonth() + 1).padStart(2, '0') + '-' +
        String(now.getDate()).padStart(2, '0') + ' ' +
        String(now.getHours()).padStart(2, '0') + ':' +
        String(now.getMinutes()).padStart(2, '0') + ':' +
        String(now.getSeconds()).padStart(2, '0');
    document.getElementById('waktu_foto_input').value = waktuFoto;
    document.getElementById('alamat_foto_input').value = document.getElementById('fullAddress').innerText;
}

function handleGeoError(error) {
    let message = 'Error geolokasi: ';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message += "Izin ditolak";
            break;
        case error.POSITION_UNAVAILABLE:
            message += "Lokasi tidak tersedia";
            break;
        case error.TIMEOUT:
            message += "Timeout";
            break;
    }
    alert(message);
}

// Fungsi bantuan
function showLoading(message) {
    document.getElementById('loading').classList.remove('hidden');
    document.getElementById('loading-detail').textContent = message;
}

function hideLoading() {
    document.getElementById('loading').classList.add('hidden');
}

function retakePhoto() {
    document.getElementById('reportForm').classList.add('hidden');
    startApp();
}

function submitReport() {
    if (!capturedImageDataURL || !currentLocation) {
        alert('Data gambar atau lokasi tidak lengkap. Silakan ambil foto ulang.');
        return;
    }
    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    }
    var file = dataURLtoFile(capturedImageDataURL, 'penyelesaian.jpg');
    console.log(file);
    var formData = new FormData();
    formData.append('foto_penyelesaian', file);
    formData.append('waktu_foto', document.getElementById('waktu_foto_input').value);
    formData.append('alamat_foto', document.getElementById('alamat_foto_input').value);

    fetch("{{ route('dinas.laporan.uploadFotoPenyelesaian', $id) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.redirect) {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'Gagal upload foto!');
        }
    })
    .catch(() => alert('Gagal upload foto!'));
}

function closeCamera() {
    if(stream) stream.getTracks().forEach(track => track.stop());
    if(watchId) navigator.geolocation.clearWatch(watchId);
    document.getElementById('initialScreen').classList.remove('hidden');
    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('reportForm').classList.add('hidden');
}
</script>

@endsection
