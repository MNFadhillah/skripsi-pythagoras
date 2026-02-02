@extends('layouts.siswa')

@section('title', 'PythaLearn')

@section('content')
<div class="container">
    <div class="row align-items-center mb-2">
        <div class="col-lg-12">
            <h3 class="text-center">Menemukan Konsep Pythagoras</h3>
        </div>
    </div>

    <nav>
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
            <button class="page-link page-btn" data-page="4">5</button>
            </li>
            <li class="page-item">
            <button class="page-link" id="nextPage">›</button>
            </li>
        </ul>
    </nav>

    <!-- ================= HALAMAN 1 ================= -->
    <section class="materi-page" data-page="0">

        <!-- Tujuan Pembelajaran -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4>Tujuan Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Peserta didik mampu menganalisis beberapa informasi untuk membuktikan kebenaran teorema Pythagoras.</li>
                        <li>Peserta didik mampu membuat pembuktian berupa skema atau prosedur terhadap rumus teorema Pythagoras.</li>
                        <li>Peserta didik mampu menentukan panjang sisi segitiga siku-siku apabila dua sisi lainnya diketahui.</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Tahukah Kamu -->
        <section class="mb-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Ayo Mengingat Kembali</h4>
                </div>

        <div class="card-body p-3">

        <div class="row">

    <!-- TOMBOL PETUNJUK -->
    <div class="col-12 text-center mb-2">
        <button class="btn btn-outline-success btn-sm fw-bold"
                data-bs-toggle="modal"
                data-bs-target="#modalPetunjuk">
            Petunjuk Pengerjaan
        </button>
    </div>

    <!-- CERITA INTERAKTIF (ASLI, TIDAK DIUBAH) -->
    <div class="col-12 mb-2">
        <div class="card border-success border-4 shadow-sm">
            <div class="card-body">
                <p class="text-justify" style="margin-bottom: 0px;">
                    Suatu hari, Ahmad sedang dalam perjalanan menuju Taman Wisata Alam (TWA) Pulau Bakut menggunakan kelotok.
                    Saat melintas di bawah Jembatan Barito, ia takjub melihat kemegahan konstruksinya.
                    Pandangannya tertuju pada
                    <span class="fw-bold text-danger clickable-text"
                          onclick="showPart('text-tegak')">Tiang Penyangga</span>
                    yang tegak lurus dengan
                    <span class="fw-bold text-success clickable-text"
                          onclick="showPart('text-datar')">Badan Jembatan</span>.
                    Keduanya dihubungkan oleh
                    <span class="fw-bold text-warning clickable-text"
                          onclick="showPart('text-miring')">Kabel Baja</span>
                    yang membentuk sisi miring.
                </p>
            </div>
        </div>
    </div>

    <!-- GAMBAR JEMBATAN -->
    <div class="col-lg-12">
        <div class="row mb-2">

            <div class="col-md-6">
                <div class="overflow-hidden h-100">
                    <div class="interactive-image-container">
                        <img src="/images/jembatan-barito-new.jpg"
                             class="img-fluid w-100"
                             style="object-fit: cover; max-height: 350px;"
                             alt="Jembatan Barito">
                             
                             <div class="text-overlay-container">
                                 <!-- TIANG -->
                            <div id="text-tegak" class="overlay-text text-tegak">
                                <div class="text-label bg-danger text-white">
                                    TIANG PENYANGGA<i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
        
                            <!-- BADAN -->
                            <div id="text-datar" class="overlay-text text-datar">
                                <div class="text-label bg-success text-white">
                                    BADAN JEMBATAN<i class="bi bi-arrow-up"></i>
                                </div>
                            </div>
        
                            <!-- KABEL -->
                            <div id="text-miring" class="overlay-text text-miring">
                                <div class="text-label bg-warning text-dark">
                                    <i class="bi bi-arrow-down-left"></i>KABEL BAJA
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 d-flex align-items-center justify-content-center">
                    <img src="/images/segitiga_jembatan.png"
                         class="img-fluid"
                         style=" max-height: 300px;"
                         alt="Segitiga Jembatan Barito">
                </div>
            </div>
        </div>
    </div>
    
    <!-- ILUSTRASI SEGITIGA (TETAP) -->
    
    <!-- PERTANYAAN KONSEPTUAL (ASLI, TIDAK DIUBAH) -->
    <div class="col-12 mb-2">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <p class="fw-semibold text-justify mb-3">
                    Berdasarkan gambar di atas, <strong>tiang penyangga</strong>, <strong>badan jembatan</strong>,
                    dan <strong>kabel baja</strong> membentuk sebuah segitiga.
                    Berdasarkan jenisnya, segitiga terbagi menjadi
                    <em>segitiga sama sisi</em>, <em>sama kaki</em>,
                    <em>siku-siku</em>, dan <em>sembarang</em>. Segitiga apakah yang terbentuk 
                </p>

                <div class="input-group mb-2">
                    <input type="text"
                           class="form-control border-success"
                           id="inputJawaban"
                           placeholder="Tuliskan jawabanmu di sini...">
                    <button class="btn btn-success fw-bold"
                            onclick="cekJawabanSegitigaSikuSiku()">
                        Cek Jawaban
                    </button>
                </div>
                <div class="text-end">
                    <button class="btn btn-outline-secondary btn-sm"
                            onclick="resetHighlight()">
                        Reset Gambar
                    </button>
                </div>

                <div id="feedbackPesan" class="fw-bold text-center mt-2"></div>


            </div>
        </div>
    </div>

    <div class="col-md-12">
        <p class="mb-0 text-justify small" style="font-size: 0.9rem;"> Konstruksi kabel pada Jembatan Barito terlihat membentuk pola segitiga yang megah. Pernahkah terlintas di benak kalian, bagaimana cara insinyur menghitung panjang kabel baja yang membentang miring tersebut? Dalam dunia Teknik Sipil dan Konstruksi, perhitungan sisi miring sangatlah penting, terutama pada struktur jembatan gantung yang memiliki pola <strong>segitiga siku-siku</strong>. Lalu, bagaimana cara menentukan panjang kabel (sisi miring) tanpa harus mengukurnya secara manual di atas sungai? Jawabannya adalah dengan menggunakan <strong>Teorema Pythagoras</strong>. Mari belajar teorema pythagoras agar kita bisa menerapkan rumus tersebut dalam kehidupan kita sehari-hari." </p>
    </div>

</div>


</div>
</div>

<div class="modal fade" id="modalPetunjuk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success border-3">
            <div class="modal-header">
                <h5 class="modal-title text-success fw-bold">Petunjuk Pengerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ol class="small ps-3">
                    <li>Perhatikan gambar jembatan barito dan cerita yang disajikan</li> 
                    <li>Pada bagian cerita, terdapat kata-kata berwarna yang bisa diklik untuk melihat posisi bagian jembatan.</li> 
                    <li>Isilah kolom jawaban berdasarkan pengamatanmu, lalu klik tombol cek jawaban.</li>
                </ol>
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
                    <h5 class="fw-bold">1. Bilangan Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        Masih ingatkah kalian bagaimana menentukan kuadrat dari suatu bilangan? Untuk menentukan kuadrat dari suatu bilangan adalah dengan cara <strong>mengalikan bilangan tersebut dengan dirinya sendiri</strong>.
                    </p>

                    <div class="alert alert-success shadow-sm border-0">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Petunjuk Pengerjaan:</h6>
                                <p class="mb-0 small">
                                Lengkapi kotak-kotak kosong yang memiliki tanda (?) dengan angka yang tepat sesuai pola tersebut.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="kuadrat-container">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th width="20%">Bilangan (a)</th>
                                        <th width="30%">(a × a)</th>
                                        <th width="30%">Bentuk Kuadrat</th>
                                        <th width="20%">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-secondary">
                                        <td>\(a\)</td>
                                        <td>\(a \times a\)</td>
                                        <td>\(a^2\)</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>\(2\)</td>
                                        <td>\(2 \times 2\)</td>
                                        <td>\(2^2\)</td>
                                        <td>\(4\)</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>\(3\)</td>
                                        <td>\(3 \times 3\)</td>
                                        <td>\(3^2\)</td>
                                        <td>
                                            <input type="number" class="form-control d-inline-block text-center fw-bold input-kuadrat px-1" 
                                                style="width: 80px;" data-answer="9" placeholder="?">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>\(5\)</td>
                                        <td>\(5 \times 5\)</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-start">
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1" 
                                                    style="width: 80px; height: 35px;" data-answer="5" placeholder="?">
                                                \(^2\)
                                            </div>
                                        </td>
                                        <td>\(25\)</td>
                                    </tr>

                                    
                                    <tr>
                                        <td>\(8\)</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1" 
                                                    style="width: 80px;" data-answer="8" placeholder="?">
                                                    <span>×</span>
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1" 
                                                style="width: 80px;" data-answer="8" placeholder="?">
                                            </div>
                                        </td>
                                        <td>\(8^2\)</td>
                                        <td>\(64\)</td>
                                    </tr>

                                    <tr>
                                        <td>\(9\)</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1" 
                                                    style="width: 80px;" data-answer="9" placeholder="?">
                                                    <span>×</span>
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1" 
                                                style="width: 80px;" data-answer="9" placeholder="?">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-start">
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1" 
                                                    style="width: 80px; height: 35px;" data-answer="9" placeholder="?">
                                                    \(^2\)
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control d-inline-block text-center fw-bold input-kuadrat px-1" 
                                            style="width: 80px;" data-answer="81" placeholder="?">
                                        </td>
                                    </tr>
                                        
                                    </tbody>
                                </table>
                        </div>

                        <div class="text-center mb-3">
                            <button class="btn btn-success px-5 fw-bold shadow-sm" id="btnCekKuadrat">
                                Periksa Jawaban
                            </button>
                        </div>
                    </div>

                    <div id="penguatan-materi" class="d-none mt-3 mb-3   animate__animated animate__fadeInUp">
                        <div class="card border-success border-4 shadow-sm bg-light">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-success mb-3">Pembahasan</h5>
                                <ul class="mb-0 text-dark">
                                    <li class="mb-2"><strong>Bilangan Kuadrat</strong> adalah bilangan yang dihasilkan dari perkalian dua bilangan yang sama (contoh: 4, 9, 16, 25, 36).</li>
                                    <li class="mb-2">Proses mengalikan dua bilangan yang sama disebut <strong>pengkuadratan</strong>.</li>
                                    <li>Misalkan \(2 \times 2 = 2^2 = 4\), dimana <strong>\(2^2\)</strong> adalah bentuk kuadrat, sedangkan <strong>4</strong> adalah bilangan kuadrat.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bold mt-5">2. Akar Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        <strong>Akar kuadrat</strong> adalah kebalikan dari operasi kuadrat, yaitu bilangan tak negatif yang jika dikuadratkan akan menghasilkan bilangan yang sama dengan bilangan semula.
                    </p>

                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8">
                            <div class="card bg-white border shadow-sm">
                                <div class="card-body text-center">
                                    <p class="mb-3 fs-5">
                                        Jika <strong>\(A^2 = B\)</strong>, maka <strong>\(\sqrt{B} = A\)</strong>
                                    </p>
                                    <div class="fs-5">
                                        \[
                                        3^2 = 9 \Rightarrow \sqrt{9} = 3
                                        \]
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-white border h-100 text-center p-3 shadow-sm">
                                <h6 class="text-muted small text-uppercase fw-bold">Contoh 1</h6>
                                <div class="my-2">
                                    <span class="badge bg-light text-dark border">\(5^2 = 25\)</span>
                                    <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                    <span class="badge bg-success text-white">\(\sqrt{25} = 5\)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-white border h-100 text-center p-3 shadow-sm">
                                <h6 class="text-muted small text-uppercase fw-bold">Contoh 2</h6>
                                <div class="my-2">
                                    <span class="badge bg-light text-dark border">\(8^2 = 64\)</span>
                                    <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                    <span class="badge bg-success text-white">\(\sqrt{64} = 8\)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-white border h-100 text-center p-3 shadow-sm">
                                <h6 class="text-muted small text-uppercase fw-bold">Contoh 3</h6>
                                <div class="my-2">
                                    <span class="badge bg-light text-dark border">\(10^2 = 100\)</span>
                                    <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                    <span class="badge bg-success text-white">\(\sqrt{100} = 10\)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm bg-light mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-bold">Sifat-sifat Akar Kuadrat</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center bg-white mb-0">
                                    <thead class="table-success small">
                                        <tr>
                                            <th style="width:10%">No</th>
                                            <th style="width:50%">Sifat Operasi</th>
                                            <th style="width:40%">Syarat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <tr>
                                            <td>i.</td>
                                            <td class="text-start ps-4">\(\sqrt{A \times B} = \sqrt{A} \times \sqrt{B}\)</td>
                                            <td>\(A \ge 0, B \ge 0\)</td>
                                        </tr>
                                        <tr>
                                            <td>ii.</td>
                                            <td class="text-start ps-4">\(\sqrt{\frac{A}{B}} = \frac{\sqrt{A}}{\sqrt{B}}\)</td>
                                            <td>\(A \ge 0, B \ne 0\)</td>
                                        </tr>
                                        <tr>
                                            <td>iii.</td>
                                            <td class="text-start ps-4">\(A\sqrt{B} + A\sqrt{C} = A(\sqrt{B} + \sqrt{C})\)</td>
                                            <td>\(B \ge 0, C \ge 0\)</td>
                                        </tr>
                                        <tr>
                                            <td>iv.</td>
                                            <td class="text-start ps-4">\(\sqrt{A} \times \sqrt{A} = A\)</td>
                                            <td>\(A \ge 0\)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success shadow-sm border-0 mb-4">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Petunjuk Pengerjaan:</h6>
                                <p class="mb-0 small">
                                Hitunglah nilai akar kuadrat berikut dengan tepat dan lengkapi kotak-kotak kosong yang memiliki tanda (?) dengan angka yang tepat.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="akar-container">
                        <div class="row g-3 justify-content-center">
                            <div class="col-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-5">\(\sqrt{36}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold" 
                                            style="width: 80px;" data-answer="6" placeholder="?">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-5">\(\sqrt{49}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold" 
                                            style="width: 80px;" data-answer="7" placeholder="?">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-5">\(\sqrt{81}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold" 
                                            style="width: 80px;" data-answer="9" placeholder="?">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-6">\(\sqrt{4} \times \sqrt{9}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold" 
                                            style="width: 80px;" data-answer="6" placeholder="?">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-6">\(\sqrt{4 \times 25}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold" 
                                            style="width: 90px;" data-answer="10" placeholder="?">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4 mb-3">
                            <button class="btn btn-success px-5 fw-bold shadow-sm" id="btnCekAkar">
                                Periksa Jawaban
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </section>

    <!-- ================= HALAMAN 3 ================= -->
    <section class="materi-page d-none" data-page="2">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Ayo Mengamati</h4>
                    </div>

                    <div class="card-body p-3">
                        <div class="row align-items-center g-4">
                
                    
                            {{-- KOLOM KIRI: TEKS PENJELASAN (MATERI & INSTRUKSI) --}}
                            <div class="col-lg-6 order-2">

                                {{-- 1. Instruksi Awal --}}
                                <p class="text-justify mb-3">
                                    Amati segitiga pada GeoGebra di samping.
                                    <br>
                                    <strong>Klik setiap titik sudut pada segitiga untuk mengamati besar sudutnya.</strong>
                                </p>


                                {{-- 2. FITUR INTERAKTIF ISIAN SINGKAT (BARU) --}}
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">

                                        <!-- Soal + Input (Sejajar) -->
                                        <div class="row align-items-center g-2 mb-3">
                                            <div class="col-md-8">
                                                <p class="mb-0 small">
                                                    Berdasarkan pengamatanmu, sudut yang berukuran <strong>90°</strong>
                                                    berada pada <strong>titik</strong>
                                                    <strong>...</strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm border-success" 
                                                    id="inputTitikSudut"
                                                    placeholder="Jawab di sini...">

                                            </div>
                                        </div>

                                        <!-- Tombol Cek Jawaban -->
                                        <div class="text-center mb-2">
                                            <button 
                                                class="btn btn-success fw-bold px-4" 
                                                type="button" 
                                                onclick="cekJawabanSikusiku()">
                                                Cek Jawaban
                                            </button>
                                        </div>

                                        <!-- Feedback Benar -->
                                        <div id="feedbackBenar" class="mt-3 d-none fade-in">
                                            <div class="alert alert-success d-flex align-items-center py-2 mb-0" role="alert">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <div>
                                                    <strong>Tepat Sekali.</strong> Sudut yang besarnya 90° disebut sudut siku-siku. Oleh karena itu, segitiga tersebut termasuk jenis <strong>segitiga siku-siku</strong>.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Feedback Salah -->
                                        <div id="feedbackSalah" class="mt-3 d-none fade-in">
                                            <div class="alert alert-danger d-flex align-items-center py-2 mb-0" role="alert">
                                                <i class="bi bi-x-circle-fill me-2"></i>
                                                <div>
                                                    Jawaban kamu kurang tepat. Ayo periksa dan jawab kembali
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                {{-- 3. Istilah Penting --}}
                                <div class="card bg-light border-start border-success border-4 shadow-sm">
                                    <div class="card-body py-3">

                                        <h5 class="fw-bold text-success">Istilah Penting</h5>
                                        <ul class="list-group list-group-flush bg-transparent">
                                            <li class="list-group-item bg-transparent px-0">
                                                Sisi yang terletak <strong>di depan sudut siku-siku</strong>, yaitu sisi <strong>AC</strong>. 
                                                Sisi ini disebut <strong> Hipotenusa (Sisi Miring)</strong>, dan merupakan sisi terpanjang pada segitiga siku-siku.
                                            </li>
                                            <li class="list-group-item bg-transparent px-0">
                                                Dua sisi yang saling bertemu dan membentuk sudut siku-siku, yaitu sisi 
                                                <strong>AB</strong> dan <strong>BC</strong> disebut <strong>Sisi Siku-siku</strong>.
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>


                            {{-- KOLOM KANAN: GEOGEBRA (TETAP) --}}
                            <div class="col-lg-6 order-1 order-lg-2">
                                <div class="p-3 border border-success border-opacity-25 rounded bg-white shadow-sm">

                                    {{-- GeoGebra Full & Center --}}
                                    <div style="width: 100%; height: 60vh; min-height: 400px; display: flex;">
                                        <iframe
                                            title="Segitiga Siku-siku"
                                            src="https://www.geogebra.org/material/iframe/id/wvtdtnyy/sfsb/true/smb/false/stb/false/stbh/false/ai/false/asb/false/sri/false/rc/false/ld/false/sdz/false/ctl/false"
                                            style="width: 100%; height: 100%; border: 0;"
                                            allowfullscreen
                                            loading="lazy">
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Ayo Menggambar</h4>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        {{-- BAGIAN ATAS: GAMBAR & PEMBAHASAN --}}
                        <div class="row g-4 mb-4">
                            <div class="col-lg-4 d-flex flex-column">
                                
                                {{-- Instruksi --}}
                                <div class="alert alert-light border-start border-success mb-3 text-justify">
                                    <h4 class="fw-bold">Langkah Pengerjaan:</h4>
                                    <ol class="ps-3 mb-0 text-dark">
                                        <li class="mb-1"><strong>Buat 3 Titik:</strong> Klik 3 kali di area grid untuk membentuk 3 titik segitiga, usahakan membentuk sudut siku-siku.</li>
                                        <li class="mb-1"><strong>Tarik Garis:</strong> Klik salah satu titik dan tahan kemudian seret dari satu titik ke titik lain.</li>
                                        <li class="mb-0">Hubungkan hingga membentuk segitiga siku-siku.</li>
                                    </ol>
                                </div>
                
                                {{-- Card Status / Pembahasan (Mengisi sisa tinggi) --}}
                                <div class="card border-0 bg-light shadow-sm flex-grow-1" id="statusCard">
                                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                        
                                        {{-- State Awal --}}
                                        <div id="initialState">
                                            <i class="bi bi-pencil-square fs-1 text-secondary opacity-25 mb-3"></i>
                                            <h6 class="text-muted fw-bold">Area Pembahasan</h6>
                                            <p class="small text-muted mb-0">Status gambar akan muncul di sini.</p>
                                        </div>
                
                                        {{-- State Benar --}}
                                        <div id="successState" class="d-none animate__animated animate__fadeIn">
                                            <h5 class="text-success fw-bold">Segitiga Siku-Siku Terbentuk</h5>
                                            <p class="small text-dark mb-0">Sekarang, silakan jawab pertanyaan di bawah ini.</p>
                                        </div>
                
                                        {{-- State Salah --}}
                                        <div id="failState" class="d-none animate__animated animate__shakeX">
                                            <h5 class="text-danger fw-bold">Segitiga Siku-Siku Belum Terbentuk</h5>
                                            <p class="small text-dark mb-3">
                                                Sudut yang kamu buat belum 90°.
                                            </p>
                                            <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="resetCanvas()">
                                                Coba Lagi
                                            </button>
                                        </div>
                
                                    </div>
                                </div>
                            </div>
                            
                            {{-- KOLOM KIRI: CANVAS --}}
                            <div class="col-lg-8">
                                <div id="canvasContainer" class="position-relative bg-white border rounded shadow-sm" style="width: 100%; min-height: 400px;">
                                    <canvas id="triangleCanvas" style="cursor: crosshair; display: block;"></canvas>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <button class="btn btn-warning btn-sm shadow-sm fw-bold" onclick="resetCanvas()">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                    </button>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: INSTRUKSI & STATUS (PEMBAHASAN) --}}
                        </div>

                        <hr class="border-secondary opacity-25 my-4">

                        {{-- BAGIAN BAWAH: KUIS / PERTANYAAN --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow-sm border-success position-relative">
                                    
                                    {{-- Overlay Pengunci --}}
                                    <div id="quizLockOverlay" class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-90 d-flex align-items-center justify-content-center rounded" style="z-index: 10;">
                                        <div class="text-center">
                                            <i class="bi bi-lock-fill text-secondary fs-2"></i>
                                            <p class="small fw-bold text-muted mt-1 mb-0">Selesaikan gambar di atas untuk membuka soal.</p>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <p class="text-muted small">
                                            Setelah menyelesaikan aktivitas di atas, perhatikan dengan seksama gambar segitiga yang telah kamu buat, lalu jawab pertanyaan berikut:
                                        </p>

                                        <form id="triangleQuizForm" onsubmit="event.preventDefault(); checkQuizAnswers();">
                                            <div class="row g-4">
                                                {{-- Soal 1 --}}
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold small">
                                                        1. Berdasarkan segitiga siku-siku yang kamu gambar, ciri utama segitiga siku-siku adalah ....
                                                    </label>
                                                    <select class="form-select form-select-sm border-success" id="q1" disabled required>
                                                        <option value="" selected disabled>-- Pilih --</option>
                                                        <option value="wrong1">Memiliki tiga sisi sama panjang</option>
                                                        <option value="90">Memiliki satu sudut dengan ukuran 90°</option>
                                                        <option value="wrong2">Memiliki dua sudut dengan ukuran sama besar</option>
                                                        <option value="wrong3">Memiliki dua sisi paling panjang</option>
                                                    </select>
                                                </div>

                                                {{-- Soal 2 (DINAMIS) --}}
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold small">
                                                        2. Perhatikan kembali titik pada segitiga yang kamu gambar, dua sisi yang membentuk sudut siku-siku adalah ....
                                                    </label>
                                                    <select class="form-select form-select-sm border-success" id="q2" disabled required>
                                                        <option value="" selected disabled>-- Pilih --</option>
                                                        <option value="ab_ac">Sisi AB dan AC</option>
                                                        <option value="ac_bc">Sisi AC dan BC</option>
                                                        <option value="ab_bc">Sisi AB dan BC</option>
                                                        <option value="wrong">Semua sisi</option>
                                                    </select>
                                                </div>

                                                {{-- Soal 3 --}}
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold small">
                                                        3. Perhatikan dengan seksama segitiga kamu, sisi miring adalah sisi yang ....
                                                    </label>
                                                    <select class="form-select form-select-sm border-success" id="q3" disabled required>
                                                        <option value="" selected disabled>-- Pilih --</option>
                                                        <option value="wrong1">Tegak lurus sisi lain</option>
                                                        <option value="depan">Berhadapan dengan sudut siku-siku</option>
                                                        <option value="wrong2">Paling pendek</option>
                                                        <option value="wrong3">Membentuk sudut siku-siku</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-end">
                                                <button type="submit" id="btnPeriksaQuiz" class="btn btn-success fw-bold shadow-sm px-4" disabled>Periksa Jawaban</button>
                                            </div>
                                            
                                            <div id="quizFeedback" class="mt-3 text-center" style="display: none;"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-sm-12 mb-4">
                <div class="card shadow-sm">
    
                    <div class="card-header text-center">
                        <h4>Penamaan Sisi Segitiga</h4>
                    </div>

                    <div class="card-body p-4">
                        
                        {{-- BAGIAN 1: MATERI --}}
                        <p class="alert alert-light border-start border-success border-4 shadow-sm mb-4">
                            Dalam matematika, penamaan sisi segitiga memiliki aturan tertentu. 
                            Garis yang menghubungkan titik \(A\) dan titik \(B\) disebut <strong>Ruas Garis</strong> yang dinotasikan sebagai \(\overline{AB}\). 
                            Sedangkan untuk menyatakan <strong>panjang / ukuran</strong> dari ruas garis tersebut, cukup ditulis sebagai \(AB\).
                            <br>
                            Selain menggunakan dua huruf kapital (misal: \(AB\)), kita juga bisa menamai sisi menggunakan 
                            <strong>satu huruf kecil</strong> dengan syarat memperhatikan sudut yang berhadapan dengan sisi tersebut.
                        </p>

                        <div class="row align-items-center g-4">
                            <div class="col-md-6">
                                <div class="p-3 bg-white rounded border border-success border-4 shadow-sm d-flex align-items-center justify-content-center h-100">
                                    <img src="/images/mengenal_sisi_segitiga_sikusiku.png" 
                                        alt="Mengenal Sisi Segitiga Siku-siku" 
                                        class="img-fluid" 
                                        style="max-height: 250px; object-fit: contain;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="alert alert-light border-start border-success border-4 shadow-sm mb-0 h-100 d-flex flex-column justify-content-center">
                                    <h6 class="fw-bold mb-2">Aturan Penamaan:</h6>
                                    <ul class="mb-0 small" style="line-height: 1.8;">
                                        <li>
                                            <strong>Ruas Garis</strong> menggunakan dua huruf kapital dengan garis diatasnya.
                                            <br><span class="text-muted">Contoh: \(\overline{AB}\), \(\overline{BC}\), \(\overline{AC}\).</span>
                                        </li>
                                        <li>
                                            <strong>Ukuran Ruas Garis</strong> menggunakan dua huruf kapital.
                                            <br><span class="text-muted">Contoh: \(AB\), \(BC\), \(AC\).</span>
                                        </li>
                                        <li>
                                            <strong>Huruf Kecil</strong> digunakan untuk menamai sisi berdasarkan <strong>sudut di depannya</strong>:
                                            <ul class="mb-0 mt-1 fw-bold list-unstyled ms-2">
                                                <li>Depan sudut \(A\) \(\rightarrow\) sisi \(a\)</li>
                                                <li>Depan sudut \(B\) \(\rightarrow\) sisi \(b\)</li>
                                                <li>Depan sudut \(C\) \(\rightarrow\) sisi \(c\)</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Contoh Visual Kecil --}}
                        <div class="card border-0 mt-4">
                            <div class="card-body py-3 px-4">
                                <p class="mb-3 fw-bold text-center border-bottom pb-2">Contoh:</p>
                                <div class="row text-center g-3">
                                    <div class="col-md-4">
                                        <div class="bg-white border rounded p-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                                            <span class="fs-6">\(\overline{BC}\) = <strong class="fs-5 ms-1">sisi \(a\)</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bg-white border rounded p-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                                            <span class="fs-6">\(\overline{AC}\) = <strong class="fs-5 ms-1">sisi \(b\)</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bg-white border rounded p-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                                            <span class="fs-6">\(\overline{AB}\) = <strong class="fs-5 ms-1">sisi \(c\)</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-5 opacity-25">

                        {{-- BAGIAN 2: HEADER INSTRUKSI --}}
                        <div class="text-center">
                            <h4 class="fw-bold">Ayo Mengamati</h4>

                            <div class="alert alert-light border-start border-success border-4 shadow-sm d-inline-block text-start p-3" style="max-width: 750px;">
                                <p class="mb-2 text-center text-dark fw-bold">
                                    Amati gambar segitiga, lalu lengkapi isian di bawah ini:
                                </p>
                                
                                <ol class="mb-3 ps-3 small text-muted text-justify" style="line-height: 1.8;">
                                    <li>
                                        <strong>Pada Segitiga ABC, MNO, dan PQR:</strong> Tentukan nama sisi yang berada di depan sudut yang ditanya.
                                    </li>
                                    <li>
                                        <strong>Pada Segitiga EFG dan HIJ:</strong> Berdasarkan nama sisi yang diketahui, tentukan <strong>Titik Sudut</strong> dan <strong>Garis yang terbentuk</strong> gunakan penamaan sisi dengan dua huruf besar saja.
                                    </li>
                                </ol>
                            </div>
                        </div>

                        {{-- BAGIAN 3: KARTU LATIHAN GAMBAR (ABC, MNO, PQR) --}}
                        <div class="row g-4 justify-content-center mb-5">
                            {{-- Latihan 1 --}}
                            <div class="col-md-4">
                                <div class="card bg-white border-0 h-100 p-3 text-center shadow-sm">
                                    <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded border" 
                                        style="height: 220px; overflow: hidden;">
                                        <img src="/images/mengenal_sisi_latihan1.png" alt="Latihan 1" class="img-fluid" 
                                            style="max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="text-start px-2 mt-auto">
                                        <label class="form-label small fw-bold">Sisi yang berada di depan sudut A adalah sisi ...</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <input type="text" class="form-control sisi-input text-center fw-bold" 
                                                data-answer="a" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Latihan 2 --}}
                            <div class="col-md-4">
                                <div class="card bg-white border-0 h-100 p-3 text-center shadow-sm">
                                    <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded border" 
                                        style="height: 220px; overflow: hidden;">
                                        <img src="/images/mengenal_sisi_latihan2.png" alt="Latihan 2" class="img-fluid" 
                                            style="max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="text-start px-2 mt-auto">
                                        <label class="form-label small fw-bold">Sisi yang berada di depan sudut N adalah sisi ...</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <input type="text" class="form-control sisi-input text-center fw-bold" 
                                                data-answer="n" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Latihan 3 --}}
                            <div class="col-md-4">
                                <div class="card bg-white border-0 h-100 p-3 text-center shadow-sm">
                                    <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded border" 
                                        style="height: 220px; overflow: hidden;">
                                        <img src="/images/mengenal_sisi_latihan3.png" alt="Latihan 3" class="img-fluid" 
                                            style="max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="text-start px-2 mt-auto">
                                        <label class="form-label small fw-bold">Sisi yang berada di depan sudut P adalah sisi ...</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <input type="text" class="form-control sisi-input text-center fw-bold" 
                                                data-answer="p" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-25">

                        {{-- BAGIAN 4: TABEL EFG --}}
                        <div class="row align-items-center mb-5 border-bottom pb-4 px-2">
                            {{-- Kolom Gambar --}}
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <div class="bg-light p-3 rounded border d-inline-block shadow-sm">
                                    {{-- Pastikan nama file gambar EFG benar --}}
                                    <img src="/images/segitiga_sikusiku_f.png" alt="Segitiga EFG" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                            
                            {{-- Kolom Tabel --}}
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th width="20%">Nama Sisi</th>
                                                <th width="40%">Titik Sudut di depan sisi</th>
                                                <th width="40%">Garis yang terbentuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold bg-light text-success fs-5">sisi <em>e</em></td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-titik" 
                                                        data-correct="E" placeholder="...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-ruas" 
                                                        data-correct="FG" placeholder="...">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold bg-light text-success fs-5">sisi <em>f</em></td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-titik" 
                                                        data-correct="F" placeholder="...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-ruas" 
                                                        data-correct="EG" placeholder="...">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold bg-light text-success fs-5">sisi <em>g</em></td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-titik" 
                                                        data-correct="G" placeholder="...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-ruas" 
                                                        data-correct="EF" placeholder="...">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 5: TABEL HIJ --}}
                        <div class="row align-items-center mb-4 px-2">
                            {{-- Kolom Gambar --}}
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <div class="bg-light p-3 rounded border d-inline-block shadow-sm">
                                    {{-- Pastikan nama file gambar HIJ benar --}}
                                    <img src="/images/segitiga_sikusiku_i.png" alt="Segitiga HIJ" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>

                            {{-- Kolom Tabel --}}
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th width="20%">Nama Sisi</th>
                                                <th width="40%">Titik Sudut di depan sisi</th>
                                                <th width="40%">Garis yang terbentuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold bg-light text-success fs-5">sisi <em>h</em></td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-titik" 
                                                        data-correct="H" placeholder="...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-ruas" 
                                                        data-correct="IJ" placeholder="...">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold bg-light text-success fs-5">sisi <em>i</em></td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-titik" 
                                                        data-correct="I" placeholder="...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-ruas" 
                                                        data-correct="HJ" placeholder="...">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold bg-light text-success fs-5">sisi <em>j</em></td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-titik" 
                                                        data-correct="J" placeholder="...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center fw-bold input-ruas" 
                                                        data-correct="HI" placeholder="...">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL & FEEDBACK --}}
                        <div class="text-center mb-3 mt-4">
                            <button class="btn btn-success px-5 fw-bold shadow-sm" onclick="checkAllAnswers()">
                                Periksa Jawaban
                            </button>
                            <div id="final-feedback" class="mt-3 fw-bold fs-5"></div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow-sm">
                    <!-- HEADER -->
                    <div class="card-header text-center bg-light">
                        <h4>
                            Hubungan Sisi-Sisi pada Segitiga Siku-Siku
                        </h4>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">
                    
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="alert alert-light border border-success border-2 shadow-sm">
                                    <h6 class="fw-bold text-success">Petunjuk Aktivitas:</h6>
                                    <ol class="ps-3 small text-muted" style="text-align: justify;">
                                        <li>
                                            Perhatikan segitiga siku-siku yang ditampilkan pada bidang koordinat.
                                        </li>
                                        <li>
                                            Klik tombol Tampilkan Persegi A dan Tampilkan Persegi B untuk menampilkan persegi pada kedua sisi siku-siku.
                                        </li>
                                        <li>
                                            Amati panjang sisi dan luas masing-masing persegi yang terbentuk.
                                        </li>
                                        <li>
                                            Klik tombol Tampilkan Persegi C untuk menampilkan persegi pada sisi miring segitiga.
                                        </li>
                                        <li>
                                            Selanjutnya, klik tombol Mulai Animasi Hubungan. Amati bagaimana kotak-kotak kecil dari Persegi A dan Persegi B bergerak dan mengisi Persegi C.
                                        </li>
                                        <li>
                                            Jika ingin mengulangi proses, klik Hentikan Animasi, kemudian tekan Mulai Animasi Hubungan kembali.
                                        </li>
                                        <li>
                                            Gunakan hasil pengamatanmu untuk mengisi tabel yang tersedia di bawah.
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="geogebra-container border rounded shadow-sm" style="overflow: hidden;">
                                    <iframe 
                                        scrolling="no"
                                        title="Hubungan Sisi-Sisi Segitiga Siku-Siku"
                                        src="https://www.geogebra.org/material/iframe/id/s6kt3mbw/width/1536/height/794/border/888888/sfsb/true/smb/false/stb/false/stbh/false/ai/false/asb/false/sri/false/rc/false/ld/false/sdz/false/ctl/false"
                                        style="width: 100%; height: 100%; border:0;"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">

                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-3">
                                            Berdasarkan aktivitas di atas, jawablah pertanyaan berikut:
                                        </p>

                                        <div class="mb-4">
                                            <label for="jawab1" class="form-label fw-bold">1. Berdasarkan pengamatan visualmu, persegi manakah yang memiliki luas paling besar?</label>
                                            <div class="d-flex gap-2">
                                                <select id="jawab1" class="form-select w-50">
                                                    <option value="" selected disabled>Pilih jawaban...</option>
                                                    <option value="persegiA">Persegi A (Sisi Siku-Siku)</option>
                                                    <option value="persegiB">Persegi B (Sisi Siku-Siku)</option>
                                                    <option value="persegiC">Persegi C (Sisi Miring)</option>
                                                </select>
                                                <button class="btn btn-success" onclick="cekSoal1()">Cek Jawaban</button>
                                            </div>
                                            <div id="feedback1" class="mt-2 fw-semibold"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="jawab2" class="form-label fw-bold">2. Apakah luas persegi yang terbesar sama dengan jumlah dua luas persegi yang lebih kecil?</label>
                                            <div class="d-flex gap-2">
                                                <select id="jawab2" class="form-select w-50">
                                                    <option value="" selected disabled>Pilih jawaban...</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                                <button class="btn btn-success" onclick="cekSoal2()">Cek Jawaban</button>
                                            </div>
                                            <div id="feedback2" class="mt-2 fw-semibold"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-3">
                                            3. Pada Geogebra di atas terbentuk 3 persegi seperti gambar di bawah.
                                        </p>
                                        
                                        <div class="text-center mb-3">
                                            <img src="/images/pembuktian_pythagoras.png" alt="Segitiga Siku-Siku" class="img-fluid rounded border" style="width: 30%;">
                                            <p class="text-muted small fst-italic mt-1">Gambar segitiga ABC dari sisi 3 persegi</p>
                                        </div>

                                        <p class="text-justify">
                                            Tiga buah persegi dengan panjang sisi setiap persegi adalah a = 3 satuan (3 Kotak), b = 4 satuan (4 Kotak), dan c = 5 satuan (5 Kotak).<br>
                                            Jika BC, AC, dan AB adalah panjang sisi pada gambar &Delta;ABC dari masing-masing sisi 3 persegi. 
                                            Lengkapi tabel berikut berdasarkan sisi persegi yang telah diketahui.
                                        </p>

                                        <div class="table-responsive mb-3">
                                            <table class="table table-bordered text-center align-middle">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th>BC</th>
                                                        <th>AC</th>
                                                        <th>BC²</th>
                                                        <th>AC²</th>
                                                        <th>AB²</th>
                                                        <th>AB</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="bg-light">5</td>
                                                        <td class="bg-light">12</td>
                                                        <td><input type="number" id="bc_sq_1" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ac_sq_1" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ab_sq_1" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ab_1" class="form-control text-center form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light">8</td>
                                                        <td class="bg-light">15</td>
                                                        <td><input type="number" id="bc_sq_2" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ac_sq_2" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ab_sq_2" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ab_2" class="form-control text-center form-control-sm"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light">9</td>
                                                        <td class="bg-light">12</td>
                                                        <td><input type="number" id="bc_sq_3" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ac_sq_3" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ab_sq_3" class="form-control text-center form-control-sm"></td>
                                                        <td><input type="number" id="ab_3" class="form-control text-center form-control-sm"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <button class="btn btn-success" onclick="cekTabel()">Cek Jawaban</button>
                                        <div id="feedbackTabel" class="mb-4 fw-semibold"></div>

                                        <div class="mb-3">
                                            <label for="pilihanRumus" class="fw-bold mb-2">Pernyataan yang benar berdasarkan tabel di atas adalah . . .</label>
                                            
                                            <div class="d-flex gap-2">
                                                <select id="pilihanRumus" class="form-select w-50">
                                                    <option value="" selected disabled>Pilih rumus...</option>
                                                    <option value="salah1">AC² - AB² = BC²</option>
                                                    <option value="benar">BC² + AC² = AB²</option>
                                                    <option value="salah2">AB² + BC² = AC²</option>
                                                </select>
                                                
                                                <button class="btn btn-success" onclick="cekKesimpulan()">Cek Jawaban</button>
                                            </div>

                                            <div id="feedbackKesimpulan" class="mt-2 fw-semibold"></div>
                                        </div>

                                        <div id="boxKesimpulan" class="alert alert-light border border-success border-2 shadow-sm d-none">
                                            <strong>Kesimpulan:</strong> Berdasarkan tabel di atas kita dapat menyimpulkan bahwa &Delta;ABC memiliki sisi siku-siku pada sisi BC dan AC, dan sisi miring atau hipotenusa di sisi AB.
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
        
    <!-- ================= HALAMAN 4 ================= -->
    <section class="materi-page d-none" data-page="3">
        <div class="row">
            <!-- ================================= -->
            <!-- DALIL PYTHAGORAS -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-light">
                        <h4 class="mb-0">Dalil Pythagoras</h4>
                    </div>

                        <div class="card-body">
                            <div class="row">


                                <div class="col-md-7">
                                    
                                    <p class="text-justify">
                                        Berdasarkan aktivitas sebelumnya, kita mendapatkan kesimpulan yaitu jumlah <strong>Luas Persegi A</strong> dan <strong>Luas Persegi B</strong>, hasilnya ternyata sama persis dengan <strong>Luas Persegi C</strong>. <br>
                                        Apa yang kamu temukan melalui aktivitas tersebut sebenarnya adalah bunyi dari <strong>Dalil Pythagoras</strong> yang berbunyi:
                                    </p>
                                    
                                    <div class="alert alert-success border-start border-success border-4">
                                        <div class="text-justify bg-white border rounded p-4 shadow-sm">
                                            <strong class="text-success">Pada suatu segitiga siku-siku, luas persegi pada sisi miringnya sama dengan jumlah luas persegi lain pada kedua sisi siku-sikunya, hal ini juga berarti jumlah dari kuadrat kedua sisi siku-siku segitiga pada segitiga siku-siku sama dengan kuadrat panjang sisi miringnya (hipotenusa).</strong>
                                        </div>

                                        <p class="text-center mt-2">
                                            Yang dapat disederhakan menjadi:
                                        </p>
                                        
                                        <div class="text-center bg-white border rounded py-2 my-3 shadow-sm">
                                            <strong class="text-success">Luas Persegi A + Luas Persegi B = Luas Persegi C</strong>
                                        </div>
                                        <div class="text-center">
                                            Jika kita ubah ke dalam simbol matematika dimana sisi-sisinya adalah <strong>a</strong>, <strong>b</strong>, dan <strong>c</strong> (sisi miring), maka diperoleh rumus:
                                            <br><br>
                                            <h3 class="fw-bold text-dark">c² = a² + b²</h3>
                                        </div>
                                    </div>
                                    

                                </div>
                                <div class="col-md-5">
                                    <div class="text-center my-4">
                                        <img src="/images/pembuktian_pythagoras.png" alt="Segitiga Siku-Siku" class="img-fluid rounded border" style="width: 100%;">
                                </div>
                            </div>
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
                        <h4>Pembuktian Teorema Pythagoras</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-justify">
                            Setelah mengetahui bunyi <strong>Dalil Pythagoras</strong> di atas, langkah selanjutnya adalah membuktikan kebenaran pernyataan tersebut. Melalui Geogebra dan penjabaran aljabar di bawah ini:
                        </p>

                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <div class="alert alert-light border border-success border-2 shadow-sm">
                                    <h6 class="fw-bold text-success"><i class="fa fa-list-ol"></i> Petunjuk Aktivitas:</h6>
                                    <ol class="ps-3 small text-muted" style="text-align: justify;">
                                        <li>
                                            Klik tombol <strong>Mulai</strong> hingga keempat segitiga berada di masing-masing sudut persegi.
                                        </li>
                                        <li>
                                            Perhatikan persegi yang terbentuk oleh sisi miring segitiga dan memiliki luas sebesar (<strong>c²</strong>).
                                        </li>
                                        <li>
                                            Klik Tombol <strong>Transformasi</strong> dan amati perpindahan susunan segitiga yang akan mengisi persegi 2.
                                        </li>
                                        <li>
                                            Klik Tombol <strong>Reset</strong> dan <strong>Reset Transformasi</strong> untuk mengulang animasi.
                                        </li>
                                        <li>
                                            Perhatikan seluruh perubahan yang terjadi dan amati luas persegi sebelum dan sesudah transformasi, dan selesaikan persamaan rumus di bawah.
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="geogebra-container border rounded shadow-sm" style="width: 100%; height: 300px; overflow: hidden;">
                                    <iframe 
                                        scrolling="no" 
                                        title="Pembuktian Teorema Pythagoras" 
                                        src="https://www.geogebra.org/material/iframe/id/jkuwjk2p/width/1536/height/794/border/888888/sfsb/true/smb/false/stb/false/stbh/false/ai/false/asb/false/sri/false/rc/false/ld/false/sdz/false/ctl/false" 
                                        width="100%" 
                                        height="100%" 
                                        style="border:0;" 
                                        allowfullscreen>  
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-center">
                            Berdasarkan hasil transformasi pada <strong>GeoGebra</strong>, diperoleh bahwa luas bangun sebelum dan sesudah transformasi adalah sama.
                        </p>

                        <p class="text-center fst-italic">
                            Luas sebelum = Luas sesudah
                        </p>
                            
                        <p class="text-center">
                            4 Segitiga Siku-siku + Luas persegi sisi miring = 4 Segitiga Siku-siku + Luas dua persegi hasil transformasi
                        </p>

                        <p class="text-center mb-4">
                            4Δ + c² = 4Δ + a² + b²
                        </p>

                        <p class="text-center text-muted">
                            Maka, diperoleh kesimpulan rumus Pythagoras:
                        </p>

                        <div class="text-center my-3 fw-bold" style="font-size: 1.5rem;">
                            <select id="jawaban1" class="form-select d-inline-block text-center border-primary shadow-sm" style="width: 70px; font-weight: bold; font-size: 1.2rem; background-color: #e6f2ff;">
                                <option value="">...</option>
                                <option value="a">a</option>
                                <option value="b">b</option>
                                <option value="c">c</option>
                            </select>² 
                            = 
        
                            <select id="jawaban2" class="form-select d-inline-block text-center border-primary shadow-sm" style="width: 70px; font-weight: bold; font-size: 1.2rem; background-color: #e6f2ff;">
                                <option value="">...</option>
                                <option value="a">a</option>
                                <option value="b">b</option>
                                <option value="c">c</option>
                            </select>² 
                            + 
                            <select id="jawaban3" class="form-select d-inline-block text-center border-primary shadow-sm" style="width: 70px; font-weight: bold; font-size: 1.2rem; background-color: #e6f2ff;">
                                <option value="">...</option>
                                <option value="a">a</option>
                                <option value="b">b</option>
                                <option value="c">c</option>
                            </select>²
                        </div>

                        <div class="text-center mb-3">
                            <button onclick="cekJawabanPembuktian()" class="btn btn-success px-4 mt-2">
                                Cek Jawaban
                            </button>
                        </div>
                        <div id="pesanFeedback" class="text-center mt-2" style="display: none;"></div>
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
                                </div>
                            </div>

                            <!-- Kolom Tengah: Rumus Sisi Tegak -->
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded h-100">
                                    <h5 class="text-success">Mencari Sisi Siku-Siku 1 (sisi b)</h5>
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
                                </div>
                            </div>

                            <!-- Kolom Kanan: Rumus Sisi Mendatar -->
                            <div class="col-md-4">
                                <div class="text-center p-3 border rounded h-100">
                                    <h5 class="text-success">Mencari Sisi Siku-Siku 2 (sisi a)</h5>
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
                        <h4>Contoh 1</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 mb-3">
                                <p class="text-muted fw-bold small mb-2">Perhatikan Gambar di bawah!</p>
                                <div class="bg-white rounded-3 shadow-sm border mb-3 py-2 d-flex justify-content-center overflow-hidden">
                                    <img src="/images/contoh_soal_1.png" class="img-fluid w-75" alt="Contoh 1">
                                </div>
                                <div class="text-start mb-2">
                                    <p class="text-muted small mb-2">
                                        Terdapat sebuah tangga menuju laboratorium sekolah dengan ujung tangga berjarak 4 meter dari dinding dan mencapai ketinggian 3 meter. Tentukan panjang tangga tersebut!
                                    </p>
                                </div>
                                <div class="border-start border-success border-3 ps-2 mb-2">
                                    <strong class="text-success small">Diketahui:</strong>
                                    <ul class="mb-0 mt-0 text-muted small ps-3">
                                        <li>Jarak kaki tangga ke dinding = 4 meter.</li>
                                        <li>Tinggi tangga di dinding = 3 meter.</li>
                                    </ul>
                                </div>
                                <div class="border-start border-warning border-3 ps-2 mb-3">
                                    <strong class="text-warning small">Ditanya:</strong>
                                    <p class="mb-0 text-muted small">Panjang tangga = ...? </p>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card bg-light border-0 rounded-3">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">Langkah Penyelesaian:</h6>
                                        <ol class="mb-0 list-group-numbered-custom small text-muted">
                                            <li class="mb-2">
                                                <strong>Tentukan sisi-sisi segitiga siku-siku:</strong><br>
                                                Pada segitiga siku-siku yang terbentuk, kita memiliki:
                                                <ul class="mb-0 ps-3">
                                                    <li>Sisi siku-siku (a) = 3 meter (tinggi tangga di dinding)</li>
                                                    <li>Sisi siku-siku (b) = 4 meter (jarak kaki tangga ke dinding)</li>
                                                    <li>Sisi miring (c) = panjang tangga yang dicari</li>
                                                </ul>
                                            </li>  
                                            <li>
                                                <strong>Gunakan Teorema Pythagoras untuk mencari panjang tangga (c):</strong><br>
                                                Menurut Teorema Pythagoras, kita punya:
                                                <div>
                                                    \[
                                                    \begin{aligned}
                                                    c^2 &= a^2 + b^2 \\
                                                    c^2 &= 3^2 + 4^2 \\
                                                    c^2 &= 9 + 16 \\
                                                    c^2 &= 25 \\
                                                    c &= \sqrt{25} = \mathbf{5 \text{ meter}}
                                                    \end{aligned}
                                                    \]
                                                </div>
                                            </li>
                                        </ol>
                                        <div class="alert alert-success d-flex align-items-center small">
                                            <div>
                                                <strong>Jadi,</strong> panjang tangga tersebut adalah <strong>\(5 \text{ meter}\)</strong>.
                                            </div> 
                                        </div>
                                    </div>
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
                        <h4>Contoh 2</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 mb-3">
                                <p class="text-muted fw-bold small mb-2">Perhatikan Gambar di bawah!</p>

                                <div class="bg-white rounded-3 shadow-sm border mb-3 py-2 d-flex justify-content-center overflow-hidden">
                                    <img src="/images/contoh_soal_2.png" class="img-fluid w-75" alt="Contoh 2">
                                </div>

                                <div class="text-start mb-2">
                                    <p class="text-muted small mb-2">
                                        Diketahui dua segitiga siku-siku seperti gambar di atas. Panjang \( AB = 13 \text{ cm} \), \( AC = 12 \text{ cm} \), dan \( CD = 3 \text{ cm} \). 
                                        Hitunglah panjang garis <strong>\( BD \)</strong>!
                                    </p>
                                </div>

                                <div class="border-start border-success border-3 ps-2 mb-2">
                                    <strong class="text-success small">Diketahui:</strong>
                                    <ul class="mb-0 mt-0 text-muted small ps-3">
                                        <li>\( \Delta ABC \): Sisi miring \( AB=13 \), alas \( AC=12 \).</li>
                                        <li>\( \Delta BCD \): Siku-siku di \( D \), sisi \( CD=3 \).</li>
                                    </ul>
                                </div>

                                <div class="border-start border-warning border-3 ps-2 mb-3">
                                    <strong class="text-warning small">Ditanya:</strong>
                                    <p class="mb-0 text-muted small">Panjang sisi \( BD = ...? \)</p>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="card bg-light border-0 rounded-3">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2">Langkah Penyelesaian:</h6>
                                        
                                        <ol class="mb-0 list-group-numbered-custom small text-muted">
                                            <li class="mb-2">
                                                <strong>Cari panjang sisi \( BC \) dari \( \Delta ABC \):</strong><br>
                                                Karena \( \Delta ABC \) siku-siku di \( C \), maka \( BC \) adalah sisi siku-siku.
                                                
                                                <div>
                                                    \[
                                                    \begin{aligned}
                                                    BC &= \sqrt{AB^2 - AC^2} \\
                                                    BC &= \sqrt{13^2 - 12^2} \\
                                                    BC &= \sqrt{169 - 144} \\
                                                    BC &= \sqrt{25} = \mathbf{5 \text{ cm}}
                                                    \end{aligned}
                                                    \]
                                                </div>
                                                Sekarang kita tahu panjang sisi miring \( \Delta BCD \) adalah <strong>\( 5 \text{ cm} \)</strong>.
                                            </li>

                                            <li>
                                                <strong>Cari panjang \( BD \) dari \( \Delta BCD \):</strong><br>
                                                Perhatikan \( \Delta BCD \) siku-siku di \( D \). Sisi miringnya adalah \( BC \) (\( 5 \text{ cm} \)), dan sisi lainnya \( CD \) (\( 3 \text{ cm} \)). Kita mencari sisi \( BD \).
                                                
                                                <div>
                                                    \[
                                                    \begin{aligned}
                                                    BD^2 &= BC^2 - CD^2 \\
                                                    BD^2 &= 5^2 - 3^2 \\
                                                    BD^2 &= 25 - 9 \\
                                                    BD^2 &= 16 \\
                                                    BD &= \sqrt{16} = \mathbf{4 \text{ cm}}
                                                    \end{aligned}
                                                    \]
                                                </div>
                                            </li>
                                        </ol>

                                        <div class="alert alert-success d-flex align-items-center small">
                                            <div>
                                                <strong>Jadi,</strong> panjang garis \( BD \) adalah <strong>\( 4 \text{ cm} \)</strong>.
                                            </div>
                                        </div>

                                    </div>
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
                        <h4 class="mb-0 fw-bold"> Ayo Berlatih: Teorema Pythagoras</h4>
                    </div>

                    <div class="card-body bg-light">
                        <div class="alert alert-white shadow-sm border-start border-success border-4 mb-4">Petunjuk Pengerjaan:</h6>
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
    </section>

    <!-- Halaman 5 -->
<section class="materi-page d-none" data-page="4">
        <div class="row justify-content-center">
            
            <div class="col-md-12 mb-4">
                <div class="card rounded-4">
                    <div class="card-header text-center">
                        <h4>Rangkuman</h4>
                    </div>
                    
                    <div class="card-body p-4 bg-white">
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">1</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Bilangan kuadrat</strong> adalah perkalian antara bilangan tersebut dengan dirinya sendiri. <strong>Akar kuadrat</strong> adalah kebalikan dari operasi kuadrat, yaitu bilangan tak negatif yang jika dikuadratkan akan menghasilkan bilangan yang sama dengan bilangan semula.
                                </p>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">2</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="text-align: justify; line-height: 1.6;">
                                    <strong>Teorema Pythagoras</strong> menyatakan bahwa kuadrat sisi miring pada segitiga siku-siku sama dengan jumlah kuadrat sisi-sisinya.
                                </p>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">3</div>
                            <div class="ms-3 w-100">
                                <div class="row align-items-center">
                                    
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="p-3 bg-light rounded border border-success border-opacity-25 text-center">
                                            <div class="mb-3">
                                                <p>Pada Segitiga di samping berlaku rumus Teorema Pythagoras:</p>
                                                <h4 class="fw-bold text-success mb-0">\( c^2 = a^2 + b^2 \)  (Mencari Sisi miring)</h4>
                                            </div>
                                            <div class="text-muted small  text-center">
                                                <p>Rumus lain yang berlaku:</p>
                                                <h4 class="fw-bold text-success mb-0">\( a^2 = c^2 - b^2 \) (Mencari Sisi Siku-Siku)</h4>
                                                <h4 class="fw-bold text-success mb-0">\( b^2 = c^2 - a^2 \) (Mencari Sisi Siku-Siku)</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center">
                                        <img src="/images/segitiga_versilain.png" alt="Rangkuman Teorema Pythagoras" class="img-fluid rounded border" style="width: 50%;">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

<div class="col-md-12 mb-4">
    <div class="card shadow-sm">
        <div class="card-header text-center bg-light">
            <h4 class="mb-0">Refleksi</h4>
            <small class="text-muted">
                Jawablah berdasarkan pemahamanmu dari aktivitas yang telah dilakukan
            </small>
        </div>

        <div class="card-body">

            <!-- REFLEKSI 1 -->
            <div class="mb-4">
                <label class="fw-semibold">
                    1. Apakah bilangan kuadrat dan akar kuadrat merupakan bilangan dasar
                    yang menentukan terbentuknya Teorema Pythagoras?
                </label>

                <div class="mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ref1_opsi" id="ref1_ya" value="ya">
                        <label class="form-check-label" for="ref1_ya">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ref1_opsi" id="ref1_tidak" value="tidak">
                        <label class="form-check-label" for="ref1_tidak">Tidak</label>
                    </div>
                </div>

                <textarea class="form-control mt-2" rows="3" id="ref1_text"
                    placeholder="Jelaskan alasanmu..."></textarea>

                <div class="feedback mt-2 small" id="fb1"></div>
            </div>

            <!-- REFLEKSI 2 -->
            <div class="mb-4">
                <label class="fw-semibold">
                    2. Bagaimana hubungan setiap sisi pada segitiga siku-siku?
                    Apakah hubungan tersebut berkaitan dengan Teorema Pythagoras?
                </label>
                <textarea class="form-control mt-2" rows="3" id="ref2"
                    placeholder="Tuliskan pemahamanmu..."></textarea>
                <div class="feedback mt-2 small" id="fb2"></div>
            </div>

            <!-- REFLEKSI 3 -->
            <div class="mb-4">
                <label class="fw-semibold">
                    3. Bagaimana langkah menentukan panjang hipotenusa jika dua sisi lainnya diketahui?
                </label>
                <textarea class="form-control mt-2" rows="3" id="ref3"
                    placeholder="Tuliskan langkah-langkahnya..."></textarea>
                <div class="feedback mt-2 small" id="fb3"></div>
            </div>

            <!-- TOMBOL -->
            <div class="text-center mt-4">
                <button class="btn btn-success px-4" onclick="cekRefleksi()">
                    Cek Jawaban
                </button>
            </div>

            <div class="text-center mt-4">
                <p>Setelah mempelajari materi tentang Menemukan Konsep Teorema Pythagoras. Silahkan kerjakan Kuis 1 - Menemukan Konsep Teorema Pythagoras</p>
            </div>

        </div>
    </div>
</div>

        </div>
    </section>

    </div>

    

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
            <button class="page-link page-btn" data-page="4">5</button>
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
