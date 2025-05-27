@extends('Dashboardstlhlogin.Admin.Template.Template')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Laporan</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola dan pantau semua laporan yang masuk</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-grow">
                    <input type="text" name="q" value="{{ request('q') }}" 
                        placeholder="Cari berdasarkan keterangan atau lokasi..." 
                        class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-sm">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="w-full sm:w-56">
                    <select name="status" onchange="this.form.submit()" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white text-sm appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi_admin" {{ request('status') == 'menunggu_verifikasi_admin' ? 'selected' : '' }}>Menunggu Verifikasi Admin</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Mobile View Cards -->
        <div class="block sm:hidden space-y-4">
            @foreach($laporans as $laporan)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200">
                <div class="p-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/'.$laporan->foto_video) }}" alt="Laporan" 
                                class="w-24 h-24 object-cover rounded-lg shadow-sm">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $laporan->deskripsi }}</p>
                            <p class="mt-1 text-xs text-gray-500 line-clamp-1">{{ $laporan->lokasi }}</p>
                            <div class="mt-2 flex items-center space-x-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-500">{{ $laporan->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="mt-3">
                                @php
                                    $trackProses = $laporan->tracking->last();
                                @endphp
                                @if($laporan->status == 'Selesai' || ($trackProses && $trackProses->status == 'Selesai'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Selesai
                                    </span>
                                @elseif($trackProses && $trackProses->sub_status == 'menunggu_verifikasi_admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Menunggu Verifikasi Admin
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            @if($laporan->status == 'Selesai' || ($trackProses && $trackProses->status == 'Selesai'))
                                <a href="{{ route('admin.laporan.selesai', ['id' => $laporan->id]) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-50 hover:bg-yellow-100 transition-colors duration-150">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('admin.laporan.detail', ['id' => $laporan->id]) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-50 hover:bg-yellow-100 transition-colors duration-150">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop/Tablet View Table -->
        <div class="hidden sm:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-kuning">
                        <th class="px-6 py-4 text-left text-xs font-bold text-hitam uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-hitam uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-hitam uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-hitam uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-hitam uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-hitam uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-hitam uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/'.$laporan->foto_video) }}" 
                                 class="h-16 w-16 object-cover rounded-lg shadow-sm">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                            <div class="line-clamp-2">{{ $laporan->deskripsi }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                            <div class="line-clamp-2">{{ $laporan->lokasi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $laporan->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $trackProses = $laporan->tracking->last();
                            @endphp
                            @if($laporan->status == 'Selesai' || ($trackProses && $trackProses->status == 'Selesai'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Selesai
                                </span>
                            @elseif($trackProses && $trackProses->sub_status == 'menunggu_verifikasi_admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Menunggu Verifikasi Admin
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($laporan->status == 'Selesai' || ($trackProses && $trackProses->status == 'Selesai'))
                                <a href="{{ route('admin.laporan.selesai', ['id' => $laporan->id]) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-50 hover:bg-yellow-100 transition-colors duration-150">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('admin.laporan.detail', ['id' => $laporan->id]) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-50 hover:bg-yellow-100 transition-colors duration-150">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection