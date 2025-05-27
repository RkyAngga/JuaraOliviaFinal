@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Kinggg')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

            <!-- Halaman Utama -->
            <section id="home" class="container bg-white p-6 mx-auto max-w-7xl">
                <div class="flex flex-col-reverse md:flex-row items-center justify-between">
                    <!-- Text section -->
                    <div class="text-section flex-1 px-6 mb-8 md:mb-0" data-aos="fade-right">
                        <h2 class="px-4 py-2 text-kuning text-[28px] md:text-[36px] font-bold">Jalan berlubang? Aspal Hancur?</h2>
                        <p class="px-4 py-2 text-[20px] md:text-[32px] font-normal">Laporkan sekarang dan pantau proses perbaikannya secara transparan.</p>
                        <p class="px-4 py-2 text-[16px] md:text-[20px] font-bold mb-6">Laporkan jalan rusak di daerah Anda dan bantu percepat perbaikannya.</p>

                        <button>
                            <a href="/masyarakat/pengaduan" class="bg-kuning hover:ring-2 ring-yellow-300 hover:bg-white hover:text-kuning transition-all duration-300 transform hover:scale-105 text-white py-1 px-6 rounded-full flex items-center gap-2">
                                <span class="text-[20px] md:text-[26px] font-bold">Lapor.pal</span>
                                <span class="flex items-center">
                                    <img src="{{ asset('img/Desain/toa.png') }}" alt="Icon Laporan" width="67" height="35" />
                                </span>
                            </a></button>
                        </div>

                        <!-- Image section (right side) -->
                        <div class="image-section flex-1 flex flex-col items-center" data-aos="fade-left">
                            <img src="{{ asset('img/Desain/Utama.png') }}" alt="Logo" class="mb-4" width="650" height="593" />
                        </div>
                    </div>
                </div>
            </section>


            <!-- Tentang Kami -->
            <section class="container mx-auto p-8 bg-kuning w-full">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Gambar (Kiri) -->
                    <div class="flex-1 mb-8 md:mb-0">
                        <img src="{{ asset('img/Desain/Desain2.png') }}" alt="Contoh Gambar" class="mx-auto" width="472.77" height="500" />
                    </div>

        <!-- Teks (Kanan) -->
        <div class="flex-1 pl-0 md:pl-8">
            <h2 class="px-4 text-[28px] md:text-[36px] font-bold mb-4 bg-gradient-to-r from-abuabu to-kuning rounded-full text-center md:text-left">Tentang Kami</h2>
            <p class="text-[18px] md:text-[20px] font-normal mb-4">
                <span class="text-[20px] font-bold">Lapor.Pal</span> adalah platform pengaduan masyarakat yang berfokus pada laporan jalan rusak. Kami hadir untuk memastikan setiap laporan Anda didengar dan ditindaklanjuti oleh Dinas. Dengan sistem yang transparan dan berbasis teknologi, Lapor.Pal memudahkan masyarakat dalam melaporkan kondisi jalan yang perlu diperbaiki serta memantau perkembangan perbaikannya secara real-time.
            </p>
            <p class="text-[20px] md:text-[24px] font-bold mb-4 text-center md:text-left">
                Bersama, kita bisa menciptakan infrastruktur yang lebih aman dan nyaman untuk semua!
            </p>
        </div>
    </div>
</section>


 <!-- Mengapa Jarus Lapor -->
 <section class="container mx-auto p-8 bg-white mt-12">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex-1 mb-8 md:mb-0">
                        <img src="{{ asset('img/Desain/Desain3.png') }}" alt="Illustration" class="w-[400px] mx-auto" />
                    </div>

                    <div class="flex-1 pl-0 md:pl-8">
                        <h2 class="text-3xl font-bold text-yellow-500 mb-4 text-center md:text-left">Mengapa Harus Melapor?</h2>
                        <ul class="text-lg text-black space-y-4">
                             <li class="flex items-center gap-3">
                                <span class="text-[24px] font-bold">✓</span>
                                Dapat Kurangi Risiko Kecelakaan – Jalan yang berlubang dapat membahayakan pengendara dan pejalan kaki.
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-[24px] font-bold">✓</span>
                                Percepatan Perbaikan – Laporanmu membantu pemerintah mengambil tindakan lebih cepat.
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-[24px] font-bold">✓</span>
                                Dapatkan Apresiasi – Aktif melapor dan memberikan ulasan yang baik mendapatkan point yang bisa ditukarkan dengan voucher.
                            </li>
                        </ul>
                    </div>
                </div>
</section>


<!-- LAngkah Laporan -->
<section class="container mx-auto p-8 bg-white px-4 md:px-30">
                <!-- Header Section -->
                <header class="mb-8" data-aos="fade-down">
                    <div class="flex items-center">
                        <h2 class="text-[24px] md:text-[32px] font-bold text-hitam pl-4 md:pl-[30px] mr-4">Lapor Jalan Rusak dalam 3</h2>
                        <div class="flex-1 h-1 bg-gradient-to-r from-abuabu to-kuning rounded-full"></div>
                    </div>
                    <h2 class="text-[24px] md:text-[32px] font-bold text-hitam pl-4 md:pl-[30px]">Langkah Mudah!</h2>
                </header>

                <!-- Steps Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    {{-- Tambahkan 'group' pada article --}}
                    <article class="text-center group" data-aos="fade-up" data-aos-delay="100">
                        {{-- Tambahkan kelas transisi dan hover pada img --}}
                        <img src="{{ asset('img/Desain/Langkah1.png') }}" alt="Ambil Foto" class="mx-auto mb-4 w-[80%] sm:w-[70%] md:w-[60%] max-w-[250px] h-auto transition-transform duration-300 ease-in-out group-hover:-translate-y-2">
                        <h3 class="text-[16px] md:text-lg font-bold text-black">1. Ambil Foto</h3>
                    </article>

                    <!-- Step 2 -->
                     {{-- Tambahkan 'group' pada article --}}
                    <article class="text-center group" data-aos="fade-up" data-aos-delay="200">
                         {{-- Tambahkan kelas transisi dan hover pada img --}}
                        <img src="{{ asset('img/Desain/Langkah2.png') }}" alt="Isi Laporan" class="mx-auto mb-4 w-[80%] sm:w-[70%] md:w-[60%] max-w-[250px] h-auto transition-transform duration-300 ease-in-out group-hover:-translate-y-2">
                        <h3 class="text-[16px] md:text-lg font-bold text-black">2. Isi Detail Laporan & Kirim</h3>
                    </article>

                    <!-- Step 3 -->
                     {{-- Tambahkan 'group' pada article --}}
                    <article class="text-center group" data-aos="fade-up" data-aos-delay="300">
                         {{-- Tambahkan kelas transisi dan hover pada img --}}
                        <img src="{{ asset('img/Desain/Langkah3.png') }}" alt="Pantau Ulasan" class="mx-auto mb-4 w-[80%] sm:w-[70%] md:w-[60%] max-w-[250px] h-auto transition-transform duration-300 ease-in-out group-hover:-translate-y-2">
                        <h3 class="text-[16px] md:text-lg font-bold text-black">3. Pantau & Berikan Ulasan</h3>
                    </article>
                </div>
            </section>

@php
    use Illuminate\Support\Facades\DB;
    $totalLaporan = DB::table('laporan_pengaduan')->count();
    $laporanMasuk = $totalLaporan;
    $laporanDiproses = DB::table('laporan_pengaduan')->where('status', 'Di Proses')->count();
    $laporanSelesai = DB::table('laporan_pengaduan')->where('status', 'Selesai')->count();
@endphp

<!-- Statistik Laporan -->
<section style="background-image: url('/img/Bg/abstrak.png'); background-position: center;" class="container mx-auto p-8 bg-kuning rounded-lg transition-all hover:shadow-lg hover:bg-yellow-50">
    <!-- Judul di kiri dengan indentasi -->
    <h2 class="text-[28px] md:text-[32px] font-bold text-black mb-4 text-center">
        Statistik Laporan
    </h2>
    <!-- Subjudul lebih kecil -->
    <p class="text-[20px] md:text-[24px] italic text-center text-gray-700 mb-8">
        Jumlah laporan yang diterima oleh LAPOR.PAL
    </p>
    <!-- Counter dengan spacing lebih rapi -->
    <div class="pl-4 md:pl-[30px] text-center">
        <p id="counter" class="counter-value text-[60px] md:text-[100px] font-bold text-gray-900 leading-none" data-target="{{ $totalLaporan }}">{{ $totalLaporan }}</p>
    </div>
</section>

<!-- Laporan Pengaduan -->
<section class="container mx-auto p-8 bg-white flex flex-col md:flex-row justify-between items-center">
    <!-- Gambar (Kiri) -->
    <div class="flex-1 text-center mb-8 md:mb-0">
        <img src="{{ asset('img/Desain/Tugu.png') }}" alt="Monumen" class="mx-auto" width="364.36" height="473" />
    </div>
    <!-- Teks dan Statistik (Kanan) -->
    <div class="flex-1 text-center">
        <h2 class="text-[32px] md:text-[48px] font-bold text-gray-800 mb-6">Laporan Pengaduan</h2>
        <div class="flex flex-col md:flex-row justify-between items-center max-w-md mx-auto text-lg font-semibold text-gray-600">
            <!-- Item Masuk -->
            <div class="flex flex-col items-center px-4 mb-6 md:mb-0">
                <p id="counter-kecamatan" class="counter-value text-[36px] md:text-[48px] font-bold text-gray-900 mb-1" data-target="{{ $laporanMasuk }}">{{ $laporanMasuk }}</p>
                <p>Laporan Masuk</p>
            </div>
            <!-- Item Diproses -->
            <div class="flex flex-col items-center px-4 mb-6 md:mb-0">
                <p id="counter-kelurahan" class="counter-value text-[36px] md:text-[48px] font-bold text-gray-900 mb-1" data-target="{{ $laporanDiproses }}">{{ $laporanDiproses }}</p>
                <p>Laporan Diproses</p>
            </div>
            <!-- Item Selesai -->
            <div class="flex flex-col items-center px-4">
                <p id="counter-kades" class="counter-value text-[36px] md:text-[48px] font-bold text-gray-900 mb-1" data-target="{{ $laporanSelesai }}">{{ $laporanSelesai }}</p>
                <p>Laporan Selesai</p>
            </div>
        </div>
    </div>
</section>

<!-- Apa kata mereka -->
<section class="container mx-auto p-8">
    <div class="flex flex-col md:flex-row items-center pt-11">
        <!-- Garis kiri -->
        <div class="flex-1 h-2 bg-gradient-to-r from-transparent to-kuning rounded-full"></div>
        <h2 class="text-[32px] md:text-[48px] text-center font-bold text-hitam mx-4">Apa kata mereka</h2>
        <!-- Garis kanan -->
        <div class="flex-1 h-2 bg-gradient-to-l from-transparent to-kuning rounded-full"></div>
    </div>
    <div class="py-12 mt-12 swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl   rounded-md">
                    <p class="font-Lobs text-white">
                        Dengan Lapor.pal, saya bisa ikut berkontribusi menjaga lingkungan sekitar. Praktis, cepat, dan hasilnya nyata.
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl  rounded-md">
                    <p class="font-Lobs text-white">
                        Setelah saya lapor, tak lama kemudian tim dari pemerintah daerah langsung turun tangan. Salut untuk responnya.
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold text-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                        <i class="ml-auto text-4xl text-white">❞</i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl  rounded-md">
                    <p class="font-Lobs text-white">
                        Suka banget sama fitur pelacakan laporan di Lapor.pal. Saya bisa lihat status laporan saya kapan saja.
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                        <i class="ml-auto text-4xl text-white">❞</i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl  rounded-md">
                    <p class="font-Lobs text-white">
                        Sebagai mahasiswa rantau, saya merasa lebih aman karena ada Lapor.pal. Layanan publik jadi lebih terbuka dan responsif.
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                        <i class="ml-auto text-4xl text-white">❞</i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl  rounded-md">
                    <p class="font-Lobs text-white">
                        Aplikasi Lapor.pal ini keren banget. Gak perlu bingung lagi mau lapor jalan berlubang kemana. Tinggal foto, isi detail, kirim. Mantap.
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                        <i class="ml-auto text-4xl text-white">❞</i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl  rounded-md">
                    <p class="font-Lobs text-white">
                        Sangat membantu! Laporan jalan rusak saya direspon cepat oleh dinas terkait setelah lapor via Lapor.pal.
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                        <i class="ml-auto text-4xl text-white">❞</i>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="flex flex-col gap-5 p-6 bg-kuning shadow-xl  rounded-md">
                    <p class="font-Lobs text-white">
                        Aplikasi Lapor.pal ini keren banget. Gak perlu bingung lagi mau lapor jalan berlubang kemana. Tinggal foto, isi detail, kirim. Mantap
                    </p>
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo/profil.png') }}" alt="" class="w-12 h-12 rounded-full">
                        <div class="ml-2">
                            <p class="text-black font-semibold uppercase">FIRDAUS</p>
                            <p class="text-white">Menteri Dagri</p>
                        </div>
                        <i class="ml-auto text-4xl text-white">❞</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Laporan Komentar -->
<section class="container mx-auto p-8">
    <div class="flex flex-col md:flex-row items-center pt-11">
        <!-- Garis kiri -->
        <div class="flex-1 h-2 bg-gradient-to-r from-transparent to-kuning rounded-full"></div>

        <h2 class="text-[32px] md:text-[48px] text-center font-bold text-hitam mx-4">Peta Laporan Pengaduan</h2>

        <!-- Garis kanan -->
        <div class="flex-1 h-2 bg-gradient-to-l from-transparent to-kuning rounded-full"></div>
    </div>
</section>

<!-- Peta -->
<section class="container mx-auto p-4 sm:p-8">
    <div id="map" class="flex justify-center items-center h-[250px] md:h-[400px] w-3/4 rounded-xl shadow-md border-4 md:border-8 border-kuning z-10">>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>




@endsection
