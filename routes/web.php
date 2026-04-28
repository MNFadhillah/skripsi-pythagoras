<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PetunjukController;

/* =====================
   CONTROLLER SISWA
===================== */
use App\Http\Controllers\Siswa\MenuController;
use App\Http\Controllers\Siswa\MateriController;
use App\Http\Controllers\Siswa\QuizController;
use App\Http\Controllers\Siswa\ProgressController;
use App\Http\Controllers\Siswa\ProfileController;
use App\Http\Controllers\Siswa\RefleksiController;

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
use App\Http\Controllers\Guru\PencapaianSiswaController;
use App\Http\Controllers\Guru\ProfileGuruController;
use App\Http\Controllers\Guru\DataRefleksiController;

/* =====================
   CONTROLLER ADMIN
===================== */
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileAdminController;


/* =====================
   PUBLIC
===================== */

Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
Route::get('/petunjuk', [PetunjukController::class, 'index'])->name('petunjuk');

/* =====================
   AUTH
===================== */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(['role:guru', 'role:siswa']);


/* =====================================================
   ADMIN (LOGIN + ROLE ADMIN)
===================================================== */
Route::middleware(['auth', 'role:admin'])
   ->prefix('admin')
   ->name('admin.')
   ->group(function () {
      Route::get('/dashboard', function () {
         return view('admin.dashboard');
      })->name('dashboard');

      Route::resource('users', UserController::class)->except(['show']);
      Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
      Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
      Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

      Route::resource('kelas', KelasController::class)->except(['show']);
      Route::get('/kelas/data', [KelasController::class, 'data'])->name('kelas.data');
      Route::get('/kelas/{kelas}/students', [KelasController::class, 'manageStudents'])->name('kelas.students');
      Route::post('/kelas/{kelas}/add-student', [KelasController::class, 'addStudent'])->name('kelas.add-student');
      Route::delete('/kelas/{kelas}/remove-student/{student}', [KelasController::class, 'removeStudent'])->name('admin.kelas.remove-student');
      Route::get('/kelas/{kelas}/detail', [KelasController::class, 'detail'])->name('kelas.detail');
      Route::post('/kelas/update-token-guru', [KelasController::class, 'updateTokenGuru'])->name('pengaturan.token.update');
      Route::post('/kelas/{kelas}/update-guru', [KelasController::class, 'updateGuru'])->name('kelas.update-guru');

      // Profil Admin
      Route::get('/profile', [ProfileAdminController::class, 'index'])->name('profile');
      Route::post('/profile/update', [ProfileAdminController::class, 'update'])->name('profile.update');
      Route::post('/profile/avatar', [ProfileAdminController::class, 'uploadAvatar'])->name('profile.avatar');
   });



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

      /* ====  GABUNG KELAS ===== */
      Route::post('/gabung-kelas', [MenuController::class, 'gabungKelas'])->name('gabung.kelas');

      /* ===== PROGRESS SISWA ===== */
      Route::post('/progress/update', [ProgressController::class, 'store'])->name('progress.update');
      Route::get('/progres-detail', [ProgressController::class, 'getDetail'])->name('progres.detail');
      Route::post('/progres/simpan', [ProgressController::class, 'store'])->name('progres.simpan');

      /* ===== PROFILE ===== */
      Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
      Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
      Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

      /* ===== REFLEKSI ===== */
      Route::post('/refleksi/simpan', [RefleksiController::class, 'simpan'])->name('refleksi.simpan');
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
      Route::get('/data_soal/{id}/edit-json', [DataSoalController::class, 'editJson'])->name('data_soal.edit_json');
      Route::get('/data_soal/{id}/detail', [DataSoalController::class, 'detail'])->name('data_soal.detail');
      Route::put('/data_soal/{id}', [DataSoalController::class, 'update'])->name('data_soal.update');
      Route::delete('/data_soal/{id}', [DataSoalController::class, 'destroy'])->name('data_soal.destroy');
      Route::get('data_soal/template', [DataSoalController::class, 'downloadTemplate'])->name('data_soal.template');
      Route::post('data_soal/import', [DataSoalController::class, 'importExcel'])->name('data_soal.import');

      /* ===== PAKET SOAL ===== */
      Route::get('/paket_soal/{id}/json', [PaketSoalController::class, 'json'])->name('paket_soal.json');

      Route::resource('paket_soal', PaketSoalController::class)->except(['show']);

      /* ===== AKTIVITAS ===== */
      Route::resource('aktivitas', AktivitasController::class)->except(['show']);

      /* ===== NILAI ===== */
      Route::get('/data_nilai', [DataNilaiController::class, 'index'])->name('data_nilai');
      Route::get('/data_nilai/export', [DataNilaiController::class, 'export'])->name('data_nilai.export');
      Route::get('/data_nilai/{id}', [DataNilaiController::class, 'show'])->name('data_nilai.show');
      Route::get('/analisis_nilai', [DataNilaiController::class, 'analisis'])->name('data_nilai.analisis');
      Route::get('/data_nilai/riwayat/{user_id}', [DataNilaiController::class, 'riwayat'])->name('data_nilai.riwayat');

      /* ===== DATA SISWA ===== */
      Route::get('/data_siswa', [DataSiswaController::class, 'index'])->name('data_siswa');
      Route::delete('/data_siswa/{id}', [DataSiswaController::class, 'destroy'])->name('data_siswa.destroy');
      Route::put('/data_siswa/{id}', [DataSiswaController::class, 'update'])->name('data_siswa.update');
      Route::get('/data_siswa/export', [DataSiswaController::class, 'export'])->name('data_siswa.export');

      // Route Data Kelas
      Route::resource('data_kelas', DataKelasController::class)->except(['show']);

      /* ===== PENCAPAIAN SISWA (Pengganti Progres Siswa) ===== */
      Route::get('/pencapaian_siswa', [PencapaianSiswaController::class, 'index'])->name('pencapaian_siswa');
      Route::get('/pencapaian_siswa/data', [PencapaianSiswaController::class, 'data'])->name('pencapaian_siswa.data');
      Route::get('/pencapaian_siswa/{user_id}/detail', [PencapaianSiswaController::class, 'detail'])->name('pencapaian_siswa.detail');

      // DUA ROUTE BARU INI:
      Route::get('/pencapaian_siswa/data_leaderboard', [PencapaianSiswaController::class, 'dataLeaderboard'])->name('pencapaian_siswa.data_leaderboard');
      Route::get('/pencapaian_siswa/badge/{badge_id}/detail', [PencapaianSiswaController::class, 'detailBadge'])->name('pencapaian_siswa.badge_detail');


      /* PROFILE GURU */
      Route::get('/profil', [ProfileGuruController::class, 'index'])->name('profil');
      Route::post('/profil/update', [ProfileGuruController::class, 'update'])->name('profil.update');
      Route::post('/profil/avatar', [ProfileController::class, 'uploadAvatar'])->name('profil.avatar');

      /* ===== DATA REFLEKSI ===== */
      Route::get('/data_refleksi', [DataRefleksiController::class, 'index'])->name('data_refleksi');
   });
