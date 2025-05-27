@extends('DasboardBelumLogin.Template.Template')
@section('title', 'Aktivitas')

@section('content')

<section class="bg-white">
    <div class="container mx-auto px-4 sm:px-8 py-4">
        <div class="p-2 sm:p-2 flex justify-center">
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <a href="/LaporanSaya"
                   class="nav-link px-4 sm:px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-all duration-300
                   {{ Request::is('LaporanSaya') ? 'active-nav' : '' }}">
                   Laporan Saya
                </a>
                <a href="/LaporanWarga"
                   class="nav-link px-4 sm:px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-all duration-300
                   {{ Request::is('LaporanWarga') ? 'active-nav' : '' }}">
                   Laporan Warga Lainnya
                </a>
                <a href="/StatistikPemerintah"
                   class="nav-link px-4 sm:px-6 py-3 text-sm sm:text-base font-semibold rounded-lg transition-all duration-300
                   {{ Request::is('StatistikPemerintah') ? 'active-nav' : '' }}">
                   Statik Pemerintah
                </a>
            </div>
        </div>
    </div>
    <main class="flex-grow py-1 mt-4 sm:mt-1">
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
