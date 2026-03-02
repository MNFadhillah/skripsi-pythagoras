@extends('layouts.siswa')

@section('title', 'PythaLearn - Tripel Pythagoras')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <h3 class="text-center">Tripel Pythagoras</h3>
        </div>
    </div>

         <!-- Pagination Navigasi -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center materi-pagination">
            <li class="page-item">
                <button class="page-link prev-btn">‹</button>
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
                <button class="page-link next-btn">›</button>
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
                        <hr>
                        <div class="alert alert-lig border-success">
                            <strong>Petunjuk Pengerjaan</strong><br>
                            <ol>
                                <li>Perhatikan tiga gambar segitiga yang masing-masing memiliki sudut A, B, dan C di bawah.</li>
                                <li>Tentukan sisi miring dan dua sisi lainnya pada setiap segitiga.</li>
                                <li>Pilih kombinasi sisi yang tepat untuk mengisi rumus Teorema Pythagoras yang terbentuk pada setiap segitiga.</li>
                                <li>Pastikan semua pilihan sudah terisi sebelum menekan tombol <strong>Cek Jawaban</strong>.</li>
                            </ol>
                        </div>

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
                            Jenis segitiga berdasarkan panjang sisi-sisinya = ...?
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
                                        a^2 + b^2 &= 914 \\\\
                                        c^2 &> a^2 + b^2
                                        \end{aligned}
                                    \]
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
                            Jenis segitiga berdasarkan panjang sisi-sisinya = ...?
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
                
                <div class="d-flex align-items-end gap-2 mt-1">
                    
                    <div class="d-flex flex-column align-items-center">
                        <label class="mb-1">c²</label>
                        <input type="number" id="inp_compare_c" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                    </div>

                    <select id="inp_sign" class="form-select form-select-sm text-center bg-white mb-0" style="width: 120px;">
                        <option value="">pilih tanda</option>
                        <option value="<">&lt;</option>
                        <option value=">">&gt;</option>
                        <option value="=">=</option>
                    </select>
                    
                    <div class="d-flex flex-column align-items-center">
                        <label class="mb-1">a² + b²</label>
                        <input type="number" id="inp_compare_ab" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                    </div>

                </div>
            </li>
        </ol>

        <div class="alert alert-success mt-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                Berdasarkan hasil perhitungan, maka segitiga ini adalah segitiga ....
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

<!-- ================= HALAMAN 3 ================= -->
<section class="materi-page d-none" data-page="2">
        <div class="row">
            <div class="col-12">
                
                <div class="card mb-4 shadow-sm">
    <div class="card-header">
        <h4 class="text-center mb-0">Pola Tripel Pythagoras</h4>
    </div>
    <div class="card-body">
        <p class="text-justify">
            Pada materi sebelumnya, kalian telah belajar cara menentukan jenis segitiga berdasarkan sudutnya yaitu segitiga lancip, tumpul, atau siku-siku. 
            Kita tahu bahwa syarat segitiga siku-siku adalah <strong>\(c^2 = a^2 + b^2\)</strong>. 
            Nah, jika ketiga sisi segitiga siku-siku tersebut merupakan <strong>bilangan asli</strong> (bilangan bulat positif), 
            maka ketiga bilangan tersebut memiliki sebutan khusus, yaitu <strong>Tripel Pythagoras</strong>.
        </p>
        <hr>
        <p class="text-justify">
            Jika kita memiliki sebuah tripel Pythagoras dasar, misalnya <strong>3, 4, dan 5</strong>. Kemudian kita mengalikan ketiga bilangan tersebut dengan bilangan lain (kelipatan), 
            maka tiga bilangan baru yang dihasilkan <strong>juga akan membentuk tripel Pythagoras</strong>.
        </p>

        <div class="alert alert-light border-success text-center">
            <p class="mb-2">Perhatikan gambar segitiga dan langkah pembuktian di bawah ini:</p>
            <img src="/images/segitiga_tripel1.png" class="img-fluid mb-3" alt="Contoh 1" style="max-height:150px">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100 bg-success">
                    <div class="card-header bg-light text-center fw-bold">
                        Dikali dengan 2
                    </div>
                    <div class="card-body bg-light">
                        <p>Sisi awal: 3, 4, 5. <br>Kalikan semua dengan 2:</p>
                        <ul>
                            <li>3 x 2 = <strong>6</strong></li>
                            <li>4 x 2 = <strong>8</strong></li>
                            <li>5 x 2 = <strong>10</strong></li>
                        </ul>
                        <hr>
                        <p class="fw-bold mb-1">Pembuktian:</p>
                        <div class="text-center">
                            <p class="mb-1">
                                \(c^2 = a^2 + b^2\)
                            </p>
                            <p class="mb-1">
                                \(10^2 = 6^2 + 8^2\)
                            </p>
                            <p class="mb-1">
                                \( 100 = 36 + 64\)
                            </p>
                            <p class="mb-1">
                                \( 100 = 100\)
                            </p>
                            <p class="mt-2">
                                Sehingga, terbukti bahwa 6, 8, dan 10 merupakan <strong>Tripel Pythagoras</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card h-100 border-success">
                    <div class="card-header text-center fw-bold">
                        Dikali dengan 3
                    </div>
                    <div class="card-body bg-light">
                        <p>Sisi awal: 3, 4, 5. <br>Kalikan semua dengan 3:</p>
                        <ul>
                            <li>3 x 3 = <strong>9</strong></li>
                            <li>4 x 3 = <strong>12</strong></li>
                            <li>5 x 3 = <strong>15</strong></li>
                        </ul>
                        <hr>
                        <p class="fw-bold mb-1">Pembuktian:</p>
                        <div class="text-center">
                            <p class="mb-1">
                                \(c^2 = a^2 + b^2\)
                            </p>
                            <p class="mb-1">
                                \(15^2 = 9^2 + 12^2\)
                            </p>
                            <p class="mb-1">
                                \( 225 = 81 + 144\)
                            </p>
                            <p class="mb-1">
                                \( 225 = 225\)
                            </p>
                            <p class="mt-2">
                                Sehingga, terbukti bahwa 9, 12, dan 15 merupakan <strong>Tripel Pythagoras</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<div class="col-md-12">
                <div class="card mb-4 shadow-sm">
    <div class="card-header bg-light">
        <h4 class="text-center mb-0">Contoh Soal</h4>
    </div>

    <div class="card-body">
        <div class="row">
    <div class="col-md-6 mb-3">
        <div class="card h-100 border-success shadow-sm">
            <div class="card-header text-center fw-bold">
                Contoh 1
            </div>
            <div class="card-body bg-light">
                <p class="mb-2">Apakah 8, 16, dan 17 adalah Tripel Pythagoras?</p>
                
                <p class="fw-bold mb-1">Penyelesaian</p>
                <p class="mb-3">Sisi terpanjang = 17</p>

                <div class="p-3 bg-white rounded border border-danger text-center">
                    <p class="mb-1">
                        \(c^2 = a^2 + b^2\)
                    </p>
                    <p class="mb-1">
                        \(17^2 = 16^2 + 8^2\)
                    </p>
                    <p class="mb-1">
                        \(289 = 256 + 64\)
                    </p>
                    <p class="mb-0 fw-bold">
                        \(289 \neq 320\)
                    </p>
                </div>

                <div class="text-center mt-3">
                    <strong>Jadi,</strong><br>
                    8, 16 dan 17 tidak termasuk Tripel Pythagoras
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card h-100 border-success shadow-sm">
            <div class="card-header text-center fw-bold">
                Contoh 2
            </div>
            <div class="card-body bg-light">
                <p class="mb-2">Apakah 10, 24, dan 26 adalah Tripel Pythagoras?</p>
                
                <p class="fw-bold mb-1">Penyelesaian</p>
                <p class="mb-3">Sisi terpanjang = 26</p>

                <div class="p-3 bg-white rounded border border-success text-center">
                    <p class="mb-1">
                        \(c^2 = a^2 + b^2\)
                    </p>
                    <p class="mb-1">
                        \(26^2 = 24^2 + 10^2\)
                    </p>
                    <p class="mb-1">
                        \(676 = 576 + 100\)
                    </p>
                    <p class="mb-0 fw-bold ">
                        \(676 = 676\)
                    </p>
                </div>

                <div class="alert mt-3 text-center mb-0">
                    <strong>Jadi,</strong><br>
                    10, 24 dan 26 termasuk bilangan Tripel Pythagoras
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
            </div>
        </div>

        <div class="col-md-12">
    <div class="card mb-5 shadow-sm">
        <div class="card-header">
            <h4 class="text-center mb-0">Ayo Berlatih</h4>
        </div>
        <div class="card-body">

            <div class="alert border-success shadow-sm" role="alert">
                <h6 class="fw-bold">Petunjuk Pengerjaan:</h6>
            <ol class="mb-0 ps-3">
                <li class="mb-2">
                    <strong>Perhatikan</strong> setiap perintah soal dengan teliti sebelum menjawab.
                </li>
                <li class="mb-2">
                    <strong>Kerjakan</strong> latihan berikut sesuai dengan jenis soalnya:
                    <ul class="ps-3 mt-1" style="list-style-type: disc;">
                        <li><strong>Soal 1:</strong> Menentukan apakah kelompok bilangan tersebut termasuk Tripel Pythagoras atau bukan (Pilih Ya/Tidak).</li>
                        <li><strong>Soal 2:</strong> Memilih satu pasangan bilangan yang paling tepat membentuk Tripel Pythagoras.</li>
                        <li><strong>Soal 3:</strong> Mengisi langkah-langkah pembuktian untuk menentukan jenis segitiga (Siku-siku, Lancip, atau Tumpul).</li>
                    </ul>
                </li>
                <li class="mb-1">
                    Jika sudah selesai, klik tombol <strong>"Cek Jawaban"</strong>.
                </li>
                <li>
                    Jawaban <strong>Benar</strong> akan ditandai warna <span class="badge bg-success">Hijau</span>, sedangkan jawaban <strong>Salah</strong> akan berwarna <span class="badge bg-danger">Merah</span> (silakan perbaiki jawaban yang salah tersebut).
                </li>
            </ol>
            </div>

            <form id="formLatihan">

                <div class="mb-4">
                    <h5 class="fw-bold text-center">Periksalah apakah bilangan-bilangan di bawah ini merupakan Tripel Pythagoras!</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width: 50%">Bilangan (Sisi)</th>
                                    <th style="width: 25%">Ya</th>
                                    <th style="width: 25%">Tidak</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td class="fw-bold px-3">6, 8, 10</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1a" value="ya"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1a" value="tidak"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold px-3">7, 12, 14</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1b" value="ya"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1b" value="tidak"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold px-3">8, 15, 17</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1c" value="ya"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1c" value="tidak"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold px-3">9, 10, 13</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1d" value="ya"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1d" value="tidak"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold px-3">10, 24, 26</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1e" value="ya"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" name="soal1e" value="tidak"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="fw-bold text-center">Manakah dari pasangan angka berikut yang membentuk Tripel Pythagoras?</h5>

                    <div class="row g-3 mt-1">
                        <div class="col-md-3 col-12">
                            <input type="radio" class="btn-check" name="soal2" id="soal2A" value="A" autocomplete="off">
                            <label class="btn btn-outline-success w-100 h-100 py-3 fw-bold shadow-sm" for="soal2A">
                                A. 7, 24, 25
                            </label>
                        </div>

                        <div class="col-md-3 col-12">
                            <input type="radio" class="btn-check" name="soal2" id="soal2B" value="B" autocomplete="off">
                            <label class="btn btn-outline-success w-100 h-100 py-3 fw-bold shadow-sm" for="soal2B">
                                B. 8, 20, 25
                            </label>
                        </div>

                        <div class="col-md-3 col-12">
                            <input type="radio" class="btn-check" name="soal2" id="soal2C" value="C" autocomplete="off">
                            <label class="btn btn-outline-success w-100 h-100 py-3 fw-bold shadow-sm" for="soal2C">
                                C. 10, 25, 27
                            </label>
                        </div>
                        <div class="col-md-3 col-12">
                            <input type="radio" class="btn-check" name="soal2" id="soal2D" value="D" autocomplete="off">
                            <label class="btn btn-outline-success w-100 h-100 py-3 fw-bold shadow-sm" for="soal2D">
                                D. 12, 20, 29
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="fw-bold text-center">Apakah sisi segitiga 9, 12, 15 membentuk segitiga siku-siku, lancip, atau tumpul?</h5>

                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body">
                            <p class="fw-bold text-decoration-underline mb-3">Penyelesaian:</p>

                            <div class="d-flex align-items-center mb-3">
                                <label class="me-2">Sisi terpanjang (\(c\)) =</label>
                                <input type="number" class="form-control form-control-sm text-center border-secondary input-soal3" style="width: 80px;" id="inputC">
                            </div>

                            <div class="ps-1">
                                <div class="row align-items-center g-1 mb-2">
                                    <div class="col-auto">\(c^2\) = </div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 input-soal3" style="width: 60px;">
                                    </div>
                                    <div class="col-auto">\(^2\) = </div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 fw-bold input-soal3" style="width: 75px;">
                                    </div>
                                </div>

                                <div class="row align-items-center g-1 mb-2">
                                    <div class="col-auto">\(a^2 + b^2\) =</div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 input-soal3" style="width: 50px;">
                                    </div>
                                    <div class="col-auto">\(^2\) + </div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 input-soal3" style="width: 50px;">
                                    </div>
                                    <div class="col-auto">\(^2\)</div>
                                </div>

                                <div class="row align-items-center g-1 mb-3 ps-5 ms-3">
                                    <div class="col-auto">=</div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 input-soal3" style="width: 60px;">
                                    </div>
                                    <div class="col-auto">+</div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 input-soal3" style="width: 60px;">
                                    </div>
                                    <div class="col-auto">=</div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm text-center px-1 fw-bold text-primary input-soal3" style="width: 75px;">
                                    </div>
                                </div>
                                <div class="d-flex align-items-end gap-2 mt-1 mb-2">
                                    
                                    <div class="d-flex flex-column align-items-center">
                                        <label class="mb-1">\(c^2\)</label>
                                        <input type="number" id="inp_compare_c_soal3" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                                    </div>

                                    <select id="inp_sign_soal3" class="form-select form-select-sm text-center bg-white mb-0" style="width: 120px;">
                                        <option value="">pilih tanda</option>
                                        <option value="<">&lt;</option>
                                        <option value=">">&gt;</option>
                                        <option value="=">=</option>
                                    </select>
                                    
                                    <div class="d-flex flex-column align-items-center">
                                        <label class="mb-1">\(a^2 + b^2\)</label>
                                        <input type="number" id="inp_compare_ab_soal3" class="form-control form-control-sm text-center bg-white" style="width: 80px;" placeholder="...">
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex align-items-center bg-white p-3 rounded border shadow-sm">
                                <span class="me-2 fw-bold">Jadi, segitiga tersebut adalah:</span>
                                <select class="form-select form-select-sm w-auto fw-bold text-success border-success" id="selectSoal3">
                                    <option selected disabled value="">-- Pilih Jawaban --</option>
                                    <option value="Siku-siku">Segitiga Siku-siku</option>
                                    <option value="Lancip">Segitiga Lancip</option>
                                    <option value="Tumpul">Segitiga Tumpul</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
                    <button type="button" class="btn btn-success fw-bold py-2" onclick="cekJawabanLatihan()">Cek Jawaban
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
        </div>
    </section>

    <section class="materi-page d-none" data-page="3">
    <div class="row justify-content-center">
        
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Rangkuman Tripel Pythagoras</h4>
                </div>
                
                <div class="card-body p-4 bg-white">
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">1</div>
                        <div class="ms-3">
                            <p class="text-muted mb-0" style="line-height: 1.6;">
                                <strong>Tripel Pythagoras</strong> adalah kelompok tiga bilangan asli (bilangan bulat positif) \(a, b, c\) yang memenuhi ketentuan <strong>\(c^2 = a^2 + b^2\)</strong>, di mana \(c\) adalah bilangan terbesar (sisi miring).
                            </p>
                        </div>
                    </div>

                    <hr class="border-secondary opacity-10 my-3">

                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 30px; height: 30px;">2</div>
                        <div class="ms-3">
                            <p class="text-muted mb-0" style="line-height: 1.6;">
                                <strong>Sifat Kelipatan:</strong> Jika kita memiliki salah satu tripel Pythagoras (misalnya 3, 4, 5), maka kelipatannya (dikali \(k\)) juga membentuk tripel Pythagoras. <br>
                                <em>Contoh:</em> 6, 8, 10 (dikali 2) atau 9, 12, 15 (dikali 3).
                            </p>
                        </div>
                    </div>

                    <hr class="border-secondary opacity-10 my-3">

                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center ">
                    <h4 class="mb-0">Refleksi</h4>
                    <small class="text-muted">
                        Jawablah berdasarkan pemahamanmu terkait aktivitas Tripel Pythagoras
                    </small>
                </div>

                <div class="card-body p-4">

                    <div class="mb-4">
                        <label class="fw-semibold mb-2">
                            1. Apakah bilangan kuadrat dan akar kuadrat suatu bilangan merupakan bilangan dasar yang menentukan terbentuknya Teorema Pythagoras? Jelaskan.
                        </label>

                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ref_tri_1" id="ref_tri_1_ya" value="ya">
                                <label class="form-check-label" for="ref_tri_1_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ref_tri_1" id="ref_tri_1_tidak" value="tidak">
                                <label class="form-check-label" for="ref_tri_1_tidak">Tidak</label>
                            </div>
                        </div>

                        <textarea class="form-control" rows="3" id="ref_tri_1_text" placeholder="Berikan penjelasanmu..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold mb-2">
                            2. Bagaimana bentuk hubungan dari setiap sisi pada segitiga siku-siku? Apakah dari hubungan tersebut dapat dikaitkan dengan Teorema Pythagoras? Jelaskan.
                        </label>
                        <textarea class="form-control" rows="3" id="ref_tri_2_text" placeholder="Tuliskan pemahamanmu..."></textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-success fw-bold" onclick="cekRefleksiTripel()">Simpan Refleksi</button>
                    </div>

                <div class="text-center mt-4">
                    <p>Setelah mempelajari materi tentang Menemukan Konsep Teorema Pythagoras. Silahkan kerjakan Kuis 2 - Tripel Pythagoras</p>
                </div>

                </div>
            </div>
        </div>

    </div>
</section>

    
    <!-- (lanjutan halaman 3, 4, dan 5 DITULIS UTUH SESUAI YANG ANDA KIRIM) -->
         <!-- Pagination Navigasi -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center materi-pagination">
            <li class="page-item">
                <button class="page-link prev-btn">‹</button>
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
                <button class="page-link next-btn">›</button>
            </li>
        </ul>
    </nav>

</div>
@endsection
