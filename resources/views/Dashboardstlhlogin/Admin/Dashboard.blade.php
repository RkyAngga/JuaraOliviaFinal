@extends('Dashboardstlhlogin.Admin.Template.Template')
@section('title', 'Dashboard Admin - LAPOR PAL')
@section('content')

<div class="min-h-screen p-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-600">Ringkasan aktivitas dan statistik sistem</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Reports Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Laporan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalLaporan }}</p>
                </div>
                <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- In Progress Reports Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Laporan Diproses</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $laporanDiproses }}</p>
                </div>
                <div class="p-3 rounded-full bg-orange-50 text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rejected Reports Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Laporan Ditolak</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $laporanDitolak }}</p>
                </div>
                <div class="p-3 rounded-full bg-red-50 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Reports Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Laporan Selesai</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $laporanSelesai }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Account Management Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Manajemen Akun</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <a href="{{ route('admin.akun') }}" class="block p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Kelola Akun</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('admin.akun.pusat') }}" class="block p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Buat Akun Pemerintah Pusat</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('admin.akun.dinas') }}" class="block p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-green-100 text-green-600 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Buat Akun Dinas</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
         <!-- Table Container -->
         <div class="w-full overflow-x-auto bg-white p-4 rounded-lg shadow-sm">
                    <div class="min-w-full overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Dinas</th>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Grade</th>
                                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($dinasList as $dinas)
                                    @php
                                        // Hitung Grade berdasarkan poin dinas
                                        $grade = 'E'; // Default
                                        if ($dinas->point >= 90) $grade = 'A';
                                        elseif ($dinas->point >= 80) $grade = 'B';
                                        elseif ($dinas->point >= 70) $grade = 'C';
                                        elseif ($dinas->point >= 60) $grade = 'D';
                                        // Presentase langsung dari poin, maksimal 100%
                                        $percentage = min(100, $dinas->point);

                                        // Tentukan warna teks berdasarkan poin
                                        $textColorClass = 'text-gray-900'; // Default
                                        if ($dinas->point >= 199) $textColorClass = 'text-[#FEC23E]'; // >= 199 poin
                                        elseif ($dinas->point >= 101) $textColorClass = 'text-[#EBDDCF]'; // 101 - 198 poin
                                        elseif ($dinas->point >= 0) $textColorClass = 'text-[#FF8000]'; // 0 - 100 poin
                                        // Catatan: Kelas Tailwind CSS arbitrer (#...) mungkin perlu dikonfigurasi di tailwind.config.js
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6 font-medium {{ $textColorClass }}">{{ $dinas->username }}</td>
                                        <td class="py-4 px-6 text-gray-600">{{ $grade }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2.5 max-w-xs">
                                                    <div class="bg-yellow-500 h-2.5 rounded-full transition-all duration-500"
                                                         style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-700">{{ $percentage }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</div>

@endsection