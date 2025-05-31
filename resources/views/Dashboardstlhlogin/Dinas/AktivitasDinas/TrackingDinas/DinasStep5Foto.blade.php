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
// Tambahkan pengecekan perangkat di awal
const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

if (!isMobile && !isLocalhost) {
    alert('Fitur pengambilan foto hanya tersedia di perangkat mobile!');
    window.location.href = '/dinas/laporan/step4/lanjutan/{{ $id }}';
}

let stream = null;
let watchId = null;
let currentLocation = null;
let addressDetails = {};
let capturedImageDataURL = null;

function showLoading(message) {
    document.getElementById('loading').classList.remove('hidden');
    document.getElementById('loading-detail').textContent = message;
}
function hideLoading() {
    document.getElementById('loading').classList.add('hidden');
}

async function startApp() {
    try {
        showLoading('Memulai sistem...');
        if(!isLocalhost && window.location.protocol !== 'https:' && isMobile) {
            alert('Akses harus melalui HTTPS!');
            window.location.href = `https://${window.location.host}${window.location.pathname}`;
            return;
        }
        if(!checkCompatibility()) {
            hideLoading();
            return;
        }
        await requestPermissions();
        await Promise.all([startCamera(), startGeoTracking()]);
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
    if(!navigator.geolocation) errors.push('- Geolokasi tidak didukung');
    if(!navigator.mediaDevices?.getUserMedia) errors.push('- Kamera tidak didukung');
    if(errors.length > 0) {
        alert('Browser tidak kompatibel:\n' + errors.join('\n'));
        return false;
    }
    return true;
}
async function requestPermissions() {
    try {
        const geoStatus = await navigator.permissions.query({ name: 'geolocation' });
        if(geoStatus.state === 'prompt') {
            await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 10000 });
            });
        } else if (geoStatus.state === 'denied') {
            throw new Error('Izin lokasi ditolak. Aktifkan izin lokasi di pengaturan browser Anda.');
        }
        const camStatus = await navigator.permissions.query({ name: 'camera' });
        if (camStatus.state === 'prompt') {
            await navigator.mediaDevices.getUserMedia({ video: true });
        } else if (camStatus.state === 'denied') {
            throw new Error('Izin kamera ditolak. Aktifkan izin kamera di pengaturan browser Anda.');
        }
    } catch (error) {
        throw new Error(`Permasalahan izin: ${error.message}`);
    }
}
function startGeoTracking() {
    return new Promise((resolve, reject) => {
        showLoading('Mencari lokasi GPS...');
        document.getElementById('geoStatus').innerHTML = `<span class='mr-2'>🌍</span>Mencari GPS...`;
        let resolved = false;
        const options = {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 20000
        };
        watchId = navigator.geolocation.watchPosition(
            position => {
                currentLocation = position.coords;
                updateGeoDisplay();
                if (!addressDetails.jalan) {
                    getAddressDetails();
                }
                if(currentLocation.accuracy <= 15 && !resolved) {
                    resolved = true;
                    resolve();
                } else {
                    showLoading(`Meningkatkan akurasi GPS (${currentLocation.accuracy.toFixed(1)}m)...`);
                }
            },
            error => {
                handleGeoError(error);
                if (!resolved) reject(new Error(`Gagal mendapatkan lokasi: ${error.message}`));
            },
            options
        );
        setTimeout(() => {
            if (!resolved) {
                if (currentLocation) {
                    resolved = true;
                    resolve();
                } else {
                    navigator.geolocation.clearWatch(watchId);
                    reject(new Error('Timeout saat mencari lokasi GPS. Pastikan GPS aktif dan sinyal baik.'));
                }
            }
        }, options.timeout + 5000);
    });
}
function updateGeoDisplay() {
    if (!currentLocation) return;
    const geoStatusElement = document.getElementById('geoStatus');
    if (geoStatusElement) {
        geoStatusElement.innerHTML = `🌍 Akurasi: ${currentLocation.accuracy.toFixed(1)}m ${currentLocation.accuracy > 10 ? '⚠️' : '✅'}`;
    }
    const geoDetailsElement = document.getElementById('geoDetails');
    if (geoDetailsElement) {
        geoDetailsElement.innerHTML = `Koordinat: <br>${currentLocation.latitude.toFixed(6)},${currentLocation.longitude.toFixed(6)}`;
    }
}
async function getAddressDetails() {
    if (!currentLocation || !currentLocation.latitude || !currentLocation.longitude) {
        const fullAddressElement = document.getElementById('fullAddress');
        if (fullAddressElement) {
            fullAddressElement.innerHTML = `<div>Gagal mendapatkan detail alamat (koordinat tidak ditemukan).</div>`;
        }
        return;
    }
    try {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${currentLocation.latitude}&lon=${currentLocation.longitude}&addressdetails=1&accept-language=id`,
            { headers: { 'User-Agent': 'LaporanAppDinas/1.0 (juaraolivia@example.com)' } }
        );
        if (!response.ok) throw new Error(`Nominatim request failed with status ${response.status}`);
        const data = await response.json();
        if (data.error) throw new Error(`Nominatim error: ${data.error}`);
        addressDetails = parseAddress(data.address);
        const fullAddressElement = document.getElementById('fullAddress');
        if (fullAddressElement) {
            fullAddressElement.innerHTML = `
                <div>${addressDetails.jalan ? `Jalan: ${addressDetails.jalan}` : ''}</div>
                <div>${addressDetails.gang ? `Gang/Lingkungan: ${addressDetails.gang}` : ''}</div>
                <div>${addressDetails.desa ? `Desa/Kel: ${addressDetails.desa}` : ''}</div>
                <div>${addressDetails.kecamatan ? `Kec. ${addressDetails.kecamatan}` : ''}</div>
                <div>${addressDetails.kota ? `${addressDetails.kota}` : ''}${addressDetails.provinsi ? `, ${addressDetails.provinsi}` : ''}</div>
            `.replace(/<div>\s*<\/div>/g, '');
        }
    } catch (error) {
        const fullAddressElement = document.getElementById('fullAddress');
        if (fullAddressElement) {
            fullAddressElement.innerHTML = `<div>Gagal mendapatkan detail alamat.</div>`;
        }
        addressDetails = { jalan: 'Tidak diketahui', gang: '', desa: '', kecamatan: '', kota: '', provinsi: '' };
    }
}
function parseAddress(address) {
    if (!address) return { jalan: 'Tidak diketahui', gang: '', desa: '', kecamatan: '', kota: '', provinsi: '' };
    let kecamatan = address.suburb || address.county || address.city_district || '';
    const kotaKab = address.city || address.town || '';
    if (kecamatan === kotaKab) {
        if (address.suburb === kotaKab) {
            kecamatan = address.county || address.city_district || '';
        } else if (address.county === kotaKab) {
            kecamatan = address.suburb || address.city_district || '';
        }
        if (kecamatan === kotaKab) kecamatan = '';
    }
    let desa = address.village || address.hamlet || '';
    if (!desa && address.suburb && address.suburb !== kecamatan) desa = address.suburb;
    if (!desa && address.neighbourhood) desa = address.neighbourhood;
    let gang = (address.neighbourhood && address.neighbourhood !== desa) ? address.neighbourhood : '';
    return {
        jalan: address.road || '',
        gang: gang,
        desa: desa,
        kecamatan: kecamatan,
        kota: kotaKab,
        provinsi: address.state || ''
    };
}
async function startCamera() {
    showLoading('Mengaktifkan kamera...');
    try {
        const constraints = {
            video: {
                width: { ideal: 1280 },
                height: { ideal: 720 },
                facingMode: isMobile ? { exact: 'environment' } : 'user'
            }
        };
        stream = await navigator.mediaDevices.getUserMedia(constraints);
        const video = document.getElementById('camera');
        video.playsInline = true;
        video.muted = true;
        video.srcObject = stream;
        await video.play();
    } catch (error) {
        if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
            try {
                const fallbackConstraints = { video: { width: { ideal: 1280 }, height: { ideal: 720 } } };
                stream = await navigator.mediaDevices.getUserMedia(fallbackConstraints);
                const video = document.getElementById('camera');
                video.playsInline = true;
                video.muted = true;
                video.srcObject = stream;
                await video.play();
            } catch (fallbackError) {
                throw new Error(`Gagal mengakses kamera: ${fallbackError.message}`);
            }
        } else {
            throw new Error(`Gagal mengakses kamera: ${error.message}`);
        }
    }
}
function capturePhoto() {
    if (!currentLocation || currentLocation.accuracy > 50) {
        alert(`Lokasi GPS belum akurat (${currentLocation ? currentLocation.accuracy.toFixed(1) + 'm' : 'tidak ditemukan'}). Tunggu sebentar atau coba lagi di tempat dengan sinyal lebih baik.`);
        return;
    }
    const video = document.getElementById('camera');
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const now = new Date();
    const timestamp = now.toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'medium', hour12: false }).replace(/\./g, '/');
    const gpsText = `Lat: ${currentLocation.latitude.toFixed(6)}, Lon: ${currentLocation.longitude.toFixed(6)}, Acc: ${currentLocation.accuracy.toFixed(1)}m`;
    let addressLines = [];
    if (addressDetails.jalan) addressLines.push(addressDetails.jalan);
    let line2 = [];
    if (addressDetails.desa) line2.push(`Desa/Kel: ${addressDetails.desa}`);
    if (addressDetails.kecamatan) line2.push(`Kec: ${addressDetails.kecamatan}`);
    if (line2.length > 0) addressLines.push(line2.join(', '));
    let line3 = [];
    if (addressDetails.kota) line3.push(addressDetails.kota);
    if (addressDetails.provinsi) line3.push(addressDetails.provinsi);
    if (line3.length > 0) addressLines.push(line3.join(', '));
    const fontSize = Math.max(12, Math.min(16, Math.round(canvas.width / 60)));
    context.font = `${fontSize}px Arial`;
    context.fillStyle = 'rgba(0, 0, 0, 0.6)';
    const textPadding = fontSize * 0.4;
    const lineHeight = fontSize * 1.3;
    const bottomMargin = 10;
    const totalLines = addressLines.length + 2;
    const backgroundHeight = (lineHeight * totalLines) + (textPadding * 1.5);
    const startY = canvas.height - backgroundHeight - bottomMargin;
    let maxWidth = 0;
    [...addressLines, gpsText, timestamp].forEach(line => {
        const lineWidth = context.measureText(line).width;
        if (lineWidth > maxWidth) {
            maxWidth = lineWidth;
        }
    });
    const backgroundWidth = maxWidth + (textPadding * 2);
    context.fillRect(
        textPadding,
        startY,
        backgroundWidth,
        backgroundHeight
    );
    context.fillStyle = 'white';
    let currentY = startY + lineHeight;
    addressLines.forEach(line => {
        context.fillText(line, textPadding * 2, currentY);
        currentY += lineHeight;
    });
    context.fillText(gpsText, textPadding * 2, currentY);
    currentY += lineHeight;
    context.fillText(timestamp, textPadding * 2, currentY);
    capturedImageDataURL = canvas.toDataURL('image/jpeg', 0.9);
    const capturedImageElement = document.getElementById('capturedImage');
    capturedImageElement.src = capturedImageDataURL;
    updateGeoDisplay();
    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('reportForm').classList.remove('hidden');
}
function handleGeoError(error) {
    let message = 'Gagal mendapatkan lokasi: ';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message += 'Izin lokasi ditolak.';
            break;
        case error.POSITION_UNAVAILABLE:
            message += 'Informasi lokasi tidak tersedia.';
            break;
        case error.TIMEOUT:
            message += 'Timeout saat mencari lokasi.';
            break;
        default:
            message += `Error tidak diketahui (${error.message}).`;
            break;
    }
    const geoStatusElement = document.getElementById('geoStatus');
    if (geoStatusElement) {
        geoStatusElement.innerHTML = `<span class='mr-2'>⚠️</span> ${message}`;
        geoStatusElement.classList.add('text-red-400');
    }
}
function retakePhoto() {
    capturedImageDataURL = null;
    document.getElementById('capturedImage').src = '';
    document.getElementById('reportForm').classList.add('hidden');
    document.getElementById('cameraSection').classList.remove('hidden');
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
    var formData = new FormData();
    formData.append('foto_penyelesaian', file);
    formData.append('waktu_foto', new Date().toISOString());
    formData.append('alamat_foto', document.getElementById('fullAddress').innerText);
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
window.addEventListener('beforeunload', () => {
    if (stream) stream.getTracks().forEach(track => track.stop());
    if (watchId) navigator.geolocation.clearWatch(watchId);
});
</script>

@endsection
