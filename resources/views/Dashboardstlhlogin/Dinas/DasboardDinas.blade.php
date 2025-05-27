@extends('Dashboardstlhlogin.Dinas.Template.Template')
@section('title', 'Aktivitas')

@section('content')

<section class="flex justify-center mt-8 ">
  <div class="inline-flex flex-wrap justify-center gap-6 md:gap-20 rounded-xl p-2">
    <!-- Laporan Saya -->
    <a href="/dinas/laporan/masyarakat" 
       class="nav-link px-6 py-3 font-bold rounded-lg border-2 border-yellow-500 transition-all duration-300 
       {{ request()->is('dinas/laporan/masyarakat*') ? 'bg-yellow-400 text-black border-transparent' : '' }}">
      <span class="block relative">
        <span class="nav-text">Laporan Masyarakat</span>
      </span>
    </a>

    <!-- Statik Dinas -->
    <a href="/dinas/statistik" 
       class="nav-link px-6 py-3 font-bold rounded-lg border-2 border-yellow-500 transition-all duration-300 
       {{ request()->is('dinas/statistik*') ? 'bg-yellow-400 text-black border-transparent' : '' }}">
      <span class="block relative">
        <span class="nav-text">Statistik Dinas</span>
      </span>
    </a>
  </div>
</section>

<style>
    .active-nav,
    .nav-link:hover {
        background-color: #FFC107 !important;
        color: black !important;
        border-color: transparent !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<main class="pt-[100px] flex-grow container mx-auto px-0 py-8">
    @yield('Laporan')
</main>

@endsection