@extends('Dashboardstlhlogin.Dinas.DasboardDinas')
@section('title', 'Laporan Masyarakat')

@section('Laporan')

<section class="min-h-screen pt-1 pb-4">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section (Opsional jika ingin ada judul halaman di sini) -->
        {{-- <div class="flex justify-between items-center mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                 <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Masyarakat</h2>
            </div>
        </div>
        <div class="w-full h-1 bg-yellow-400 mb-4 sm:mb-6"></div> --}}

        <!-- Search and Filter Section -->
        <div class="mb-6 md:mb-8 bg-white p-4 rounded-lg mt-[-5rem]">
            <form method="GET" action="{{ route('dinas.laporan.masyarakat') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="relative flex-1 w-full md:w-auto">
                    <label for="q" class="sr-only">Cari laporan...</label>
                    <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Cari laporan..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-sm md:text-base">
                    <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="w-full md:w-auto">
                    <label for="status" class="sr-only">Filter Status</label>
                    <select name="status" id="status" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-sm md:text-base">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Di Proses" {{ request('status') == 'Di Proses' ? 'selected' : '' }}>Di Proses</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-yellow-400">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-bold text-black uppercase border-r border-black/10">No</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-black uppercase border-r border-black/10">Foto</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase border-r border-black/10">Keterangan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-black uppercase border-r border-black/10">Alamat</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-black uppercase border-r border-black/10">Tanggal</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-black uppercase border-r border-black/10">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-black uppercase">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($laporanUtama as $laporan)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-4 py-4 text-center align-top text-sm text-gray-700 border-r border-gray-200">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4 text-center align-top border-r border-gray-200">
                                    <img src="{{ asset('storage/'.$laporan->foto_video) }}" alt="Foto" class="w-12 h-12 object-cover rounded-md border border-gray-200 mx-auto">
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700 align-top border-r border-gray-200" style="max-width: 200px; white-space: normal; word-break: break-word;">
                                    {{ \Illuminate\Support\Str::words($laporan->deskripsi, 15, '') }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700 align-top border-r border-gray-200" style="max-width: 200px; white-space: normal; word-break: break-word;">
                                    {{ \Illuminate\Support\Str::words($laporan->lokasi, 15, '') }}
                                </td>
                                <td class="px-4 py-4 text-center align-top text-gray-500 text-sm border-r border-gray-200">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/Y') }}</td>
                                <td class="px-4 py-4 text-center align-top font-semibold text-sm border-r border-gray-200">
                                    @php
                                        $lastTracking = $laporan->tracking->sortByDesc('created_at')->first();
                                    @endphp
                                    @if($laporan->status == 'Selesai' || ($lastTracking && $lastTracking->status == 'Selesai'))
                                        <span class="px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Selesai</span>
                                    @elseif($laporan->status == 'Ditolak')
                                        <span class="px-2.5 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                    @elseif($laporan->status == 'Menunggu')
                                        <span class="px-2.5 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                    @elseif($lastTracking && $lastTracking->sub_status == 'menunggu_verifikasi_admin')
                                        <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Verifikasi Admin</span>
                                    @elseif($lastTracking && $lastTracking->sub_status == 'proses')
                                        <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Diproses</span>
                                    @endif
                                    @if($lastTracking && $lastTracking->status == 'Tidak Terselesaikan')
                                         <a href="{{ route('dinas.laporan.lanjutan', $laporan->id) }}" class="block mt-1">
                                            <span class="px-2.5 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full cursor-pointer">
                                                Terlambat Terselesaikan
                                            </span>
                                        </a>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center align-top text-sm border-gray-200">
                                    @php
                                        $penyelesaian = $laporan->penyelesaian;
                                        $lastTracking = $laporan->tracking->sortByDesc('created_at')->first();
                                    @endphp
                                    @if($laporan->status == 'Selesai' || ($lastTracking && $lastTracking->status == 'Selesai'))
                                        <a href="{{ route('dinas.laporan.selesai', $laporan->id) }}" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                            </svg>
                                        </a>
                                    @elseif($laporan->status == 'Ditolak')
                                        <a href="{{ route('dinas.laporan.step2.ditolak', $laporan->id) }}" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                            </svg>
                                        </a>
                                    @elseif($laporan->status == 'Menunggu')
                                        <a href="{{ route('dinas.laporan.detail', $laporan->id) }}" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                            </svg>
                                        </a>
                                    @elseif($laporan->status == 'Di Proses')
                                        @if($lastTracking && $lastTracking->sub_status == 'menunggu_verifikasi_admin')
                                            <a href="{{ route('dinas.laporan.step7.lanjutan', $laporan->id) }}" title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                                </svg>
                                            </a>
                                        @elseif($penyelesaian)
                                            <a href="{{ route('dinas.laporan.lanjutan', $laporan->id) }}" title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('dinas.laporan.step4.diproses', $laporan->id) }}" title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                                </svg>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-600 font-medium">Tidak ada laporan yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4 p-4">
                @forelse($laporanUtama as $laporan)
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                        <div class="flex items-start space-x-4">
                            <img src="{{ asset('storage/'.$laporan->foto_video) }}" alt="Foto {{ $loop->iteration }}" class="w-16 h-16 object-cover rounded-md border border-gray-200">
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-medium text-gray-900 text-sm">{{ \Illuminate\Support\Str::words($laporan->deskripsi, 15, '') }}</h3>
                                    <div>
                                        @php
                                            $lastTracking = $laporan->tracking->sortByDesc('created_at')->first();
                                        @endphp
                                        @if($laporan->status == 'Selesai' || ($lastTracking && $lastTracking->status == 'Selesai'))
                                            <span class="px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Selesai</span>
                                        @elseif($laporan->status == 'Ditolak')
                                            <span class="px-2.5 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                        @elseif($laporan->status == 'Menunggu')
                                            <span class="px-2.5 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                        @elseif($lastTracking && $lastTracking->sub_status == 'menunggu_verifikasi_admin')
                                            <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Verifikasi Admin</span>
                                        @elseif($lastTracking && $lastTracking->sub_status == 'proses')
                                            <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Diproses</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::words($laporan->lokasi, 15, '') }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/Y H:i') }}</p>
                                @php
                                    $penyelesaian = $laporan->penyelesaian;
                                    $lastTracking = $laporan->tracking->sortByDesc('created_at')->first();
                                @endphp
                                @if($laporan->status == 'Selesai' || ($lastTracking && $lastTracking->status == 'Selesai'))
                                    <a href="{{ route('dinas.laporan.selesai', $laporan->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                                @elseif($laporan->status == 'Ditolak')
                                    <a href="{{ route('dinas.laporan.step2.ditolak', $laporan->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                                @elseif($laporan->status == 'Menunggu')
                                     <a href="{{ route('dinas.laporan.detail', $laporan->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                                @elseif($laporan->status == 'Di Proses')
                                    @if($lastTracking && $lastTracking->sub_status == 'menunggu_verifikasi_admin')
                                        <a href="{{ route('dinas.laporan.step7.lanjutan', $laporan->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                                    @elseif($penyelesaian)
                                        <a href="{{ route('dinas.laporan.lanjutan', $laporan->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                                    @else
                                         <a href="{{ route('dinas.laporan.step4.diproses', $laporan->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                                    @endif
                                @endif
                                @if($lastTracking && $lastTracking->status == 'Tidak Terselesaikan')
                                     <a href="{{ route('dinas.laporan.lanjutan', $laporan->id) }}" class="mt-1 inline-block text-sm text-red-600 hover:text-red-800 font-medium">Terlambat Terselesaikan →</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                     <div class="bg-white p-4 rounded-lg shadow border border-gray-200 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-600 font-medium">Tidak ada laporan yang ditemukan.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection
