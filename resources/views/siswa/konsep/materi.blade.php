@extends('layouts.siswa')

@section('title', 'PythaLearn')

@section('content')
<div class="container">
    <div class="row align-items-center mb-2">
        <div class="col-lg-8">
            <h3 class="mb-1">Menemukan Konsep Pythagoras</h3>
        </div>
    </div>

    <!-- ================= HALAMAN 1 ================= -->
    <section class="materi-page" data-page="0">

        <!-- Tujuan Pembelajaran -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tujuan Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li>Peserta didik mampu menganalisis beberapa informasi untuk membuktikan kebenaran teorema Pythagoras.</li>
                        <li>Peserta didik mampu membuat pembuktian berupa skema atau prosedur terhadap rumus teorema Pythagoras.</li>
                        <li>Peserta didik mampu menentukan panjang sisi segitiga siku-siku apabila dua sisi lainnya diketahui.</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Tahukah Kamu -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Tahukah Kamu?</h4>
                </div>

                <div class="card-body">

                    <p class="text-justify">
                        Bayangkan kalian berdiri di tepi sungai dan melihat Jembatan Barito dari samping.
                    </p>

                    <div class="text-center mb-4">
                        <img src="/images/jembatan-barito.jpg" class="img-fluid rounded" style="max-width:50%;">
                        <p class="text-muted small mt-2">
                            Gambar 1. Jembatan Barito dilihat dari samping
                        </p>
                    </div>

                    <p class="text-justify">
                        Perhatikan tiang yang berdiri tegak, kabel yang miring, dan badan jembatan yang mendatar.
                    </p>

                    <div class="text-center mb-4">
                        <img src="/images/jembatan_barito_2.png" class="img-fluid rounded" style="max-width:50%;">
                        <p class="text-muted mt-2">
                            Gambar 2. Ilustrasi bentuk segitiga pada jembatan
                        </p>
                    </div>

                    <p class="text-justify">
                        Dari gambar tersebut terlihat bangun yang menyerupai segitiga dengan:
                    </p>

                    <ul>
                        <li>satu sisi tegak,</li>
                        <li>satu sisi mendatar,</li>
                        <li>satu sisi miring.</li>
                    </ul>

                    <hr>

                    <!-- Interaktif -->
                    <h5 class="fw-bold text-center mt-4">Ayo Amati dan Cocokkan</h5>
                    <p class="text-center text-muted">
                        Seret jawaban ke tempat yang sesuai.
                    </p>

                    <!-- DRAG ITEM -->
                    <div class="d-flex justify-content-center gap-3 mb-4" id="dragContainer">
                        <div class="drag-item" draggable="true" data-value="tegak">Tegak</div>
                        <div class="drag-item" draggable="true" data-value="datar">Datar</div>
                        <div class="drag-item" draggable="true" data-value="miring">Miring</div>
                    </div>

                    <!-- DROP ZONE -->
                    <div class="alert alert-light">
                        <div class="d-flex flex-wrap align-items-center justify-content-around gap-4">
                            <!-- Item 1 -->
                            <div class="text-center">
                                <p class="mb-1 small">Garis <span class="badge bg-primary">biru</span> menunjukkan sisi</p>
                                <div class="drop-zone drop-h1" data-answer="tegak">...</div>
                            </div>
                            
                            <!-- Item 2 -->
                            <div class="text-center">
                                <p class="mb-1 small">Garis <span class="badge bg-warning text-dark">kuning</span> menunjukkan sisi</p>
                                <div class="drop-zone drop-h1" data-answer="datar">...</div>
                            </div>
                            
                            <!-- Item 3 -->
                            <div class="text-center">
                                <p class="mb-1 small">Garis <span class="badge bg-success">hijau</span> menunjukkan sisi</p>
                                <div class="drop-zone drop-h1" data-answer="miring">...</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-success" id="checkAnswer">
                            Periksa Jawaban
                        </button>
                    </div>

                    <!-- HASIL -->
                    <div id="hasilStruktur" class="d-none mt-5">

                    <div class="alert alert-success border-0 shadow-sm rounded-4 p-4 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                <i class="bi bi-check-lg fs-3"></i>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0 text-muted">
                                    Perhatikan!
                                    Berikut penjelasan struktur sisi segitiga siku-siku.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow rounded-4">
                        <div class="card-body p-4 p-lg-5">

                                            <div class="text-center mb-4">
                                        <img src="/images/jembatan_barito_1.png" class="img-fluid rounded" style="max-width:30%;">
                                        <p class="text-muted small mt-2">
                                            Gambar 3. Struktur Segitiga Siku-siku pada Jembaran Barito
                                        </p>
                                    </div>
                            
                            <div class="text-center mb-5">
                                <h3 class="fw-bold text-dark mb-2">Struktur Segitiga Siku-siku</h3>
                                <p class="text-muted">Berdasarkan posisi garis yang baru saja kamu susun:</p>
                            </div>

                            <div class="row g-4">
                                
                                <div class="col-md-6">
                                    <div class="h-100 p-4 rounded-4 bg-light border border-success border-opacity-25 position-relative overflow-hidden">

                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-success px-3 py-2 rounded-pill fs-6 fw-normal shadow-sm me-2">Garis Hijau</span>
                                            <span class="text-muted small"><i class="bi bi-arrow-right"></i> Disebut sebagai:</span>
                                        </div>

                                        <h4 class="fw-bold text-success mb-3">Hipotenusa (Sisi Miring)</h4>
                                        <ul class="list-unstyled text-secondary mb-0">
                                            <li class="mb-2 d-flex align-items-start">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                                Merupakan sisi yang paling panjang.
                                            </li>
                                            <li class="d-flex align-items-start">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                                Posisinya selalu di depan sudut siku-siku.
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="h-100 p-4 rounded-4 bg-light border border-primary border-opacity-25 position-relative overflow-hidden">
                                        <div class="d-flex align-items-center mb-3 gap-2">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill fs-6 fw-normal shadow-sm">Garis Biru</span>
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6 fw-normal shadow-sm">Garis Kuning</span>
                                            <span class="text-muted small ms-1"><i class="bi bi-arrow-right"></i> Disebut:</span>
                                        </div>

                                        <h4 class="fw-bold text-primary mb-3">Sisi Siku-siku</h4>
                                        <ul class="list-unstyled text-secondary mb-0">
                                            <li class="mb-2 d-flex align-items-start">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                                Sisi Tegak (Biru) dan Sisi Datar (Kuning).
                                            </li>
                                            <li class="d-flex align-items-start">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                                Kedua sisi ini bertemu membentuk Sudut 90° (Huruf L).
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </section>
    </section>

    <!-- ================= HALAMAN 2 ================= -->
    <section class="materi-page d-none" data-page="1">

        <section class="mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Ayo Mengingat Kembali</h4>
                </div>

                <div class="card-body">

                    <!-- ================= 1. BILANGAN KUADRAT ================= -->
                    <h5 class="fw-bold">1. Bilangan Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        Salah satu bentuk perkalian yang sering muncul dalam matematika adalah
                        <strong>perkalian suatu bilangan dengan dirinya sendiri</strong>.
                        Perkalian jenis ini banyak digunakan dalam berbagai konsep,
                        termasuk pada <strong>Teorema Pythagoras</strong>.
                    </p>

                    <p class="text-justify">
                        Perkalian suatu bilangan dengan dirinya sendiri disebut
                        <strong>bentuk kuadrat</strong>.
                        Disebut kuadrat karena bilangan tersebut dipangkatkan dua.
                        Bentuk kuadrat digunakan untuk menyederhanakan penulisan
                        perkalian berulang.
                    </p>

                    <!-- TABEL CONTOH -->
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>Perkalian</th>
                                    <th>Bentuk Kuadrat</th>
                                    <th>Hasil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>\(2 \times 2\)</td>
                                    <td>\(2^2\)</td>
                                    <td>\(4\)</td>
                                </tr>
                                <tr>
                                    <td>\(4 \times 4\)</td>
                                    <td>\(4^2\)</td>
                                    <td>\(16\)</td>
                                </tr>
                                <tr>
                                    <td>\(6 \times 6\)</td>
                                    <td>\(6^2\)</td>
                                    <td>\(36\)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-justify mt-3">
                        Dari tabel di atas terlihat bahwa bilangan
                        \(4\), \(16\), dan \(36\) diperoleh dari hasil
                        pengkuadratan suatu bilangan.
                        Bilangan-bilangan tersebut disebut
                        <strong>bilangan kuadrat</strong>.
                    </p>

                    <p class="text-justify">
                        Secara umum, jika suatu bilangan dinyatakan dengan
                        simbol <strong>\(a\)</strong>, maka bentuk kuadratnya
                        dapat dituliskan sebagai:
                    </p>

                    <p class="text-center math-block">
                    \[
                    a^2 = a \times a
                    \]
                    </p>

                    <div class="alert alert-light border-start border-success border-4 mt-3">
                        <strong>Bilangan kuadrat</strong> adalah bilangan
                        yang diperoleh dari hasil perkalian suatu bilangan
                        dengan dirinya sendiri.
                    </div>

                    <p class="text-justify mt-3">
                        Selain dalam operasi hitung, bilangan kuadrat juga
                        memiliki makna dalam konteks geometri.
                        Jika sebuah persegi memiliki panjang sisi
                        <strong>\(a\)</strong>, maka luas persegi tersebut
                        adalah <strong>\(a^2\)</strong>.
                    </p>

                    <p class="text-justify">
                        Konsep luas persegi inilah yang menjadi dasar
                        dalam <strong>Teorema Pythagoras</strong>,
                        karena teorema tersebut membahas hubungan antara
                        <strong>luas persegi pada sisi-sisi segitiga siku-siku</strong>.
                    </p>

                    <p class="fw-bold mt-4">Sifat-sifat Bilangan Berpangkat</p>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-success">
                                <tr>
                                    <th style="width:10%">No</th>
                                    <th style="width:30%">Jenis Sifat</th>
                                    <th style="width:30%">Rumus Umum</th>
                                    <th style="width:30%">Contoh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sifat Perkalian -->
                                <tr>
                                    <td>1</td>
                                    <td>Perkalian Bilangan Berpangkat</td>
                                    <td>\(a^m \times a^n = a^{m+n}\)</td>
                                    <td>\(3^2 \times 3^3 = 3^{2+3} = 3^5\)</td>
                                </tr>

                                <!-- Sifat Pembagian -->
                                <tr>
                                    <td>2</td>
                                    <td>Pembagian Bilangan Berpangkat</td>
                                    <td>\(a^m : a^n = a^{m-n}\)</td>
                                    <td>\(3^4 : 3^2 = 3^{4-2} = 3^2\)</td>
                                </tr>

                                <!-- Sifat Perpangkatan -->
                                <tr>
                                    <td>3</td>
                                    <td>Perpangkatan Bilangan Berpangkat</td>
                                    <td>\((a^m)^n = a^{m \times n}\)</td>
                                    <td>\((3^2)^2 = 3^{2 \times 2} = 3^4\)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="kuadrat-container" class="ayo-kuadrat mt-5">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white text-center py-3">
                                <h5 class="mb-0 fw-bold">Ayo Mencoba: Bilangan Berpangkat</h5>
                            </div>
                            
                            <div class="card-body bg-light">
                                <p class="text-muted text-center mb-4">
                                    Lengkapi kotak kosong pada kolom <strong>Penyelesaian</strong> dan <strong>Hasil Akhir</strong>.
                                </p>
                                
                                <div class="table-responsive bg-white rounded shadow-sm p-3">
                                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                                        <thead class="table-success text-dark">
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th width="20%">Soal</th>
                                                <th width="50%">Penyelesaian</th>
                                                <th width="25%">Hasil Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">a.</td>
                                                <td class="fs-5">\(3^2\)</td>
                                                <td class="text-start ps-5 fs-5">
                                                    \(3 \times 3\)
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-kuadrat px-1" 
                                                        style="width: 80px; font-size: 1.1rem;" 
                                                        data-answer="9" placeholder="...">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">b.</td>
                                                <td class="fs-5">\(2^2 \times 2^3\)</td>
                                                <td class="text-start ps-5 fs-5">
                                                    \(2\)
                                                    <sup class="d-inline-flex align-items-center">
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="2">
                                                        <span class="mx-1 fs-6">+</span>
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="3">
                                                    </sup>
                                                </td>
                                                <td class="fs-5">
                                                    \(2\)
                                                    <sup>
                                                        <input type="number" class="form-control px-1 d-inline-block text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 32px; font-size: 0.9rem;" data-answer="5">
                                                    </sup>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">c.</td>
                                                <td class="fs-5">\((-5)^2 \times (-5)^2\)</td>
                                                <td class="text-start ps-5 fs-5">
                                                    \((-5)\)
                                                    <sup class="d-inline-flex align-items-center">
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="2">
                                                        <span class="mx-1 fs-6">+</span>
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="2">
                                                    </sup>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-kuadrat px-1" 
                                                        style="width: 80px; font-size: 1.1rem;" 
                                                        data-answer="625" placeholder="...">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">d.</td>
                                                <td class="fs-5">\(3^3 : 3^2\)</td>
                                                <td class="text-start ps-5 fs-5">
                                                    \(3\)
                                                    <sup class="d-inline-flex align-items-center">
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="3">
                                                        <span class="mx-1 fs-6">-</span>
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="2">
                                                    </sup>
                                                </td>
                                                <td class="fs-5">
                                                    \(3\)
                                                    <sup>
                                                        <input type="number" class="form-control px-1 d-inline-block text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 32px; font-size: 0.9rem;" data-answer="1">
                                                    </sup>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">e.</td>
                                                <td class="fs-5">\((5^2)^2\)</td>
                                                <td class="text-start ps-5 fs-5">
                                                    \(5\)
                                                    <sup class="d-inline-flex align-items-center">
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="2">
                                                        <span class="mx-1 fs-6">&times;</span>
                                                        <input type="number" class="form-control px-1 text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 30px; font-size: 0.9rem;" data-answer="2">
                                                    </sup>
                                                </td>
                                                <td class="fs-5">
                                                    \(5\)
                                                    <sup>
                                                        <input type="number" class="form-control px-1 d-inline-block text-center fw-bold input-kuadrat" 
                                                            style="width: 45px; height: 32px; font-size: 0.9rem;" data-answer="4">
                                                    </sup>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-center mt-4 mb-3">
                                    <button class="btn btn-success btn-lg px-5 shadow fw-bold" id="btnCekKuadrat">Periksa Jawaban</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================================================= -->
                    <!-- 2. AKAR KUADRAT -->
                    <!-- ================================================= -->
                    <h5 class="fw-bold mt-5">2. Akar Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        Akar kuadrat merupakan kebalikan dari bilangan kuadrat.
                        Akar kuadrat dari suatu bilangan positif adalah bilangan
                        yang jika dikuadratkan menghasilkan bilangan tersebut.
                    </p>

                    <p class="text-center math-block">
                        \[
                        3^2 = 9 \Rightarrow \sqrt{9} = 3
                        \]
                    </p>

                    <p class="text-justify">
                        Secara umum, jika suatu bilangan positif dapat dituliskan sebagai
                        \[
                        k = a^2
                        \]
                        maka bilangan tersebut memiliki dua akar, yaitu akar positif dan
                        akar negatif.
                    </p>

                    <p class="text-center math-block">
                        \[
                        \sqrt{64} = 8 \quad \text{dan} \quad -\sqrt{64} = -8
                        \]
                    </p>

                    <div class="alert alert-light border-start border-success border-4 mt-3">
                        Dalam penerapan <strong>Teorema Pythagoras</strong>,
                        yang digunakan hanya <strong>akar kuadrat positif</strong>
                        karena berkaitan dengan panjang sisi.
                    </div>

                    <p class="fw-bold mt-4">Sifat-sifat Akar Kuadrat</p>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-success">
                                <tr>
                                    <th style="width:10%">No</th>
                                    <th style="width:30%">Bentuk</th>
                                    <th style="width:30%">Sifat</th>
                                    <th style="width:30%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Perkalian Akar -->
                                <tr>
                                    <td>1</td>
                                    <td>\(\sqrt{A \times B}\)</td>
                                    <td>\(\sqrt{A} \times \sqrt{B}\)</td>
                                    <td>\(A \ge 0,\ B \ge 0\)</td>
                                </tr>

                                <!-- Pembagian Akar -->
                                <tr>
                                    <td>2</td>
                                    <td>\(\sqrt{\dfrac{A}{B}}\)</td>
                                    <td>\(\dfrac{\sqrt{A}}{\sqrt{B}}\)</td>
                                    <td>\(A \ge 0,\ B \ne 0\)</td>
                                </tr>

                                <!-- Akar dikuadratkan -->
                                <tr>
                                    <td>3</td>
                                    <td>\(\sqrt{A} \times \sqrt{A}\)</td>
                                    <td>\(A\)</td>
                                    <td>\(A \ge 0\)</td>
                                </tr>

                                <!-- Akar bertingkat -->
                                <tr>
                                    <td>4</td>
                                    <td>\(\sqrt{\sqrt{A}}\)</td>
                                    <td>\(\sqrt[4]{A}\)</td>
                                    <td>\(A \ge 0\)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="akar-container" class="ayo-akar mt-5">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white text-center py-3">
                                <h5 class="mb-0 fw-bold">Ayo Mencoba: Akar Kuadrat</h5>
                            </div>
                            
                            <div class="card-body bg-light">
                                <p class="text-muted text-center mb-4">
                                    Lengkapi titik-titik pada kolom <strong>Penyelesaian</strong> dan <strong>Hasil Akhir</strong> sesuai dengan pola contoh.
                                </p>
                                
                                <div class="table-responsive bg-white rounded shadow-sm p-3">
                                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                                        <thead class="table-success text-dark">
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th width="20%">Soal</th>
                                                <th width="50%">Penyelesaian</th>
                                                <th width="25%">Hasil Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">a.</td>
                                                <td class="fs-5">\(\sqrt{25}\)</td>
                                                <td class="text-start ps-4 fs-5">
                                                    \(\sqrt{5 \times 5} = \sqrt{5} \times \sqrt{5}\)
                                                </td>
                                                <td class="fs-5 fw-bold">5</td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">b.</td>
                                                <td class="fs-5">\(\sqrt{4 \times 9}\)</td>
                                                <td class="text-start ps-4 fs-5">
                                                    \(\sqrt{4} \times \sqrt{9} =\)
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                        style="width: 50px; font-size: 1rem;" data-answer="2">
                                                    \(\times\)
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                        style="width: 50px; font-size: 1rem;" data-answer="3">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                        style="width: 60px; font-size: 1.1rem;" 
                                                        data-answer="6" placeholder="...">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">c.</td>
                                                <td class="fs-5">\(\sqrt{9 + 16}\)</td>
                                                <td class="text-start ps-4 fs-5">
                                                    \(\sqrt{9 + 16} = \sqrt{}\)
                                                        <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                            style="width: 60px; font-size: 1rem;" data-answer="25">
                                                </td>
                                                <td class="fs-5 fw-bold">5</td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">d.</td>
                                                <td class="fs-5">\(\sqrt{\sqrt{16}}\)</td>
                                                <td class="text-start ps-4 fs-5">
                                                    \(\sqrt{\sqrt{16}} = \sqrt{4}\)
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                        style="width: 60px; font-size: 1.1rem;" 
                                                        data-answer="2" placeholder="...">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="fw-bold">e.</td>
                                                <td class="fs-5">\(\sqrt{\sqrt{81}}\)</td>
                                                <td class="text-start ps-4 fs-5">
                                                    \(\sqrt{\sqrt{81}} = \sqrt{}\)
                                                        <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                            style="width: 60px; font-size: 1rem;" data-answer="9">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control d-inline-block text-center fw-bold input-akar px-1" 
                                                        style="width: 60px; font-size: 1.1rem;" 
                                                        data-answer="3" placeholder="...">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-center mt-4 mb-3">
                                    <button class="btn btn-success btn-lg px-5 shadow fw-bold" id="btnCekAkar">Periksa Jawaban</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </section>

    <!-- ================= HALAMAN 3 ================= -->
<section class="materi-page d-none" data-page="2">
    <div class="row">
        
        <!-- ================= KANVAS INTERAKTIF SEGITIGA ================= -->
        <div class="col-sm-12 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Ayo Menggambar</h4>
                </div>
                
                <div class="card-body">
                    <!-- ================= PETUNJUK PENGGUNAAN ================= -->
                    <div class="col-sm-12">                
                        <div class="alert alert-light border-start border-success border-4">
                            <h6 class="fw-bold mb-2">Petunjuk Penggunaan</h6>
                            <ol class="mb-0">
                                <li>
                                    Dibawah ini terdapat <strong>kanvas interaktif</strong> untuk menggambar segitiga
                                    yang digunakan untuk mengenali jenis-jenis segitiga.
                                </li>
                                <li>
                                    Anda dapat menggambar segitiga dengan dua cara:
                                    <ul>
                                        <li>
                                            <strong>Mengklik tiga titik berbeda</strong> pada area kanvas,
                                            dan sistem akan otomatis menghubungkan ketiga titik tersebut
                                            menjadi sebuah segitiga.
                                        </li>
                                        <li>
                                            <strong>Mengklik satu titik lalu menyeretnya dengan kursor</strong>
                                            untuk membentuk sisi-sisi segitiga hingga terbentuk
                                            bangun segitiga.
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    Setiap garis yang dibuat akan secara visual membentuk
                                    <strong>sisi-sisi segitiga</strong>.
                                </li>
                                <li>
                                    Setelah segitiga terbentuk, sistem akan secara otomatis
                                    <strong>menganalisis dan menentukan jenis segitiga</strong>.
                                </li>
                                <li>
                                    Perhatikan hasilnya untuk mengetahui apakah segitiga tersebut
                                    termasuk <strong>segitiga siku-siku, sama kaki, sama sisi,</strong>
                                    atau <strong>segitiga sembarang</strong>.
                                </li>
                                <li>
                                    Gunakan tombol <strong>Reset</strong> untuk menghapus gambar
                                    dan mencoba membuat segitiga dengan bentuk yang berbeda.
                                </li>
                            </ol>

                        </div>
                    </div>

                    <div class="canvas-wrapper">
                        <canvas id="triangleCanvas" width="520" height="420"></canvas>
                    </div>

                    <div class="canvas-toolbar controls text-center mt-3">
                        <button class="btn btn-success btn-sm" onclick="resetCanvas()">Reset Canvas</button>
                    </div>

                    <div id="triangleInfo"
                        class="alert alert-light border-start border-success border-4 mt-4">
                        Jenis Segitiga:
                    </div>

                </div>
            </div>
            <div class="mt-5">
    
                <div class="alert alert-light border-start border-success border-4 mb-4">
                    <h6 class="fw-bold mb-2 text-success">
                        <i class="bi bi-lightbulb me-2"></i>Refleksi Pengamatan
                    </h6>
                    <p class="mb-0">
                        Setelah mencoba fitur menggambar di atas, jawablah pertanyaan-pertanyaan berikut 
                        sebagai <strong>refleksi untuk lebih mengenal</strong> karakteristik segitiga. 
                        Tuliskan jawaban berdasarkan <strong>hasil pengamatanmu</strong> sendiri sebelum menyimpan jawaban.
                    </p>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        1. Bagaimana proses yang kamu lakukan saat menggambar segitiga?
                    </label>
                    <textarea id="jawaban1" class="form-control" rows="2" placeholder="Ceritakan langkahmu..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        2. Menurut pengamatanmu, kapan sebuah segitiga dapat disebut sebagai segitiga siku-siku?    
                    </label>
                    <div class="card card-body bg-light border-0 p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="refleksi2" id="opsi_a" value="salah">
                            <label class="form-check-label" for="opsi_a">Jika ketiga sisinya sama panjang.</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="refleksi2" id="opsi_b" value="benar">
                            <label class="form-check-label" for="opsi_b">Jika memiliki tepat satu sudut siku-siku (90°).</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="refleksi2" id="opsi_c" value="salah">
                            <label class="form-check-label" for="opsi_c">Jika semua sudutnya kurang dari 90°.</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        3. Jika segitiga memiliki sudut siku-siku, sisi manakah yang paling panjang?
                    </label>
                    <select class="form-select" id="jawaban3">
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="tegak">Sisi Tegak</option>
                        <option value="datar">Sisi Datar</option>
                        <option value="miring">Sisi Miring</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        4. Apa kesimpulanmu tentang segitiga siku-siku setelah mencoba fitur menggambar ini?
                    </label>
                    <textarea id="jawaban4" class="form-control" rows="3" placeholder="Tuliskan pendapatmu..."></textarea>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" onclick="resetInputs()" class="btn btn-outline-secondary">
                        Reset Jawaban
                    </button>
                    <button type="button" id="btnSimpan" class="btn btn-success px-4 fw-bold">
                        Simpan Jawaban 
                    </button>
                </div>
            </div>
        </div>

    

        <!-- ================================= -->
        <!-- SEGITIGA SIKU-SIKU -->
        <!-- ================================= -->
        <div class="col-sm-12 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Segitiga Siku-Siku</h4>
                </div>

                <div class="card-body">
                    <p class="text-justify">
                        Segitiga siku-siku adalah segitiga yang memiliki
                        <strong>satu sudut sebesar 90°</strong>.
                        Perhatikan segitiga siku-siku <strong>ABC</strong> berikut.
                    </p>

                    <div class="text-center my-4">
                        <img src="/images/segitiga_sikusiku_1.png"
                            alt="Segitiga siku-siku ABC"
                            class="img-fluid"
                            style="max-width: 300px;">
                        <p class="text-muted mt-2">
                            Gambar 3. Segitiga siku-siku ABC
                        </p>
                    </div>

                    <h5>Keterangan:</h5>
                    <ul>
                        <li>
                            Sisi depan sudut siku-siku atau sisi AC adalah sisi terpanjang yang disebut <strong>sisi miring (hipotenusa)</strong>.
                        </li>
                        <li>
                            Sisi lain pembentuk sudut siku-siku yaitu sisi AB (sisi tegak) dan sisi BC (sisi datar) disebut sisi siku-siku
                        </li>
                    </ul>

                    <div class="alert alert-light border-start border-success border-4 mt-3">
                        Pemahaman tentang posisi sisi-sisi segitiga siku-siku
                        menjadi dasar dalam mempelajari <strong>Teorema Pythagoras</strong>.
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= AYO MENCOBA SEGITIGA SIKU-SIKU ================= -->
        <div class="col-sm-12 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Ayo Mengamati</h4>
                    <p class="text-muted mb-0">
                        Perhatikan gambar berbagai posisi segitiga siku-siku di bawah ini.
                        Tentukan sisi mana yang menjadi sisi tegak, sisi mendatar, dan sisi miring (hipotenusa).
                    </p>
                </div>

                <div class="card-body">
                    <!-- Tabel Pengamatan -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Segitiga ACB</th>
                                    <th>Segitiga ABC</th>
                                    <th>Segitiga BAC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <!-- Gambar Segitiga ACB -->
                                        <div class="text-center">
                                            <img src="/images/segitiga_sikusiku_c.png" 
                                                alt="Segitiga ACB siku-siku di C" 
                                                class="img-fluid rounded border mb-2"
                                                style="max-height: 250px;">
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Gambar Segitiga ABC -->
                                        <div class="text-center">
                                            <img src="/images/segitiga_sikusiku_b.png" 
                                                alt="Segitiga ABC siku-siku di B" 
                                                class="img-fluid rounded border mb-2"
                                                style="max-height: 250px;">
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Gambar Segitiga BAC -->
                                        <div class="text-center">
                                            <img src="/images/segitiga_sikusiku_a.png" 
                                                alt="Segitiga BAC siku-siku di A" 
                                                class="img-fluid rounded border mb-2"
                                                style="max-height: 250px;">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Isian -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center align-middle" id="tabel-isian">
                            <thead class="table-light">
                                <tr>
                                    <th>Segitiga</th>
                                    <th>Sudut Siku-siku di Titik</th>
                                    <th>Sisi Tegak</th>
                                    <th>Sisi Mendatar</th>
                                    <th>Sisi Miring</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris ACB -->
                                <tr>
                                    <td><strong>ACB</strong></td>
                                    <td class="bg-light">C</td>
                                    <td class="bg-light">AC</td>
                                    <td class="bg-light">BC</td>
                                    <td class="bg-light">AB</td>
                                </tr>
                                <!-- Baris ABC -->
                                <tr>
                                    <td><strong>ABC</strong></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm table-input" 
                                            data-correct="B" data-row="abc" data-col="sudut"
                                            placeholder="...">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm table-input" 
                                            data-correct="AB" data-row="abc" data-col="tegak"
                                            placeholder="...">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm table-input" 
                                            data-correct="BC" data-row="abc" data-col="mendatar"
                                            placeholder="...">
                                    </td>
                                    <td class="bg-light">AC</td>
                                </tr>
                                <!-- Baris BAC -->
                                <tr>
                                    <td><strong>BAC</strong></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm table-input" 
                                            data-correct="A" data-row="bac" data-col="sudut"
                                            placeholder="...">
                                    </td>
                                    <td class="bg-light">AC</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm table-input" 
                                            data-correct="AB" data-row="bac" data-col="mendatar"
                                            placeholder="...">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm table-input" 
                                            data-correct="BC" data-row="bac" data-col="miring"
                                            placeholder="...">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Tombol Validasi Tabel -->
                        <div class="text-center mt-3">
                            <button class="btn btn-success" onclick="checkTableAnswers()">Periksa Jawaban</button>
                        </div>
                        
                        <!-- Informasi Percobaan -->
                        <div id="table-attempt-info" class="text-center mt-2 text-muted small"></div>
                    </div>

                    <!-- Pertanyaan 1-3 -->
                    <div class="border rounded p-4 bg-light">
                        <h5>Silahkan jawab pertanyaan di bawah ini:</h5>
                        
                        <!-- Pertanyaan 1 -->
                        <div class="mb-4">
                            <p class="fw-bold mb-2">
                                1. Dari semua posisi segitiga di atas, sisi manakah yang selalu berhadapan dengan sudut siku-siku?
                            </p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q1" id="q1a">
                                <label class="form-check-label" for="q1a">
                                    Sisi tegak
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q1" id="q1b">
                                <label class="form-check-label" for="q1b">
                                    Sisi mendatar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q1" id="q1c">
                                <label class="form-check-label" for="q1c">
                                    Sisi miring (hipotenusa)
                                </label>
                            </div>
                        </div>

                        <!-- Pertanyaan 2 -->
                        <div class="mb-4">
                            <p class="fw-bold mb-2">
                                2. Dari hasil pengamatanmu, apakah sisi tersebut selalu menjadi sisi terpanjang dalam segitiga?
                            </p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q2" id="q2a">
                                <label class="form-check-label" for="q2a">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="q2" id="q2b">
                                <label class="form-check-label" for="q2b">
                                    Tidak
                                </label>
                            </div>
                        </div>

                        <!-- Pertanyaan 3 (SOAL BARU) -->
                        <div class="mb-4">
                            <p class="fw-bold mb-2">
                                3. Berdasarkan pengamatanmu, manakah pernyataan yang BENAR tentang segitiga siku-siku?
                            </p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q3" id="q3a">
                                <label class="form-check-label" for="q3a">
                                    Segitiga siku-siku bisa memiliki dua sudut siku-siku
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q3" id="q3b">
                                <label class="form-check-label" for="q3b">
                                    Sisi miring bisa lebih pendek dari sisi tegak atau mendatar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q3" id="q3c">
                                <label class="form-check-label" for="q3c">
                                    Segitiga siku-siku hanya memiliki satu sudut siku-siku (90°)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q3" id="q3d">
                                <label class="form-check-label" for="q3d">
                                    Sisi tegak dan mendatar selalu sama panjang
                                </label>
                            </div>
                        </div>

                        <!-- Tombol Check Answer -->
                        <div class="text-center">
                            <button class="btn btn-success" onclick="checkQuestionAnswers()">Periksa Jawaban    </button>
                        </div>
                        
                        <!-- Informasi Percobaan Pertanyaan -->
                        <div id="question-attempt-info" class="text-center mt-2 text-muted small"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
    
    <!-- ================= HALAMAN 4 ================= -->
    <section class="materi-page d-none" data-page="3">
        <div class="row">
            <!-- ================================= -->
            <!-- DALIL PYTHAGORAS -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Dalil Pythagoras</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-justify">
                            Perhatikan gambar dibawah, setiap sisi segitiga siku-siku yang ditengah menempel sebuah persegi yang menyesuaikan panjang sisi tersebut. Ternyata luas persegi pada sisi miring sama dengan jumlah luas dua persegi pada sisi siku-siku. Hubungan inilah yang menjadi dasar dari Dalil Pythagoras.
                        </p>

                        
                        <!-- Gambar Segitiga Siku-siku dengan Persegi -->
                        <div class="text-center my-4">
                            <img src="/images/pembuktian_pythagoras.png" alt="Segitiga Siku-Siku" class="img-fluid rounded border" style="width: 30%;">
                            <p class="text-muted mt-2">
                                Gambar 4. Ilustrasi Persegi pada sisi miring (c) memiliki luas yang sama dengan jumlah luas persegi pada sisi a dan b
                            </p>
                        </div>
                        
                        <div class="alert alert-light border-start border-success border-4 mt-3">
                            <strong>Konsep Dasar:</strong>
                            Jika pada setiap sisi segitiga siku-siku dibuat sebuah persegi,
                            maka luas persegi pada sisi miring sama dengan jumlah luas
                            dua persegi pada sisi siku-sikunya.
                            
                            <div class="text-center my-2">
                                <strong>Luas Persegi C = Luas Persegi A + Luas Persegi B</strong>
                            </div>

                            <div class="text-center">
                                Jika panjang sisi-sisinya berturut-turut adalah
                                <strong>a</strong>, <strong>b</strong>, dan <strong>c</strong>,
                                maka hubungan luas tersebut dapat dituliskan sebagai:
                                <br>
                                <strong>c² = a² + b²</strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
            <!-- ================= PYTHAGORAS STEP PROOF ================= -->
            <div class="col-sm-12">
                <div class="card mb-4 psp-card">
                    <div class="card-header text-center">
                        <h4>Pembuktian Teorema Pythagoras</h4>
                    </div>
                    
                    <div class="card-body">
                        <!-- ================= PETUNJUK PENGGUNAAN ================= -->
                        <div class="col-sm-12">                
                            <div class="alert alert-light border-start border-success border-4">
                                <h6 class="fw-bold mb-2">Petunjuk Penggunaan Pembuktian Pythagoras</h6>
                                <ol class="mb-0">
                                    <li>
                                        Klik tombol <strong>1 sampai 6 secara berurutan</strong> untuk melihat
                                        langkah-langkah pembuktian Teorema Pythagoras.
                                    </li>
                                    <li>
                                        Setiap langkah akan menampilkan <strong>persegi pada sisi segitiga</strong>
                                        (tegak, datar, dan miring).
                                    </li>
                                    <li>
                                        Langkah 4 dan 5 akan menampilkan <strong>grid satuan</strong>
                                        pada persegi sisi tegak dan datar.
                                    </li>
                                    <li>
                                        Langkah 6 menunjukkan <strong>pembuktian Teorema Pythagoras,</strong> bahwa luas persegi pada sisi miring, sama dengan jumlah luas sisi tegak dan sisi datar.
                                    </li>
                                    <li>
                                        Gunakan tombol <strong>Reset</strong> untuk mengulang pembuktian
                                        dari awal.
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <canvas id="psp-canvas"
                                width="520"
                                height="520"></canvas>

                        <!-- STEP BUTTON -->
                        <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                            <button class="btn btn-outline-primary btn-sm psp-step-btn"
                                onclick="psp_goStep(1)">1</button>
                            <button class="btn btn-outline-primary btn-sm psp-step-btn"
                                onclick="psp_goStep(2)">2</button>
                            <button class="btn btn-outline-primary btn-sm psp-step-btn"
                                onclick="psp_goStep(3)">3</button>
                            <button class="btn btn-outline-success btn-sm psp-step-btn"
                                onclick="psp_goStep(4)">4</button>
                            <button class="btn btn-outline-success btn-sm psp-step-btn"
                                onclick="psp_goStep(5)">5</button>
                            <button class="btn btn-outline-danger btn-sm psp-step-btn"
                                onclick="psp_goStep(6)">6</button>

                            <!-- TOMBOL RESET -->
                            <button class="btn btn-outline-warning btn-sm psp-reset-btn"
                                onclick="psp_reset()" title="Reset ke awal">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </button>
                        </div>

                        <div id="psp-info"
                            class="alert alert-light border-start border-success border-4 mt-3">
                            Klik langkah 1 untuk memulai pembuktian.
                        </div>

                    </div>
                </div>
            </div>

            <!-- ================================= -->
            <!-- TEOREMA PYTHAGORAS -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Teorema Pythagoras</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-justify">
                            Dari hasil eksplorasi dan pembuktian sebelumnya, dapat disimpulkan bahwa
                            hubungan panjang sisi-sisi pada segitiga siku-siku mengikuti suatu aturan
                            tertentu. Aturan ini dikenal sebagai <strong>Teorema Pythagoras</strong>.
                            Pada segitiga ΔABC yang siku-siku di titik C, berlaku hubungan berikut:
                        </p>

                        <div class="text-center my-3">
                            <em>
                                Kuadrat panjang sisi miring pada segitiga siku-siku sama dengan
                                jumlah kuadrat panjang sisi tegak dan sisi datarnya.
                            </em>
                        </div>
                        
                        <!-- Gambar Segitiga dengan Label -->
                        <div class="text-center my-4">
                            <img src="/images/segitiga_sikusiku_1.png" alt="Segitiga ABC siku-siku di C" class="img-fluid rounded border" style="width: 30%;">
                            <p class="text-muted mt-2">
                                Segitiga ABC siku-siku di C, dengan sisi miring AC dan sisi siku-siku AB dan BC dan berlaku:
                            </p>
                        </div>

                        <div class="text-center my-4">
                            <div class="border rounded d-inline-block px-4 py-3 bg-light">
                                \[
                                AC^2 = AB^2 + BC^2
                                \]
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">                            
                                <div class="alert alert-light border-start border-success border-4">
                                    <strong>Keterangan:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>AC</strong> = Sisi Miring (hipotenusa)</li>
                                        <li><strong>AB</strong> = Sisi Tegak</li>
                                        <li><strong>BC</strong> = Sisi Datar</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-light border-start border-success border-4">
                                    <strong>Catatan Penting:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Teorema ini <strong>hanya berlaku untuk segitiga siku-siku</strong></li>
                                        <li>Sisi miring selalu berhadapan dengan sudut siku-siku</li>
                                        <li>Sisi miring selalu merupakan sisi terpanjang</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================= -->
            <!-- RUMUS PYTHAGORAS SEGITIGA SIKU-SIKU -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Rumus Pythagoras Segitiga Siku-Siku</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Gambar Segitiga dengan Label -->
                            <div class="text-center my-4">
                                <img src="/images/segitiga_versilain.png" alt="Segitiga ABC siku-siku di C" class="img-fluid rounded border" style="width: 20%;">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kolom Kiri: Rumus Sisi Miring -->
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded h-100">
                                    <h5 class="text-success">Mencari Sisi Miring</h5>
                                    <div class="my-3">
                                        \[
                                        c^2 = a^2 + b^2
                                        \]
                                    </div>
                                    <div class="my-3">
                                        \[
                                        c = \sqrt{a^2 + b^2}
                                        \]
                                    </div>
                                    <p class="text-muted mb-0">
                                        Digunakan untuk mencari panjang sisi miring (hipotenusa)
                                    </p>
                                </div>
                            </div>

                            <!-- Kolom Tengah: Rumus Sisi Tegak -->
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded h-100">
                                    <h5 class="text-success">Mencari Sisi Tegak / Tinggi</h5>
                                    <div class="my-3">
                                        \[
                                        b^2 = c^2 - a^2
                                        \]
                                    </div>
                                    <div class="my-3">
                                        \[
                                        b = \sqrt{c^2 - a^2}
                                        \]
                                    </div>
                                    <p class="text-muted mb-0">
                                        Digunakan untuk mencari panjang sisi tegak (tinggi)
                                    </p>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Rumus Sisi Mendatar -->
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded h-100">
                                    <h5 class="text-success">Mencari Sisi Mendatar / Alas</h5>
                                    <div class="my-3">
                                        \[
                                        a^2 = c^2 - b^2
                                        \]
                                    </div>
                                    <div class="my-3">
                                        \[
                                        a = \sqrt{c^2 - b^2}
                                        \]
                                    </div>
                                    <p class="text-muted mb-0">
                                        Digunakan untuk mencari panjang sisi mendatar (alas)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================= -->
            <!-- CONTOH SOAL 1 -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Contoh 1: Mencari Panjang Sisi Segitiga Siku-Siku</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Kiri: Soal dan Gambar -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h4 class="text-justify">
                                        Tentukan panjang sisi mendatar segitiga di bawah ini.
                                    </h4>
                                </div>

                                <!-- Tempat untuk gambar segitiga -->
                                <div class="text-center mb-4">
                                    <img src="/images/segitiga_contoh1.png" 
                                        alt="Segitiga ABC Contoh 1" 
                                        class="img-fluid rounded border w-50">
                                    <p class="text-muted mt-2">
                                        Segitiga ABC siku-siku di B
                                    </p>
                                </div>
                                <h5>Penyelesaian:</h5>
                                
                                <!-- Diketahui -->
                                <div class="border-start border-success border-3 ps-3 mb-3">
                                    <strong>Diketahui:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>AC = 13 cm (sisi miring)</li>
                                        <li>BC = 12 cm (sisi mendatar)</li>
                                        <li>Segitiga siku-siku di B</li>
                                    </ul>
                                </div>

                                <!-- Ditanya -->
                                <div class="border-start border-success border-3 ps-3 mb-3">
                                    <strong>Ditanya:</strong>
                                    <p class="mb-0 mt-1">Panjang sisi AB: ?</p>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Penyelesaian -->
                            <div class="col-md-6">
                                
                                <!-- Jawab -->
                                <div class="border-start border-success border-3 ps-3 mb-3">
                                    <strong>Jawab:</strong>
                                    <p class="mt-1">Segitiga ABC siku-siku di B, maka:</p>
                                    <ul class="mb-2">
                                        <li>Sisi miring (c) = AC = 13 cm</li>
                                        <li>Sisi mendatar (a) = BC = 12 cm</li>
                                        <li>Sisi tegak (b) = AB = ?</li>
                                    </ul>
                                </div>

                                <!-- Rumus dan Perhitungan -->
                                <div class="mb-4">
                                    <p>Menggunakan rumus Pythagoras:</p>
                                    <div class="alert alert-light border-start border-success border-4">
                                        \[
                                        \begin{aligned}
                                        c^2 &= a^2 + b^2 \\
                                        13^2 &= 12^2 + AB^2 \\
                                        169 &= 144 + AB^2 \\
                                        AB^2 &= 169 - 144 \\
                                        AB^2 &= 25 \\
                                        AB &= \sqrt{25} \\
                                        AB &= 5 \text{ cm}
                                        \end{aligned}
                                        \]
                                    </div>
                                </div>

                                <!-- Kesimpulan -->
                                <div class="alert alert-light border-start border-success border-4 mt-3">
                                    <p class="mb-0 mt-1">
                                        <strong>Maka,</strong> panjang sisi AB adalah <strong>5 cm</strong>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================= -->
            <!-- CONTOH SOAL 2 -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Contoh 2: Penerapan Teorema Pythagoras dalam Masalah Sehari-hari</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Kiri: Soal dan Gambar -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h4 class="text-justify">
                                        Seorang nahkoda kapal melihat puncak menara pandang di Siring Banjarmasin, 
                                        yang berjarak 40 meter dari kapal. Diketahui tinggi menara pandang 30 meter, 
                                        jarak dari puncak menara pandang tersebut adalah ...
                                    </h4>
                                </div>

                                <!-- Tempat untuk gambar ilustrasi -->
                                <div class="text-center mb-4">
                                    <img src="/images/segitiga_contoh2.png" 
                                        alt="Ilustrasi Menara Pandang dan Kapal" 
                                        class="img-fluid rounded border w-90">
                                    <p class="text-muted mt-2">
                                        Ilustrasi permasalahan menara pandang dan kapal
                                    </p>
                                </div>
                                
                                <h5>Penyelesaian:</h5>
                                
                                <!-- Diketahui -->
                                <div class="border-start border-success border-3 ps-3 mb-3">
                                    <strong>Diketahui:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Jarak horizontal kapal-menara (AB) = 40 m</li>
                                        <li>Tinggi menara pandang (BC) = 30 m</li>
                                        <li>Sudut di B = 90° (permukaan tanah datar)</li>
                                    </ul>
                                </div>

                                <!-- Ditanya -->
                                <div class="border-start border-success border-3 ps-3 mb-3">
                                    <strong>Ditanya:</strong>
                                    <p class="mb-0 mt-1">Panjang AC (jarak puncak menara ke kapal): ?</p>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Penyelesaian -->
                            <div class="col-md-6">
                                
                                <!-- Jawab -->
                                <div class="border-start border-success border-3 ps-3 mb-3">
                                    <strong>Jawab:</strong>
                                    <p class="mt-1">Membentuk segitiga siku-siku ABC dengan:</p>
                                    <ul class="mb-2">
                                        <li>Sisi mendatar (a) = AB = 40 m</li>
                                        <li>Sisi tegak (b) = BC = 30 m</li>
                                        <li>Sisi miring (c) = AC = ?</li>
                                        <li>Sudut siku-siku di B</li>
                                    </ul>
                                </div>

                                <!-- Rumus dan Perhitungan -->
                                <div class="mb-4">
                                    <p>Menggunakan rumus Pythagoras:</p>
                                    <div class="alert alert-light border-start border-success border-4">
                                        \[
                                        \begin{aligned}
                                        AC^2 &= AB^2 + BC^2 \\
                                        AC^2 &= 40^2 + 30^2 \\
                                        AC^2 &= 1600 + 900 \\
                                        AC^2 &= 2500 \\
                                        AC &= \sqrt{2500} \\
                                        AC &= 50 \text{ meter}
                                        \end{aligned}
                                        \]
                                    </div>
                                </div>

                                <!-- Kesimpulan -->
                                <div class="alert alert-light border-start border-success border-4 mt-3">
                                    <p class="mb-0 mt-1">
                                        <strong>Maka,</strong> jarak dari puncak menara pandang ke kapal adalah <strong>50 meter</strong>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    

            <!-- ================================= -->
            <!-- LATIHAN DRAG & DROP: AYO BERLATIH -->
            <!-- ================================= -->
            <div class="container-fluid mb-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0 fw-bold"></i> Ayo Berlatih: Teorema Pythagoras</h4>
                    </div>

                    <div class="card-body bg-light">
                        <div class="alert alert-white shadow-sm border-start border-success border-4 mb-4">
                            <h6 class="fw-bold text-success"></i> Petunjuk Pengerjaan:</h6>
                            <ol class="mb-0 small text-muted">
                                <li><strong>Geser (Drag)</strong> kartu angka di sebelah kanan ke dalam kotak bertanda "<strong>?</strong>" pada soal.</li>
                                <li>Jawaban akan tersimpan sementara (berwarna biru).</li>
                                <li>Jika ingin mengganti, cukup timpa dengan jawaban baru.</li>
                                <li>Klik tombol <strong>Periksa Jawaban</strong> di panel kanan untuk melihat hasil akhir.</li>
                            </ol>
                        </div>

                        <div class="row g-4" id="pyth-latihan-container">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm pyth-card">
                                            <div class="card-body d-flex flex-column text-center">
                                                <span class="badge bg-success align-self-start mb-2">Soal 1</span>
                                                <p class="fw-bold text-dark mb-2">Hitung sisi tegak:</p>
                                                
                                                <div class="pyth-img-box mb-3">
                                                    <img src="/images/segitiga_latihan1_nomor1.png" class="img-fluid rounded" alt="Soal 1">
                                                </div>

                                                <div class="mt-auto">
                                                    <div class="pyth-drop-zone mx-auto" data-soal="1">
                                                        <span class="placeholder-text">?</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm pyth-card">
                                            <div class="card-body d-flex flex-column text-center">
                                                <span class="badge bg-success align-self-start mb-2">Soal 2</span>
                                                <p class="fw-bold text-dark mb-2">Hitung sisi miring:</p>
                                                
                                                <div class="pyth-img-box mb-3">
                                                    <img src="/images/segitiga_latihan1_nomor2.png" class="img-fluid rounded" alt="Soal 2">
                                                </div>

                                                <div class="mt-auto">
                                                    <div class="pyth-drop-zone mx-auto" data-soal="2">
                                                        <span class="placeholder-text">?</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm pyth-card">
                                            <div class="card-body d-flex flex-column text-center">
                                                <span class="badge bg-success align-self-start mb-2">Soal 3</span>
                                                <p class="fw-bold text-dark mb-2">Hitung sisi alas:</p>
                                                
                                                <div class="pyth-img-box mb-3">
                                                    <img src="/images/segitiga_latihan1_nomor3.png" class="img-fluid rounded" alt="Soal 3">
                                                </div>

                                                <div class="mt-auto">
                                                    <div class="pyth-drop-zone mx-auto" data-soal="3">
                                                        <span class="placeholder-text">?</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm pyth-card">
                                            <div class="card-body d-flex flex-column text-center">
                                                <span class="badge bg-success align-self-start mb-2">Soal 4</span>
                                                <p class="fw-bold text-dark mb-2">Hitung sisi miring:</p>
                                                
                                                <div class="pyth-img-box mb-3">
                                                    <img src="/images/segitiga_latihan1_nomor4.png" class="img-fluid rounded" alt="Soal 4">
                                                </div>

                                                <div class="mt-auto">
                                                    <div class="pyth-drop-zone mx-auto" data-soal="4">
                                                        <span class="placeholder-text">?</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm pyth-card">
                                            <div class="card-body d-flex flex-column text-center">
                                                <span class="badge bg-success align-self-start mb-2">Soal 5</span>
                                                <p class="fw-bold text-dark mb-2">Hitung Tinggi Segitiga:</p>
                                                
                                                <div class="pyth-img-box mb-3">
                                                    <img src="/images/segitiga_latihan1_nomor5.png" class="img-fluid rounded" alt="Soal 5">
                                                </div>

                                                <div class="mt-auto">
                                                    <div class="pyth-drop-zone mx-auto" data-soal="5">
                                                        <span class="placeholder-text">?</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="pyth-sidebar card border-0 shadow-sm">
                                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                                        <h5 class="fw-bold text-success"><i class="bi bi-grid-fill"></i> Pilihan Jawaban</h5>
                                        <p class="text-muted small">Seret angka ke kotak soal.</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2 justify-content-center">
                                            <div class="col-6">
                                                <div class="pyth-drag-item shadow-sm" draggable="true" data-value="8">
                                                    <span class="num">8</span> <small>cm</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pyth-drag-item shadow-sm" draggable="true" data-value="13">
                                                    <span class="num">13</span> <small>cm</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pyth-drag-item shadow-sm" draggable="true" data-value="25">
                                                    <span class="num">25</span> <small>cm</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pyth-drag-item shadow-sm" draggable="true" data-value="29">
                                                    <span class="num">29</span> <small>cm</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pyth-drag-item shadow-sm" draggable="true" data-value="24">
                                                    <span class="num">24</span> <small>cm</small>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <button id="btn-pyth-check" class="btn btn-success w-100 py-2 fw-bold shadow-sm">Periksa Jawaban</button>
                                        
                                        <button id="btn-pyth-reset" class="btn btn-outline-secondary w-100 mt-2 py-1 small btn-sm">Ulangi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center" id="materiPagination">
            <li class="page-item">
            <button class="page-link" id="prevPage">‹</button>
            </li>

            <li class="page-item active">
            <button class="page-link page-btn" data-page="0">1</button>
            </li>
            <li class="page-item">
            <button class="page-link page-btn" data-page="1">2</button>
            </li>
            <li class="page-item">
            <button class="page-link page-btn" data-page="2">3</button>
            </li>
            <li class="page-item">
            <button class="page-link page-btn" data-page="3">4</button>
            </li>
            <li class="page-item">
            <button class="page-link" id="nextPage">›</button>
            </li>
        </ul>
    </nav>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush


@endsection
