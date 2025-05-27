@extends('Dashboardstlhlogin.masyarakat.templatemasyarakat')
@section('title', 'Aktivitas')

@section('content')

<section class="bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-8 py-1">

        <div class="p-4 sm:p-6 flex justify-center">
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <a href="/masyarakat/aktivitas/LaporanSaya"
                   class="nav-link px-4 sm:px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-all duration-300
                   {{ Request::is('masyarakat/aktivitas/LaporanSaya*') ? 'active-nav' : '' }}">
                   Laporan Saya
                </a>
                <a href="/masyarakat/aktivitas/LaporanWarga"
                   class="nav-link px-4 sm:px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-all duration-300
                   {{ Request::is('masyarakat/aktivitas/LaporanWarga*') ? 'active-nav' : '' }}">
                   Laporan Warga Lainnya
                </a>
                <a href="/masyarakat/aktivitas/StatistikDinas"
                   class="nav-link px-4 sm:px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-all duration-300
                   {{ Request::is('masyarakat/aktivitas/StatistikDinas*') ? 'active-nav' : '' }}">
                   Statik Dinas
                </a>
            </div>
        </div>
    </div>

    <main class="flex-grow py-8 mt-4 sm:mt-8">
        @yield('Laporan')
    </main>

</section>

<style>
    .nav-link {
        background-color: white;
        color: #FFC107;
        border: 2px solid #FFC107;
        transition: all 0.3s ease;
        text-align: center;
        display: block;
        width: 100%;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    @media (min-width: 640px) {
        .nav-link {
            width: auto;
            min-width: 180px;
        }
    }

    .active-nav,
    .nav-link:hover {
        background-color: #FFC107 !important;
        color: black !important;
        border-color: transparent !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

@endsection
