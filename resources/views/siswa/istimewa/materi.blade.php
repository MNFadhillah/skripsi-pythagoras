@extends('layouts.siswa')

@section('title', 'PythaLearn - Segitiga Istimewa')

@push('scripts')
<script>
    window.completedCheckpoints = JSON.parse('{!! json_encode($completedCheckpoints ?? []) !!}');
</script>
<script src="{{ asset('js/materi3.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container">
    <div class="row align-items-center mb-2">
        <div class="col-lg-12">
            <h3 class="text-center">Segitiga Istimewa</h3>
        </div>
    </div>

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

                <div class="card-header bg-light text-center">
                    <h4 class="mb-0">Segitiga Istimewa 45°, 45°, dan 90°</h4>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Segitiga siku-siku sama kaki adalah segitiga istimewa yang memiliki besar sudut 45°, 45°, dan 90°.
                                Pada segitiga \(ABC\), sisi \(AB\) dan \(BC\) merupakan sisi siku-siku dengan panjang yang sama, misalnya \(a\).
                                Panjang sisi miring \(AC\) dapat ditentukan menggunakan Teorema Pythagoras sebagai berikut:
                            </p>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-4 text-md-end pe-md-4">
                            <img src="/images/segitiga_istimewa_1.png"
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
                            <p class="mb-2">Maka perbandingan yang memenuhi sisi segitiga istimewa 45°, 45°, dan 90°:</p>

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


                    <p class="mb-3 mt-3 text-dark">
                        Berdasarkan penjelasan sebelumnya tentang segitiga istimewa 45°, 45°, dan 90°, diketahui bahwa panjang sisi miring (hipotenusa) memiliki hubungan tertentu dengan panjang sisi siku-sikunya.
                        Untuk memahami pola tersebut, lakukan aktivitas <strong>Ayo Mengamati</strong> berikut.
                    </p>

                    <hr class="my-4">

                    <div class="text-center mb-2">
                        <h5 class="fw-bold text-success">Ayo Mengamati</h5>
                    </div>

                    <div class="alert alert-light shadow-sm border-start border-success border-4">
                        <div class="small">
                            <strong>Petunjuk Pengerjaan:</strong>
                            Lengkapi nilai pada tabel berikut dengan mengisi panjang sisi siku-siku dan sisi miring sesuai dengan hubungan yang berlaku pada segitiga siku-siku.
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <img src="/images/segitiga_istimewa_mengamati.png"
                            class="img-fluid"
                            style="max-height: 200px;">
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered text-center align-middle table-sm">

                            <thead class="table-light">
                                <tr>
                                    <th class="bg-light" style="width: 220px;">Sisi Siku-siku 1</th>

                                    <td class="bg-light">1</td>
                                    <td class="bg-light">2</td>
                                    <td class="bg-light">3</td>
                                    <td class="bg-light">4</td>
                                    <td class="bg-light">5</td>
                                    <td class="bg-light">6</td>
                                    <td class="bg-light">p</td>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <th class="bg-light">Sisi Siku-siku 2</th>

                                    <td class="bg-light">1</td>

                                    <td><input type="number" id="bc2" class="form-control form-control-sm text-center" style="width:70px; margin:auto;"></td>
                                    <td><input type="number" id="bc3" class="form-control form-control-sm text-center" style="width:70px; margin:auto;"></td>
                                    <td><input type="number" id="bc4" class="form-control form-control-sm text-center" style="width:70px; margin:auto;"></td>
                                    <td><input type="number" id="bc5" class="form-control form-control-sm text-center" style="width:70px; margin:auto;"></td>
                                    <td><input type="number" id="bc6" class="form-control form-control-sm text-center" style="width:70px; margin:auto;"></td>
                                    <td><input type="text" id="bcp" class="form-control form-control-sm text-center" style="width:70px; margin:auto;"></td>
                                </tr>

                                <tr>
                                    <th class="bg-light">Sisi Miring (Hipotenusa)</th>

                                    <td class="bg-light">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <span class="fw-bold">2</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <input type="number" id="h2_a" class="form-control form-control-sm text-center" style="width:55px;">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <input type="number" id="h2_b" class="form-control form-control-sm text-center" style="width:55px;">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <input type="number" id="h3_a" class="form-control form-control-sm text-center" style="width:55px;">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <input type="number" id="h3_b" class="form-control form-control-sm text-center" style="width:55px;">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <input type="number" id="h4_a" class="form-control form-control-sm text-center" style="width:55px;">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <input type="number" id="h4_b" class="form-control form-control-sm text-center" style="width:55px;">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <input type="number" id="h5_a" class="form-control form-control-sm text-center" style="width:55px;">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <input type="number" id="h5_b" class="form-control form-control-sm text-center" style="width:55px;">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <input type="number" id="h6_a" class="form-control form-control-sm text-center" style="width:55px;">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <input type="number" id="h6_b" class="form-control form-control-sm text-center" style="width:55px;">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <input type="text" id="h7_a" class="form-control form-control-sm text-center" style="width:55px;">
                                            <span class="fw-bold">\(\sqrt{}\)</span>
                                            <input type="number" id="h7_b" class="form-control form-control-sm text-center" style="width:55px;">
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-1 d-flex flex-column flex-md-row justify-content-between align-items-center border-top pt-3">
                        <div id="tab45_feedback" class="small fw-bold mb-3 mb-md-0"></div>
                        <div>
                            <button class="btn btn-success px-4 fw-bold shadow-sm me-2" onclick="cekTab45()">
                                Cek Jawaban
                            </button>
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
                            <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                                <div class="small">
                                    <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi gambar di bawah ini, kemudian lengkapi data yang diketahui dan selesaikan langkah perhitungannya dengan mengisi kotak yang kosong.
                                </div>
                            </div>

                            <div class="row mt-4">

                                <div class="col-md-5 mb-4 mb-md-0">
                                    <div class="text-justify mb-3">
                                        <p class="text-dark mb-0">
                                            Diketahui suatu segitiga siku-siku sama kaki \(\triangle ABC\) dengan \(\angle C = 90^\circ\) dan panjang hipotenusa \(AB = 15\sqrt{2}\) cm. Hitunglah panjang sisi siku-siku AC.
                                        </p>
                                    </div>

                                    <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                        <img src="{{ asset('images/contoh_soal_istimewa_1_454590.png') }}" class="img-fluid w-75" alt="Segitiga 45-45-90">
                                    </div>

                                    <div class="card border mb-4 shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Diketahui</h6>
                                        </div>
                                        <div class="card-body small">
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 150px;">Hipotenusa atau panjang AB =</span>
                                                <select id="c1i_dik_ab" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 90px;">
                                                    <option value=""></option>
                                                    <option value="15sqrt2">15&radic;2</option>
                                                    <option value="20sqrt2">20&radic;2</option>
                                                    <option value="25sqrt2">25&radic;2</option>
                                                </select>
                                                <span>cm.</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 150px;">Besar sudut A dan C = ...</span>
                                                <select id="c1i_dik_sudut" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                    <option value=""></option>
                                                    <option value="30">30&deg;</option>
                                                    <option value="45">45&deg;</option>
                                                    <option value="60">60&deg;</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Ditanya</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted small">
                                                Panjang Sisi Siku-siku AC adalah ... 
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                        </div>
                                        <div class="card-body bg-light">

                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">1. Tentukan Perbandingan Sisi</span>
                                                <div class="mt-2 text-muted mb-3">
                                                    Berdasarkan perbandingan segitiga istimewa \(45^\circ, 45^\circ, \) dan \(90^\circ\), perbandingan sisi di depan sudut tersebut berturut-turut adalah:
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <input type="number" id="c1i_rasio_45_1" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark">:</span>
                                                    <input type="number" id="c1i_rasio_45_2" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark">: \(\sqrt{}\)</span>
                                                    <input type="number" id="c1i_rasio_90" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>

                                                <div class="text-muted mb-2">Sehingga perbandingan sisi AC dan AB dapat dituliskan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                    <span class="fw-bold text-dark">AC : AB = </span>
                                                    <input type="number" id="c1i_perbandingan_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> : \(\sqrt{}\)</span>
                                                    <input type="number" id="c1i_perbandingan_bawah" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                            </div>

                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">2. Substitusi Nilai dan Kali Silang</span>
                                                <div class="mt-2 text-muted mb-3">Masukkan nilai hipotenusa (AB) yang diketahui ke dalam perbandingan:</div>

                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <span class="fw-bold text-dark">AC : </span>
                                                    <input type="number" id="c1i_sub_ab_angka" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark">\(\sqrt{2}\) = </span>
                                                    <input type="number" id="c1i_sub_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> : \(\sqrt{}\)</span>
                                                    <input type="number" id="c1i_sub_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>

                                                <div class="text-muted mb-2">Ubah bentuk perbandingan menjadi pecahan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">AC</div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <input type="number" id="c1i_pecahan_ab_angka" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                            <span class="fw-bold text-dark ms-1">\(\sqrt{2}\)</span>
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold text-dark">=</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1">
                                                            <input type="number" id="c1i_pecahan_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c1i_pecahan_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-muted mb-2">Selesaikan dengan perkalian silang:</div>
                                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                                    <span class="fw-bold text-dark">AC &times; \(\sqrt{}\)</span>
                                                    <input type="number" id="c1i_ks_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> = </span>
                                                    <input type="number" id="c1i_ks_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> &times; </span>
                                                    <input type="number" id="c1i_kali_silang_angka" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark">\(\sqrt{2}\)</span>
                                                </div>
                                            </div>

                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">3. Hitung Hasil Akhir</span>
                                                <div class="mt-2 text-muted mb-3">Pindahkan ruas untuk mencari panjang AC:</div>

                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <span class="fw-bold text-dark">AC = </span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 d-flex align-items-center justify-content-center px-2">
                                                            <input type="number" id="c1i_pindah_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                            <span class="ms-1 fw-bold text-dark">\(\sqrt{2}\)</span>
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c1i_pindah_bawah" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <span class="fw-bold text-dark">AC = </span>
                                                    <input type="number" id="c1i_hasil_hitung" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                            </div>

                                            <div class="p-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">4. Hasil akhir</span>
                                                <div class="alert alert-light border border-secondary d-flex flex-wrap justify-content-center align-items-center gap-2 mb-0 py-2">
                                                    <span class="text-dark">Jadi, panjang sisi AC adalah</span>
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" id="c1i_hasil_akhir" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                        <span class="ms-2 text-dark">cm.</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                                <div id="c1i_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                                <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh1Interaktif()">
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


        <section class="mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-center bg-light">
                            <h4 class="mb-0">Contoh 2</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                                <div class="small">
                                    <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi gambar di bawah ini, kemudian lengkapi data yang diketahui dan selesaikan langkah perhitungannya dengan mengisi kotak yang kosong.
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-5 mb-4 mb-md-0">
                                    <div class="text-justify mb-3">
                                        <p class="text-dark mb-0">
                                            Perhatikan gambar segitiga siku-siku di bawah ini! Tentukan panjang AB, apabila diketahui panjang AC = 20 cm.
                                        </p>
                                    </div>
                                    <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                        <img src="/images/contoh_soal_istimewa_1.png" class="img-fluid w-75" alt="Contoh 2">
                                    </div>
                                    <div class="card border mb-4 shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Diketahui</h6>
                                        </div>
                                        <div class="card-body small">
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 120px;">Panjang sisi miring AC =</span>
                                                <select id="c2_45_dik_ac" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                    <option value=""></option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                </select>
                                                <span>cm.</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 120px;">Besar sudut A dan C = ....</span>
                                                <select id="c2_45_dik_sudut" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                    <option value=""></option>
                                                    <option value="30">30&deg;</option>
                                                    <option value="45">45&deg;</option>
                                                    <option value="60">60&deg;</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Ditanya</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted small">
                                                Panjang sisi siku-siku AB.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                        </div>
                                        <div class="card-body bg-light">
                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">1. Tentukan Perbandingan Sisi</span>
                                                <div class="mt-2 text-muted mb-3">
                                                    Berdasarkan perbandingan segitiga istimewa \(45^\circ, 45^\circ, \) dan \(90^\circ\), perbandingan sisi di depan sudut tersebut berturut-turut adalah:
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <input type="number" id="c2_45_rasio_45_1" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark">:</span>
                                                    <input type="number" id="c2_45_rasio_45_2" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark">: \(\sqrt{}\)</span>
                                                    <input type="number" id="c2_45_rasio_90" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                                <div class="text-muted mb-2">Sehingga perbandingan sisi AB dan AC dapat dituliskan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                    <span class="fw-bold text-dark">AB : AC = \(\sqrt{}\)</span>
                                                    <input type="number" id="c2_45_perbandingan_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> : </span>
                                                    <input type="number" id="c2_45_perbandingan_bawah" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                            </div>
                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">2. Substitusi Nilai dan Pindah Ruas</span>
                                                <div class="mt-2 text-muted mb-3">Masukkan nilai sisi (AC) yang diketahui ke dalam perbandingan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <span class="fw-bold text-dark">AB : </span>
                                                    <input type="number" id="c2_45_sub_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> = \(\sqrt{}\)</span>
                                                    <input type="number" id="c2_45_sub_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> : </span>
                                                    <input type="number" id="c2_45_sub_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                                <div class="text-muted mb-2">Ubah bentuk perbandingan menjadi pecahan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">AB</div>
                                                        <div class="pt-1">
                                                            <input type="number" id="c2_45_pecahan_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold text-dark">=</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c2_45_pecahan_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1">
                                                            <input type="number" id="c2_45_pecahan_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-muted mb-2">Pindahkan ruas untuk mencari nilai sisi AB:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                    <span class="fw-bold text-dark">AB = </span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 d-flex align-items-center justify-content-center gap-1">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c2_45_pindah_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                            <span class="fw-bold text-dark">&times;</span>
                                                            <input type="number" id="c2_45_pindah_angka_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <input type="number" id="c2_45_pindah_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">3. Rasionalkan Bentuk Akar (Jika Perlu)</span>
                                                <div class="mt-2 text-muted mb-3">Kalikan pembilang dan penyebut dengan sekawannya:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-3">
                                                    <span class="fw-bold text-dark">AB = </span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2">
                                                            <input type="number" id="c2_45_ras_val_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c2_45_ras_val_bawah" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold text-dark">&times;</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c2_45_rasionalkan_atas" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c2_45_rasionalkan_bawah" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mt-4">
                                                    <span class="fw-bold text-dark">AB = </span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 d-flex align-items-center justify-content-center gap-1">
                                                            <input type="number" id="c2_45_hasil_pembilang_angka" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c2_45_hasil_pembilang_akar" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1">
                                                            <input type="number" id="c2_45_hasil_penyebut" class="form-control form-control-sm text-center border-secondary text-dark mx-auto" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">4. Hasil Akhir</span>
                                                <div class="alert alert-light border border-secondary d-flex flex-wrap justify-content-center align-items-center gap-2 mb-0 py-2">
                                                    <span class="text-dark">Jadi, panjang AB adalah</span>
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" id="c2_45_hasil_akhir_angka" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                        <span class="fw-bold text-dark ms-1 me-1">\(\sqrt{}\)</span>
                                                        <input type="number" id="c2_45_hasil_akhir_akar" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                        <span class="ms-2 text-dark">cm.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                                <div id="c2_45_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                                <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh2_45()">
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
    </section>

    <!-- Halaman 2 -->

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
                            <h4 class="mb-0">Contoh 1</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                                <div class="small">
                                    <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi gambar di bawah ini, kemudian lengkapi data yang diketahui dan selesaikan langkah perhitungannya dengan mengisi kotak yang kosong.
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-5 mb-4 mb-md-0">
                                    <div class="text-justify mb-3">
                                        <p class="text-dark mb-0">
                                            Perhatikan soal berikut! Diketahui \(\Delta ABC\) siku-siku di \(C\) dengan \(\angle ABC = 30^\circ\) dan panjang \(BC = 15 \text{ cm}\). Tentukan panjang AC!
                                        </p>
                                    </div>
                                    <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                        <img src="/images/contoh_soal_istimewa_2.png" class="img-fluid w-50" alt="Contoh 1">
                                    </div>
                                    <div class="card border mb-4 shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Diketahui</h6>
                                        </div>
                                        <div class="card-body small">
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 130px;">Panjang sisi siku-siku BC =</span>
                                                <select id="c1_30_dik_bc" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 100px;">
                                                    <option value=""></option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                </select>
                                                <span>cm.</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <span style="width: 130px;">Besar \(\angle ABC\) = ....</span>
                                                <select id="c1_30_dik_sudut" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 100px;">
                                                    <option value=""></option>
                                                    <option value="30">30&deg;</option>
                                                    <option value="45">45&deg;</option>
                                                    <option value="60">60&deg;</option>
                                                </select>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span style="width: 130px;">Siku-siku berada pada titik ....</span>
                                                <select id="c1_30_dik_siku" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 100px;">
                                                    <option value=""></option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-sm">
                                        <div class="card-header border-bottom bg-light">
                                            <h6 class="fw-bold mb-0 small text-dark">Ditanya</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted small">
                                                Panjang AC = ...?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                        </div>
                                        <div class="card-body bg-light">
                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">1. Tentukan Perbandingan Sisi</span>
                                                <div class="mt-2 text-muted mb-3">
                                                    Berdasarkan perbandingan segitiga istimewa \(30^\circ, 60^\circ, \) dan \(90^\circ\), perbandingan sisi di depan sudut tersebut berturut-turut adalah:
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <input type="number" id="c1_30_rasio_30" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 100px;" placeholder="...">
                                                    <span class="fw-bold text-dark">: \(\sqrt{}\)</span>
                                                    <input type="number" id="c1_30_rasio_60" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 100px;" placeholder="...">
                                                    <span class="fw-bold text-dark">:</span>
                                                    <input type="number" id="c1_30_rasio_90" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 100px;" placeholder="...">
                                                </div>
                                                <div class="text-muted mb-2">Sehingga perbandingan sisi AC dan BC dapat dituliskan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                    <span class="fw-bold text-dark">AC : BC = </span>
                                                    <input type="number" id="c1_30_perbandingan_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> : \(\sqrt{}\)</span>
                                                    <input type="number" id="c1_30_perbandingan_bawah" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                            </div>
                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">2. Substitusi Nilai dan Pindah Ruas</span>
                                                <div class="mt-2 text-muted mb-3">Masukkan nilai sisi (BC) yang diketahui ke dalam perbandingan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    <span class="fw-bold text-dark">AC : </span>
                                                    <input type="number" id="c1_30_sub_bc" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> = </span>
                                                    <input type="number" id="c1_30_sub_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark"> : \(\sqrt{}\)</span>
                                                    <input type="number" id="c1_30_sub_rasio_bc" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                                <div class="text-muted mb-2">Ubah bentuk perbandingan menjadi pecahan:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">AC</div>
                                                        <div class="pt-1">
                                                            <input type="number" id="c1_30_pecahan_bc" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold text-dark">=</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 d-flex align-items-center justify-content-center">
                                                            <input type="number" id="c1_30_pecahan_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c1_30_pecahan_rasio_bc" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-muted mb-2">Pindahkan ruas untuk mencari nilai sisi AC:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                    <span class="fw-bold text-dark">AC = </span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 d-flex align-items-center justify-content-center gap-1">
                                                            <input type="number" id="c1_30_pindah_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                            <span class="fw-bold text-dark">&times;</span>
                                                            <input type="number" id="c1_30_pindah_angka_bc" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c1_30_pindah_rasio_bc" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">3. Rasionalkan Bentuk Akar</span>
                                                <div class="mt-2 text-muted mb-3">Kalikan pembilang dan penyebut dengan sekawannya:</div>
                                                <div class="d-flex justify-content-center align-items-center gap-3">
                                                    <span class="fw-bold text-dark">AC =</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">15</div>
                                                        <div class="pt-1 d-flex align-items-center justify-content-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{3}\)</span>
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold text-dark px-1">&times;</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 d-flex align-items-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c1_30_rasional_atas" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                        <div class="pt-1 d-flex align-items-center">
                                                            <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                            <input type="number" id="c1_30_rasional_bawah" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center gap-2 mt-4">
                                                    <span class="fw-bold text-dark">AC =</span>
                                                    <div class="d-flex flex-column text-center">
                                                        <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">\(15\sqrt{3}\)</div>
                                                        <div class="pt-1">
                                                            <input type="number" id="c1_30_hasil_bagi" class="form-control form-control-sm text-center border-secondary text-dark mx-auto" style="width: 80px;" placeholder="...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                                <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">4. Hasil Akhir</span>
                                                <div class="alert alert-light border border-secondary d-flex flex-wrap justify-content-center align-items-center gap-2 mb-0 py-2">
                                                    <span class="text-dark">Jadi, panjang AC adalah</span>
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" id="c1_30_hasil_akhir_angka" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                        <span class="fw-bold text-dark ms-1 me-1">\(\sqrt{}\)</span>
                                                        <input type="number" id="c1_30_hasil_akhir_akar" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                        <span class="ms-2 text-dark">cm.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                                <div id="c1_30_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                                <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh1_30()">
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
    </section>

    <section class="materi-page d-none" data-page="2">
        <div class="card shadow-sm mb-4 border-1">
            <div class="card-header text-center bg-light">
                <h4>Ayo Berlatih</h4>
            </div>
            <div class="card-body bg-white">

                <div class="alert alert-light shadow-sm border-start border-success border-4 mb-4">
                    <h6 class="fw-bold">Petunjuk Pengerjaan:</h6>
                    <ul class="mb-0 small text-muted">
                        <li>Perhatikan gambar dan angka yang diketahui di sebelah kiri.</li>
                        <li>Lengkapi data pada bagian <strong>Diketahui</strong> dan <strong>Ditanya</strong>.</li>
                        <li>Isi kotak-kotak kosong pada langkah penyelesaian di sebelah kanan.</li>
                        <li>Klik tombol <strong>Cek Jawaban</strong> di setiap nomor untuk memeriksa hasilmu.</li>
                    </ul>
                </div>

                <div class="card border-1 shadow-sm mb-4 border-top border-success border-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold text-success">Soal 1</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-lg-5 mb-4">
                                <p class="text-muted fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 border mb-3 d-flex justify-content-center overflow-hidden shadow-sm">
                                    <img src="/images/latihan_istimewa_1.png" class="img-fluid p-2" style="max-height: 200px;" alt="Soal 1">
                                </div>
                                <p class="small text-justify mb-4">Segitiga siku-siku \(\triangle ABC\) memiliki sudut siku-siku di \(C\). Jika panjang salah satu sisi siku-siku \(AC = 10\) cm, tentukan panjang sisi miring \(AB\)!</p>

                                <div class="card border mb-3 shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                    </div>
                                    <div class="card-body small py-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 100px;">Besar \(\angle C\):</span>
                                            <select id="s1_dik_c" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="45">45&deg;</option>
                                                <option value="60">60&deg;</option>
                                                <option value="90">90&deg;</option>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 100px;">Besar \(\angle A\):</span>
                                            <select id="s1_dik_a" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="30">30&deg;</option>
                                                <option value="45">45&deg;</option>
                                                <option value="60">60&deg;</option>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="width: 100px;">Panjang \(AC\):</span>
                                            <select id="s1_dik_ac" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                            </select>
                                            <span>cm</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center small text-muted">
                                            <span>Panjang sisi miring </span>
                                            <select id="s1_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="AB">AB</option>
                                                <option value="AC">AC</option>
                                                <option value="BC">BC</option>
                                            </select>
                                            <span> = ...?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light py-2 border-bottom">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body d-flex flex-column bg-light">

                                        <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-3 border-bottom border-secondary pb-2">1. Tentukan Perbandingan Sisi</span>

                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                <input type="number" id="s1_rasio_45_1" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                <span class="fw-bold text-dark">:</span>
                                                <input type="number" id="s1_rasio_45_2" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                <span class="fw-bold text-dark">: \(\sqrt{}\)</span>
                                                <input type="number" id="s1_rasio_90" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                <span class="fw-bold text-dark">AB : AC = </span>
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                    <input type="number" id="s1_perbandingan_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                </div>
                                                <span class="fw-bold text-dark"> : </span>
                                                <input type="number" id="s1_perbandingan_bawah" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">AB</div>
                                                    <div class="pt-1 fw-bold text-dark">AC</div>
                                                </div>
                                                <span class="fw-bold text-dark">=</span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 d-flex align-items-center justify-content-center">
                                                        <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                        <input type="number" id="s1_pecahan_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s1_pecahan_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-3 border-bottom border-secondary pb-2">2. Substitusi Nilai dan Pindah Ruas</span>

                                            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">AB</div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s1_pecahan_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                                <span class="fw-bold text-dark">=</span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 d-flex align-items-center justify-content-center">
                                                        <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                        <input type="number" id="s1_pecahan_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark ms-1" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s1_pecahan_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <span class="fw-bold text-dark">AB = </span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 px-2 d-flex align-items-center justify-content-center gap-1">
                                                        <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                        <input type="number" id="s1_pindah_rasio_ab" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        <span class="fw-bold text-dark">&times;</span>
                                                        <input type="number" id="s1_pindah_angka_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1 d-flex align-items-center justify-content-center">
                                                        <input type="number" id="s1_pindah_rasio_ac" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-3 border-bottom border-secondary pb-2">3. Hitung Hasil Akhir</span>

                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <span class="fw-bold text-dark">AB = </span>
                                                <input type="number" id="s1_hasil_hitung_angka" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                <span class="fw-bold text-dark">\(\sqrt{}\)</span>
                                                <input type="number" id="s1_hasil_hitung_akar" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                            </div>
                                        </div>

                                        <div class="p-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">4. Kesimpulan</span>
                                            <div class="alert alert-light border border-secondary d-flex flex-wrap justify-content-center align-items-center gap-2 mb-0 py-2">
                                                <span class="text-dark">Jadi, panjang sisi AB adalah</span>
                                                <div class="d-flex align-items-center">
                                                    <input type="number" id="s1_final_angka" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                    <span class="fw-bold text-dark ms-1 me-1">\(\sqrt{}\)</span>
                                                    <input type="number" id="s1_final_akar" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                    <span class="ms-2 text-dark">cm.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-3 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                            <div id="s1_feedback" class="small fw-bold"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekSoal1()">
                                                <i class="fas fa-check-circle me-1"></i> Cek Jawaban
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card border-1 shadow-sm border-top border-success border-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold text-success">Soal 2</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-lg-5 mb-4">
                                <p class="text-muted fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 border mb-3 d-flex justify-content-center overflow-hidden shadow-sm">
                                    <img src="/images/latihan_istimewa_2.png" class="img-fluid p-2" style="max-height:200px;" alt="Soal 2">
                                </div>
                                <p class="small text-justify mb-4">Segitiga \(\Delta EFG\) di bawah ini dengan siku-siku di \(G\), \(\angle E = 60^\circ\) dan \(EF = 25\) cm. Tentukan Panjang \(EG\)!</p>

                                <div class="card border mb-3 shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                    </div>
                                    <div class="card-body small py-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 100px;">Panjang \(EF\):</span>
                                            <select id="s2_dik_ef" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select>
                                            <span>cm</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 100px;">Besar \(\angle E\):</span>
                                            <select id="s2_dik_e" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="30">30&deg;</option>
                                                <option value="45">45&deg;</option>
                                                <option value="60">60&deg;</option>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="width: 100px;">Siku-siku di:</span>
                                            <select id="s2_dik_siku" class="form-select form-select-sm text-center border-secondary mx-2 text-dark" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="E">Titik E</option>
                                                <option value="F">Titik F</option>
                                                <option value="G">Titik G</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center small text-muted">
                                            <span>Panjang sisi </span>
                                            <select id="s2_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width: 80px;">
                                                <option value=""></option>
                                                <option value="EF">EF</option>
                                                <option value="EG">EG</option>
                                                <option value="FG">FG</option>
                                            </select>
                                            <span> = ...?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light py-2 border-bottom">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body d-flex flex-column bg-light">

                                        <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-3 border-bottom border-secondary pb-2">1. Analisis Sudut dan Perbandingan Sisi</span>

                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                <input type="number" id="s2_rasio_30" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                <span class="fw-bold text-dark">: \(\sqrt{}\)</span>
                                                <input type="number" id="s2_rasio_60" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                <span class="fw-bold text-dark">:</span>
                                                <input type="number" id="s2_rasio_90" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                <span class="fw-bold text-dark">EG : EF = </span>
                                                <input type="number" id="s2_perbandingan_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                <span class="fw-bold text-dark"> : </span>
                                                <input type="number" id="s2_perbandingan_bawah" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">EG</div>
                                                    <div class="pt-1 fw-bold text-dark">EF</div>
                                                </div>
                                                <span class="fw-bold text-dark">=</span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1">
                                                        <input type="number" id="s2_pecahan_rasio_eg" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s2_pecahan_rasio_ef" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-3 border-bottom border-secondary pb-2">2. Substitusi Nilai dan Pindah Ruas</span>

                                            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 px-2 fw-bold text-dark">EG</div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s2_pecahan_ef" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                                <span class="fw-bold text-dark">=</span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1">
                                                        <input type="number" id="s2_pecahan_rasio_eg" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s2_pecahan_rasio_ef" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <span class="fw-bold text-dark">EG = </span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1 px-2 d-flex align-items-center justify-content-center gap-1">
                                                        <input type="number" id="s2_pindah_rasio_eg" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                        <span class="fw-bold text-dark">&times;</span>
                                                        <input type="number" id="s2_pindah_ef" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1 d-flex align-items-center justify-content-center">
                                                        <input type="number" id="s2_pindah_rasio_ef" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-3 border-bottom border-secondary pb-2">3. Hitung Hasil Akhir</span>

                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <span class="fw-bold text-dark">EG = </span>
                                                <div class="d-flex flex-column text-center">
                                                    <div class="border-bottom border-dark pb-1">
                                                        <input type="number" id="s2_hasil_hitung_atas" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                    <div class="pt-1">
                                                        <input type="number" id="s2_hasil_hitung_bawah" class="form-control form-control-sm text-center border-secondary text-dark" style="width: 80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3 bg-white border border-secondary rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom border-secondary pb-2">4. Kesimpulan</span>
                                            <div class="alert alert-light border border-secondary d-flex flex-wrap justify-content-center align-items-center gap-2 mb-0 py-2">
                                                <span class="text-dark">Jadi, panjang sisi EG adalah</span>
                                                <div class="d-flex align-items-center">
                                                    <input type="number" step="any" id="s2_final" class="form-control form-control-sm text-center fw-bold text-dark border-secondary shadow-sm" style="width: 80px;" placeholder="...">
                                                    <span class="ms-2 text-dark">cm.</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-3 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                            <div id="s2_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                            <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekSoal2()">
                                                <i class="fas fa-check-circle me-1"></i> Cek Jawaban
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

    <section class="materi-page d-none" data-page="3">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">

                    <div class="card-header text-center">
                        <h4>Rangkuman</h4>
                    </div>

                    <div class="card-body p-4 bg-white">

                        <!-- Poin 1 -->
                        <div class="d-flex align-items-start mb-4">

                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"
                                style="width: 32px; height: 32px; font-size: 1rem;">
                                1
                            </div>

                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Perbandingan Segitiga Istimewa</strong><br>

                                    Pada teorema Pythagoras, jika hanya satu sisi segitiga siku-siku yang diketahui,
                                    kita bisa menentukan panjang sisi lainnya menggunakan
                                    <strong>perbandingan tetap</strong> pada segitiga istimewa
                                    (\(45^\circ\),\(45^\circ\), dan \(90^\circ\) serta
                                    \(30^\circ\), \(60^\circ\), dan \(90^\circ\)),
                                    tanpa perlu menghitung kuadrat dan akar.
                                </p>
                            </div>

                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <!-- Poin 2 -->
                        <div class="d-flex align-items-start mb-4">

                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"
                                style="width: 32px; height: 32px; font-size: 1rem;">
                                2
                            </div>

                            <div class="ms-3 w-100">

                                <div class="row align-items-center">

                                    <div class="col-md-7">
                                        <p class="text-muted mb-0" style="line-height: 1.6;">
                                            <strong>Segitiga siku-siku \(45^\circ\), \(45^\circ\), dan \(90^\circ\)</strong><br>

                                            Perbandingan sisi :
                                            <strong>\(1 : 1 : \sqrt{2}\)</strong>
                                        </p>
                                    </div>

                                    <div class="col-md-5 text-center">
                                        <img src="/images/segitiga_istimewa_1.png"
                                            alt="Segitiga 45-45-90"
                                            class="img-fluid"
                                            style="max-height: 150px;">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <!-- Poin 3 -->
                        <div class="d-flex align-items-start">

                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"
                                style="width: 32px; height: 32px; font-size: 1rem;">
                                3
                            </div>

                            <div class="ms-3 w-100">

                                <div class="row align-items-center">

                                    <div class="col-md-7">
                                        <p class="text-muted mb-0" style="line-height: 1.6;">
                                            <strong>Segitiga siku-siku \(30^\circ\), \(60^\circ\), dan \(90^\circ\)</strong><br>

                                            Perbandingan sisi :
                                            <strong>\(1 : \sqrt{3} : 2\)</strong>
                                        </p>
                                    </div>

                                    <div class="col-md-5 text-center">
                                        <img src="/images/pembuktian_30_60_90.png"
                                            alt="Segitiga 30-60-90"
                                            class="img-fluid"
                                            style="max-height: 150px;">
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
                        <h4 class="mb-0">Refleksi Belajar</h4>
                        <small class="text-muted">Jawablah jujur sesuai pemahaman dan imajinasimu hari ini!</small>
                    </div>

                </div>
            </div>
        </div>
    </section>

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
        's2_r1_top': '1',
        's2_r1_bot': '2',
        's2_r2_top': '1',
        's2_r2_bot': '2',
        's2_r3_top': '1',
        's2_r3_bot': '2',
        's2_inp_ef': '25',
        's2_r4_top': '1',
        's2_r4_bot': '2',
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