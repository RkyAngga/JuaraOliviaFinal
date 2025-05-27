@extends('Dashboardstlhlogin.Admin.Template.Template')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Section dengan efek gradien -->
    <div class="rounded-xl bg-white p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Tombol Buat Akun dengan efek hover yang lebih menarik -->
            <button id="buatAkunBtn" class="px-6 py-3 bg-kuning text-hitam font-semibold rounded-lg transform hover:scale-105 hover:bg-yellow-500 transition-all duration-300 shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Akun
            </button>

            <!-- Search and Filter Section yang lebih modern -->
            <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                <!-- Search Bar dengan animasi focus -->
                <div class="relative w-full md:w-140 group">
                    <input type="text" id="searchInput" placeholder="Cari nama atau username..." 
                        class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-kuning focus:border-transparent transition-all duration-300 bg-white/80 backdrop-blur-sm">
                    <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400 group-hover:text-kuning transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Role Filter Dropdown dengan animasi -->
                <div class="relative group">
                    <select id="roleFilter" class="w-full md:w-48 pl-4 pr-10 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-kuning focus:border-transparent transition-all duration-300 appearance-none bg-white/80 backdrop-blur-sm cursor-pointer">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="dinas">Dinas</option>
                        <option value="pemerintahpusat">Pemerintah Pusat</option>
                        <option value="masyarakat">Masyarakat</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400 group-hover:text-kuning transition-colors duration-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Sort Dropdown dengan animasi -->
                <div class="relative group">
                    <select id="sortBy" class="w-full md:w-48 pl-4 pr-10 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-kuning focus:border-transparent transition-all duration-300 appearance-none bg-white/80 backdrop-blur-sm cursor-pointer">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="name_asc">Nama (A-Z)</option>
                        <option value="name_desc">Nama (Z-A)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400 group-hover:text-kuning transition-colors duration-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tags dengan animasi -->
    <div id="activeFilters" class="flex flex-wrap">
        <!-- Active filters will be added here dynamically -->
    </div>

    <!-- Tabel Data Role dengan desain modern -->
    <div class="overflow-hidden bg-white rounded-xl shadow-lg border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gradient-to-r from-kuning to-yellow-400">
                    <th class="px-6 py-4 text-left text-sm font-bold text-hitam">No</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-hitam">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-hitam">Username</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-hitam">Password</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-hitam">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-hitam">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $user->nama_lengkap }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->username }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">********</td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="px-4 py-1.5 text-sm font-medium text-red-700 bg-red-100 rounded-full inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                    Admin
                                </span>
                            @elseif($user->role === 'dinas')
                                <a href="{{ route('admin.akun.dinas.edit', $user->id) }}" class="inline-block align-middle mr-1" title="Edit Akun Dinas">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 hover:text-kuning inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m2-2l-6 6m2-2l6-6" />
                                    </svg>
                                </a>
                                <span class="px-4 py-1.5 text-sm font-medium text-green-600 bg-green-100 rounded-full">Dinas</span>
                            @elseif($user->role === 'pemerintahpusat')
                                <a href="{{ route('admin.akun.pusat.edit', $user->id) }}" class="inline-block align-middle mr-1" title="Edit Akun Pusat">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 hover:text-kuning inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m2-2l-6 6m2-2l6-6" />
                                    </svg>
                                </a>
                                <span class="px-4 py-1.5 text-sm font-medium text-blue-600 bg-blue-100 rounded-full">Pemerintah Pusat</span>
                            @else
                                <span class="px-4 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-full inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                    {{ ucfirst($user->role) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 bg-gray-50">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm font-medium">Tidak ada data akun</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Buat Akun dengan desain modern -->
<div id="modalBuatAkun" class="fixed inset-0 bg-opacity-50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 relative transform transition-all duration-300">
            <!-- Tombol Close dengan animasi -->
            <button id="closeModal" class="absolute top-4 right-4 p-2 hover:bg-red-100 rounded-full transition-colors duration-200">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-hitam mb-2">Buat Akun</h2>
                <p class="text-gray-600">Pilih jenis akun yang ingin Anda buat</p>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button onclick="openDaerah()" class="group px-6 py-3 bg-kuning text-hitam font-semibold rounded-xl hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105 shadow-lg w-full sm:w-auto flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Dinas
                </button>
                <button onclick="openPusat()" class="group px-6 py-3 bg-kuning text-hitam font-semibold rounded-xl hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105 shadow-lg w-full sm:w-auto flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Pemerintah Pusat
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi untuk filter tags */
    .filter-tag {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
function openPusat() {
    window.location.href = '/admin/akun/pusat';
}

function openDaerah() {
    window.location.href = '/admin/akun/dinas';
}

// Modal functionality dengan animasi fade
const modal = document.getElementById('modalBuatAkun');
const buatAkunBtn = document.getElementById('buatAkunBtn');
const closeModal = document.getElementById('closeModal');
const searchInput = document.getElementById('searchInput');
const roleFilter = document.getElementById('roleFilter');
const sortBy = document.getElementById('sortBy');
const activeFilters = document.getElementById('activeFilters');

// Tambahkan kelas untuk animasi fade
const fadeIn = (element) => {
    element.classList.remove('hidden');
    element.classList.add('opacity-0');
    setTimeout(() => {
        element.classList.add('opacity-100');
        element.classList.add('transition-opacity');
        element.classList.add('duration-300');
    }, 10);
};

const fadeOut = (element) => {
    element.classList.remove('opacity-100');
    element.classList.add('opacity-0');
    setTimeout(() => {
        element.classList.add('hidden');
    }, 300);
};

// Event listeners untuk modal dengan animasi
buatAkunBtn.addEventListener('click', () => {
    fadeIn(modal);
});

closeModal.addEventListener('click', () => {
    fadeOut(modal);
});

// Close modal when clicking outside dengan animasi
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        fadeOut(modal);
    }
});

// Search functionality dengan debounce
function filterTable() {
    const searchTerm = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const username = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        
        const matchesSearch = nama.includes(searchTerm) || username.includes(searchTerm);
        
        if (matchesSearch) {
            row.classList.remove('hidden');
            // Highlight matching text
            if (searchTerm) {
                highlightText(row.querySelector('td:nth-child(2)'), searchTerm);
                highlightText(row.querySelector('td:nth-child(3)'), searchTerm);
            } else {
                // Remove highlighting if search is empty
                row.querySelector('td:nth-child(2)').innerHTML = nama;
                row.querySelector('td:nth-child(3)').innerHTML = username;
            }
        } else {
            row.classList.add('hidden');
        }
    });

    updateEmptyState();
}

function highlightText(element, searchTerm) {
    const originalText = element.textContent;
    const lowerText = originalText.toLowerCase();
    const index = lowerText.indexOf(searchTerm);
    
    if (index >= 0) {
        const before = originalText.slice(0, index);
        const match = originalText.slice(index, index + searchTerm.length);
        const after = originalText.slice(index + searchTerm.length);
        element.innerHTML = `${before}<span class="bg-yellow-200">${match}</span>${after}`;
    }
}

function updateEmptyState() {
    const visibleRows = document.querySelectorAll('tbody tr:not(.hidden)');
    const emptyState = document.querySelector('tbody tr td[colspan="6"]')?.parentElement;
    
    if (visibleRows.length === 0) {
        if (!emptyState) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 bg-gray-50">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-sm font-medium">Tidak ada data yang sesuai dengan pencarian</p>
                    </td>
                </tr>
            `;
        }
    } else if (emptyState) {
        emptyState.remove();
    }
}

// Event listener untuk pencarian dengan debounce
let searchTimeout;
searchInput.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filterTable();
        updateActiveFilters();
    }, 300);
});

// Role filter functionality
roleFilter.addEventListener('change', () => {
    filterTable();
    updateActiveFilters();
});

// Sort functionality
sortBy.addEventListener('change', () => {
    filterTable();
});

// Initialize filters
filterTable();
updateActiveFilters();
</script>
</style>
@endsection