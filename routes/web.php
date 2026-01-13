<?php

use App\Http\Controllers\Guru\DataSoalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\Siswa\MenuController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Siswa\MateriController;
use App\Http\Controllers\Siswa\QuizController;
use App\Http\Controllers\siswa\EvaluasiController;
use App\Http\Controllers\Guru\PaketSoalController;
use App\Http\Controllers\Guru\AktivitasController;
use App\Http\Controllers\Guru\DataNilaiController;

Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');

Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });
    Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
        Route::get('/leaderboard', 'leaderboard')->name('leaderboard');
    });
    Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
        Route::get('/nilai_siswa', 'nilai_siswa')->name('nilai_siswa');
    });
    Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
        Route::get('/petunjuk', 'petunjuk')->name('petunjuk');
    });

    Route::controller(MateriController::class)->group(function () {
        Route::get('/pendahuluan/pengantar', 'pendahuluan')->name('pendahuluan.pengantar');
    });
    Route::controller(MateriController::class)->group(function () {
        Route::get('/konsep/materi', 'konsep')->name('konsep.materi');
    });
    Route::controller(MateriController::class)->group(function () {
        Route::get('/tripel/materi', 'tripel')->name('tripel.materi');
    });
    Route::controller(MateriController::class)->group(function () {
        Route::get('/istimewa/materi', 'istimewa')->name('istimewa.materi');
    });
    Route::controller(MateriController::class)->group(function () {
        Route::get('/penerapan/materi', 'penerapan')->name('penerapan.materi');
    });

    Route::controller(EvaluasiController::class)->group(function () {
        Route::get('/evaluasi', 'index')->name('evaluasi');
    });

});

Route::prefix('guru')->group(function () {
    Route::controller(GuruController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('guru.dashboard');
        Route::get('/data_siswa', 'data_siswa')->name('guru.data_siswa');
        Route::get('/data_nilai', 'data_nilai')->name('guru.data_nilai');
        Route::get('/data_kelas', 'data_kelas')->name('guru.data_kelas');
        Route::get('/data_soal', 'data_soal')->name('guru.data_soal');
        Route::get('/data_evaluasi', 'data_evaluasi')->name('guru.data_evaluasi');
    });
});


Route::prefix('guru')->group(function () {

    Route::get('/data_soal', [DataSoalController::class, 'data_soal'])->name('guru.data_soal');

    Route::post('/data_soal', [DataSoalController::class, 'store'])->name('guru.data_soal.store');

    Route::get('/data_soal/{id}/json', [DataSoalController::class, 'data_soal_json'])->name('guru.data_soal.json');

    Route::get('/data_soal/{id}/detail', [DataSoalController::class, 'detail'])->name('guru.data_soal.detail');

    Route::get('/data_soal/{id}/edit-json', [DataSoalController::class, 'editJson']);

    Route::put('/data_soal/{id}', [DataSoalController::class, 'update']);

    Route::delete('/data_soal/{id}', [DataSoalController::class, 'destroy'])->name('guru.data_soal.destroy');


    Route::get('/paket_soal', [PaketSoalController::class, 'index'])->name('guru.paket_soal');
    Route::post('/paket_soal', [PaketSoalController::class, 'store'])->name('guru.paket_soal.store');
    Route::get('/paket_soal/{id}/edit', [PaketSoalController::class, 'edit'])->name('guru.paket_soal.edit');
    Route::put('/paket_soal/{id}', [PaketSoalController::class, 'update'])->name('guru.paket_soal.update');
    Route::delete('/paket_soal/{id}', [PaketSoalController::class, 'destroy'])->name('guru.paket_soal.destroy');
    Route::get('/paket_soal/{id}/json', [PaketSoalController::class, 'show'])->name('guru.paket_soal.json');

    
    
    // Route::get('/aktivitas', [AktivitasBelajarController::class, 'index'])->name('guru.aktivitas');
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('guru.aktivitas');
    Route::post('/aktivitas', [AktivitasController::class, 'store'])->name('guru.aktivitas.store');
    Route::get('/aktivitas/{id}/edit', [AktivitasController::class, 'edit'])->name('guru.aktivitas.edit');
    Route::put('/aktivitas/{id}', [AktivitasController::class, 'update'])->name('guru.aktivitas.update');
    Route::delete('/aktivitas/{id}', [AktivitasController::class, 'destroy'])->name('guru.aktivitas.destroy');
    
    Route::get('/data_nilai', [DataNilaiController::class, 'index'])->name('guru.data_nilai');
    Route::get('/data_nilai/{id}', [DataNilaiController::class, 'show'])->name('guru.data_nilai.show');
    Route::get('/analisis_nilai', [DataNilaiController::class, 'analisis'])->name('guru.data_nilai.analisis');

});



// routes/web.php

// Route::get('/kuis/{id}', [QuizController::class, 'show'])->name('siswa.kuis.show');
// Route::get('/api/kuis/{id}', [QuizController::class, 'api'])->name('siswa.kuis.api');
// Route::post('/kuis/submit', [QuizController::class, 'submit'])->name('siswa.kuis.submit');
// Route::get('/hasil/{id}', [QuizController::class, 'showResult'])->name('siswa.kuis.result');
// Route::get('/api/hasil/{id}', [QuizController::class, 'getResultDetail'])->name('siswa.kuis.result.detail');

// ==========================================
// ROUTE SISWA (AKSES KUIS/AKTIVITAS)
// ==========================================
Route::prefix('siswa')->group(function () {
    
    // Halaman Mengerjakan Kuis (ID yang dikirim adalah ID AKTIVITAS)
    Route::get('/aktivitas/{id}/kerjakan', [QuizController::class, 'show'])
        ->name('siswa.kuis.show');

    // API untuk mengambil data soal (JSON)
    Route::get('/api/aktivitas/{id}/soal', [QuizController::class, 'api'])
        ->name('siswa.kuis.api');

    // Submit Jawaban
    Route::post('/aktivitas/submit', [QuizController::class, 'submit'])
        ->name('siswa.kuis.submit');

    // Halaman Hasil
    Route::get('/hasil/{id}', [QuizController::class, 'showResult'])
        ->name('siswa.kuis.result');
        
    // API Detail Hasil
    Route::get('/api/hasil/{id}', [QuizController::class, 'getResultDetail'])
        ->name('siswa.kuis.result.detail');
});