@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Buat Laporan Baru')

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

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

<section class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-8 py-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                <a href="/masyarakat/pengaduan" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-yellow-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pengaduan</h2>
            </div>
        </div>
        <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>

        <!-- Card Section -->
        <div id="initialCards" class="grid grid-cols-2 gap-4 sm:gap-6 mb-6">
            <!-- Buat Laporan Baru -->
            <div class="bg-white rounded-3xl sm:rounded-3xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-shadow cursor-pointer" onclick="startApp()">
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                    <div class="bg-yellow-100 p-2 sm:p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10 text-yellow-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </div>
                    <h3 class="text-center sm:text-left text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-800 hover:text-yellow-600 transition-colors">
                        Buat Laporan Baru
                    </h3>
                </div>
            </div>

            <!-- Lihat Laporan Lain -->
            <a href="{{ route('masyarakat.laporan.warga') }}" class="block hover:shadow-xl transition-shadow">
                <div class="bg-white rounded-3xl sm:rounded-3xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-shadow">
                    <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                        <div class="bg-blue-100 p-2 sm:p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <h3 class="text-center sm:text-left text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-800 hover:text-yellow-600 transition-colors">
                            Lihat Laporan Warga Lainnya
                        </h3>
                    </div>
                </div>
            </a>
        </div>
        <!-- Panduan Section -->
        <div id="panduanSection" class="mt-10 my-4">
            <p class="text-base font-semibold text-black">
                Belum tahu <span class="text-yellow-500">bagaimana cara melapornya?</span>
            </p>
            <p class="text-base font-semibold text-black">
                Lihat panduan <span class="text-yellow-500 underline underline-offset-2"><a href="/masyarakat/panduan">disini</a></span>
            </p>
        </div>

        {{-- Camera Interface dan Report Form dipindahkan ke sini --}}
    <div class="container mx-auto px-8 py-1"> {{-- Buka container baru atau sesuaikan --}}

        <!-- Camera Interface -->
        <div id="cameraSection" class="hidden max-w-lg mx-auto mt-8"> {{-- Tambah margin top --}}
            <div class="bg-white rounded-xl shadow-lg p-4">
                <div class="relative">
                    <video id="camera" class="w-full h-74 object-cover rounded-lg"></video>
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

        <!-- Report Form -->
        <div id="reportForm" class="hidden max-w-lg mx-auto mt-8"> {{-- Tambah margin top --}}
            <div class="bg-white rounded-xl shadow-lg p-4">
                <h2 class="text-xl font-bold mb-4">Form Laporan</h2>

                <div class="relative mb-4">
                    <img id="capturedImage" class="w-full h-64 object-cover rounded-lg border-2 border-dashed">
                    <div class="address-overlay">
                        <div id="fullAddress"></div>
                        <div class="mt-1" id="geoDetails"></div>
                    </div>
                </div>


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

        <!-- Initial Button (Hidden by default, shown if camera fails or is closed) -->
        <div id="initialScreen" class="text-center mt-12 hidden">
            <button onclick="startApp()"
                class="bg-blue-500 text-white px-8 py-3 rounded-full text-lg hover:bg-blue-600 transition-colors">
                Mulai Pelaporan
            </button>
        </div>

    </div> {{-- Penutup container baru --}}

        {{-- Bagian Laporan Aktif Milikmu --}}
        <div class="container mx-auto px-6 mt-10">
            <!-- Header -->
            <div class="indent-30 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2 sm:gap-4 mb-10">
                    <h2 class="text-lg sm:text-xl md:text-[20px] font-bold text-hitam whitespace-nowrap">
                        Laporan Aktif Milikmu
                    </h2>
                    {{-- Lebar garis responsif --}}
                    <span class="block w-full sm:w-[200px] h-[3px] sm:h-[4px] bg-kuning"></span>
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                @if($laporans->isEmpty())
                    {{-- Tampilan Kosong untuk Laporan Aktif --}}
                    <div class="flex flex-col items-center justify-center min-h-[60vh] py-12 sm:py-16 px-4 relative overflow-hidden">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 left-0 w-full h-full opacity-10">
                            <div class="absolute top-10 left-5 sm:top-20 sm:left-10 w-24 h-24 sm:w-32 sm:h-32 bg-yellow-400 rounded-full blur-xl"></div>
                            <div class="absolute bottom-5 right-5 sm:bottom-10 sm:right-10 w-32 h-32 sm:w-40 sm:h-40 bg-yellow-300 rounded-full blur-xl"></div>
                        </div>

                        <!-- Illustration -->
                        <div class="relative mb-6 sm:mb-8 animate-float">
                            <img src="{{ asset('img/Desain/kosong.svg') }}" alt="Ilustrasi" class="w-36 h-auto sm:w-44 md:w-52 drop-shadow-lg">
                            <div class="absolute -inset-2 sm:-inset-4 bg-yellow-200 rounded-full -z-10 blur-md opacity-70"></div>
                        </div>

                        <!-- Text content -->
                        <div class="text-center max-w-sm sm:max-w-md md:max-w-lg mx-auto mb-6 sm:mb-8 px-4">
                            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2 sm:mb-3 leading-tight">
                                Kamu belum pernah buat laporan!
                            </h2>
                            <p class="text-base sm:text-lg text-gray-600 opacity-90">
                                Yuk mulai berkontribusi untuk lingkungan yang lebih baik dengan membuat laporan pertama Anda!
                            </p>
                        </div>

                        <!-- CTA button -->
                        <a href="/masyarakat/pengaduan/buat/1"
                            class="relative inline-block px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm sm:text-base font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-white transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 overflow-hidden">
                            <span class="relative z-10 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Laporan Sekarang
                            </span>
                        </a>
                    </div>
                @else
                    {{-- Grid Card Laporan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($laporans as $laporan)
                            @php
                                $trackProses = $laporan->tracking->where('status', 'Di Proses')->last();
                                $isMenungguVerif = $trackProses && $trackProses->sub_status == 'menunggu_verifikasi_admin';
                            @endphp
                            <div class="card group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-l-4"
                                @if($laporan->status == 'Menunggu')
                                    style="border-color: #FFD600;"
                                @elseif($laporan->status == 'Di Proses')
                                    style="border-color: {{ $isMenungguVerif ? '#093456' : '#2196F3' }};"
                                @elseif($laporan->status == 'Selesai')
                                    style="border-color: #43A047;"
                                @elseif($laporan->status == 'Ditolak')
                                    style="border-color: #E53935;"
                                @endif
                            >
                                {{-- Badge Status --}}
                                <div class="absolute top-4 right-4 text-white text-xs font-semibold px-3 py-1 rounded-full z-10 shadow-sm"
                                    @if($laporan->status == 'Menunggu')
                                        style="background: #FFD600; color: #000;"
                                    @elseif($laporan->status == 'Di Proses')
                                        style="background: {{ $isMenungguVerif ? '#093456' : '#2196F3' }};"
                                    @elseif($laporan->status == 'Selesai')
                                        style="background: #43A047;"
                                    @elseif($laporan->status == 'Ditolak')
                                        style="background: #E53935;"
                                    @endif
                                >
                                    @if($laporan->status == 'Di Proses')
                                        {{ $isMenungguVerif ? 'Menunggu Verifikasi Admin' : 'On-Proggres' }}
                                    @elseif($laporan->status == 'Ditolak')
                                        Ditolak
                                    @else
                                        {{ $laporan->status }}
                                    @endif
                                </div>

                                {{-- Link Detail Laporan --}}
                                <a href="
                                    @if($laporan->ulasan)
                                        {{ route('masyarakat.laporan.ulasan', $laporan->id) }}
                                    @elseif($laporan->status == 'Menunggu')
                                        {{ route('masyarakat.laporan.menunggu', $laporan->id) }}
                                    @elseif($laporan->status == 'Di Proses' && $isMenungguVerif)
                                        {{ route('masyarakat.laporan.proses.ditindaklanjuti', $laporan->id) }}
                                    @elseif($laporan->status == 'Di Proses')
                                        {{ route('masyarakat.laporan.proses.diselesaikan', $laporan->id) }}
                                    @elseif($laporan->status == 'Selesai')
                                        {{ route('masyarakat.laporan.selesai', $laporan->id) }}
                                    @elseif($laporan->status == 'Ditolak')
                                        {{ route('masyarakat.laporan.ditolak', $laporan->id) }}
                                    @endif
                                " class="block">
                                    {{-- Foto Laporan --}}
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                                    </div>

                                    {{-- Informasi Laporan --}}
                                    <div class="p-5">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition-colors line-clamp-2">{{ $laporan->deskripsi }}</h3>
                                            <span class="text-sm text-gray-500">{{ $laporan->created_at->format('Y-m-d H:i:s') }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600 text-sm mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <a href="/masyarakat/dashboard?focus={{ $laporan->id }}" title="Lihat di Peta" class="flex items-center text-gray-600 hover:text-green-600 transition-colors">
                                                <span class="truncate">{{ $laporan->lokasi }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </a>

                                {{-- Tombol Interaksi untuk Laporan yang Sedang Diproses --}}
                                @if($laporan->status == 'Di Proses')
                                <div class="px-5 pb-5 pt-0">
                                    <div class="flex justify-between items-center">
                                        <div class="flex space-x-4">
                                            <button class="like-btn flex items-center text-gray-500 hover:text-red-500 transition" data-liked="false">
                                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                <span>0</span>
                                            </button>
                                            <button class="flex items-center text-gray-500 hover:text-blue-500 transition">
                                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                <span>0</span>
                                            </button>
                                        </div>
                                        <a href="
                                            @if($laporan->status == 'Menunggu')
                                                {{ route('masyarakat.laporan.menunggu', $laporan->id) }}
                                            @elseif($laporan->status == 'Di Proses' && $isMenungguVerif)
                                                {{ route('masyarakat.laporan.proses.ditindaklanjuti', $laporan->id) }}
                                            @elseif($laporan->status == 'Di Proses')
                                                {{ route('masyarakat.laporan.proses.diselesaikan', $laporan->id) }}
                                            @elseif($laporan->status == 'Selesai')
                                                {{ route('masyarakat.laporan.selesai', $laporan->id) }}
                                            @elseif($laporan->status == 'Ditolak')
                                                {{ route('masyarakat.laporan.ditolak', $laporan->id) }}
                                            @endif
                                        " class="text-yellow-600 font-medium hover:text-yellow-700 transition-colors">Lihat Detail</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        {{-- Akhir Bagian Laporan Aktif Milikmu --}}

    </div> {{-- Penutup div container utama pertama --}}

    {{-- Loading Screen (tetap di luar container utama agar fullscreen) --}}
    <div id="loading" class="loading-overlay hidden">
        <div class="text-center">
            <div class="spinner mb-4"></div>
            <p>Menginisialisasi sistem...</p>
            <p class="text-sm opacity-75 mt-2" id="loading-detail"></p>
        </div>
    </div>
</section>

<div id="cooldownModal" class="fixed inset-0 flex items-center justify-center backdrop-blur-sm z-50  hidden">
    <div class="bg-white rounded-2xl px-8 py-8 max-w-lg w-full text-center shadow-lg relative">
        <div class="text-sm sm:text-2xl font-bold text-black mb-4">
            Mohon maaf tidak bisa mengirim laporan baru.<br>
            Anda harus menunggu (2 menit):
        </div>
        <div id="cooldownTimer" class="text-3xl sm:text-5xl font-bold text-black mb-6 font-mono">
            <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
        </div>
        <button onclick="closeCooldownModal()"
                class="mt-4 bg-kuning text-hitam font-bold py-2 px-8 rounded-lg hover:text-white hover:bg-kuning hover:ring-2 ring-white hover:bg-opacity-90 transform hover:scale-[0.98] transition-all duration-200 text-base shadow-lg">
            Oke
        </button>
    </div>
</div>

<script>
let stream = null;
let watchId = null;
let currentLocation = null;
let addressDetails = {};
let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
let cooldownTimer = null;
let cooldownCheckInterval = null;
let isInCooldown = false;

// Deteksi lingkungan
const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

function startCooldownTimer(totalSeconds) {
    // Clear existing timer if any
    if (cooldownTimer) clearInterval(cooldownTimer);

    const updateTimer = () => {
        // Pastikan totalSeconds adalah integer
        totalSeconds = Math.floor(totalSeconds);

        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = Math.floor(totalSeconds % 60);

        // Format waktu dengan padding nol di depan jika angka < 10
        const formattedHours = String(hours).padStart(2, '0');
        const formattedMinutes = String(minutes).padStart(2, '0');
        const formattedSeconds = String(seconds).padStart(2, '0');

        // Update tampilan timer dengan format HH:MM:SS
        document.getElementById('hours').textContent = formattedHours;
        document.getElementById('minutes').textContent = formattedMinutes;
        document.getElementById('seconds').textContent = formattedSeconds;

        if (totalSeconds <= 0) {
            clearInterval(cooldownTimer);
            isInCooldown = false;
            document.getElementById('cooldownModal').classList.add('hidden');
            return;
        }

        totalSeconds--;
    };

    updateTimer(); // Update immediately
    cooldownTimer = setInterval(updateTimer, 1000);
}

function closeCooldownModal() {
    document.getElementById('cooldownModal').classList.add('hidden');
    // Jika masih dalam cooldown, pastikan UI kembali ke state awal
    if (isInCooldown) {
        resetUIToInitial();
    }
}

function resetUIToInitial() {
    // Hentikan kamera jika masih aktif
    stopCameraStream();
    // Hentikan tracking lokasi
    stopGeoTracking();
    // Sembunyikan section kamera dan form laporan
    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('reportForm').classList.add('hidden');
    // Tampilkan kembali elemen awal
    document.getElementById('initialCards').classList.remove('hidden');
    document.getElementById('panduanSection').classList.remove('hidden');
    document.getElementById('initialScreen').classList.add('hidden');
}

function checkCooldown() {
    return new Promise((resolve, reject) => {
        fetch('/masyarakat/check-cooldown')
            .then(res => res.json())
            .then(data => {
                isInCooldown = !data.canReport;
                if (!data.canReport && data.remainingTime) {
                    document.getElementById('cooldownModal').classList.remove('hidden');
                    // Pastikan total_seconds adalah integer
                    const totalSeconds = Math.floor(data.remainingTime.total_seconds);
                    if (totalSeconds > 0) {
                        startCooldownTimer(totalSeconds);
                    }
                    resetUIToInitial();
                } else {
                    document.getElementById('cooldownModal').classList.add('hidden');
                    if (cooldownTimer) {
                        clearInterval(cooldownTimer);
                        cooldownTimer = null;
                    }
                }
                resolve(data.canReport);
            })
            .catch(error => {
                console.error('Error checking cooldown:', error);
                reject(error);
            });
    });
}

async function startApp() {
    try {
        // Check cooldown first
        const canReport = await checkCooldown();
        if (!canReport) {
            return; // Stop here if in cooldown
        }

        // Start periodic cooldown checks
        if (cooldownCheckInterval) clearInterval(cooldownCheckInterval);
        cooldownCheckInterval = setInterval(checkCooldown, 30000); // Check every 30 seconds

        // Validasi HTTPS untuk mobile
        if(!isLocalhost && window.location.protocol !== 'https:' && isMobile) {
            alert('Akses harus melalui HTTPS!');
            window.location.href = `https://${window.location.host}${window.location.pathname}`;
            return;
        }

        showLoading('Memulai sistem...');

        // Sembunyikan elemen awal
        document.getElementById('initialCards').classList.add('hidden');
        document.getElementById('panduanSection').classList.add('hidden');

        // 1. Cek kompatibilitas
        if(!checkCompatibility()) {
            hideLoading();
            document.getElementById('initialScreen').classList.remove('hidden');
            return;
        }

        // 2. Minta izin
        await requestPermissions();

        // 3. Inisialisasi kamera dan lokasi
        await Promise.all([startCamera(), startGeoTracking()]);

        // Tampilkan UI Kamera
        hideLoading();
        document.getElementById('cameraSection').classList.remove('hidden');

    } catch (error) {
        hideLoading();
        alert(`Error: ${error.message}`);
        resetUIToInitial();
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
        if(geoStatus.state === 'prompt') {
             // Minta izin jika belum diberikan
             await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 10000 });
            });
        } else if (geoStatus.state === 'denied') {
            throw new Error('Izin lokasi ditolak. Aktifkan izin lokasi di pengaturan browser Anda.');
        }

        // Izin kamera
        const camStatus = await navigator.permissions.query({ name: 'camera' });
         if (camStatus.state === 'prompt') {
            await navigator.mediaDevices.getUserMedia({ video: true }); // Minta izin kamera
        } else if (camStatus.state === 'denied') {
            throw new Error('Izin kamera ditolak. Aktifkan izin kamera di pengaturan browser Anda.');
        }
        // Jika sudah granted, tidak perlu minta lagi

    } catch (error) {
        // Tangani error spesifik jika diperlukan
        if (error.name === 'NotAllowedError' || error.message.includes('denied')) {
             throw new Error(`Izin diperlukan: ${error.message}. Mohon aktifkan izin di pengaturan browser.`);
        } else if (error.name === 'NotFoundError') {
             throw new Error('Tidak ada kamera yang ditemukan.');
        }
        throw new Error(`Permasalahan izin: ${error.message}`);
    }
}


function startGeoTracking() {
    return new Promise((resolve, reject) => {
        showLoading('Mencari lokasi GPS...');
        document.getElementById('geoStatus').innerHTML = `<span class="mr-2">🌍</span>Mencari GPS...`;

        // Simulasi lokasi untuk desktop
        if(!isMobile && isLocalhost) {
            console.log("Simulating location for desktop localhost");
            currentLocation = {
                latitude:  -7.95459832805591,
                longitude:  112.61261386055314,
                accuracy: 5
            };
            updateGeoDisplay(); // Panggil update setelah set lokasi
            getAddressDetails().then(resolve).catch(reject); // Dapatkan detail alamat
            return;
        }

        let resolved = false; // Flag untuk memastikan resolve hanya dipanggil sekali
        const options = {
            enableHighAccuracy: true,
            maximumAge: 0, // Jangan gunakan cache
            timeout: 20000 // Tingkatkan timeout
        };

        watchId = navigator.geolocation.watchPosition(
            position => {
                console.log("Position received:", position.coords);
                currentLocation = position.coords;
                updateGeoDisplay(); // Panggil update setiap kali ada posisi baru

                // Coba dapatkan alamat segera setelah posisi pertama didapat
                if (!addressDetails.jalan) { // Hanya panggil jika belum ada detail alamat
                    getAddressDetails();
                }

                // Resolve jika akurasi cukup baik
                if(currentLocation.accuracy <= 15 && !resolved) { // Tingkatkan toleransi akurasi awal
                    console.log("Accurate position found, resolving.");
                    resolved = true;
                    resolve();
                } else {
                     showLoading(`Meningkatkan akurasi GPS (${currentLocation.accuracy.toFixed(1)}m)...`);
                }
            },
            error => {
                console.error("Geolocation error:", error);
                handleGeoError(error);
                if (!resolved) {
                    reject(new Error(`Gagal mendapatkan lokasi: ${error.message}`));
                }
            },
            options
        );

         // Tambahkan timeout tambahan jika watchPosition tidak resolve dalam waktu tertentu
        setTimeout(() => {
            if (!resolved) {
                console.warn("Geolocation timeout reached, attempting to use last known position.");
                if (currentLocation) {
                    console.log("Using last known position:", currentLocation);
                    resolved = true;
                    resolve(); // Resolve dengan lokasi terakhir yang diketahui jika ada
                } else {
                     navigator.geolocation.clearWatch(watchId); // Hentikan watch jika timeout dan tidak ada lokasi
                     reject(new Error("Timeout saat mencari lokasi GPS. Pastikan GPS aktif dan sinyal baik."));
                }
            }
        }, options.timeout + 5000); // Beri waktu tambahan 5 detik setelah timeout utama
    });
}


function updateGeoDisplay() {
    if (!currentLocation) return; // Pastikan currentLocation ada

    // Update tampilan GPS di header kamera
    const geoStatusElement = document.getElementById('geoStatus');
    if (geoStatusElement) {
        geoStatusElement.innerHTML = `
            🌍 Akurasi: ${currentLocation.accuracy.toFixed(1)}m
            ${currentLocation.accuracy > 10 ? '⚠️' : '✅'}
        `;
    }

    // Update koordinat di overlay form laporan
    const geoDetailsElement = document.getElementById('geoDetails');
     if (geoDetailsElement) {
        geoDetailsElement.innerHTML = `
            Koordinat: <br>
            ${currentLocation.latitude.toFixed(6)},
            ${currentLocation.longitude.toFixed(6)}
        `;
    }
}

async function getAddressDetails() {
     if (!currentLocation) {
        console.warn("Cannot get address details, location is null.");
        return;
    }
    console.log("Fetching address details for:", currentLocation.latitude, currentLocation.longitude);
    try {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${currentLocation.latitude}&lon=${currentLocation.longitude}&addressdetails=1&accept-language=id`, // Tambahkan accept-language=id
            {
                headers: {
                    'User-Agent': 'LaporanAppMasyarakat/1.0 (juaraolivia@example.com)' // Ganti User-Agent jika perlu
                }
            }
        );

        if (!response.ok) {
            throw new Error(`Nominatim request failed with status ${response.status}`);
        }

        const data = await response.json();
        console.log("Address data received:", data);

        if (data.error) {
            throw new Error(`Nominatim error: ${data.error}`);
        }

        addressDetails = parseAddress(data.address);

        // Update tampilan alamat di overlay form laporan
        const fullAddressElement = document.getElementById('fullAddress');
        if (fullAddressElement) {
            fullAddressElement.innerHTML = `
                <div>${addressDetails.jalan ? `Jalan: ${addressDetails.jalan}` : ''}</div>
                <div>${addressDetails.gang ? `Gang/Lingkungan: ${addressDetails.gang}` : ''}</div>
                <div>${addressDetails.desa ? `Desa/Kel: ${addressDetails.desa}` : ''}</div>
                <div>${addressDetails.kecamatan ? `Kec. ${addressDetails.kecamatan}` : ''}</div>
                <div>${addressDetails.kota ? `${addressDetails.kota}` : ''}${addressDetails.provinsi ? `, ${addressDetails.provinsi}` : ''}</div>
            `.replace(/<div>\s*<\/div>/g, ''); // Hapus div kosong
        }

    } catch (error) {
        console.error('Error getting address details:', error);
         const fullAddressElement = document.getElementById('fullAddress');
         if (fullAddressElement) {
             fullAddressElement.innerHTML = `<div>Gagal mendapatkan detail alamat.</div>`;
         }
        // Set default empty values if address lookup fails
        addressDetails = {
            jalan: 'Tidak diketahui', gang: '', desa: '', kecamatan: '', kota: '', provinsi: ''
        };
    }
}


function parseAddress(address) {
    if (!address) return { jalan: 'Tidak diketahui', gang: '', desa: '', kecamatan: '', kota: '', provinsi: '' };

    // Prioritaskan 'suburb' atau 'county' atau 'city_district' untuk kecamatan
    // Urutan ini bisa disesuaikan jika 'suburb' lebih sering benar untuk kecamatan di area Anda
    let kecamatan = address.suburb || address.county || address.city_district || '';

    // Cek apakah field kecamatan malah berisi nama Kota/Kabupaten. Jika iya, coba cari alternatif.
    const kotaKab = address.city || address.town || '';
    if (kecamatan === kotaKab) {
        // Jika suburb adalah nama kota, coba county/city_district sebagai gantinya
        if (address.suburb === kotaKab) {
            kecamatan = address.county || address.city_district || '';
        }
        // Jika county adalah nama kota, coba suburb sebagai gantinya
        else if (address.county === kotaKab) {
             kecamatan = address.suburb || address.city_district || '';
        }
         // Jika masih sama dengan nama kota/kabupaten, kemungkinan data kecamatan tidak spesifik dari Nominatim
         if (kecamatan === kotaKab) {
             kecamatan = ''; // Kosongkan jika tidak ada data kecamatan yang valid
         }
    }

    // Prioritaskan 'village' atau 'hamlet' untuk desa/kelurahan
    let desa = address.village || address.hamlet || '';

    // Jika desa kosong, dan 'suburb' tidak sama dengan kecamatan yang sudah didapat (atau kecamatan kosong),
    // maka kemungkinan 'suburb' adalah nama desa/kelurahan.
    if (!desa && address.suburb && address.suburb !== kecamatan) {
        desa = address.suburb;
    }
    // Fallback lain untuk desa jika masih kosong, coba 'neighbourhood'
    if (!desa && address.neighbourhood) {
         desa = address.neighbourhood;
    }


    // Gunakan 'neighbourhood' untuk gang/lingkungan jika ada dan tidak sama dengan desa
    let gang = (address.neighbourhood && address.neighbourhood !== desa) ? address.neighbourhood : '';


    return {
        jalan: address.road || '',
        gang: gang,
        desa: desa,
        kecamatan: kecamatan,
        kota: kotaKab, // Gunakan variabel kotaKab yang sudah didefinisikan
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
                facingMode: isMobile ? { exact: 'environment' } : 'user' // Prioritaskan kamera belakang di mobile
            }
        };

        stream = await navigator.mediaDevices.getUserMedia(constraints);
        const video = document.getElementById('camera');

        video.playsInline = true; // Penting untuk iOS
        video.muted = true; // Mute untuk autoplay

        video.srcObject = stream;
        await video.play();
        console.log("Camera started successfully.");

    } catch (error) {
        console.error("Error starting camera:", error);
         // Coba lagi dengan facingMode tidak spesifik jika 'environment' gagal
         if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
             console.log("Retrying camera without specific facingMode...");
             try {
                 const fallbackConstraints = { video: { width: { ideal: 1280 }, height: { ideal: 720 } } };
                 stream = await navigator.mediaDevices.getUserMedia(fallbackConstraints);
                 const video = document.getElementById('camera');
                 video.playsInline = true;
                 video.muted = true;
                 video.srcObject = stream;
                 await video.play();
                 console.log("Camera started successfully with fallback constraints.");
             } catch (fallbackError) {
                 console.error("Fallback camera start failed:", fallbackError);
                 throw new Error(`Gagal mengakses kamera: ${fallbackError.message}`);
             }
         } else {
            throw new Error(`Gagal mengakses kamera: ${error.message}`);
         }
    }
}


let capturedImageDataURL = null; // Variabel global untuk menyimpan data URL gambar

function capturePhoto() {
    // Pastikan lokasi sudah didapat sebelum mengambil foto
    if (!currentLocation || currentLocation.accuracy > 50) { // Tambah batas akurasi
        alert(`Lokasi GPS belum akurat (${currentLocation ? currentLocation.accuracy.toFixed(1) + 'm' : 'tidak ditemukan'}). Tunggu sebentar atau coba lagi di tempat dengan sinyal lebih baik.`);
        return;
    }

    const video = document.getElementById('camera');
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // --- Tambahkan Watermark ---
    const now = new Date();
    const timestamp = now.toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'medium', hour12: false }).replace(/\./g, '/'); // Format Tgl/Bln/Thn JJ:MM:SS
    const gpsText = `Lat: ${currentLocation.latitude.toFixed(6)}, Lon: ${currentLocation.longitude.toFixed(6)}, Acc: ${currentLocation.accuracy.toFixed(1)}m`;

    // Format Alamat dari addressDetails (pastikan addressDetails sudah terisi)
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

    // Styling watermark
    const fontSize = Math.max(12, Math.min(16, Math.round(canvas.width / 60))); // Ukuran font adaptif
    context.font = `${fontSize}px Arial`;
    context.fillStyle = 'rgba(0, 0, 0, 0.6)'; // Latar belakang semi-transparan
    const textPadding = fontSize * 0.4;
    const lineHeight = fontSize * 1.3; // Sesuaikan berdasarkan ukuran font

    // Hitung posisi Y mulai dari bawah
    const bottomMargin = 10;
    const totalLines = addressLines.length + 2; // Alamat + GPS + Timestamp
    const backgroundHeight = (lineHeight * totalLines) + (textPadding * 1.5);
    const startY = canvas.height - backgroundHeight - bottomMargin;

    // Ukur lebar teks maksimum untuk background
    let maxWidth = 0;
    [...addressLines, gpsText, timestamp].forEach(line => {
        const lineWidth = context.measureText(line).width;
        if (lineWidth > maxWidth) {
            maxWidth = lineWidth;
        }
    });
    const backgroundWidth = maxWidth + (textPadding * 2);

    // Gambar background
    context.fillRect(
        textPadding, // X
        startY, // Y
        backgroundWidth, // Width
        backgroundHeight // Height
    );

    // Gambar teks watermark
    context.fillStyle = 'white'; // Warna teks
    let currentY = startY + lineHeight; // Posisi Y untuk baris pertama

    // Gambar baris alamat
    addressLines.forEach(line => {
        context.fillText(line, textPadding * 2, currentY);
        currentY += lineHeight;
    });

    // Gambar baris GPS dan Timestamp
    context.fillText(gpsText, textPadding * 2, currentY);
    currentY += lineHeight;
    context.fillText(timestamp, textPadding * 2, currentY);
    // --- Akhir Watermark ---

    capturedImageDataURL = canvas.toDataURL('image/jpeg', 0.9);

    const capturedImageElement = document.getElementById('capturedImage');
    capturedImageElement.src = capturedImageDataURL;

    updateGeoDisplay();
    // Tidak perlu panggil getAddressDetails lagi di sini karena sudah dipanggil sebelumnya
    // dan datanya digunakan untuk watermark

    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('reportForm').classList.remove('hidden');
}

function handleGeoError(error) {
    let message = 'Gagal mendapatkan lokasi: ';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message += "Izin lokasi ditolak.";
            break;
        case error.POSITION_UNAVAILABLE:
            message += "Informasi lokasi tidak tersedia.";
            break;
        case error.TIMEOUT:
            message += "Timeout saat mencari lokasi.";
            break;
        default:
            message += `Error tidak diketahui (${error.message}).`;
            break;
    }
    console.error("Geolocation Error:", message, error);
    // Update UI untuk menampilkan error
    const geoStatusElement = document.getElementById('geoStatus');
    if (geoStatusElement) {
        geoStatusElement.innerHTML = `<span class="mr-2">⚠️</span> ${message}`;
        geoStatusElement.classList.add('text-red-400'); // Tambah warna merah
    }
     // Mungkin tampilkan alert atau pesan lain ke pengguna
     // alert(message);
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
    // Bersihkan data gambar yang tersimpan
    capturedImageDataURL = null;
    document.getElementById('capturedImage').src = ''; // Kosongkan preview

    // Sembunyikan form, tampilkan kamera lagi
    document.getElementById('reportForm').classList.add('hidden');
    document.getElementById('cameraSection').classList.remove('hidden');

    // Mulai ulang kamera dan geo tracking jika sebelumnya dihentikan
    // Jika tidak dihentikan di capturePhoto, baris ini mungkin tidak perlu
    // startCamera();
    // startGeoTracking(); // Mungkin tidak perlu jika watchPosition masih aktif
}

function submitReport() {
    // Ambil deskripsi (jika ada di form ini, tapi sepertinya tidak)
    // const description = document.getElementById('reportDesc').value;

    // Pastikan data gambar dan lokasi ada
    if (!capturedImageDataURL || !currentLocation) {
        alert('Data gambar atau lokasi tidak lengkap. Silakan ambil foto ulang.');
        return;
    }

    try {
        // Simpan data ke localStorage untuk digunakan di halaman berikutnya
        localStorage.setItem('capturedImageData', capturedImageDataURL);
        localStorage.setItem('capturedLatitude', currentLocation.latitude.toString());
        localStorage.setItem('capturedLongitude', currentLocation.longitude.toString());

        console.log('Data disimpan ke localStorage:', {
            image: capturedImageDataURL.substring(0, 50) + '...', // Log sebagian data gambar
            lat: currentLocation.latitude,
            lon: currentLocation.longitude
        });

        // Arahkan ke halaman BuatLaporan2
        window.location.href = '/masyarakat/pengaduan/buat/2';

    } catch (error) {
        console.error('Gagal menyimpan ke localStorage:', error);
        // Cek apakah error karena storage penuh
        if (error.name === 'QuotaExceededError') {
            alert('Penyimpanan browser penuh. Tidak dapat melanjutkan.');
        } else {
            alert('Terjadi kesalahan saat menyimpan data laporan.');
        }
    }
}

function stopCameraStream() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
        console.log("Camera stream stopped.");
    }
}

function stopGeoTracking() {
     if (watchId) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
        console.log("Geolocation tracking stopped.");
    }
}

function closeCamera() {
    stopCamera();
    stopGeoTracking();
    // Sembunyikan UI kamera/form, tampilkan kembali elemen awal
    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('reportForm').classList.add('hidden');
    document.getElementById('initialCards').classList.remove('hidden');
    document.getElementById('panduanSection').classList.remove('hidden');
    document.getElementById('initialScreen').classList.add('hidden'); // Sembunyikan tombol retry
    hideLoading();
}


// Tambahkan event listener untuk membersihkan resource saat halaman ditutup
window.addEventListener('beforeunload', () => {
    stopCameraStream();
    stopGeoTracking();
    if (cooldownTimer) clearInterval(cooldownTimer);
    if (cooldownCheckInterval) clearInterval(cooldownCheckInterval);
});

document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        checkCooldown(); // Check cooldown status when page becomes visible
    }
});

</script>

@endsection
