@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Kinggg')

@section('content')

<section class="min-h-screen">
    <div class="container mx-auto px-10">
        <!-- Header Section -->
    <div class="flex justify-between items-center mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                <a href="/masyarakat/pengaduan" class="p-2 hover:bg-gray-100 rounded-lg transition-colors group">
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
                <div class="bg-white rounded-xl shadow-xl overflow-hidden border-4 border-white">
                    <img id="image-modal-trigger" src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-96 md:h-[380px] object-cover rounded-xl transform hover:scale-105 transition duration-500 cursor-pointer">
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

                        <div class="space-y-5 md:space-y-7 w-full max-w-md md:max-w-lg mx-auto px-4 md:px-0">
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
            </div>
        </div>
        </div>
    </div>
</section>

@endsection
