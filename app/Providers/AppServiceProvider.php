<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $unreadNotifCount = 0;
            if (Auth::check()) {
                $unreadNotifCount = \App\Models\Notifikasi::where('user_id', Auth::id())
                    ->where('status_notifikasi', 'Terkirim')
                    ->where('role_tujuan', 'dinas')
                    ->count();
            }
            $view->with('unreadNotifCount', $unreadNotifCount);
        });

        // View composer untuk template pusat
        View::composer('Dashboardstlhlogin.pemerintahpusat.template.*', function ($view) {
            if (Auth::check() && Auth::user()->role === 'pemerintahpusat') {
                $pusat = \App\Models\PemerintahPusatDinas::where('user_id', Auth::id())->first();
                $view->with('pusat', $pusat);
            }
        });

        // View composer untuk template dinas
        View::composer('Dashboardstlhlogin.Dinas.template.*', function ($view) {
            if (Auth::check() && Auth::user()->role === 'dinas') {
                $dinas = \App\Models\Dinas::where('user_id', Auth::id())->first();
                $view->with('dinas', $dinas);
            }
        });
    }
}
