<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <title>Lapor.pal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo/icon.png') }}" type="image/png">

    {{-- Link Google Fonts Poppins jika belum pakai @fontsource --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link rel="icon" href="{{ asset('img/logo/icon.png') }}" type="image/png">

    <link rel="stylesheet" href="path/to/swiper/swiper-bundle.min.css" />
    <!-- Link CSS untuk Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Link ke Swiper CDN -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body class="flex flex-col min-h-screen">
    <script>window.isLoggedIn = true;</script>

    <!-- Header -->
    <header class="bg-white absolute top-0 h-[90px] left-0 w-full flex items-center shadow-lg lg:py-0">
        <div class="container">
            <div class="flex items-center justify-between w-full">
                <!-- Logo -->
                <div class="px-4">
                    <a href="#" class="font-bold text-black mx-8 flex items-center py-6 pl-4">
                        <img src="{{ asset('img/logo/Hitam2.png') }}" alt="Logo Lapor.Pal!" class="custom-logo resize-logo" />
                    </a>
                </div>

                <!-- Menu Navigasi -->
                <div class="flex items-center ml-auto px-4 lg:px-8 space-x-6">
                    <!-- Hamburger Button (Mobile Only) -->
                    <button id="hamburger" type="button" class="lg:hidden focus:outline-none z-50">
                        <span class="hamburger-line transition duration-300 ease-in-out"></span>
                        <span class="hamburger-line transition duration-300 ease-in-out"></span>
                        <span class="hamburger-line transition duration-300 ease-in-out"></span>
                    </button>

                    <!-- Navigation Menu -->
                    <nav id="nav-menu" class="hidden absolute lg:static top-0 left-0 right-0 lg:block mt-16 lg:mt-0 py-5 lg:py-0 bg-white lg:bg-transparent shadow-lg lg:shadow-none rounded-lg lg:rounded-none w-full lg:w-auto">
                        <ul class="flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0">
                            <!-- Main Menu Group -->
                            <div class="flex flex-col lg:flex-row w-full lg:w-auto space-y-4 lg:space-y-0 lg:space-x-7 px-8 lg:px-0">
                                <li class="w-full lg:w-auto">
                                    <a href="/masyarakat/dashboard" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('/') || request()->is('home') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Beranda
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/masyarakat/pengaduan" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('pengaduan*') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Pengaduan
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/masyarakat/aktivitas/LaporanSaya" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('aktivitas*') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Aktivitas
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/masyarakat/panduan" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('panduan*') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Panduan
                                    </a>
                                </li>
                            </div>

                            <!-- Mobile Menu Items (Only visible on mobile) -->
                            <div class="lg:hidden w-full px-8 pt-4 border-t border-gray-200">
                                <a href="/masyarakat/notifikasi" class="flex items-center space-x-2 py-3 text-gray-600 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span>Notifikasi</span>
                                    @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                                        <span class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">{{ $unreadNotifCount }}</span>
                                    @endif
                                </a>
                                <a href="/masyarakat/profil" class="flex items-center space-x-2 py-3 text-gray-600 hover:text-gray-900">
                                    <div class="w-6 h-6 rounded-full overflow-hidden border border-gray-300">
                                        <img src="{{ Auth::user()->masyarakat->foto_profil ? 'data:image/jpeg;base64,' . base64_encode(Auth::user()->masyarakat->foto_profil) : asset('img/logo/profil.png') }}" alt="Profil" class="w-full h-full object-cover">
                                    </div>
                                    <span>Profil Saya</span>
                                </a>
                                <a href="/login" class="flex items-center space-x-2 py-3 text-red-500 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Keluar</span>
                                </a>
                            </div>
                        </ul>
                    </nav>

                    <!-- Ikon Notifikasi & Profil (Only visible on desktop) -->
                    <div class="hidden lg:flex items-center space-x-4 relative">
                        <!-- Notification Icon (Heroicons) -->
                        <a href="/masyarakat/notifikasi" class="relative text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                    {{ $unreadNotifCount }}
                                </span>
                            @endif
                        </a>
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <div class="profile-button flex items-center focus:outline-none cursor-pointer" onclick="toggleDropdown()">
                                <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-gray-300">
                                    <img src="{{ Auth::user()->masyarakat->foto_profil ? 'data:image/jpeg;base64,' . base64_encode(Auth::user()->masyarakat->foto_profil) : asset('img/logo/profil.png') }}" alt="Profil Lapor.Pal" class="w-full h-full object-cover" />
                                </div>
                            </div>
                            <!-- Dropdown Menu  -->
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="/masyarakat/profil" class="px-4 py-2 text-sm text-gray-700 hover:bg-kuning hover:text-white flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="/login" class="px-4 py-2 text-sm text-red-500 hover:bg-kuning flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-[100px] flex-grow container mx-auto px-0 py-8">
        @yield('content') <!-- This is where content will be injected -->
    </main>

    <!-- Tombol Back to Top -->
    <button id="backToTopBtn" class="fixed bottom-5 right-5 bg-kuning hover:bg-yellow-500 text-white p-3 rounded-full shadow-lg z-50 hidden transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <footer class="w-full">
        <!-- Gambar ilustrasi kota Malang -->
        <img src="{{ asset('img/logo/Footer.png') }}" alt="Ilustrasi Kota Malang" class="w-full h-auto" style="max-height: 250px; object-fit: cover;">

        <!-- Background kuning dengan copyright text -->
        <div class="w-full bg-kuning text-center py-4">
            <p class="text-hitam font-semibold text-[13px]">Copyright © 2025 Pemerintah Kota Malang. - All Rights Reserved.</p>
        </div>
    </footer>



    <!-- Script untuk Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileButton = document.querySelector('.profile-button');

            if (!profileButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
        document.getElementById('profileDropdown').addEventListener('click', function(event) {
            event.stopPropagation();
        });
        document.querySelector('.profile-button').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
</body>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
</html>
