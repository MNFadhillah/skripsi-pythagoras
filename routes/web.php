<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformasiController;

/* =====================
   CONTROLLER SISWA
===================== */
use App\Http\Controllers\Siswa\MenuController;
use App\Http\Controllers\Siswa\MateriController;
use App\Http\Controllers\Siswa\QuizController;

/* =====================
   CONTROLLER GURU
===================== */
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Guru\DataSoalController;
use App\Http\Controllers\Guru\PaketSoalController;
use App\Http\Controllers\Guru\AktivitasController;
use App\Http\Controllers\Guru\DataNilaiController;
use App\Http\Controllers\Guru\DataSiswaController;
use App\Http\Controllers\Guru\DataKelasController; 

/* =====================
   PUBLIC
===================== */
Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');

/* =====================
   AUTH
===================== */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(['role:guru', 'role:siswa']);


/* =====================================================
   SISWA (LOGIN + ROLE SISWA)
===================================================== */
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

    /* ===== MENU ===== */
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/dashboard', [MenuController::class, 'dashboard'])->name('dashboard');
        Route::get('/leaderboard', [MenuController::class, 'leaderboard'])->name('leaderboard');
        Route::get('/nilai_siswa', [MenuController::class, 'nilai_siswa'])->name('nilai_siswa');
        Route::get('/petunjuk', [MenuController::class, 'petunjuk'])->name('petunjuk');
    });

    /* ===== MATERI ===== */
    Route::get('/pendahuluan/pengantar', [MateriController::class, 'pendahuluan'])->name('pendahuluan.pengantar');
    Route::get('/konsep/materi', [MateriController::class, 'konsep'])->name('konsep.materi');
    Route::get('/tripel/materi', [MateriController::class, 'tripel'])->name('tripel.materi');
    Route::get('/istimewa/materi', [MateriController::class, 'istimewa'])->name('istimewa.materi');
    Route::get('/penerapan/materi', [MateriController::class, 'penerapan'])->name('penerapan.materi');

    /* ===== KUIS / AKTIVITAS ===== */
    Route::get('/aktivitas/{id}/kerjakan', [QuizController::class, 'show'])->name('kuis.show');
    Route::get('/api/aktivitas/{id}/soal', [QuizController::class, 'api'])->name('kuis.api');
    Route::post('/aktivitas/submit', [QuizController::class, 'submit'])->name('kuis.submit');
    Route::get('/hasil/{id}', [QuizController::class, 'showResult'])->name('kuis.result');
    Route::get('/api/hasil/{id}', [QuizController::class, 'getResultDetail'])->name('kuis.result.detail');

    Route::post('/gabung-kelas', [MenuController::class, 'gabungKelas'])->name('gabung.kelas');
});

/* =====================================================
   GURU (LOGIN + ROLE GURU)
===================================================== */
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

    /* ===== DASHBOARD ===== */
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');

    /* ===== DATA SOAL ===== */
    Route::get('/data_soal', [DataSoalController::class, 'data_soal'])->name('data_soal');
    Route::post('/data_soal', [DataSoalController::class, 'store'])->name('data_soal.store');
    Route::get('/data_soal/{id}/json', [DataSoalController::class, 'data_soal_json'])->name('data_soal.json');
    Route::get('/data_soal/{id}/detail', [DataSoalController::class, 'detail'])->name('data_soal.detail');
    Route::put('/data_soal/{id}', [DataSoalController::class, 'update'])->name('data_soal.update');
    Route::delete('/data_soal/{id}', [DataSoalController::class, 'destroy'])->name('data_soal.destroy');

    /* ===== PAKET SOAL ===== */
    Route::get('/paket_soal/{id}/json', [PaketSoalController::class, 'json'])->name('paket_soal.json');

    Route::resource('paket_soal', PaketSoalController::class)->except(['show']);

    /* ===== AKTIVITAS ===== */
    Route::resource('aktivitas', AktivitasController::class)->except(['show']);

    /* ===== NILAI ===== */
    Route::get('/data_nilai', [DataNilaiController::class, 'index'])->name('data_nilai');
    Route::get('/data_nilai/{id}', [DataNilaiController::class, 'show'])->name('data_nilai.show');
    Route::get('/analisis_nilai', [DataNilaiController::class, 'analisis'])->name('data_nilai.analisis');

    /* ===== DATA SISWA ===== */
    Route::get('/data_siswa', [DataSiswaController::class, 'index'])
        ->name('data_siswa');

    Route::delete('/data_siswa/{id}', [DataSiswaController::class, 'destroy'])
        ->name('data_siswa.destroy');

    // Route Data Kelas
    Route::resource('data_kelas', DataKelasController::class)->except(['show']);
});
