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
</head>
<body class="bg-gray-100">
<header class="bg-white fixed top-0 h-[90px] left-0 w-full flex items-center shadow-lg lg:py-0 z-50">
    <div class="container">
        <div class="flex items-center justify-between w-full">
            <!-- Logo -->
            <div class="px-4">
                <a href="/home" class="font-bold text-black mx-8 flex items-center py-6 pl-4">
                    <img src="{{ asset('img/logo/Hitam2.png') }}" alt="Logo Lapor.Pal!" class="custom-logo resize-logo" />
                </a>
            </div>

            <!-- Menu Navigasi -->
            <div class="flex items-center ml-auto px-8">
                <button id="hamburger" name="hamburger" type="button" class="block absolute right-4 lg:hidden">
                    <span class="hamburger-line transition duration-300 ease-in-out origin-top-left"></span>
                    <span class="hamburger-line transition duration-300 ease-in-out"></span>
                    <span class="hamburger-line transition duration-300 ease-in-out origin-bottom-left"></span>
                </button>

                <nav id="nav-menu" class="hidden absolute py-5 bg-white shadow-lg rounded-lg max-w-[250px] w-full right-4 top-full lg:block lg:static lg:bg-transparent lg:max-w-full lg:shadow-none lg:rounded-none">
                    <ul class="block lg:flex lg:items-center">
                        <!-- Grup Menu -->
                        <div class="flex flex-col lg:flex-row lg:items-center space-y-4 lg:space-y-0 lg:space-x-7 px-8">
                            <li class="group">
                                <a href="/admin/dashboard"
                                    class="text-base lg:text-[18px] font-bold py-2 mx-8 lg:mx-0 flex group-hover:text-hitam relative
                                    {{ request()->is('/') || request()->is('home') ? 'text-hitam after:content-[\"\"] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="group">
                                <a href="/admin/laporan"
                                    class="text-base lg:text-[18px] font-bold py-2 mx-8 lg:mx-0 flex group-hover:text-hitam relative
                                    {{ request()->is('pengaduan*') ? 'text-hitam after:content-[\"\"] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                    Laporan
                                </a>
                            </li>
                            <li class="group">
                                <a href="/admin/statistikDinas"
                                    class="text-base lg:text-[18px] font-bold py-2 mx-8 lg:mx-0 flex group-hover:text-hitam relative
                                    {{ request()->is('statistikDinas*') ? 'text-hitam after:content-[\"\"] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                    Statistik Dinas
                                </a>
                            </li>
                            <li class="group">
                                <a href="/admin/akun"
                                    class="text-base lg:text-[18px] font-bold py-2 mx-8 lg:mx-0 flex group-hover:text-hitam relative
                                    {{ request()->is('aktivitas*') ? 'text-hitam after:content-[\"\"] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-kuning' : 'text-hitam/70 hover:text-hitam' }}">
                                    Akun
                                </a>
                            </li>
                        </div>

                        <!-- Grup Auth -->
                        <div class="flex items-center space-x-4 px-8 lg:px-4">
                            <li>
                                <a href="/login" class="text-base lg:text-[13px] font-bold py-2 flex text-merah hover:text-opacity-80">
                                    Logout
                                </a>
                            </li>
                            <li class="relative">
                                <a href="/admin/notifikasi" class="text-[18px] font-bold text-hitam py-2 flex hover:text-kuning transition-colors relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 lg:h-7 lg:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                                        <span class="absolute -top-1 -right-1 bg-merah text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">
                                            {{ $unreadNotifCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        </div>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<style>
.hamburger-line {
    @apply w-8 h-1.5 my-1.5 block bg-hitam rounded transition-all duration-300;
}

#hamburger.active span:nth-child(1) {
    @apply rotate-45;
}

#hamburger.active span:nth-child(2) {
    @apply scale-0;
}

#hamburger.active span:nth-child(3) {
    @apply -rotate-45;
}

@media (max-width: 1024px) {
    #nav-menu.open {
        @apply block;
    }
}
</style>
    
    <main class="pt-[100px] pb-[200px] flex-grow container mx-auto px-0 py-8">
        @yield('content')
    </main>

    <footer class="w-full">
    <!-- Gambar ilustrasi kota Malang -->
    <img src="{{ asset('img/logo/Footer.png') }}" alt="Ilustrasi Kota Malang" class="w-full h-auto" style="max-height: 250px; object-fit: cover;">
    
    <!-- Background kuning dengan copyright text -->
    <div class="w-full bg-kuning text-center py-4">
        <p class="text-hitam text-[13px]">Copyright © 2025 Pemerintah Kota Malang. - All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>