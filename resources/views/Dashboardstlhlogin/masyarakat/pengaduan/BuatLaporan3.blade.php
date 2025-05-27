@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Form Pengaduan')

@section('content')
<section>
    <!-- Tambahkan meta tag CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Modal Sukses -->
    <div id="successModal" class="fixed inset-0 bg-opacity-50 z-50 hidden backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full mx-auto relative transform transition-all" >
            <!-- Close Button -->
            <button onclick="document.getElementById('successModal').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none">
                &times;
            </button>
            <div class="text-center">
                <h2 class="text-xl font-bold text-yellow-400 mb-4">Laporan Berhasil Terkirim</h2>
                <div class="w-10 h-10 mx-auto mb-4 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="text-gray-700 text-sm mb-4">
                    Terimakasih telah berkontribusi dalam melaporkan jalan rusak di Kabupaten Malang. <br>
                    Laporan Anda akan segera ditinjau oleh pihak terkait.
                </p>
                <button onclick="window.location.href='/masyarakat/pengaduan/buat/1'" class="bg-yellow-400 text-black text-sm font-bold py-3 px-6 rounded-lg hover:bg-white hover:text-kuning hover:ring-2 ring-kuning transition-colors inline-flex items-center gap-2 cursor-pointer">
                    Lihat Laporan Aktifmu 🚀
                </button>
            </div>
        </div>
    </div>

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
    <div class="min-h-screen  py-2 px-4 sm:px-6 lg:px-8">
        <div class="max-w-full md:max-w-2xl lg:max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 flex items-center justify-center gap-4">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-black">Laporan Pengaduan Saya</h1>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 max-w-xl mx-auto">
                <img id="previewImage" src="/img/Desain/foto.png" alt="Foto Laporan" class="w-full h-auto object-contain rounded-lg border ring-8 ring-kuning border-kuning">
            </div>

            <div class="px-6 sm:px-8 pb-8">
                <form id="pengaduanForm" action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="imageData" name="imageData">
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">

                    <div class="mt-6">
                        <label for="alamat" class="block text-base font-medium text-hitam mb-2">Alamat Laporan sesuai dengan Gmaps</label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-gray-100"
                            placeholder="Jl. Naim desa padaan, kecamatan pakishaji."
                            required
                            readonly
                        ></textarea>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-base font-medium text-hitam mb-2">Detail Permasalahan Laporan</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-gray-100"
                            placeholder="Jalan rusak parah, mohon diperbaiki"
                            required
                            readonly
                        ></textarea>
                    </div>

                    <div class="flex items-center gap-2 mt-6 mb-4">
                        <input
                            type="checkbox"
                            id="confirm"
                            name="confirm"
                            class="w-5 h-5 text-yellow-400 border-gray-300 rounded focus:ring-yellow-400"
                            required
                        >
                        <label for="confirm" class="text-sm text-gray-700">
                            Laporan pengaduan saya benar dan dapat dipertanggungjawabkan
                        </label>
                    </div>

                    <button
                        id="submitLaporanButton"
                        type="submit"
                        class="w-full mb-4 bg-yellow-400 hover:bg-abuabu text-black font-bold py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 cursor-pointer"
                    >
                        Kirim Laporan
                        <img src="{{ asset('img/icon/kirim.svg') }}" class="w-5 h-5">
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load data from localStorage
        const loadFromLocalStorage = () => {
            document.getElementById('imageData').value = localStorage.getItem('capturedImageData');
            document.getElementById('latitude').value = localStorage.getItem('capturedLatitude');
            document.getElementById('longitude').value = localStorage.getItem('capturedLongitude');
            document.getElementById('alamat').value = localStorage.getItem('capturedAlamat');
            document.getElementById('deskripsi').value = localStorage.getItem('capturedDeskripsi');

            if (localStorage.getItem('capturedImageData')) {
                document.getElementById('previewImage').src = localStorage.getItem('capturedImageData');
            }
        };

        loadFromLocalStorage();

        // Form submission handler
        const pengaduanForm = document.getElementById('pengaduanForm');
        let isSubmitting = false;

        pengaduanForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (isSubmitting) return; // Cegah double submit
            isSubmitting = true;

            // Disable form & button
            pengaduanForm.querySelectorAll('input, textarea, button').forEach(el => el.disabled = true);

            const submitButton = document.getElementById('submitLaporanButton');
            const originalButtonContent = submitButton.innerHTML; // Store original button content

            // Disable button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengirim...
            `;

            try {
                // Get the image data from localStorage
                const imageDataUrl = localStorage.getItem('capturedImageData');
                if (!imageDataUrl) {
                    throw new Error('Data foto tidak ditemukan');
                }

                // Convert base64 to blob
                const response = await fetch(imageDataUrl);
                const blob = await response.blob();

                // Create FormData
                const formData = new FormData();
                formData.append('foto', blob, 'foto.jpg');
                formData.append('latitude', document.getElementById('latitude').value);
                formData.append('longitude', document.getElementById('longitude').value);
                formData.append('alamat', document.getElementById('alamat').value);
                formData.append('deskripsi', document.getElementById('deskripsi').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                // Send the request using the form's action URL
                const fetchResponse = await fetch(this.action, { // Menggunakan this.action
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });

                // Handle different response types
                const contentType = fetchResponse.headers.get('content-type');

                if (!contentType || !contentType.includes('application/json')) {
                    if (fetchResponse.redirected) {
                        window.location.href = fetchResponse.url;
                        return;
                    }
                    const errorText = await fetchResponse.text(); // Get error text for debugging
                    console.error('Server response (non-JSON):', errorText);
                    throw new Error('Server mengirim response tidak valid atau terjadi kesalahan server.');
                }

                // Parse JSON response
                const data = await fetchResponse.json();

                if (fetchResponse.status === 422) {
                    const errorMessages = Object.values(data.errors).flat().join('\n');
                    throw new Error(errorMessages);
                }

                if (!fetchResponse.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan pada server');
                }

                if (data.success) {
                    localStorage.removeItem('capturedImageData');
                    localStorage.removeItem('capturedLatitude');
                    localStorage.removeItem('capturedLongitude');
                    localStorage.removeItem('capturedAlamat');
                    localStorage.removeItem('capturedDeskripsi');
                    window.location.href = '/masyarakat/pengaduan/buat/1';
                } else {
                    window.location.href = '/masyarakat/pengaduan/buat/1';
                }

            } catch (error) {
                console.error('Error:', error);

                // Re-enable button and restore original text on error
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonContent;
            } finally {
                isSubmitting = false;
                // Re-enable form
                pengaduanForm.querySelectorAll('input, textarea, button').forEach(el => el.disabled = false);
            }
        });
    });
</script>

@endsection