<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lapor.pal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Link Google Fonts Poppins jika belum pakai @fontsource --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>




<!-- Header -->
<header class="bg-white absolute top-0 h-[90px] left-0 w-full flex items-center shadow-lg lg:py-0">
    <div class="container ">
        <div class="flex items-center justify-between w-full">
            <!-- Logo di Kiri -->
            <div class="px-4">
                <a href="#home" class="font-bold text-black mx-8 flex items-center py-6 pl-4">
                    <img src="{{ asset('img/logo/Hitam2.png') }}" alt="Logo Lapor.Pal!" class="custom-logo resize-logo" />
                </a>
            </div>

            <!-- Menu Navigasi -->
            <div class="flex items-center ml-auto px-8">
                <button id="hamburger" name="hamburger" type="button" class="block absolute right-4 lg:hidden">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
                <nav id="nav-menu" class="hidden lg:block py-5 bg-white lg:bg-transparent shadow-lg lg:shadow-none rounded-lg max-w-[250px] lg:max-w-full w-full lg:w-auto flex justify-between">
                    <ul class="block lg:flex">
                        <!-- Grup 1: Beranda, Pengaduan, Aktivitas, Panduan -->
                        <div class="flex space-x-7 px-8">
                            <li>
                                <a href="#home" class="text-[18px] font-bold text-hitam py-2 flex">Beranda</a>
                            </li>
                            <li>
                                <a href="#Products" class="text-[18px] font-bold text-hitam py-2 flex">Pengaduan</a>
                            </li>
                            <li>
                                <a href="#about" class="text-[18px] font-bold text-hitam py-2 flex">Aktivitas</a>
                            </li>
                            <li>
                                <a href="#contact" class="text-[18px] font-bold text-hitam py-2 flex">Panduan</a>
                            </li>
                        </div>

                        <!-- Grup 2: Masuk dan Registrasi -->
                        <div class="flex me-auto space-x-4">
                            <li>
                                <a href="#Jurney" class="text-[18px] font-bold text-abuabu hover:text-hitam py-2 flex hover-button">Masuk</a>
                            </li>
                            <li>
                                <a href="#Jurney" class="text-[18px] font-bold text-white py-2 px-4 flex bg-kuning rounded-full hover:bg-kuning transition-colors">Registrasi</a>
                            </li>
                        </div>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>





<body class="bg-putih text-hitam p-10 space-y-4">

    <table class="table-auto w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left">Font Style</th>
                <th class="border px-4 py-2 text-left">Example</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2 text-[48px] font-normal">Poppins Regular 48</td>
                <td class="border px-4 py-2 text-[48px] font-normal">Poppins Regular 48</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[40px] font-bold">Poppins Bold 40</td>
                <td class="border px-4 py-2 text-[40px] font-bold">Poppins Bold 40</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[36px] font-bold">Poppins Bold 36</td>
                <td class="border px-4 py-2 text-[36px] font-bold">Poppins Bold 36</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[33px] font-bold">Poppins Bold 33</td>
                <td class="border px-4 py-2 text-[33px] font-bold">Poppins Bold 33</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[32px] font-semibold italic">Poppins, Semibold Italic 32</td>
                <td class="border px-4 py-2 text-[32px] font-semibold italic">Poppins, Semibold Italic 32</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[32px] font-normal">Poppins, Regular 32</td>
                <td class="border px-4 py-2 text-[32px] font-normal">Poppins, Regular 32</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[24px] font-bold">Poppins Bold 24</td>
                <td class="border px-4 py-2 text-[24px] font-bold">Poppins Bold 24</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[24px] font-bold">Poppins, Bold and Mixes 24</td>
                <td class="border px-4 py-2 text-[24px] font-bold">Poppins, Bold and Mixes 24</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[20px] font-normal">Poppins, Regular 20</td>
                <td class="border px-4 py-2 text-[20px] font-normal">Poppins, Regular 20</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[20px] font-bold">Poppins Bold 20</td>
                <td class="border px-4 py-2 text-[20px] font-bold">Poppins Bold 20</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[15px] font-normal">Poppins Regular 15</td>
                <td class="border px-4 py-2 text-[15px] font-normal">Poppins Regular 15</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-[15px] font-bold">Poppins Bold 15</td>
                <td class="border px-4 py-2 text-[15px] font-bold">Poppins Bold 15</td>
            </tr>
        </tbody>
    </table>

    {{-- Box untuk menampilkan color palette --}}
    <div class="pt-6">
        <h2 class="text-xl font-bold pb-4">Color Palette</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-kuning text-putih text-center rounded-lg">
                <p class="font-bold">Kuning</p>
                <p>#FFC43D</p>
            </div>
            <div class="p-4 bg-putih text-hitam text-center rounded-lg">
                <p class="font-bold">Putih</p>
                <p>#FFFFFF</p>
            </div>
            <div class="p-4 bg-abuabu text-hitam text-center rounded-lg">
                <p class="font-bold">Abu-abu</p>
                <p>#D9D9D9</p>
            </div>
            <div class="p-4 bg-hitam text-putih text-center rounded-lg">
                <p class="font-bold">Hitam</p>
                <p>#000000</p>
            </div>
            <div class="p-4 bg-biru text-putih text-center rounded-lg">
                <p class="font-bold">Biru</p>
                <p>#2CA5F0</p>
            </div>
            <div class="p-4 bg-merah text-putih text-center rounded-lg">
                <p class="font-bold">Merah</p>
                <p>#FF0000</p>
            </div>
        </div>
    </div>

    <div class="flex gap-4 pt-6">
        <button class="bg-merah text-putih font-semibold px-6 py-2 rounded hover:opacity-10 transition">
            Tombol Merah
        </button>
        <button class="bg-biru text-putih font-semibold px-6 py-2 rounded hover:opacity-10 transition">
            Tombol Biru
        </button>
    </div>

</body>

<footer class="w-full">
    <!-- Gambar di atas teks -->
    <img src="{{ asset('img/logo/Footer.png') }}" alt="Logo Lapor.Pal!" class="mx-auto mb-4" width="1441.44" height="387.79">

    <!-- Background kuning memenuhi seluruh lebar layar -->
    <div class="w-full bg-kuning text-center py-4">
        <!-- Teks di bawah gambar -->
        <p class="text-hitam text-[18px]">&copy; 2025 Lapor.Pal!. All Rights Reserved.</p>
    </div>
</footer>




</html>
