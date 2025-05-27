@extends('Dashboardstlhlogin.Dinas.Template.Template')
@section('title', 'Kinggg')

@section('content')

<section class="min-h-screen py-4">
    <div class="container mx-auto px-8">
        <!-- Header Section -->
    <div class="flex justify-between items-center mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                <a href="/dinas/laporan/masyarakat" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-yellow-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Detail Laporan Pengaduan</h2>
            </div>
    </div>
    <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>


        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Image Section -->
            <div class="lg:col-span-7">
                <div class="border-4 border-kuning rounded-xl shadow-xl overflow-hidden">
                    <img id="image-modal-trigger" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-96 md:h-[380px] object-cover rounded-xl transform hover:scale-105 transition duration-500 cursor-pointer">
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 my-8 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="h-8 w-1 bg-yellow-400 rounded-full mr-3"></div>
                        <h2 class="text-xl font-semibold text-gray-800">Waktu tindakan segera laporan penyelesaian</h2>
                    </div>
                    @php
                        $expired = $laporan->waktu_menunggu_expired ? \Carbon\Carbon::parse($laporan->waktu_menunggu_expired)->format('Y-m-d\TH:i:s') : null;
                    @endphp

                    @if($expired)
                        <div>
                            Waktu tindakan segera laporan penyelesaian:
                            <span id="countdown"></span>
                        </div>
                        <script>
                            let expired = new Date("{{ $expired }}").getTime();
                            let x = setInterval(function() {
                                let now = new Date().getTime();
                                let distance = expired - now;
                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("countdown").innerHTML = "Waktu habis Laporan sudah di-escalate ke Pemerintah Pusat!";
                                } else {
                                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                    document.getElementById("countdown").innerHTML = days + "hari " + hours + "jam " + minutes + "menit " + seconds + "detik";
                                }
                            }, 1000);
                        </script>
                    @else
                        <div class="text-red-500 font-bold">Waktu habis! Laporan sudah di-escalate ke Pemerintah Pusat.</div>
                    @endif
                </div>

            </div>
            

            <!-- Modal -->
            <div id="image-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden justify-center items-center z-50">
                <div class="relative bg-white p-8 rounded-lg">
                    <span id="close-modal" class="absolute top-2 right-2 text-2xl font-bold text-gray-500 cursor-pointer">&times;</span>
                    <img id="modal-image" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-auto max-h-[90vh] object-contain rounded-xl">
                </div>
            </div>

            <!-- Detail Section -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-xl shadow-xl p-8 h-full">

                     <!-- Problem Section -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Permasalahan</h3>
                        </div>
                        <p class="text-gray-700 text-lg pl-14">{{ $laporan->deskripsi }}</p>
                    </div>

                    <!-- Location Section -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Lokasi</h3>
                        </div>
                        <p class="text-gray-700 text-lg pl-14">{{ $laporan->lokasi }}</p>
                    </div>

                    <!-- Jam Laporan -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Waktu Laporan</h3>
                        </div>
                        <p class="text-gray-700 text-lg pl-14">{{ $laporan->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <!-- Status Timeline -->
                    @php
                        $trackMenunggu = $laporan->tracking->where('status', 'Menunggu')->last();
                    @endphp

                    @if($trackMenunggu)
                        <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 shadow-sm mb-4">
                            <span class="font-bold text-yellow-700">Menunggu Verifikasi</span>
                            <p>{{ $trackMenunggu->keterangan }}</p>
                            <p class="text-xs text-gray-400">Waktu: {{ $trackMenunggu->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    @endif

                    <!-- Status Section -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b-2 border-yellow-400 pb-2 inline-block">Status Laporan</h2>

                        <div class="relative mt-8 pl-6">
                            <!-- Vertical Timeline Line -->
                            <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-yellow-400 via-gray-200 to-gray-200 rounded-full"></div>

                            <!-- Status Items -->
                            <div class="space-y-5 md:space-y-7">
                                <!-- Status 1 - Active -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-5 md:h-6 w-5 md:w-6 rounded-full bg-yellow-400 border-4 border-white shadow-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 md:h-3 md:w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="pl-5 md:pl-7 w-full">
                                        <div class="bg-yellow-50 p-3 md:p-4 rounded-lg border border-yellow-100 shadow-sm w-full">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-6 w-6 md:h-7 md:w-7 rounded-full bg-yellow-100 mr-2.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base md:text-lg font-semibold text-gray-800">Menunggu Verifikasi</h3>
                                            </div>
                                            <p class="text-sm md:text-base text-gray-600 mt-1.5 md:mt-2 ml-8 md:ml-9">Laporanmu dikirim, menunggu verifikasi dinas</p>
                                            <p class="text-xs md:text-sm text-gray-400 mt-1 md:mt-1.5 ml-8 md:ml-9">Waktu Laporan {{ $laporan->created_at->format('Y-m-d H:i:s') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 2 - Next -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-5 md:h-6 w-5 md:w-6 rounded-full bg-gray-200 border-4 border-white shadow-lg"></div>
                                    </div>
                                    <div class="pl-5 md:pl-7 w-full">
                                        <div class="bg-gray-50 p-3 md:p-4 rounded-lg border border-gray-100 w-full">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-6 w-6 md:h-7 md:w-7 rounded-full bg-gray-200 mr-2.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base md:text-lg font-semibold text-gray-500">Dalam Proses</h3>
                                            </div>
                                            <p class="text-sm md:text-base text-gray-400 mt-1.5 md:mt-2 ml-8 md:ml-9">Laporan sedang di Proses, di tindak lanjuti</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status 3 - Future -->
                                <div class="relative flex items-start group">
                                    <div class="absolute left-0 flex items-center justify-center transform -translate-x-1/2 -translate-y-3">
                                        <div class="h-5 md:h-6 w-5 md:w-6 rounded-full bg-gray-200 border-4 border-white shadow-lg"></div>
                                    </div>
                                    <div class="pl-5 md:pl-7 w-full">
                                        <div class="bg-gray-50 p-3 md:p-4 rounded-lg border border-gray-100 w-full">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-6 w-6 md:h-7 md:w-7 rounded-full bg-gray-200 mr-2.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base md:text-lg font-semibold text-gray-500">Selesai</h3>
                                            </div>
                                            <p class="text-sm md:text-base text-gray-400 mt-1.5 md:mt-2 ml-8 md:ml-9">Laporanmu sudah selesai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex gap-2">
                        <button onclick="openRejectModal()" class="flex-1 px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Tolak Laporan
                        </button>
                        <form action="{{ route('dinas.laporan.tindaklanjuti', $laporan->id) }}" method="POST" class="inline flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Tindaklanjuti
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Rejection Modal with Transparent Background -->
<div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm hidden pointer-events-none">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 border border-gray-200 pointer-events-auto" id="modalContent">
        <div class="p-6 relative">
            <!-- Close Button -->
            <button onclick="closeRejectModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">Konfirmasi Penolakan</h3>
                <p class="text-gray-500 mt-1">Masukkan alasan penolakan laporan</p>
            </div>

            <!-- Form -->
            <form id="rejectForm" class="space-y-4" method="POST" action="{{ route('dinas.laporan.tolak', $laporan->id) }}">
                @csrf
                <div>
                    <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea id="rejectReason" name="alasan_penolakan" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Lokasi tidak jelas, foto tidak sesuai..." required></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeRejectModal()" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg hover:from-red-700 hover:to-red-600 transition-colors shadow-md">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- script gambar -->
<script>
    // Get the modal
    const modal = document.getElementById("image-modal");
    const modalImage = document.getElementById("modal-image");
    const triggerImage = document.getElementById("image-modal-trigger");
    const closeModal = document.getElementById("close-modal");

    // When the image is clicked, open the modal
    triggerImage.addEventListener("click", function() {
        modal.classList.remove("hidden");
        modalImage.src = triggerImage.src; // Set the image source in modal to be the same as the clicked image
    });

    // When the user clicks the close button, close the modal
    closeModal.addEventListener("click", function() {
        modal.classList.add("hidden");
    });

    // Optional: Close modal if clicked outside of the image
    modal.addEventListener("click", function(e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
</script>


<!-- script tolak -->
<script>
    // Modal functions with animation
    function openRejectModal() {
        const modal = document.getElementById('rejectModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        const content = document.getElementById('modalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Form submission
    document.getElementById('rejectForm').addEventListener('submit', function(e) {
        // e.preventDefault(); // <-- JANGAN ADA INI jika ingin submit normal!
        const reason = document.getElementById('rejectReason').value;

        // Here you would typically send the rejection reason to your backend
        console.log('Laporan ditolak dengan alasan:', reason);

        // Close modal
        closeRejectModal();

        // Show success notification
        showNotification('Laporan berhasil ditolak!', 'green');
    });

    // Notification function
    function showNotification(message, color) {
        const notification = document.createElement('div');
        notification.className = `fixed top-6 right-6 bg-${color}-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transform transition-all duration-300 translate-x-8 opacity-0`;

        // Icon based on color
        let icon;
        if (color === 'green') {
            icon = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>`;
        } else {
            icon = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>`;
        }

        notification.innerHTML = icon + message;
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-8', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 10);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('opacity-0', 'translate-x-8');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
</script>
@endsection
