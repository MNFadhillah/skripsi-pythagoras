@extends('layouts.siswa')

@section('title', 'PythaLearn - Segitiga Istimewa')

@section('content')
<div class="container">
    <div class="row align-items-center mb-2">
        <div class="col-lg-12">
            <h3 class="text-center">Segitiga Istimewa</h3>
        </div>
    </div>

    <!-- Pagination Navigasi -->
    <nav>
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
                <div class="card-header text-center">
                    <h4>Tujuan Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Peserta didik mampu membandingkan sisi pada segitiga siku-siku istimewa</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">

                    <h4>Tahukah Kamu?</h4>
                </div>
                <div class="card-body">
                    <p class="text-justify mb-2">
                        Pada materi sebelumnya, untuk mencari panjang sisi miring atau salah satu sisi siku-siku, kita selalu menggunakan rumus Teorema Pythagoras \(c^2 = a^2 + b^2\). Kita harus mengkuadratkan angka, menjumlahkannya, lalu mencari akar kuadratnya. Terkadang, angkanya cukup besar dan merepotkan, bukan?
                    </p>
                    <p class="text-justify mb-0">
                        Nah, ada sebuah aturan segitiga yang <strong>"Spesial"</strong> yang dikenal dengan <strong>Segitiga Istimewa</strong>. Segitiga ini memiliki aturan perbandingan unik yang memungkinkan kita menemukan panjang sisinya <strong>jika hanya satu sisi yang diketahui!</strong> Yuk, kita pelajari bersama!
                    </p>
                </div>

            </div>
        </section>

        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="text-center mb-0">Segitiga Istimewa 45°, 45°, 90°</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Segitiga siku-siku sama kaki adalah segitiga istimewa yang ukuran ketiga sudutnya adalah 45°, 45°, 90°. Segitiga \(ABC\) di samping memiliki sisi siku-siku \(AB\) dan \(BC\) serta sisi miring \(AC\). Diketahui bahwa sisi \(AB = BC = a\), maka panjang sisi miringnya dapat ditentukan menggunakan rumus pythagoras berikut:.</p>
                            
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-4 text-md-end pe-md-4">
                            <img src="/images/segitiga_istimewa_1.png" 
                                 alt="Segitiga" 
                                 class="img-fluid" 
                                 style="max-height: 240px; object-fit: contain;">
                        </div>
                        <div class="col-md-4 text-center text-md-start ps-md-4">
                            $$
                            \begin{aligned}
                            a^2 + b^2 &= c^2 \\
                            a^2 + a^2 &= c^2 \\
                            2a^2 &= c^2 \\
                            c &= a\sqrt{2}
                            \end{aligned}
                            $$
                        </div>
                        <div class="col-md-12 text-center">
                            <p class="mb-2">Maka perbandingan yang memenuhi sisi segitiga istimewa 45°, 45°, 90°:</p>
                            
                            <div class="bg-light border rounded py-3 mx-auto" style="max-width: 500px;">
                                <div class="fw-bold text-center">
                                    $$
                                    \begin{matrix}
                                    \text{sisi di hadapan } 45^\circ & : & \text{sisi di hadapan } 45^\circ & : & \text{sisi miring} \\
                                    a & : & a & : & a\sqrt{2} \\
                                    1 & : & 1 & : & \sqrt{2}
                                    \end{matrix}
                                    $$
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-center bg-light">
                            <h4 class="mb-0">Contoh 1</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5 mb-3">
                                    <p class="text-muted fw-bold small mb-2">Perhatikan gambar segitiga siku-siku di bawah ini!</p>
                                    <div class="bg-white rounded-3 shadow-sm border mb-3 py-3 d-flex justify-content-center overflow-hidden">
                                        <img src="/images/contoh_soal_istimewa_1.png" class="img-fluid w-75" alt="Contoh 1">
                                    </div>
                                    <div class="text-justify mb-2">
                                        <p class="text-muted small mb-2">
                                            Tentukan panjang AB, apabila diketahui panjang AC = 20 cm.
                                        </p>
                                    </div>  
                                    <div class="border-3 border-start ps-2 mb-2">
                                        <strong class="text-success small">Diketahui:</strong>
                                        <ul class="mb-0 mt-0 text-muted small ps-3">
                                            <li>Panjang AC = 20 cm</li>
                                            <li>Sudut A dan sudut C = 45&deg;</li>
                                        </ul>
                                    </div> 
                                    <div class="border-start border-warning border-3 ps-2 mb-3">
                                        <strong class="text-warning small">Ditanya:</strong>
                                        <p class="mb-0 text-muted small">Panjang AB = ...? </p>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="card bg-light border-0 rounded-3">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-2">Langkah Penyelesaian:</h6>
                                            <ol class="mb-0 list-group-numbered-custom small text-muted">
                                                <li class="mb-2">
                                                    <strong>Gunakan perbandingan segitiga istimewa 45&deg;-45&deg;-90&deg;:</strong><br>
                                                    Diketahui perbandingan sisi miring adalah \(c\sqrt{2}\). Maka persamaan untuk segitiga tersebut adalah:
                                                    <div>
                                                        $$
                                                        \begin{aligned}
                                                        c &= a\sqrt{2} \\
                                                        AC &= AB\sqrt{2}
                                                        \end{aligned}
                                                        $$
                                                    </div>
                                                </li>  
                                                <li>
                                                    <strong>Masukkan nilai yang diketahui dan hitung panjang AB:</strong><br>
                                                    Pindahkan ruas untuk mencari AB, lalu masukkan nilai AC = 20 cm:
                                                    <div>
                                                        $$
                                                        \begin{aligned}
                                                        AB &= \frac{AC}{\sqrt{2}} \\
                                                        AB &= \frac{20}{\sqrt{2}}
                                                        \end{aligned}
                                                        $$
                                                    </div>
                                                    Rasionalkan bentuk akarnya dengan mengalikan pembilang dan penyebut dengan $\sqrt{2}$:
                                                    <div class="mt-2">
                                                        $$
                                                        \begin{aligned}
                                                        AB &= \frac{20}{\sqrt{2}} \times \frac{\sqrt{2}}{\sqrt{2}} \\
                                                        AB &= \frac{20\sqrt{2}}{2} \\
                                                        AB &= 10\sqrt{2}
                                                        \end{aligned}
                                                        $$
                                                    </div>
                                                </li>
                                            </ol>
                                            <div class="alert alert-success d-flex align-items-center small mt-3 mb-0">
                                                <div>
                                                    <strong>Jadi,</strong> panjang AB adalah <strong>\(10\sqrt{2} \text{ cm}\)</strong>.
                                                </div> 
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
    </section>

    <!-- ================= HALAMAN 2 ================= -->
    <section class="materi-page d-none" data-page="1">
        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="text-center mb-0">Segitiga Istimewa 30&deg;, 60&deg;, 90&deg;</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-justify mb-2">
                                Segitiga Istimewa yang lain yang akan kita pelajari yaitu segitiga siku-siku 30&deg;, 60&deg;, 90&deg;. Segitiga \(ABC\) di bawah memiliki sisi miring \(AB\) dan sisi siku-sikunya \(AC\) dan \(BC\), serta &ang;A = 30&deg;, &ang;C = 90&deg;, &ang;B = 60&deg;.
                            </p>
                            <p class="text-justify mb-3">
                                Jika ditarik garis bantu membelah sudut, dapat terlihat bahwa sisi miring adalah 2 kali sisi terpendek. Karena diketahui sisi terpendek \(BC = a\) dan sisi miring \(AB = 2a\), maka panjang sisi \(AC\) dapat ditentukan menggunakan rumus Pythagoras berikut:
                            </p>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center mb-4">
                        <div class="col-md-4 text-center text-md-end pe-md-4 mb-3 mb-md-0">
                            <img src="/images/pembuktian_30_60_90.png" 
                                 alt="pembuktian 30 60 90" 
                                 class="img-fluid" 
                                 style="max-height: 240px; object-fit: contain;">
                        </div>
                        <div class="col-md-4 text-center text-md-start ps-md-4">
                            $$
                            \begin{aligned}
                            AC^2 + BC^2 &= AB^2 \\
                            AC^2 + a^2 &= (2a)^2 \\
                            AC^2 + a^2 &= 4a^2 \\
                            AC^2 &= 4a^2 - a^2 \\
                            AC^2 &= 3a^2 \\
                            AC &= \sqrt{3a^2} \\
                            AC &= a\sqrt{3}
                            \end{aligned}
                            $$
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 text-center">
                            <p class="mb-2">Maka perbandingan yang memenuhi sisi segitiga istimewa 30&deg;, 60&deg;, 90&deg;:</p>
                            
                            <div class="bg-light border rounded py-3 mx-auto" style="max-width: 600px;">
                                <div class="fw-bold text-center overflow-auto">
                                    $$
                                    \begin{matrix}
                                    \text{sisi di depan } 30^\circ & : & \text{sisi di depan } 60^\circ & : & \text{sisi miring} \\
                                    BC & : & AC & : & AB \\
                                    a & : & a\sqrt{3} & : & 2a \\
                                    1 & : & \sqrt{3} & : & 2
                                    \end{matrix}
                                    $$
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-center bg-light">
                            <h4 class="mb-0">Contoh 2</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5 mb-3">
                                    <p class="text-muted fw-bold small mb-2">Perhatikan soal berikut!</p>
                                    <div class="bg-white rounded-3 shadow-sm border mb-3 py-3 d-flex justify-content-center overflow-hidden">
                                        <img src="/images/contoh_soal_istimewa_2.png" class="img-fluid w-50" alt="Contoh 2">
                                    </div>
                                    <div class="text-justify mb-2">
                                        <p class="text-muted small mb-2">
                                            Diketahui \(\Delta ABC\) Siku-siku di \(C\) dengan \(\angle ABC = 30^\circ\) dan panjang \(BC = 15 \text{ cm}\). Tentukan panjang AC!
                                        </p>
                                    </div>  
                                    
                                    <div class="border-start border-3 ps-2 mb-2">
                                        <strong class="text-success small">Diketahui:</strong>
                                        <ul class="mb-0 mt-0 text-muted small ps-3">
                                            <li>Panjang \(BC = 15 \text{ cm}\)</li>
                                            <li>\(\angle ABC = 30^\circ\)</li>
                                            <li>Siku-siku di \(C\)</li>
                                        </ul>
                                    </div> 
                                    
                                    <div class="border-0 border-start border-warning border-3 ps-2 mb-3">
                                        <strong class="text-warning small">Ditanya:</strong>
                                        <p class="mb-0 text-muted small">Panjang AC = ...? </p>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="card bg-light border-0 rounded-3">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-2">Langkah Penyelesaian:</h6>
                                            <ol class="mb-0 list-group-numbered-custom small text-muted">
                                                <li class="mb-2">
                                                    <strong>Gunakan perbandingan segitiga istimewa 30&deg;-60&deg;-90&deg;:</strong><br>
                                                    Tuliskan perbandingan sisi yang saling berhadapan dengan sudutnya:
                                                    <div class="mt-2">
                                                        $$
                                                        \begin{aligned}
                                                        \text{sisi di depan } 30^\circ : \text{sisi di depan } 60^\circ : \text{sisi miring} &= 1 : \sqrt{3} : 2 \\
                                                        \frac{\text{sisi di depan } 30^\circ}{\text{sisi di depan } 60^\circ} &= \frac{1}{\sqrt{3}} \\
                                                        \frac{AC}{BC} &= \frac{1}{\sqrt{3}}
                                                        \end{aligned}
                                                        $$
                                                    </div>
                                                </li>  
                                                <li>
                                                    <strong>Masukkan nilai yang diketahui dan hitung panjang AC:</strong><br>
                                                    Pindahkan ruas untuk mencari AC, lalu masukkan nilai BC = 15 cm:
                                                    <div class="mt-2 mb-2">
                                                        $$
                                                        \begin{aligned}
                                                        AC &= \frac{BC}{\sqrt{3}} \\
                                                        AC &= \frac{15}{\sqrt{3}}
                                                        \end{aligned}
                                                        $$
                                                    </div>
                                                    Rasionalkan bentuk akarnya dengan mengalikan pembilang dan penyebut dengan \(\sqrt{3}\):
                                                    <div class="mt-2">
                                                        $$
                                                        \begin{aligned}
                                                        AC &= \frac{15}{\sqrt{3}} \times \frac{\sqrt{3}}{\sqrt{3}} \\
                                                        AC &= \frac{15\sqrt{3}}{3} \\
                                                        AC &= 5\sqrt{3}
                                                        \end{aligned}
                                                        $$
                                                    </div>
                                                </li>
                                            </ol>
                                            <div class="alert alert-success d-flex align-items-center small mt-3 mb-0">
                                                <div>
                                                    <strong>Jadi,</strong> panjang AC adalah <strong>\(5\sqrt{3} \text{ cm}\)</strong>.
                                                </div> 
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
    </section>

    <!-- ================= HALAMAN 3 ================= -->
    <section class="materi-page d-none" data-page="2">
        <div class="card shadow-sm mb-4">
            <div class="card-header text-center border-bottom">
                <h4>Ayo Berlatih</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-white shadow-sm border-start border-success border-4">
                    <h6 class="fw-bold">Petunjuk Pengerjaan:</h6>
                    <ul class="mb-0 small text-muted">
                        <li>Perhatikan gambar dan angka yang diketahui di sebelah kiri.</li>
                        <li>Isi kotak-kotak kosong pada langkah penyelesaian di sebelah kanan.</li>
                        <li>Klik tombol <strong>Cek Jawaban</strong> di setiap nomor untuk memeriksa hasilmu.</li>
                    </ul>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0 fw-bold">Soal 1</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 mb-3">
                                <p class="text-muted fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 border mb-3 d-flex justify-content-center">
                                    <img src="/images/latihan_istimewa_1.png" class="img-fluid p-2" style="max-height: 250px;" alt="Soal 1">
                                </div>
                                <p>Segitiga siku-siku &Delta;ABC memiliki sudut siku-siku di C. Jika panjang salah satu sisi siku-siku AC = 10 cm, tentukan panjang sisi miring AB!</p>
                                
                                <div class="border-start border-3 ps-3 mb-3">
                                    <strong class="text-success small d-block mb-1">Diketahui:</strong>
                                    <ul class="mb-0 mt-0 text-muted small ps-3">
                                        <li>&ang;C = <strong>90&deg;</strong></li>
                                        <li>&ang;A = <strong>45&deg;</strong></li>
                                        <li>AC = <strong>10 cm</strong></li>
                                    </ul>
                                </div>

                                <div class="border-start border-warning border-3 ps-3">
                                    <strong class="text-warning small d-block mb-1">Ditanya:</strong>
                                    <p class="mb-0 text-muted small">Panjang sisi miring AB = ... ?</p>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="card bg-light border-0 rounded-3 h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-dark">Langkah Penyelesaian:</h6>
                                        
                                        <ol class="ps-3 mb-0 text-muted list-group-numbered-custom">
                                            <li class="mb-4">
                                                <strong>Mencari panjang sisi miring (AB):</strong>
                                                <p class="text-muted mb-3 mt-2">
                                                    Pada segitiga siku-siku 45&deg; &ndash; 45&deg; &ndash; 90&deg;, perbandingan panjang sisi-sisinya adalah:<br>
                                                    <strong>sisi siku-siku : sisi miring = 1 : &radic;2</strong><br>
                                                    <br>
                                                    Artinya, kedua sisi siku-siku sama panjang, dan sisi miring adalah:<br>
                                                    <span class="fst-italic text-dark">sisi miring = sisi siku-siku &times; &radic;2</span>
                                                </p>
                                                
                                                <div class="p-3 bg-white border rounded shadow-sm">
                                                    <div class="d-flex align-items-center gap-2 mb-3">
                                                        <span class="fw-bold text-dark">AB = AC &times; &radic;2</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2 mb-3">
                                                        <span class="text-dark">AB =</span>
                                                        <input type="number" id="s1_inp_ac" class="form-control form-control-sm text-center bg-white" style="width:70px;" placeholder="...">
                                                        <span class="text-dark">&times; &radic;2</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="text-dark">AB =</span>
                                                        <input type="number" id="s1_final" class="form-control form-control-sm text-center bg-white fw-bold text-success border-success" style="width:90px;" placeholder="...">
                                                        <span class="fw-bold text-dark">&radic;2 cm</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>

                                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                            <div id="s1_feedback" class="small fw-bold text-success"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekSoal1()">
                                                Cek Jawaban
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0 fw-bold">Soal 2</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 mb-1">
                                <p class="text-muted fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 border mb-1 d-flex justify-content-center">
                                    <img src="/images/latihan_istimewa_2.png" class="img-fluid p-2" style="max-height:250px;" alt="Soal 2">
                                </div>
                                <p>Segitiga &Delta;EFG di bawah ini dengan siku siku di G, &ang;E = 60&deg; dan EF = 25 cm. Tentukan Panjang EG!</p>

                                <div class="border-start border-3 ps-3 mb-1">
                                    <strong class="text-success small d-block mb-1">Diketahui:</strong>
                                    <ul class="mb-0 text-muted small ps-3">
                                        <li>EF = <strong>25 cm</strong></li>
                                        <li>&ang;E = <strong>60&deg;</strong></li>
                                    </ul>
                                </div>
                                <div class="border-start border-warning border-3 ps-3">
                                    <strong class="text-warning small d-block mb-1">Ditanya:</strong>
                                    <p class="mb-0 text-muted small">Panjang EG = ... ?</p>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="card bg-light border-0 rounded-3 h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-1 text-dark">Langkah Penyelesaian:</h6>

                                        <ol class="ps-3 mb-0 text-muted list-group-numbered-custom">
                                            <li class="mb-4">
                                                <strong>Mencari panjang sisi EG:</strong>
                                                <p class="text-muted mb-1 mt-2">
                                                    Perbandingan sisi pada segitiga siku-siku dengan sudut khusus 30&deg; &ndash; 60&deg; &ndash; 90&deg; adalah:<br>
                                                    <strong>sisi di depan 30&deg; : sisi di depan 60&deg; : sisi miring = 1 : &radic;3 : 2</strong>
                                                </p>

                                                <div class="p-3 bg-white border rounded shadow-sm">
                                                    
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <div class="d-inline-flex flex-column align-items-center align-middle">
                                                            <span class="px-2 border-bottom border-dark text-dark">sisi di depan 30&deg;</span>
                                                            <span class="px-2 text-dark">sisi miring</span>
                                                        </div>
                                                        <span class="fw-bold text-dark">=</span>
                                                        <div class="d-inline-flex flex-column align-items-center align-middle">
                                                            <input type="number" id="s2_r1_top" class="form-control form-control-sm text-center px-1 py-0 mb-1" style="width: 45px; height: 26px;" placeholder="...">
                                                            <div class="border-top border-dark w-100"></div>
                                                            <input type="number" id="s2_r1_bot" class="form-control form-control-sm text-center px-1 py-0 mt-1" style="width: 45px; height: 26px;" placeholder="...">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <div class="d-inline-flex flex-column align-items-center align-middle">
                                                            <span class="px-2 border-bottom border-dark text-dark">EG</span>
                                                            <span class="px-2 text-dark">EF</span>
                                                        </div>
                                                        <span class="fw-bold text-dark">=</span>
                                                        <div class="d-inline-flex flex-column align-items-center align-middle">
                                                            <input type="number" id="s2_r2_top" class="form-control form-control-sm text-center px-1 py-0 mb-1" style="width: 45px; height: 26px;" placeholder="...">
                                                            <div class="border-top border-dark w-100"></div>
                                                            <input type="number" id="s2_r2_bot" class="form-control form-control-sm text-center px-1 py-0 mt-1" style="width: 45px; height: 26px;" placeholder="...">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <span class="text-dark">EG = EF &times;</span>
                                                        <div class="d-inline-flex flex-column align-items-center align-middle">
                                                            <input type="number" id="s2_r3_top" class="form-control form-control-sm text-center px-1 py-0 mb-1" style="width: 45px; height: 26px;" placeholder="...">
                                                            <div class="border-top border-dark w-100"></div>
                                                            <input type="number" id="s2_r3_bot" class="form-control form-control-sm text-center px-1 py-0 mt-1" style="width: 45px; height: 26px;" placeholder="...">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <span class="text-dark">EG =</span>
                                                        <input type="number" id="s2_inp_ef" class="form-control form-control-sm text-center bg-white" style="width:70px;" placeholder="...">
                                                        <span class="text-dark">&times;</span>
                                                        <div class="d-inline-flex flex-column align-items-center align-middle">
                                                            <input type="number" id="s2_r4_top" class="form-control form-control-sm text-center px-1 py-0 mb-1" style="width: 45px; height: 26px;" placeholder="...">
                                                            <div class="border-top border-dark w-100"></div>
                                                            <input type="number" id="s2_r4_bot" class="form-control form-control-sm text-center px-1 py-0 mt-1" style="width: 45px; height: 26px;" placeholder="...">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="text-dark">EG =</span>
                                                        <input type="number" step="any" id="s2_final" class="form-control form-control-sm text-center bg-white fw-bold text-success border-success" style="width:90px;" placeholder="...">
                                                        <span class="fw-bold text-dark">cm</span>
                                                    </div>

                                                </div>
                                            </li>
                                        </ol>
                                        
                                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                            <div id="s2_feedback" class="small fw-bold text-success"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekSoal2()">
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

    <!-- ================= HALAMAN 4 ================= -->
    <section class="materi-page d-none" data-page="3">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>Rangkuman Segitiga Istimewa</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Segitiga siku-siku 45°-45°-90°: perbandingan sisi = 1 : 1 : √2.</li>
                            <li>Segitiga siku-siku 30°-60°-90°: perbandingan sisi = 1 : √3 : 2.</li>
                            <li>Rumus-rumus ini memudahkan perhitungan panjang sisi tanpa menggunakan teorema Pythagoras secara langsung.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Refleksi</h4>
                        <small class="text-muted">Jawablah berdasarkan pemahamanmu</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="fw-semibold mb-2">1. Apakah perbandingan sisi pada segitiga istimewa selalu tetap? Jelaskan.</label>
                            <textarea class="form-control" rows="3" id="ref_istimewa_1" placeholder="Tulis penjelasanmu..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="fw-semibold mb-2">2. Berikan contoh penerapan segitiga istimewa dalam kehidupan sehari-hari.</label>
                            <textarea class="form-control" rows="3" id="ref_istimewa_2" placeholder="Tulis contohnya..."></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-success fw-bold" onclick="simpanRefleksiIstimewa()">Simpan Refleksi</button>
                        </div>
                        <div class="text-center mt-4">
                            <p>Setelah mempelajari materi ini, silakan kerjakan kuis untuk menguji pemahamanmu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pagination Navigasi (bawah) -->
    <nav>
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

<!-- Script untuk interaktivitas -->
<script>

// Fungsi untuk mengecek latihan soal pilihan ganda
function cekLatihanIstimewa() {
    // Kunci jawaban
    const kunci = {
        soal1: '6',
        soal2: '5,5',
        soal3: '8√3,16',
        soal4: '18',
        soal5: '4√3'
    };

    // Reset semua feedback
    document.querySelectorAll('.feedback-soal').forEach(el => el.innerHTML = '');

    // Periksa setiap soal
    for (let i = 1; i <= 5; i++) {
        let soalName = 'soal' + i;
        let selected = document.querySelector('input[name="' + soalName + '"]:checked');
        let feedbackDiv = document.querySelector('#soal' + i + ' .feedback-soal');
        if (!selected) {
            feedbackDiv.innerHTML = '<span class="text-warning">⚠️ Belum dijawab</span>';
            continue;
        }
        let jawaban = selected.value;
        if (jawaban === kunci[soalName]) {
            feedbackDiv.innerHTML = '<span class="text-success">✔️ Benar</span>';
            // Beri warna hijau pada card
            document.querySelector('#soal' + i).classList.add('border-success');
        } else {
            feedbackDiv.innerHTML = '<span class="text-danger">❌ Salah. Coba lagi!</span>';
            document.querySelector('#soal' + i).classList.add('border-danger');
        }
    }
}

// Fungsi simpan refleksi (hanya alert untuk demo)
function simpanRefleksiIstimewa() {
    let jawaban1 = document.getElementById('ref_istimewa_1').value;
    let jawaban2 = document.getElementById('ref_istimewa_2').value;
    if (jawaban1.trim() === '' || jawaban2.trim() === '') {
        alert('Harap isi kedua kolom refleksi.');
    } else {
        alert('Refleksi berhasil disimpan. Terima kasih!');
    }
}

document.addEventListener('DOMContentLoaded', function() {

let attemptSoal1 = 0;
let attemptSoal2 = 0;
const maxAttempts = 3;

// semua kode soal kamu di sini

});

// Kunci Jawaban Soal 1
const jawabanSoal1 = {
    's1_inp_ac': '10',
    's1_final': '10'
};

// Kunci Jawaban Soal 2
const jawabanSoal2 = {
    's2_r1_top': '1', 's2_r1_bot': '2',
    's2_r2_top': '1', 's2_r2_bot': '2',
    's2_r3_top': '1', 's2_r3_bot': '2',
    's2_inp_ef': '25',
    's2_r4_top': '1', 's2_r4_bot': '2',
    's2_final': '12.5' // Validasi di bawah akan menangani penulisan koma (12,5)
};

// Fungsi bantuan untuk mengecek apakah ada input yang kosong
function cekAdaKosong(inputs) {
    return inputs.some(input => input.value.trim() === "");
}

// Fungsi bantuan untuk memberi warna hijau (benar) atau merah (salah)
function setWarnaInput(input, isCorrect) {
    // Hapus kelas warna sebelumnya
    input.classList.remove("border-success", "text-success", "border-danger", "text-danger");
    
    // Tambahkan kelas baru berdasarkan kebenaran jawaban
    if (isCorrect) {
        input.classList.add("border-success", "text-success");
    } else {
        input.classList.add("border-danger", "text-danger");
    }
}

// Fungsi Validasi Soal 1
function cekSoal1() {
    const inputElements = Object.keys(jawabanSoal1).map(id => document.getElementById(id));
    
    // Cek jika belum diisi atau ada yang kosong
    if (cekAdaKosong(inputElements)) {
        Swal.fire({
            title: 'Perhatian',
            text: 'Harap lengkapi semua kotak jawaban terlebih dahulu.',
            icon: 'warning',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptSoal1++;
    let semuaBenar = true;

    // Periksa setiap inputan
    inputElements.forEach(input => {
        let userVal = input.value.trim();
        let isCorrect = userVal === jawabanSoal1[input.id];
        
        setWarnaInput(input, isCorrect);
        if (!isCorrect) semuaBenar = false;
    });

    // Hasil Evaluasi
    if (semuaBenar) {
        Swal.fire({
            title: 'Tepat Sekali',
            text: 'Seluruh tahapan penyelesaian Soal 1 sudah benar.',
            icon: 'success',
            confirmButtonColor: '#198754'
        });
        document.getElementById('s1_feedback').innerText = "Jawaban Benar";
    } else {
        if (attemptSoal1 >= maxAttempts) {
            Swal.fire({
                title: 'Kesempatan Habis',
                text: 'Jawaban Anda masih ada yang kurang tepat. Ingin melihat jawaban yang benar?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Tampilkan Jawaban',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan jawaban
                    inputElements.forEach(input => {
                        input.value = jawabanSoal1[input.id];
                        setWarnaInput(input, true);
                    });
                    document.getElementById('s1_feedback').innerText = "Jawaban telah ditampilkan.";
                }
            });
        } else {
            let sisa = maxAttempts - attemptSoal1;
            Swal.fire({
                title: 'Kurang Tepat',
                text: `Masih ada kotak yang salah (warna merah). Sisa kesempatan menjawab: ${sisa} kali.`,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    }
}

// Fungsi Validasi Soal 2
function cekSoal2() {
    const inputElements = Object.keys(jawabanSoal2).map(id => document.getElementById(id));
    
    // Cek jika belum diisi atau ada yang kosong
    if (cekAdaKosong(inputElements)) {
        Swal.fire({
            title: 'Perhatian',
            text: 'Harap lengkapi semua kotak jawaban terlebih dahulu.',
            icon: 'warning',
            confirmButtonColor: '#198754'
        });
        return;
    }

    attemptSoal2++;
    let semuaBenar = true;

    // Periksa setiap inputan
    inputElements.forEach(input => {
        let userVal = input.value.trim();
        let isCorrect = false;

        // Khusus untuk s2_final, kita izinkan format titik (12.5) maupun koma (12,5)
        if (input.id === 's2_final') {
            userVal = userVal.replace(',', '.'); // ubah koma jadi titik agar seragam
            isCorrect = userVal === jawabanSoal2[input.id];
        } else {
            isCorrect = userVal === jawabanSoal2[input.id];
        }
        
        setWarnaInput(input, isCorrect);
        if (!isCorrect) semuaBenar = false;
    });

    // Hasil Evaluasi
    if (semuaBenar) {
        Swal.fire({
            title: 'Tepat Sekali',
            text: 'Seluruh tahapan penyelesaian Soal 2 sudah benar.',
            icon: 'success',
            confirmButtonColor: '#198754'
        });
        document.getElementById('s2_feedback').innerText = "Jawaban Benar";
    } else {
        if (attemptSoal2 >= maxAttempts) {
            Swal.fire({
                title: 'Kesempatan Habis',
                text: 'Jawaban Anda masih ada yang kurang tepat. Ingin melihat jawaban yang benar?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Tampilkan Jawaban',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan jawaban
                    inputElements.forEach(input => {
                        // Untuk final result, kembalikan format koma jika Anda mau, atau pakai titik bawaan
                        input.value = (input.id === 's2_final') ? '12,5' : jawabanSoal2[input.id];
                        setWarnaInput(input, true);
                    });
                    document.getElementById('s2_feedback').innerText = "Jawaban telah ditampilkan.";
                }
            });
        } else {
            let sisa = maxAttempts - attemptSoal2;
            Swal.fire({
                title: 'Kurang Tepat',
                text: `Masih ada kotak yang salah (warna merah). Sisa kesempatan menjawab: ${sisa} kali.`,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    }
}


</script>

<!-- Tambahan CSS untuk feedback -->
<style>
    .soal-item {
        transition: all 0.2s;
    }
    .border-success {
        border: 2px solid #28a745 !important;
    }
    .border-danger {
        border: 2px solid #dc3545 !important;
    }
    .feedback-soal {
        font-weight: bold;
    }
</style>
@endsection