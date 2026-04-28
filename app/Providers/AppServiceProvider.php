<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AktivitasBelajar;
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
    public function boot()
    {
        View::composer('layouts.siswa', function ($view) {
            $user = Auth::user();
            $aktivitas = collect();
            if ($user && $user->kelas_id) {
                $aktivitas = AktivitasBelajar::where('kelas_id', $user->kelas_id)->get();
            }
            $view->with('aktivitas', $aktivitas);
        });
    }
}
