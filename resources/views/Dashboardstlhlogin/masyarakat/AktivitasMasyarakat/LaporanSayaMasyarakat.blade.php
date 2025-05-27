@extends('Dashboardstlhlogin.masyarakat.AktivitasMasyarakat')
@section('title', 'laporansaya')

@section('Laporan')

<section class="p-0 -mt-16">
    {{-- Header Aktivitas Pelaporan Saya --}}
    <div class="indent-34 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 sm:gap-4 mb-8">
            <h2 class="text-lg sm:text-xl md:text-[20px] font-bold text-hitam whitespace-nowrap">
                Aktivitas Pelaporan Saya
            </h2>
            {{-- Lebar garis responsif --}}
            <span class="block w-full sm:w-[200px] h-[3px] sm:h-[4px] bg-kuning"></span>
        </div>
    </div>

    {{-- Konten Card Laporan Aktif --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        @php
            $userReports = $laporans;
            $hasReports = $userReports->count() > 0;
            // Laporan aktif: status Menunggu, Di Proses, Ditolak (belum selesai)
            $activeReports = $userReports->filter(function($laporan) {
                if ($laporan->status == 'Menunggu') return true;
                if ($laporan->status == 'Di Proses') return true;
                if ($laporan->status == 'Ditolak') return true;
                return false;
            });
        @endphp

        @if(!$hasReports)
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
            {{-- Grid Card Laporan Aktif --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activeReports as $laporan)
                    @php
                        $trackProses = $laporan->tracking->where('status', 'Di Proses')->last();
                        $isMenungguVerif = $trackProses && $trackProses->sub_status == 'menunggu_verifikasi_admin';
                        $detailUrl = '';
                        if ($laporan->status == 'Menunggu') {
                            $detailUrl = route('masyarakat.laporan.menunggu', $laporan->id);
                        } elseif ($laporan->status == 'Di Proses' && $isMenungguVerif) {
                            $detailUrl = route('masyarakat.laporan.proses.ditindaklanjuti', $laporan->id);
                        } elseif ($laporan->status == 'Di Proses') {
                            $detailUrl = route('masyarakat.laporan.proses.diselesaikan', $laporan->id);
                        } elseif ($laporan->status == 'Ditolak') {
                            $detailUrl = route('masyarakat.laporan.ditolak', $laporan->id);
                        }
                    @endphp
                    <div class="card group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-l-4"
                        @if($laporan->status == 'Menunggu')
                            style="border-color: #FFD600;"
                        @elseif($laporan->status == 'Di Proses' && $isMenungguVerif)
                            style="border-color: #093456;"
                        @elseif($laporan->status == 'Di Proses')
                            style="border-color: #2196F3;"
                        @elseif($laporan->status == 'Ditolak')
                            style="border-color: #E53935;"
                        @endif
                    >
                        {{-- Badge Status --}}
                        <div class="absolute top-4 right-4 text-white text-xs font-semibold px-3 py-1 rounded-full z-10 shadow-sm"
                            @if($laporan->status == 'Menunggu')
                                style="background: #FFD600; color: #000;"
                            @elseif($laporan->status == 'Di Proses' && $isMenungguVerif)
                                style="background: #093456;"
                            @elseif($laporan->status == 'Di Proses')
                                style="background: #2196F3;"
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
                        <a href="{{ $detailUrl }}" class="block">
                            {{-- Foto Laporan --}}
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            {{-- Informasi Laporan --}}
                            <div class="p-5">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition-colors break-words whitespace-normal">{{ $laporan->deskripsi }}</h3>
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Header Aktivitas Pelaporan Selesai --}}
    <div class="indent-30 px-4 sm:px-6 lg:px-8 mt-8 sm:mt-12">
        <div class="flex items-center gap-2 sm:gap-4 mb-3">
            <h2 class="text-lg sm:text-xl md:text-[20px] font-bold text-hitam whitespace-nowrap">
                Aktivitas Pelaporan Selesai
            </h2>
            <span class="block w-full sm:w-[200px] h-[3px] sm:h-[4px] bg-kuning"></span>
        </div>
        <p class="text-sm text-gray-600 opacity-90 mb-8">Beri ulasan pada laporanmu yang telah selesai dan kumpulkan poin sebagai apresiasi</p>
    </div>

    {{-- Konten Card Laporan Selesai --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        @php
            $completedReports = $userReports->where('status', 'Selesai');
        @endphp
        @if($completedReports->isEmpty())
            {{-- Tampilan Kosong untuk Laporan Selesai --}}
            <div class="flex flex-col items-center justify-center min-h-[60vh] py-12 sm:py-16 px-4 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-10 left-5 sm:top-20 sm:left-10 w-24 h-24 sm:w-32 sm:h-32 bg-yellow-400 rounded-full blur-xl"></div>
                    <div class="absolute bottom-5 right-5 sm:bottom-10 sm:right-10 w-32 h-32 sm:w-40 sm:h-40 bg-yellow-300 rounded-full blur-xl"></div>
                </div>
                <!-- Illustration -->
                <div class="relative mb-6 sm:mb-8 animate-float">
                    <img src="{{ asset('img/Desain/kosongselesai.svg') }}" alt="Ilustrasi" class="w-36 h-auto sm:w-44 md:w-52 drop-shadow-lg">
                    <div class="absolute -inset-2 sm:-inset-4 bg-yellow-200 rounded-full -z-10 blur-md opacity-70"></div>
                </div>
                <!-- Text content -->
                <div class="text-center max-w-sm sm:max-w-md md:max-w-lg mx-auto mb-6 sm:mb-8 px-4">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2 sm:mb-3 leading-tight">
                        Belum ada laporan selesai!
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 opacity-90">
                        Laporan yang sudah selesai akan muncul di sini. Buat laporan baru jika Anda menemukan masalah!
                    </p>
                </div>
                <!-- CTA button -->
                <a href="/masyarakat/pengaduan/buat/1"
                    class="relative inline-block px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm sm:text-base font-bold rounded-xl shadow-lg hover:shadow-xl ring-yellow-300 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Laporan Sekarang
                    </span>
                </a>
            </div>
        @else
            {{-- Grid Card Laporan Selesai --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($completedReports as $laporan)
                    @php
                        $ulasan = $laporan->ulasan;
                        $borderColor = $ulasan ? '#327931' : '#43A047';
                        $detailUrl = $ulasan ? route('masyarakat.laporan.ulasan', $laporan->id) : route('masyarakat.laporan.selesai', $laporan->id);
                    @endphp
                    <div class="card group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-l-4" style="border-color: {{ $borderColor }};">
                        {{-- Badge Status --}}
                        <div class="absolute top-4 right-4 text-white text-xs font-semibold px-3 py-1 rounded-full z-10 shadow-sm" style="background: {{ $borderColor }};">
                            {{ $ulasan ? 'Sudah Diberi Ulasan' : 'Selesai' }}
                        </div>
                        {{-- Link Detail Laporan --}}
                        <a href="{{ $detailUrl }}" class="block">
                            {{-- Foto Laporan --}}
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Foto Laporan" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            {{-- Informasi Laporan --}}
                            <div class="p-5">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition-colors break-words whitespace-normal">{{ $laporan->deskripsi }}</h3>
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Style untuk animasi --}}
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

@endsection
