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
            // 2. TAMBAHKAN KODE INI DI DALAM FUNCTION BOOT
            // Kode ini akan mengirim data $aktivitas secara otomatis ke file layouts/siswa.blade.php
            View::composer('layouts.siswa', function ($view) {
                $view->with('aktivitas', AktivitasBelajar::where('status', 1)->orderBy('id')->get());
            });
        }
}
