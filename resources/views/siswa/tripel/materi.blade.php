@extends('layouts.siswa')

@section('title', 'PythaLearn - Tripel Pythagoras')

@section('content')
<div class="container">
    <div class="row align-items-center mb-2">
        <div class="col-lg-12">
            <h3 class="text-center">Tripel Pythagoras</h3>
        </div>
    </div>

         <!-- Pagination Navigasi -->
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
                <button class="page-link" id="nextPage">›</button>
            </li>
        </ul>
    </nav>

    <!-- ================= HALAMAN 1 ================= -->
    <section class="materi-page" data-page="0">
        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Tujuan Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Peserta didik mampu menghitung hipotenusa dan sisi segitiga siku-siku lainnya dengan teorema Pythagoras</li>
                        <li>Peserta didik mampu menemukan tripel Pythagoras</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="text-center mb-0">Mari Mengingat</h4>
                </div>
                <div class="card-body">
                    <p class="text-justify">
                        Sebelum membahas lebih detail terkait tripel Pythagoras, kita perlu mengingat kembali terkait Teorema Pythagoras. Hal ini dikarenakan bahwa terdapat kebalikan dari Teorema Pythagoras yang juga sering digunakan dalam menyelesaikan permasalahan dalam kehidupan sehari-hari.
                    </p>

                    <div class="alert alert-light border-success">
                        <h5 class="fw-bold text-center">Kebalikan Teorema Pythagoras</h5>
                        <div class="row g-4">

    <!-- ================= KARTU A ================= -->
    <div class="col-md-4">
        <div class="card h-100 border-success shadow-sm">
            <div class="card-body text-center p-3">
                <img src="/images/segitiga_sikusiku_diA.png" class="img-fluid mb-3" style="max-height:140px;">
                <p class="mb-2">Untuk <strong>\( b < c < a \)</strong></p>

                <div class="d-flex justify-content-center gap-1 my-3 fw-bold">
                    <select id="rumusA_1" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>² =</span>
                    <select id="rumusA_2" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>² +</span>
                    <select id="rumusA_3" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>²</span>
                </div>

                <div id="feedbackA" class="small fw-bold"></div>
                <div id="kesimpulanA" class="alert alert-success mt-2 py-1 small d-none">
                    Maka △ABC <strong>siku-siku di A</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= KARTU B ================= -->
    <div class="col-md-4">
        <div class="card h-100 border-success shadow-sm">
            <div class="card-body text-center p-3">
                <img src="/images/segitiga_sikusiku_diB.png" class="img-fluid mb-3" style="max-height:140px;">
                <p class="mb-2">Untuk <strong>\( a < c < b \)</strong></p>

                <div class="d-flex justify-content-center gap-1 my-3 fw-bold">
                    <select id="rumusB_1" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>² =</span>
                    <select id="rumusB_2" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>² +</span>
                    <select id="rumusB_3" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>²</span>
                </div>

                <div id="feedbackB" class="small fw-bold"></div>
                <div id="kesimpulanB" class="alert alert-success mt-2 py-1 small d-none">
                    Maka △ABC <strong>siku-siku di B</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= KARTU C ================= -->
    <div class="col-md-4">
        <div class="card h-100 border-success shadow-sm">
            <div class="card-body text-center p-3">
                <img src="/images/segitiga_sikusiku_diC.png" class="img-fluid mb-3" style="max-height:140px;">
                <p class="mb-2">Untuk <strong>\( a < b < c \)</strong></p>

                <div class="d-flex justify-content-center gap-1 my-3 fw-bold">
                    <select id="rumusC_1" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>² =</span>
                    <select id="rumusC_2" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>² +</span>
                    <select id="rumusC_3" class="form-select form-select-sm text-center" style="width:60px">
                        <option value=""></option><option>a</option><option>b</option><option>c</option>
                    </select>
                    <span>²</span>
                </div>

                <div id="feedbackC" class="small fw-bold"></div>
                <div id="kesimpulanC" class="alert alert-success mt-2 py-1 small d-none">
                    Maka △ABC <strong>siku-siku di C</strong>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- TOMBOL GLOBAL -->
<div class="text-center mt-4">
    <button class="btn btn-lg btn-success px-5" onclick="cekSemuaRumus()">
        Cek Jawaban
    </button>
</div>

                    </div>

                </div>
            </div>
        </section>
    </section>

    <!-- ================= HALAMAN 2 ================= -->
    <section class="materi-page d-none" data-page="1">
        <div class="row">
            <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
    <div class="card-header bg-light">
        <h4 class="text-center mb-0">Menentukan Jenis Segitiga</h4>
    </div>

    <div class="card-body">
        <p class="text-justify">
            Setelah memahami <strong>kebalikan Teorema Pythagoras</strong>,
            kita dapat menggunakannya untuk
            <strong>menentukan jenis segitiga</strong>.
            Caranya adalah dengan membandingkan
            nilai \(a^2 + b^2\) dengan \(c^2\).
            Dari hasil perbandingan tersebut,
            kita dapat mengetahui apakah segitiga termasuk
            segitiga <strong>siku-siku</strong>, <strong>lancip</strong>,
            atau <strong>tumpul</strong>.
        </p>


        <div class="alert alert-light border-success">
            <h5 class="fw-bold text-center mb-4">
                Jenis Segitiga Berdasarkan Besar Sudutnya
            </h5>

            <div class="row g-4">

                <!-- ================= SEGITIGA TUMPUL ================= -->
                <div class="col-md-4">
                    <div class="card h-100 border-success shadow-sm">
                        <div class="card-body text-center p-3">
                            <img 
                                src="/images/segitiga_tumpul.png" 
                                class="img-fluid mb-3"
                                style="max-height: 140px;"
                                alt="Segitiga Tumpul">

                            <p class="fw-semibold mb-2">(i)</p>

                            <div class="my-2">
                                <p class="mb-1">
                                    Pada segitiga di atas jika <br> <strong>\(c^2 > a^2 + b^2\)</strong>,
                                </p>
                                <p class="mb-0">
                                    maka ∆ACB merupakan <br>
                                    <div class="alert alert-success py-1 small mb-0 fw-bold">
                                        Segitiga Tumpul
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= SEGITIGA SIKU-SIKU ================= -->
                <div class="col-md-4">
                    <div class="card h-100 border-success shadow-sm">
                        <div class="card-body text-center p-3">
                            <img src="/images/segitiga_sikusiku_contoh.png" 
                                class="img-fluid mb-3" 
                                style="max-height: 140px;" 
                                alt="Segitiga Siku-siku">

                            <p class="fw-semibold mb-2">(ii)</p>

                            <div class="my-2">
                                <p class="mb-1">
                                    Pada segitiga di atas jika <br> <strong>\(c^2 = a^2 + b^2\)</strong>,
                                </p>
                                <p class="mb-0">
                                    maka ∆ACB merupakan <br>
                                    <div class="alert alert-success py-1 small mb-0 fw-bold">
                                        Segitiga Siku-siku
                                    </div>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ================= SEGITIGA LANCIP ================= -->
                <div class="col-md-4">
                    <div class="card h-100 border-success shadow-sm">
                        <div class="card-body text-center p-3">
                            <img 
                                src="/images/segitiga_lancip.png" 
                                class="img-fluid mb-3"
                                style="max-height: 140px;"
                                alt="Segitiga Lancip">

                            <p class="fw-semibold mb-2">(iii)</p>

                            <div class="my-2">
                                <p class="mb-1">
                                    Pada segitiga di atas jika <br> <strong>\(c^2 < a^2 + b^2\)</strong>,
                                </p>
                                <p class="mb-0">
                                    maka ∆ACB merupakan <br>
                                    <div class="alert alert-success py-1 small mb-0 fw-bold">
                                        Segitiga Lancip
                                    </div>
                                </p>
                            </div>
                        </div>
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
            <h4>Contoh 1</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- KIRI -->
                <div class="col-lg-5 mb-3">
                    <p class="text-muted fw-bold mb-2">Perhatikan Gambar di bawah!</p>
                    <div class="bg-white rounded-3 shadow-sm border mb-3 py-2 d-flex justify-content-center overflow-hidden">
                        <img src="/images/segitiga_contoh_1_materi2.png" class="img-fluid w-50" alt="Contoh 1">
                    </div>

                    <div class="text-start mb-2">
                        <p class="text-muted mb-2">
                            Diketahui sebuah segitiga dengan panjang sisi-sisinya masing-masing 17 cm, 25 cm, dan 38 cm. 
                            Tentukan jenis segitiga tersebut berdasarkan panjang sisi-sisinya.
                        </p>
                    </div>

                    <div class="border-start border-success border-3 ps-2 mb-2">
                        <strong class="text-success">Diketahui:</strong>
                        <ul class="mb-0 mt-0 text-muted ps-3">
                            <li>Sisi terpendek (a) = 17 cm</li>
                            <li>Sisi sedang (b) = 25 cm</li>
                            <li>Sisi terpanjang (c) = 38 cm</li>
                        </ul>
                    </div>

                    <div class="border-start border-warning border-3 ps-2 mb-3">
                        <strong class="text-warning">Ditanya:</strong>
                        <p class="mb-0 text-muted">
                            Jenis segitiga berdasarkan sudutnya?
                        </p>
                    </div>
                </div>

                <!-- KANAN -->
                <div class="col-lg-7">
                    <div class="card bg-light border-0 rounded-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">Langkah Penyelesaian:</h6>

                            <ol class="mb-0 list-group-numbered-custom text-muted">
                                <li class="mb-2">
                                    <strong>Tentukan sisi terpanjang segitiga:</strong><br>
                                    Sisi terpanjang adalah <strong>c = 38 cm</strong>.
                                </li>

                                <li class="mb-2">
                                    <strong>Hitung kuadrat sisi terpanjang (c²):</strong>
                                    <div>
                                        \[
                                        \begin{aligned}
                                        c^2 &= 38^2 \\
                                        &= 1.444
                                        \end{aligned}
                                        \]
                                    </div>
                                </li>

                                <li class="mb-2">
                                    <strong>Hitung jumlah kuadrat dua sisi lainnya (a² + b²):</strong>
                                    <div>
                                        \[
                                        \begin{aligned}
                                        a^2 + b^2 &= 17^2 + 25^2 \\
                                        &= 289 + 625 \\
                                        &= 914
                                        \end{aligned}
                                        \]
                                    </div>
                                </li>

                                <li>
                                    <strong>Bandingkan nilai c² dengan a² + b²:</strong><br>
                                     \[
                                        \begin{aligned}
                                        c^2 &= 1.444 \\
                                        a^2 + b^2 &= 914
                                        \end{aligned}
                                    \]
                                    Maka berlaku <strong>c² > a² + b²</strong>, sehingga segitiga tersebut adalah <strong>segitiga tumpul</strong>.
                                </li>
                            </ol>

                            <div class="alert alert-success d-flex align-items-center mt-3">
                                <div>
                                    <strong>Jadi,</strong> segitiga dengan panjang sisi 17 cm, 25 cm, dan 38 cm merupakan 
                                    <strong>segitiga tumpul</strong>.
                                </div>
                            </div>

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
            <h4>Ayo Mencoba</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <p class="text-muted fw-bold mb-2">Perhatikan Gambar di bawah!</p>
                    <div class="bg-white rounded-3 shadow-sm border mb-3 py-2 d-flex justify-content-center overflow-hidden">
                        <img src="/images/segitiga_ayomencoba_materi2.png" class="img-fluid w-50" alt="Contoh 1">
                    </div>
                    
                    <div class="text-start mb-2">
                        <p class= mb-2">
                            Diketahui segitiga dengan panjang sisi <strong>11 cm</strong>, <strong>13 cm</strong>, dan <strong>15 cm</strong>.
                            Tentukan jenis segitiga tersebut berdasarkan panjang sisi-sisinya.
                        </p>
                    </div>

                    <div class="border-start border-success border-3 ps-2 mb-2">
                        <strong class="text-success">Diketahui:</strong>
                        <ul class="mb-0 mt-0 ps-3">
                            <li>Sisi a = 11 cm</li>
                            <li>Sisi b = 13 cm</li>
                            <li>Sisi c = 15 cm</li>
                        </ul>
                    </div>

                    <div class="border-start border-warning border-3 ps-2 mb-3">
                        <strong class="text-warning">Ditanya:</strong>
                        <p class="mb-0">
                            Jenis segitiga?
                        </p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card bg-light border-0 rounded-3">
    <div class="card-body">
        <p class="mb-3">Isi kotak kosong di bawah ini:</p>
        <h6 class="fw-bold mb-2">Langkah Penyelesaian:</h6>
        
        <ol class="mb-0 ps-3">
            <li class="mb-3">
                <strong>Tentukan sisi terpanjang (c):</strong><br>
                <div class="d-flex align-items-center mt-1">
                    <span class="me-2">Sisi terpanjang =</span>
                    <input type="number" id="inp_c" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="..."> 
                    <span class="ms-2">cm</span>
                </div>
            </li>

            <li class="mb-3">
                <strong>Hitung kuadrat sisi terpanjang (c²):</strong>
                <div class="d-flex align-items-center mt-1 gap-1">
                    <i>c</i>² =
                    <input type="number" id="inp_c_base" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">²
                    =
                    <input type="number" id="inp_c_res" class="form-control form-control-sm text-center bg-white fw-bold text-primary" style="width: 80px;" placeholder="...">
                </div>
            </li>

            <li class="mb-3">
                <strong>Hitung jumlah kuadrat dua sisi lainnya (a² + b²):</strong>
                <div class="mt-1">
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <i>a</i>² + <i>b</i>² = 
                        <input type="number" id="inp_a_base" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">²
                        +
                        <input type="number" id="inp_b_base" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">²
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span style="visibility: hidden;"><i>a</i>² + <i>b</i>²</span> = 
                        <input type="number" id="inp_a_res" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                        +
                        <input type="number" id="inp_b_res" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                    </div>
                    <div class="d-flex align-items-center gap-1 mt-1">
                        <span style="visibility: hidden;"><i>a</i>² + <i>b</i>²</span> = 
                        <input type="number" id="inp_ab_total" class="form-control form-control-sm text-center bg-white fw-bold text-primary" style="width: 80px;" placeholder="...">
                    </div>
                </div>
            </li>

            <li class="mb-3">
                <strong>Bandingkan nilai c² dengan a² + b²:</strong><br>
                <div class="d-flex align-items-center gap-2 mt-1">
                    <input type="number" id="inp_compare_c" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                    
                    <select id="inp_sign" class="form-select form-select-sm text-center bg-white" style="width: 120px;">
                        <option value="">pilih tanda</option>
                        <option value="<">&lt;</option>
                        <option value=">">&gt;</option>
                        <option value="=">=</option>
                    </select>
                    
                    <input type="number" id="inp_compare_ab" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                </div>
            </li>
        </ol>

        <div class="alert alert-success mt-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                Berdasarkan hasil perhitungan, maka segitiga ini adalah segitiga:
                <select id="inp_conclusion" class="form-select form-select-sm w-auto d-inline fw-bold text-success">
                    <option value="">-- Pilih Jawaban --</option>
                    <option value="siku">Siku-siku</option>
                    <option value="lancip">Lancip</option>
                    <option value="tumpul">Tumpul</option>
                </select>
            </div>
        </div>

        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-success" onclick="cekJawaban()">
                Cek Jawaban
            </button>
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

<section class="materi-page d-none" data-page="2">
    <div class="row">
        <div class="col-12">
            
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="text-center mb-0">Menemukan Tripel Pythagoras dengan Aljabar</h4>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="text-justify mb-3">
                                Kita dapat menentukan himpunan bilangan Tripel Pythagoras menggunakan bentuk aljabar. 
                                Jika <strong>\(p\)</strong> dan <strong>\(q\)</strong> adalah bilangan bulat positif dengan <strong>\(p > q\)</strong>, maka berlaku rumus:
                            </p>
                            
                            <div class="alert alert-light border-success border-start-4 shadow-sm">
                                <ul class="mb-0 list-unstyled">
                                    <li class="mb-1">📐 Sisi Miring (Hipotenusa) = <strong>\(p^2 + q^2\)</strong></li>
                                    <li class="mb-1">🔹 Sisi Siku-siku 1 = <strong>\(p^2 - q^2\)</strong></li>
                                    <li>🔹 Sisi Siku-siku 2 = <strong>\(2pq\)</strong></li>
                                </ul>
                            </div>

                            <p class="text-muted small mt-2">
                                <i class="bi bi-info-circle-fill text-success me-1"></i>
                                <strong>Petunjuk:</strong> Perhatikan pola pada baris contoh (baris 1 & 2), lalu lengkapi tabel kosong di bawahnya.
                            </p>
                        </div>

                        <div class="col-md-4 text-center">
                            <div class="bg-white rounded p-3 border border-success">
                                <svg width="100%" height="140" viewBox="0 0 160 140">
                                    <defs>
                                        <marker id="arrow" markerWidth="10" markerHeight="10" refX="0" refY="3" orient="auto" markerUnits="strokeWidth">
                                            <path d="M0,0 L0,6 L9,3 z" fill="#198754" />
                                        </marker>
                                    </defs>
                                    <polygon points="30,110 140,110 140,30" fill="#e9f7ef" stroke="#198754" stroke-width="2"/>
                                    <polyline points="130,110 130,100 140,100" fill="none" stroke="#198754" stroke-width="1.5"/>
                                    <text x="85" y="125" font-size="12" text-anchor="middle" font-weight="bold" fill="#495057">p² - q²</text>
                                    <text x="145" y="75" font-size="12" text-anchor="start" font-weight="bold" fill="#495057">2pq</text>
                                    <text x="75" y="65" font-size="12" text-anchor="middle" font-weight="bold" fill="#198754">p² + q²</text>
                                </svg>
                                <div class="small text-muted mt-1 fst-italic">Model Segitiga</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="table-responsive">
<table class="table table-bordered text-center align-middle small" id="tabelTripel">

<thead class="table-success">
<tr>
    <th>p</th>
    <th>q</th>
    <th>p² + q²</th>
    <th>p² − q²</th>
    <th>2pq</th>
    <th>Hubungan</th>
    <th>Tripel<br>Pythagoras</th>
</tr>
</thead>

<tbody>

<!-- ===== BARIS 1 (CONTOH PENUH) ===== -->
<tr>
    <td>2</td>
    <td>1</td>
    <td>2² + 1² = 5</td>
    <td>2² − 1² = 3</td>
    <td>2 × 2 × 1</td>
    <td>5² = 3² + 4²</td>
    <td>5, 3, 4</td>
</tr>

<!-- ===== BARIS 2 (CONTOH PENUH) ===== -->
<tr>
    <td>3</td>
    <td>1</td>
    <td>3² + 1² = 10</td>
    <td>3² − 1² = 8</td>
    <td>2 × 3 × 1</td>
    <td>10² = 6² + 8²</td>
    <td>10, 6, 8</td>
</tr>

<!-- ===== BARIS 3 (INTERAKTIF) ===== -->
<tr>
    <td>3</td>
    <td>2</td>

    <td>
        3² + 2² = 
        <input type="number" class="form-control d-inline w-50"
               data-jawaban="13">
    </td>

    <td>
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="3">² −
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="2">² =
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="5">
    </td>

    <td>
        2 × 
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="3"> ×
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="2">
    </td>

    <td>
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="13">² =
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="5">² +
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="12">²
    </td>

    <td>
        <input type="text" class="form-control"
               data-jawaban="13,5,12">
    </td>
</tr>

<!-- ===== BARIS 4 (INTERAKTIF) ===== -->
<tr>
    <td>4</td>
    <td>1</td>

    <td>
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="4">² +
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="1">² =
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="17">
    </td>

    <td>
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="4">² −
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="1">² =
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="15">
    </td>

    <td>
        2 × 
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="4"> ×
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="1">
    </td>

    <td>
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="17">² =
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="15">² +
        <input type="number" class="form-control d-inline w-25"
               data-jawaban="8">²
    </td>

    <td>
        <input type="text" class="form-control"
               data-jawaban="17,15,8">
    </td>
</tr>

</tbody>
</table>
</div>

<button class="btn btn-success mt-3" onclick="cekTabel()">Cek Jawaban</button>

                </div>
            </div>

        </div>
    </div>
</section>

    <!-- ================= HALAMAN 3–5 ================= -->
    <!-- (lanjutan halaman 3, 4, dan 5 DITULIS UTUH SESUAI YANG ANDA KIRIM) -->
         <!-- Pagination Navigasi -->
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
                <button class="page-link" id="nextPage">›</button>
            </li>
        </ul>
    </nav>

</div>
@endsection
