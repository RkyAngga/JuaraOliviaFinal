@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Edit Alamat & Deskripsi Laporan')

@section('content')
<section class="py-6">
    {{-- Header Pengaduan with improved styling --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/masyarakat/pengaduan" class="p-2.5 bg-white rounded-lg transition-all duration-300 hover:bg-yellow-50 hover:shadow-md group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-yellow-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">Pengaduan</h2>
        </div>
        <div class="w-full h-1 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-400 rounded-full shadow-sm"></div>
    </div>

    {{-- Main Content with enhanced card design --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            {{-- Form Title with improved typography --}}
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 text-center">Edit Alamat & Deskripsi Laporan</h1>
            </div>

            {{-- Form Content with better spacing --}}
            <div class="p-8">
                <!-- Enhanced Preview Photo Section -->
                <div class="mb-8 bg-gray-50 p-6 rounded-xl">
                    <img id="previewImage" class="w-full h-auto object-contain rounded-xl border-2 border-yellow-400 ring-4 ring-yellow-100 shadow-md transition-all duration-300 hover:shadow-lg" src="" alt="Preview foto laporan">
                    <div class="mt-6 flex justify-center">
                        <button onclick="window.location.href='/masyarakat/pengaduan/buat/1'" class="flex items-center gap-3 bg-yellow-400 hover:bg-abuabu text-gray-900 font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                            <span>Ambil Foto Ulang</span>
                        </button>
                    </div>
                </div>

                <!-- Improved Form Input Area -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                    <form id="reportForm" action="/masyarakat/pengaduan/buat/3" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" id="imageData" name="imageData">
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        {{-- Enhanced Address Field --}}
                        <div class="space-y-3">
                            <label for="alamat" class="block text-base font-semibold text-gray-800">Edit Alamat Laporan <span class="text-red-500 text-sm">*</span></label>
                            <textarea 
                                id="alamat" 
                                name="alamat" 
                                placeholder="Memuat alamat otomatis..." 
                                class="w-full p-4 border border-gray-200 rounded-lg resize-none bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring focus:ring-yellow-100 transition-all duration-300 text-gray-700" 
                                rows="3"
                            ></textarea>
                            <p class="text-sm text-gray-500 italic">Alamat diisi otomatis berdasarkan lokasi foto. Anda bisa mengeditnya jika perlu.</p>
                        </div>

                        {{-- Enhanced Description Field --}}
                        <div class="space-y-3">
                            <label for="deskripsi" class="block text-base font-semibold text-gray-800">Detail Permasalahan <span class="text-red-500 text-sm">*</span></label>
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                placeholder="Contoh: Jalan rusak berlubang sangat parah..." 
                                class="w-full p-4 border border-gray-200 rounded-lg resize-none bg-gray-50 focus:bg-white focus:border-yellow-400 focus:ring focus:ring-yellow-100 transition-all duration-300 text-gray-700" 
                                rows="4"
                            ></textarea>
                        </div>
                    </form>
                </div>

                {{-- Enhanced Continue Button --}}
                <div class="mt-8 flex justify-end">
                    <button
                        type="button"
                        onclick="prepareAndSubmit()"
                        class="group flex items-center gap-3 bg-yellow-400 hover:bg-abuabu text-gray-900 font-bold py-3 px-8 rounded-full transition-all duration-300 shadow-md hover:shadow-lg"
                    >
                        <span>Lanjutkan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewImage = document.getElementById('previewImage');
        const imageDataInput = document.getElementById('imageData');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const alamatTextarea = document.getElementById('alamat');

        // Ambil data dari localStorage
        const capturedImageData = localStorage.getItem('capturedImageData');
        const capturedLatitude = localStorage.getItem('capturedLatitude'); // <-- Mengambil Latitude dari penyimpanan
        const capturedLongitude = localStorage.getItem('capturedLongitude'); // <-- Mengambil Longitude dari penyimpanan

        // Tampilkan Gambar
        if (capturedImageData) {
            previewImage.src = capturedImageData;
            imageDataInput.value = capturedImageData; // Tetap simpan data gambar di input hidden
        } else {
            console.log('Tidak ada data gambar ditemukan di localStorage.');
            previewImage.alt = 'Tidak ada preview gambar';

        }

        // Isi Latitude dan Longitude (dan coba ambil alamat)
        if (capturedLatitude && capturedLongitude) {
            latitudeInput.value = capturedLatitude;
            longitudeInput.value = capturedLongitude;
            // Panggil fungsi untuk mengambil alamat berdasarkan koordinat yang disimpan
            fetchAddressFromCoordinates(capturedLatitude, capturedLongitude); // <-- Mengambil alamat sesuai koordinat foto
        } else {
            alamatTextarea.placeholder = 'Koordinat lokasi tidak ditemukan. Isi alamat manual.';
            console.log('Koordinat (latitude/longitude) tidak ditemukan di localStorage.');
        }
    });

    // Fungsi untuk mengambil alamat dari koordinat menggunakan Nominatim API
    async function fetchAddressFromCoordinates(lat, lon) {
        const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`;
        const alamatTextarea = document.getElementById('alamat');
        alamatTextarea.placeholder = 'Mencari alamat...'; // Update placeholder

        try {
            const response = await fetch(apiUrl, {
                headers: {
                    'Accept': 'application/json',
                    'Accept-Language': 'id-ID,id;q=0.9' // Request bahasa Indonesia jika tersedia
                }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            if (data && data.display_name) {
                alamatTextarea.value = data.display_name; // <-- Mengisi textarea dengan alamat dari API
            } else {
                alamatTextarea.value = ''; // Kosongkan jika tidak ditemukan
                alamatTextarea.placeholder = 'Alamat tidak ditemukan. Silakan isi manual.';
                console.warn('Tidak dapat menemukan alamat untuk koordinat:', lat, lon, data);
            }
        } catch (error) {
            alamatTextarea.value = ''; // Kosongkan jika error
            alamatTextarea.placeholder = 'Gagal mengambil alamat. Silakan isi manual.';
            console.error('Error fetching address:', error);
        }
    }

    function prepareAndSubmit() {
        // Ambil data dari form
        const imageData = document.getElementById('imageData').value;
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;
        const alamat = document.getElementById('alamat').value;
        const deskripsi = document.getElementById('deskripsi').value;

        // Validasi sederhana sebelum lanjut
        if (!alamat.trim()) {
            alert('Alamat laporan tidak boleh kosong.');
            document.getElementById('alamat').focus();
            return;
        }
        if (!deskripsi.trim()) {
            alert('Harap isi deskripsi permasalahan laporan.');
            document.getElementById('deskripsi').focus();
            return;
        }

        // Simpan ke localStorage
        localStorage.setItem('capturedImageData', imageData);
        localStorage.setItem('capturedLatitude', latitude);
        localStorage.setItem('capturedLongitude', longitude);
        localStorage.setItem('capturedAlamat', alamat);
        localStorage.setItem('capturedDeskripsi', deskripsi);

        // Redirect ke BuatLaporan3 (GET)
        window.location.href = '/masyarakat/pengaduan/buat/3';
    }

</script>

@endsection
