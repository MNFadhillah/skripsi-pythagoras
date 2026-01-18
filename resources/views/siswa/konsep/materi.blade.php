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
                    <h5 class="fw-bold">1. Bilangan Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        Masih ingatkah kalian bagaimana menentukan kuadrat dari suatu bilangan? Untuk menentukan kuadrat dari suatu bilangan adalah dengan cara <strong>mengalikan bilangan tersebut dengan dirinya sendiri</strong>.
                    </p>

                    <div class="alert alert-success shadow-sm border-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
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
                                <h5 class="fw-bold text-success mb-3"><i class="bi bi-lightbulb-fill me-2"></i>Pembahasan</h5>
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
                        Akar kuadrat adalah <strong>kebalikan</strong> dari operasi kuadrat. 
                        Operasi ini sangat penting dalam Teorema Pythagoras untuk menemukan panjang sisi segitiga 
                        setelah kita mengetahui luas perseginya.
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
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
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
                    <h4>Eksplorasi Segitiga: Sudut & Sisi</h4>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-9 mb-3">
                            <div id="canvasContainer" class="canvas-wrapper position-relative bg-white border rounded shadow-sm" style="width: 100%;">
                                <canvas id="triangleCanvas" style="cursor: crosshair; display: block;"></canvas>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2 p-2 bg-light border rounded">
                                <small class="text-muted fst-italic">
                                    <i class="bi bi-arrows-move me-1"></i> Area gambar luas. Klik 3 titik untuk membentuk sudut.
                                </small>
                                <button class="btn btn-warning btn-sm shadow-sm fw-bold" onclick="resetCanvas()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-3">
    
    {{-- PETUNJUK (TETAP) --}}
    <div class="card border-success mb-3 shadow-sm">
    <div class="card-header bg-success text-white py-2">
        <h6 class="mb-0 fw-bold small">
            <i class="bi bi-compass-fill me-2"></i>
            Petunjuk & Cara Pengerjaan
        </h6>
    </div>

    <div class="card-body p-3 small bg-white">
        
        <!-- TUJUAN -->
        <p class="mb-2 text-muted">
            <strong>Tujuan:</strong><br>
            Mengeksplorasi hubungan panjang sisi dan sudut pada segitiga.
        </p>

        <!-- LANGKAH -->
        <p class="mb-1 fw-semibold">Langkah Pengerjaan:</p>
        <ol class="ps-3 mb-3">
            <li class="mb-1"><strong>Klik 3 titik</strong> pada grid untuk membentuk segitiga.</li>
            <li class="mb-1">Amati <strong>panjang sisi</strong> dan <strong>sudut</strong> yang muncul.</li>
            <li class="mb-1">Periksa apakah terdapat sudut <strong>90° (siku-siku)</strong>.</li>
        </ol>

        <!-- TANTANGAN -->
        <div class="alert alert-warning border-0 p-2 rounded mb-0 d-flex align-items-start">
            <i class="bi bi-star-fill text-warning me-2 mt-1"></i>
            <div class="lh-sm" style="font-size: 0.85rem;">
                <strong>Tantangan:</strong><br>
                Buat segitiga <strong>miring</strong> yang tetap <strong>siku-siku</strong> dan memiliki
                <strong>sisi bilangan bulat</strong>.
            </div>
        </div>

    </div>
</div>

    {{-- HASIL ANALISIS --}}
    <div id="triangleInfo" class="card border-0 shadow-sm bg-light">
        <div class="card-body text-center d-flex flex-column justify-content-center text-muted py-4">
            <i class="bi bi-pencil-square fs-1 mb-2 opacity-25"></i>
            <p class="small mb-0">Hasil analisis akan muncul di sini...</p>
        </div>
    </div>

</div>

                    </div>
                </div>
            </div>
        </div>

        <!-- ================================= -->
        <!-- MENGENAL SISI SEGITIGA -->
        <!-- ================================= -->

            <div class="col-sm-12 mb-4">
                <div class="card">
                    
                    <div class="card-header text-center">
                        <h4>Penamaan Sisi Segitiga</h4>
                    </div>

                    <div class="card-body p-4">
                        
                        <p class="text-justify mb-4">
                            Dalam matematika, penamaan sisi segitiga memiliki aturan tertentu. 
                            Ruas garis yang menghubungkan titik \(A\) dan titik \(B\) dinotasikan sebagai \(\overline{AB}\). 
                            Sedangkan untuk menyatakan <strong>panjang</strong> dari ruas garis tersebut, cukup ditulis sebagai \(AB\).
                            <br><br>
                            Selain menggunakan dua huruf kapital (misal: \(AB\)), kita juga bisa menamai sisi menggunakan 
                            <strong>satu huruf kecil</strong>. Aturan ini yang akan sering digunakan dalam rumus Pythagoras.
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
                                            <strong>Titik Sudut</strong> menggunakan <strong>Huruf Kapital</strong>.
                                            <br><span class="text-muted">Contoh: Titik \(A\), Titik \(B\), Titik \(C\).</span>
                                        </li>
                                        <li>
                                            <strong>Sisi (Ruas Garis)</strong> menggunakan dua huruf kapital dengan garis diatasnya.
                                            <br><span class="text-muted">Contoh: \(\overline{AB}\), \(\overline{BC}\), \(\overline{AC}\).</span>
                                        </li>
                                        <li>
                                            <strong>Sisi (Huruf Kecil)</strong> dinamai berdasarkan <strong>sudut di depannya</strong>:
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

                        <div class="card border-0">
                            <div class="card-body py-3 px-4">
                                <p class="mb-3 fw-bold text-center border-bottom pb-2">Contoh Penerapan pada Gambar di Atas:</p>
                                <div class="row text-center g-3">
                                    <div class="col-md-4">
                                        <div class="bg-white border rounded p-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                                            <span class="fs-6">\(\overline{AB}\) = <strong class="fs-5 ms-1">sisi \(a\)</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bg-white border rounded p-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                                            <span class="fs-6">\(\overline{BC}\) = <strong class="fs-5 ms-1">sisi \(b\)</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bg-white border rounded p-3 shadow-sm h-100 d-flex align-items-center justify-content-center">
                                            <span class="fs-6">\(\overline{AC}\) = <strong class="fs-5 ms-1">sisi \(c\)</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <h5 class="fw-bold">Ayo Berlatih: Berikan nama pada sisi segitiga!</h5>
                        <p class="text-muted small">
                            Perhatikan posisi sudut pada setiap segitiga di bawah ini.<br>
                            Tentukan nama sisi (menggunakan <strong>satu huruf kecil</strong>) yang berada di depan sudut yang ditanyakan.
                            Isilah kotak di bawah gambar untuk menjawab.
                        </p>
                    </div>

                    <div class="row g-4 justify-content-center">
                        
                        <div class="col-md-4">
                            <div class="card bg-white border-0 h-100 p-3 text-center">
                                <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded border" 
                                    style="height: 220px; overflow: hidden;">
                                    <img src="/images/mengenal_sisi_latihan1.png" 
                                        alt="Latihan 1" 
                                        class="img-fluid" 
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
            
                        <div class="col-md-4">
                            <div class="card bg-white border-0 h-100 p-3 text-center">
                                <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded border" 
                                    style="height: 220px; overflow: hidden;">
                                    <img src="/images/mengenal_sisi_latihan2.png" 
                                        alt="Latihan 2" 
                                        class="img-fluid" 
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
            
                        <div class="col-md-4">
                            <div class="card bg-white border-0 h-100 p-3 text-center">
                                <div class="mb-3 d-flex align-items-center justify-content-center bg-light rounded border" 
                                    style="height: 220px; overflow: hidden;">
                                    <img src="/images/mengenal_sisi_latihan3.png" 
                                        alt="Latihan 3" 
                                        class="img-fluid" 
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
    
                    <div class="text-center mb-3">
                        <button class="btn btn-success px-5 fw-bold shadow-sm" id="btnCekSisi">
                            Periksa Jawaban
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
                                    <th>Segitiga MNO</th>
                                    <th>Segitiga PQR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <!-- Gambar Segitiga ABC -->
                                        <div class="text-center">
                                            <img src="/images/segitiga_sikusiku_c.png" 
                                                alt="Segitiga ACB siku-siku di C" 
                                                class="img-fluid rounded border mb-2"
                                                style="max-height: 250px;">
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Gambar Segitiga MNO -->
                                        <div class="text-center">
                                            <img src="/images/segitiga_sikusiku_n.png" 
                                                alt="Segitiga MNO siku-siku di N" 
                                                class="img-fluid rounded border mb-2"
                                                style="max-height: 250px;">
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Gambar Segitiga PQR -->
                                        <div class="text-center">
                                            <img src="/images/segitiga_sikusiku_q.png" 
                                                alt="Segitiga PQR siku-siku di A" 
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
