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
    }
}
