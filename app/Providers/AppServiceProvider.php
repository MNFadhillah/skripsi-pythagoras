<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AktivitasBelajar;

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
            View::composer('layouts.siswa', function ($view) {
                // Hapus where('status', 1) agar semua kuis selalu muncul di sidebar
                $view->with('aktivitas', AktivitasBelajar::orderBy('id')->get());
            });
        }
}
