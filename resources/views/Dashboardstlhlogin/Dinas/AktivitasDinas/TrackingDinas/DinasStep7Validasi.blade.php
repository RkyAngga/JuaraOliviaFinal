@extends('Dashboardstlhlogin.Dinas.Template.Template')
@section('title', 'Laporan Selesai')

@section('content')

<section class="min-h-screen py-12">
    <div class="container mx-auto px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Laporan Berhasil dikirim</h2>
        <a href="/dinas/laporan/masyarakat" class="text-hitam hover:text-kuning transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>
    <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div>
    </div>

    {{-- Konten Section 1 --}}
    <div class="flex flex-col items-center justify-center min-h-[60vh] py-12 sm:py-16 px-4 relative overflow-hidden">
        <!-- Illustration - Ukuran responsif -->
        <div class="relative mb-6 sm:mb-8 animate-float">
            <div class="text-center max-w-sm sm:max-w-md md:max-w-lg mx-auto mb-6 sm:mb-8 px-4">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 sm:mb-3 leading-tight">
                    Yeay, Laporan Telah Selesai
                </h2>
            </div>
            <div class="relative flex justify-center">
                <img src="{{ asset('img/logo/laporan-selesai.png') }}" alt="Ilustrasi"
                     class="w-48 h-auto sm:w-56 md:w-64">
                <div class="absolute -inset-2 sm:-inset-4  rounded-full -z-10 blur-xl opacity-60"></div>
            </div>
        </div>



        <!-- Enhanced CTA button - Padding dan ukuran teks responsif -->
        <div class="mt-4">
            <button
                onclick="window.location.href='{{ route('dinas.laporan.step7.lanjutan', ['id' => $laporan->id]) }}';"
                type="button"
                class="relative inline-block px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm sm:text-base font-bold rounded-xl shadow-lg hover:shadow-xl  transition-all duration-300 transform hover:scale-105 focus:outline-none overflow-hidden">
                Lihat penyelesaian laporan
            </button>
        </div>
        {{-- Elemen dekoratif bawah --}}
        <div class="absolute bottom-0 left-0 w-full h-12 sm:h-16 "></div>
    </div>
</section>


@endsection
