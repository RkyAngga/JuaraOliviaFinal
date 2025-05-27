@extends('DasboardBelumLogin.AktivitasBelumLogin')
@section('title', 'laporansaya')

@section('Laporan')

<section>
    <div class="indent-30 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 sm:gap-4 mb-3">
            <h2 class="text-lg sm:text-xl md:text-[20px] font-bold text-hitam whitespace-nowrap">
                Aktivitas Pelaporan Saya
            </h2>
            {{-- Lebar garis responsif --}}
            <span class="block w-full sm:w-[200px] h-[3px] sm:h-[4px] bg-kuning"></span>
        </div>
    </div>
    {{-- Konten Section 1 --}}
    <div class="flex flex-col items-center justify-center min-h-[60vh] py-12 sm:py-16 px-4 relative overflow-hidden">
        <!-- Decorative elements - Sesuaikan ukuran jika perlu -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-5 sm:top-20 sm:left-10 w-24 h-24 sm:w-32 sm:h-32 bg-yellow-400 rounded-full blur-xl"></div>
            <div class="absolute bottom-5 right-5 sm:bottom-10 sm:right-10 w-32 h-32 sm:w-40 sm:h-40 bg-yellow-300 rounded-full blur-xl"></div>
        </div>

        <!-- Illustration - Ukuran responsif -->
        <div class="relative mb-6 sm:mb-8 animate-float">
            {{-- Ganti w-50 dengan kelas standar dan buat responsif --}}
            <img src="img/Desain/kosong.svg" alt="Ilustrasi" class="w-36 h-auto sm:w-44 md:w-52 drop-shadow-lg">
            <div class="absolute -inset-2 sm:-inset-4 bg-yellow-200 rounded-full -z-10 blur-md opacity-70"></div>
        </div>

        <!-- Text content - Ukuran teks dan max-width responsif -->
        <div class="text-center max-w-sm sm:max-w-md md:max-w-lg mx-auto mb-6 sm:mb-8 px-4">
            {{-- Ukuran teks heading responsif --}}
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2 sm:mb-3 leading-tight">
                Kamu belum pernah buat laporan!
            </h2>
            {{-- Ukuran teks paragraf responsif --}}
            <p class="text-base sm:text-lg text-gray-600 opacity-90">
                Yuk mulai berkontribusi untuk lingkungan yang lebih baik dengan membuat laporan pertama Anda!
            </p>
        </div>

        <!-- Enhanced CTA button - Padding dan ukuran teks responsif -->
        <a href="/login"
            class="relative inline-block px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm sm:text-base font-bold rounded-xl shadow-lg hover:shadow-xl  ring-yellow-300 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 overflow-hidden">
            <span class="relative z-10 flex items-center">
                {{-- Ukuran ikon bisa disesuaikan jika perlu --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Laporan Sekarang
            </span>
        </a>
        {{-- Elemen dekoratif bawah --}}
        <div class="absolute bottom-0 left-0 w-full h-12 sm:h-16 "></div>
    </div>

    {{-- Judul Section Aktivitas Pelaporan Selesai --}}
    <div class="indent-30 px-4 sm:px-6 lg:px-8 mt-8 sm:mt-12"> {{-- Tambahkan margin atas dan padding horizontal responsif --}}
        <div class="flex items-center gap-2 sm:gap-4 mb-3">
             {{-- Ukuran teks responsif --}}
            <h2 class="text-lg sm:text-xl md:text-[20px] font-bold text-hitam whitespace-nowrap">
                Aktivitas Pelaporan Selesai
            </h2>
             {{-- Lebar garis responsif --}}
            <span class="block w-full sm:w-[200px] h-[3px] sm:h-[4px] bg-kuning"></span>
        </div>
    </div>
    {{-- Konten Section 2 --}}
    <div class="flex flex-col items-center justify-center min-h-[60vh] w-full py-12 sm:py-16 px-4 relative overflow-hidden">
        <!-- Decorative elements - Sesuaikan ukuran jika perlu -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-5 sm:top-20 sm:left-10 w-24 h-24 sm:w-32 sm:h-32 bg-yellow-400 rounded-full blur-xl"></div>
            <div class="absolute bottom-5 right-5 sm:bottom-10 sm:right-10 w-32 h-32 sm:w-40 sm:h-40 bg-yellow-300 rounded-full blur-xl"></div>
        </div>

        <!-- Illustration - Ukuran responsif -->
        <div class="relative mb-6 sm:mb-8 animate-float">
             {{-- Ganti w-50 dengan kelas standar dan buat responsif --}}
            <img src="img/Desain/kosongselesai.svg" alt="Ilustrasi" class="w-36 h-auto sm:w-44 md:w-52 drop-shadow-lg">
            <div class="absolute -inset-2 sm:-inset-4 bg-yellow-200 rounded-full -z-10 blur-md opacity-70"></div>
        </div>

        <!-- Text content - Ukuran teks dan max-width responsif -->
        <div class="text-center max-w-sm sm:max-w-md md:max-w-lg mx-auto mb-6 sm:mb-8 px-4">
             {{-- Ukuran teks heading responsif --}}
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2 sm:mb-3 leading-tight">
                Belum ada laporan selesai!
            </h2>
             {{-- Ukuran teks paragraf responsif --}}
            <p class="text-base sm:text-lg text-gray-600 opacity-90">
                Laporan yang sudah selesai akan muncul di sini. Buat laporan baru jika Anda menemukan masalah!
            </p>
        </div>

        <!-- Enhanced CTA button - Padding dan ukuran teks responsif -->
        <a href="/login"
            class="relative inline-block px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm sm:text-base font-bold rounded-xl shadow-lg hover:shadow-xl  ring-yellow-300 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 overflow-hidden">
            <span class="relative z-10 flex items-center">
                 {{-- Ukuran ikon bisa disesuaikan jika perlu --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Laporan Sekarang
            </span>
        </a>
        {{-- Elemen dekoratif bawah --}}
        <div class="absolute bottom-0 left-0 w-full h-12 sm:h-16 bg-gradient-to-t from-white to-transparent"></div>
    </div>
</section>

{{-- Style untuk animasi tetap sama --}}
<style>
    @keyframes float {
        0%,
        100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

@endsection
