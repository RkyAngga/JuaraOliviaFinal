@extends('Dashboardstlhlogin.masyarakat.AktivitasMasyarakat')
@section('title', 'laporansaya')

@section('Laporan')

<section class="p-0 -mt-12">
    <!-- Search and Filter -->
    <div class="max-w-6xl mx-auto mb-2">
        <form method="GET" action="{{ route('masyarakat.laporan.warga') }}" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari laporan..."
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <select name="status" class="px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Di Proses" {{ request('status') == 'Di Proses' ? 'selected' : '' }}>Di Proses</option>
                <option value="Menunggu Verifikasi Admin" {{ request('status') == 'Menunggu Verifikasi Admin' ? 'selected' : '' }}>Menunggu Verifikasi Admin</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="px-6 py-3 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 transition">
                Terapkan
            </button>
        </form>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mt-8 sm:mt-12">
        <div class="flex items-center gap-2 sm:gap-4 mb-2">
            <h2 class="text-lg sm:text-xl md:text-[20px] font-bold text-hitam whitespace-nowrap">
                Laporan Pengaduan Warga
            </h2>
            <span class="block w-full sm:w-[200px] h-[3px] sm:h-[4px] bg-kuning"></span>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        @if($laporans->isEmpty())
            {{-- Tampilan Kosong --}}
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
                        Belum ada laporan yang tersedia!
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 opacity-90">
                        Jadilah yang pertama untuk melaporkan masalah di lingkungan Anda.
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
            @php
                // Ambil query pencarian dan status dari request
                $q = request('q');
                $statusFilter = request('status');
                $filteredLaporans = $laporans->filter(function($laporan) use ($q, $statusFilter) {
                    $trackProses = $laporan->tracking->where('status', 'Di Proses')->last();
                    $isMenungguVerif = $trackProses && $trackProses->sub_status == 'menunggu_verifikasi_admin';
                    // Filter status
                    if ($statusFilter) {
                        if ($statusFilter === 'Menunggu' && $laporan->status !== 'Menunggu') return false;
                        if ($statusFilter === 'Di Proses' && ($laporan->status !== 'Di Proses' || $isMenungguVerif)) return false;
                        if ($statusFilter === 'Menunggu Verifikasi Admin' && (!$isMenungguVerif || $laporan->status !== 'Di Proses')) return false;
                        if ($statusFilter === 'Ditolak' && $laporan->status !== 'Ditolak') return false;
                        if ($statusFilter === 'Selesai' && $laporan->status !== 'Selesai') return false;
                    }
                    // Filter search
                    if ($q) {
                        $qLower = strtolower($q);
                        $desc = strtolower($laporan->deskripsi);
                        $lokasi = strtolower($laporan->lokasi);
                        if (strpos($desc, $qLower) === false && strpos($lokasi, $qLower) === false) {
                            return false;
                        }
                    }
                    return true;
                });
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($filteredLaporans as $laporan)
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
                        } elseif ($laporan->status == 'Selesai') {
                            $detailUrl = route('masyarakat.laporan.ulasan', $laporan->id);
                        }
                        $borderColor = match($laporan->status) {
                            'Menunggu' => '#FFD600',
                            'Di Proses' => $isMenungguVerif ? '#093456' : '#2196F3',
                            'Selesai' => '#43A047',
                            'Ditolak' => '#E53935',
                            default => '#FFD600',
                        };
                        $badgeColor = $borderColor;
                    @endphp
                    <div class="card group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-l-4" style="border-color: {{ $borderColor }};">
                        {{-- Badge Status --}}
                        <div class="absolute top-4 right-4 text-white text-xs font-semibold px-3 py-1 rounded-full z-10 shadow-sm" style="background: {{ $badgeColor }};">
                            @if($laporan->status == 'Di Proses')
                                {{ $isMenungguVerif ? 'Menunggu Verifikasi Admin' : 'On-Proggres' }}
                            @elseif($laporan->status == 'Ditolak')
                                Tidak Terselesaikan
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

<script>
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const isLiked = this.getAttribute('data-liked') === 'true';
            const icon = this.querySelector('svg');
            const count = this.querySelector('span:last-child');

            if (isLiked) {
                this.setAttribute('data-liked', 'false');
                this.classList.remove('text-red-500');
                count.textContent = parseInt(count.textContent) - 1;
            } else {
                this.setAttribute('data-liked', 'true');
                this.classList.add('text-red-500');
                count.textContent = parseInt(count.textContent) + 1;
            }
        });
    });
</script>

@endsection
