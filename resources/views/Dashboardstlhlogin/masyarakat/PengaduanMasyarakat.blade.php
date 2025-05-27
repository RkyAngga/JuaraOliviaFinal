@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Kinggg')

@section('content')


<section class="min-h-screen">
    <div class="container mx-auto px-8 py-1">
        <div>
            <h2 class="text-[24px] md:text-[32px] font-bold text-hitam mt-7">
                Mengalami Masalah Terhadap Kerusakan Jalan ?
            </h2>
            <h2 class="text-[24px] md:text-[32px] font-bold text-kuning mb-3">
                Buat Laporan Baru Yuk !
            </h2>
            <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>
            <h2 class="text-[20px] md:text-[28px] font-bold text-hitam mt-4">
                Baca ini dulu sebelum membuat laporan ya!
            </h2>
        </div>
        <div class="max-w-4xl mx-auto p-4 sm:p-8 bg-kuning rounded-3xl shadow-xl my-5 relative overflow-hidden">
            <div class="relative z-20 space-y-6 sm:space-y-8">
                <div class="flex flex-col md:flex-row items-start gap-4 sm:gap-6 p-4 bg-putih/40 rounded-lg backdrop-blur-sm">
                    <div class="flex-shrink-0 p-2 bg-white rounded-full shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2">Tindak Lanjut Laporan</h4>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">
                            <span class="italic">Prioritas utama kami</span> adalah menangani laporan tentang jalan rusak dan berlubang di wilayah Kota Malang.
                            Setiap laporan yang masuk akan diverifikasi terlebih dahulu oleh tim kami dalam waktu maksimal
                            <span class="font-semibold">2x24 jam</span> sebelum ditindaklanjuti oleh dinas terkait.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-start gap-4 sm:gap-6 p-4 bg-putih/40 rounded-lg backdrop-blur-sm">
                    <div class="flex-shrink-0 p-2 bg-white rounded-full shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2">Lokasi Laporan</h4>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">
                            Sistem kami secara <span class="italic">otomatis</span> akan mendeteksi lokasi laporan berdasarkan metadata GPS dari foto yang Anda unggah.
                            Pastikan <span class="font-semibold">fitur lokasi</span> pada kamera smartphone Anda aktif untuk akurasi yang maksimal.
                            Lokasi ini akan membantu tim kami menemukan titik kerusakan dengan tepat.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-start gap-4 sm:gap-6 p-4 bg-putih/40 rounded-lg backdrop-blur-sm">
                    <div class="flex-shrink-0 p-2 bg-white rounded-full shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2">Laporan Publik</h4>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">
                            Secara default, semua laporan yang masuk bersifat <span class="italic">publik</span> dan dapat dilihat oleh pengguna lain.
                            Ini memungkinkan <span class="font-semibold">transparansi</span> dan memudahkan masyarakat untuk memantau perkembangan laporan.
                            Anda bisa melacak status laporan melalui dashboard akun pribadi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-4xl mx-auto p-4 sm:p-8 bg-kuning rounded-3xl my-5 shadow-xl relative overflow-hidden">
            <div class="relative z-20 space-y-6 sm:space-y-8">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="p-2 bg-red-100 rounded-full animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg md:text-xl font-bold text-red-700 tracking-tight">
                            PERHATIAN <span class="animate-bounce inline-block">⚠️</span>
                        </h4>
                    </div>
                </div>
                <div class="mt-4 sm:mt-6 pl-2">
                    <p class="text-black leading-relaxed text-sm sm:text-base">
                        <span class="italic font-medium text-sm sm:text-base">Fitur pelaporan kami dirancang khusus untuk pengalaman mobile!</span>
                        <br><br>
                        Untuk memberikan <span class="font-semibold">kualitas foto terbaik</span> dan <span class="italic">akurasi lokasi</span> yang presisi,
                        kami mengharuskan Anda mengakses halaman ini melalui <span class="underline">perangkat seluler</span>.
                        <br><br>
                        <span class="text-xs sm:text-sm">🔍 <span class="italic">Tips:</span> Aktifkan GPS dan gunakan kamera utama untuk hasil optimal</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="flex max-w-4xl mx-auto p-4 sm:p-8 relative overflow-hidden">
            <a href="{{ route('masyarakat.pengaduan.buat.step1') }}" class="flex items-center px-4 py-2 sm:px-6 sm:py-3 font-medium rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 text-xs sm:text-sm md:text-base bg-kuning hover:ring-2 ring-yellow-300 hover:bg-white hover:text-kuning text-white">
                Buat Laporan yuk
                <img src="{{ asset('img/icon/back.svg') }}" class="w-3 h-2 sm:w-3 sm:h-4 ml-1 sm:ml-1 gap-1 sm:gap-2" alt="icon">
            </a>
        </div>
    </div>
</section>



@endsection