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

    <link rel="stylesheet" href="path/to/swiper/swiper-bundle.min.css" />
    <!-- Link CSS untuk Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Link ke Swiper CDN -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        /* Hapus style hamburger dan nav-menu, gunakan dari navbar.css */
    </style>
</head>

<body>
    <script>window.isLoggedIn = false;</script>

    <!-- Header -->
    <header class="header bg-white absolute top-0 h-[90px] left-0 w-full flex items-center shadow-lg lg:py-0">
        <div class="container">
            <div class="flex items-center justify-between w-full">
                <!-- Logo -->
                <div class="px-4">
                    <a href="/home" class="font-bold text-black mx-8 flex items-center py-6 pl-4">
                        <img src="{{ asset('img/logo/Hitam2.png') }}" alt="Logo Lapor.Pal!" class="custom-logo resize-logo" />
                    </a>
                </div>

                <!-- Menu Navigasi -->
                <div class="flex items-center ml-auto px-4 lg:px-8">
                    <!-- Hamburger Button (Mobile Only) -->
                    <button id="hamburger" type="button" class="lg:hidden focus:outline-none z-50">
                        <span class="hamburger-line hamburger-line-yellow transition duration-300 ease-in-out"></span>
                        <span class="hamburger-line hamburger-line-yellow transition duration-300 ease-in-out"></span>
                        <span class="hamburger-line hamburger-line-yellow transition duration-300 ease-in-out"></span>
                    </button>

                    <!-- Navigation Menu -->
                    <nav id="nav-menu" class="hidden absolute lg:static top-0 left-0 right-0 lg:block mt-16 lg:mt-0 py-5 lg:py-0 bg-white lg:bg-transparent shadow-lg lg:shadow-none rounded-lg lg:rounded-none w-full lg:w-auto">
                        <ul class="flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 gap-3 lg:gap-3">
                            <!-- Main Menu Group -->
                            <div class="flex flex-col lg:flex-row w-full lg:w-auto space-y-4 lg:space-y-0 lg:space-x-7 px-8 lg:px-0">
                                <li class="w-full lg:w-auto">
                                    <a href="/home" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('/') || request()->is('home') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Beranda
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/pengaduan" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('pengaduan*') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Pengaduan
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/LaporanSaya" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('aktivitas*') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Aktivitas
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/panduan" class="block text-[18px] font-bold py-2 relative
            {{ request()->is('panduan*') ? 'text-hitam after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                        Panduan
                                    </a>
                                </li>
                            </div>

                            <!-- Auth Group -->
                            <div class="flex flex-col lg:flex-row w-full lg:w-auto space-y-4 lg:space-y-0 lg:space-x-4 px-8 lg:px-0 pb-4 lg:pb-0">
                                <li class="w-full lg:w-auto">
                                    <a href="/login" class="block text-[18px] font-bold py-2
            {{ request()->is('login') ? 'text-hitam underline underline-offset-8 decoration-2 decoration-kuning' : 'text-abuabu hover:text-hitam' }}">
                                        Masuk
                                    </a>
                                </li>
                                <li class="w-full lg:w-auto">
                                    <a href="/register" class="block text-[18px] font-bold text-white py-2 px-4 bg-kuning rounded-full hover:bg-kuning/90 transition-colors
            {{ request()->is('register') ? 'ring-2 ring-offset-2 ring-kuning' : '' }}">
                                        Registrasi
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </nav>
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

        // Hamburger color change on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header.header');
            const lines = document.querySelectorAll('.hamburger-line');
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
                lines.forEach(line => {
                    line.classList.remove('hamburger-line-yellow');
                    line.classList.add('hamburger-line-white');
                });
            } else {
                header.classList.remove('scrolled');
                lines.forEach(line => {
                    line.classList.remove('hamburger-line-white');
                    line.classList.add('hamburger-line-yellow');
                });
            }
        });
    </script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>
