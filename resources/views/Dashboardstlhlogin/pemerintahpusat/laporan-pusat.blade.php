@extends('Dashboardstlhlogin.pemerintahpusat.template.template')
@section('title', 'pusat')

@section('content')
<section class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 py-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-2">
            <div class="flex-1 min-w-0 pl-8">
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 truncate">Laporan Dinas</h2>
            </div>
        </div>

    <!-- Search and Filter Section -->
    <div class="container mx-auto px-4 sm:px-6 py-4">
        <form method="GET" action="{{ route('pemerintahpusat.laporan') }}" class="flex flex-col sm:flex-row gap-4 sm:gap-6">
            <!-- Search Bar -->
            <div class="flex-1 relative">
                <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari Jalan laporan..."
                    class="w-full pl-10 pr-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm sm:text-base">
                <svg class="absolute left-3 top-2.5 sm:top-3 h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Filter Dropdown -->
            <div class="w-full sm:w-48">
                <select name="status" id="statusFilter" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm sm:text-base">
                    <option value="">Semua Status</option>
                    <option value="Belum Respon" {{ request('status') == 'Belum Respon' ? 'selected' : '' }}>Belum Respon</option>
                    <option value="Tidak Terselesaikan" {{ request('status') == 'Tidak Terselesaikan' ? 'selected' : '' }}>Tidak Terselesaikan</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="container mx-auto px-4 sm:px-6 pb-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-kuning">
                            <th class="px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam">No</th>
                            <th class="px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam">Foto</th>
                            <th class="px-3 sm:px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam hidden sm:table-cell">Keterangan</th>
                            <th class="px-3 sm:px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam hidden md:table-cell">Alamat</th>
                            <th class="px-3 sm:px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam">Tanggal</th>
                            <th class="px-3 sm:px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam">Status</th>
                            <th class="px-3 sm:px-4 py-4 text-left text-xs sm:text-sm font-semibold text-hitam">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-4 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4">
                                    <img src="{{ asset('storage/' . $laporan->foto_video) }}" alt="Laporan"
                                        class="w-16 h-16 object-cover rounded-lg shadow-md hover:shadow-lg
                                               transition duration-200 ease-in-out">
                                </td>
                                <td class="px-3 sm:px-4 py-4 text-xs sm:text-sm text-gray-900 hidden sm:table-cell">{{ $laporan->deskripsi }}</td>
                                <td class="px-3 sm:px-4 py-4 text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                    <div class="max-w-xs overflow-hidden">
                                        {{ Str::limit($laporan->lokasi, 100) }}
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 py-4 text-xs sm:text-sm text-gray-900">{{ $laporan->created_at->format('d/m/Y') }}</td>
                                <td class="px-3 sm:px-4 py-4">
                                    @php
                                        $lastTracking = $laporan->tracking->sortByDesc('created_at')->first();
                                    @endphp
                                    @if($laporan->status == 'Menunggu' && $laporan->escalated_to_pusat)
                                        <span class="px-3 py-1 text-sm font-medium text-red-900 bg-red-100 rounded-full">Belum Respon</span>
                                    @elseif($lastTracking && $lastTracking->status == 'Tidak Terselesaikan')
                                        <span class="px-3 py-1 text-sm font-medium text-red-900 bg-red-100 rounded-full">Tidak Terselesaikan</span>
                                    @endif
                                </td>
                                <td class="px-3 sm:px-4 py-4">
                                    @if($laporan->status == 'Menunggu' && $laporan->escalated_to_pusat)
                                        <a href="{{ route('pemerintahpusat.laporan.belumdirespon.detail', $laporan->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                            </svg>
                                        </a>
                                    @elseif($lastTracking && $lastTracking->status == 'Tidak Terselesaikan')
                                        <a href="{{ route('pemerintahpusat.laporan.belumterselesaikan.detail', $laporan->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-yellow-500 hover:text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-600 font-medium">Tidak ada laporan yang belum direspon</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const tableRows = document.querySelectorAll('tbody tr');

        // Fungsi pencarian dan filter
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            tableRows.forEach(row => {
                const keterangan = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const alamat = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const status = row.querySelector('td:nth-child(6)').textContent.trim();
                
                const matchesSearch = keterangan.includes(searchTerm) || alamat.includes(searchTerm);
                const matchesStatus = statusValue === '' || status === statusValue;
                
                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        // Event listeners
        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>
