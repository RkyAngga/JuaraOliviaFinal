@extends('Dashboardstlhlogin.pemerintahpusat.template.template')
@section('title', 'pusat')

@section('content')

<section class="min-h-screen py-4">
    <div class="container mx-auto px-8">
        <!-- Header Section -->
    <div class="flex justify-between items-center mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                <a href="/pemerintahpusat/laporan" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group">
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
            <div class="lg:col-span-7 space-y-6">
               <!-- Image Section -->
            <div class="lg:col-span-7">
                <div class="border-4 border-merah rounded-xl shadow-xl overflow-hidden">
                    <img id="image-modal-trigger" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-96 md:h-[380px] object-cover rounded-xl transform hover:scale-105 transition duration-500 cursor-pointer">
                </div>
            </div>

                <!-- Rejection Reason Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="h-8 w-1 bg-yellow-400 rounded-full mr-3"></div>
                        <h2 class="text-xl font-semibold text-gray-800">Alasan Penolakan</h2>
                    </div>
                    <p class="text-gray-700 pl-4">{{ $alasan_penolakan }}</p>
                    <p class="text-gray-400 pl-4 text-xs">Ditolak pada: {{ \Carbon\Carbon::parse($waktu_tolak)->format('d M Y • H:i') }} WIB</p>
                </div>
            </div>
            <!-- Modal -->
            <div id="image-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden justify-center items-center z-50">
                <div class="relative bg-white p-8 rounded-lg">
                    <span id="close-modal" class="absolute top-2 right-2 text-2xl font-bold text-gray-500 cursor-pointer">&times;</span>
                    <img id="modal-image" src="/img/Desain/foto.png" alt="Foto Laporan" class="w-full h-auto max-h-[90vh] object-contain rounded-xl">
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

                    <!-- Status Section -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b-2 border-yellow-400 pb-2 inline-block">Status Laporan</h2>

                        <div class="relative mt-8 pl-6">
                            <!-- Vertical Timeline Line -->
                            <div class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-yellow-400 to-red-400 rounded-full"></div>

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
                                        <div class="h-5 md:h-6 w-5 md:w-6 rounded-full bg-red-400 border-4 border-white shadow-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 md:h-3 md:w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path fill-rule="evenodd" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="pl-5 md:pl-7 w-full">
                                        <div class="bg-red-50 p-3 md:p-4 rounded-lg border border-red-100 shadow-sm w-full">
                                            <div class="flex items-center">
                                                <span class="flex items-center justify-center h-6 w-6 md:h-7 md:w-7 rounded-full bg-red-100 mr-2.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                                    </svg>
                                                </span>
                                                <h3 class="text-base md:text-lg font-semibold text-gray-500">Laporan Ditolak</h3>
                                            </div>
                                            <p class="text-sm md:text-base text-gray-400 mt-1.5 md:mt-2 ml-8 md:ml-9">Laporan Ditolak: {{ $alasan_penolakan }}</p>
                                            <p class="text-xs md:text-sm text-gray-400 mt-1 md:mt-1.5 ml-8 md:ml-9">{{ \Carbon\Carbon::parse($waktu_tolak)->format('d M Y • H:i') }} WIB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>





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
@endsection