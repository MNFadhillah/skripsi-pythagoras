@extends('layouts.siswa')

@section('title', 'PythaLearn - Penerapan Teorema Pythagoras')

@section('content')
<div class="container">
    <!-- Judul Halaman -->
    <div class="row align-items-center mb-2">
        <div class="col-lg-12">
            <h3 class="text-center">Penerapan Teorema Pythagoras</h3>
        </div>
    </div>

    <!-- Pagination Navigasi Atas -->
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
                <button class="page-link next-btn">›</button>
            </li>
        </ul>
    </nav>

    <!-- ================= HALAMAN 1 ================= -->
    <section class="materi-page" data-page="0">
        <!-- Tujuan Pembelajaran -->
        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Tujuan Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Peserta didik mampu menyelesaikan permasalahan dalam kehidupan sehari-hari terkait penerapan teorema Pythagoras.</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="mb-5">
            <div class="card shadow-sm border-1">
                <div class="card-header text-center py-3">
                    <h4 class="mb-0 fw-bold">Ayo Berlatih</h4>
                </div>
                
                <div class="card-body p-3">

                    <div class="mb-3 border border-success border-2 rounded p-3">
                        <h5 class="fw-bold text-dark">Petunjuk Pengerjaan</h5>
                        <ol class="mb-0 text-muted" style="padding-left: 1.2rem; line-height: 1.6;">
                            <li>Bacalah dengan cermat setiap soal tentang penerapan Teorema Pythagoras yang tersedia.</li>
                            <li>Untuk setiap soal, buatlah sketsa segitiga siku-siku sesuai konteksnya (misalnya jarak, ketinggian, atau posisi benda).</li>
                            <li>Isilah kolom kosong pada tiap soal dengan nilai hasil perhitungan yang kamu temukan dari sketsa percobaan.</li>
                            <li>Setelah mengisi seluruh kolom jawaban, klik tombol “Periksa Jawaban” untuk memeriksa hasil pengerjaanmu.</li>
                            <li>Jika jawaban benar, kotak jawaban akan berwarna hijau.</li>
                            <li>Jika jawaban kurang tepat, kotak akan berwarna merah, dan kamu perlu memperbaikinya hingga benar.</li>
                        </ol>
                    </div>

                    <div class="card border-1 shadow-sm mb-3">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0 fw-bold">Soal 1: Klotok di Sungai Barito</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-5 mb-4 mb-lg-0">
                                    <p class="text-muted small" style="text-align: justify; line-height: 1.6;">
                                        Pak Rahman mengemudikan klotok di Sungai Barito. Ia menyeberang sejauh 40 meter ke arah timur, namun karena arus, klotok juga terbawa ke selatan sejauh 30 meter. Tentukan jarak lurus yang ditempuh klotok dari titik awal ke titik akhir.
                                    </p>
                                    <img src="/images/ilustrasi_soal1.png" 
                                        alt="Segitiga" 
                                        class="img-fluid mb-3" 
                                        style="max-height: 240px; object-fit: contain; width: 100%;">
                                    <div class="border-start border-success border-3 ps-3 mb-3 mt-2">
                                        <strong class="text-success small d-block mb-1">Diketahui:</strong>
                                        <ul class="mb-0 mt-0 text-muted small ps-3">
                                            <li>Gerak timur (AB) = <strong>40 m</strong></li>
                                            <li>Gerak selatan (BC) = <strong>30 m</strong></li>
                                        </ul>
                                    </div>
                                    <div class="border-start border-warning border-3 ps-3">
                                        <strong class="text-warning small d-block mb-1">Ditanya:</strong>
                                        <p class="mb-0 text-muted small">Jarak lurus (AC) = ... ?</p>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="bg-light border-0 rounded-3 p-4 h-100">
                                        <h6 class="fw-bold mb-3 text-dark">Langkah Penyelesaian (Teorema Pythagoras):</h6>
                                        <p class="text-muted small mb-3">Pada segitiga siku-siku ABC, siku-siku di B. Maka:</p>
                                        <div class="p-3 bg-white border rounded shadow-sm">
                                            <div class="mb-3 text-center">
                                                <span class="fw-bold text-dark fs-5">AC² = AB² + BC²</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="text-dark fw-medium" style="width: 45px;">AB =</span>
                                                <input type="number" id="s1_ab" class="form-control form-control-sm text-center bg-white" style="width:80px;">
                                                <span class="text-muted small">meter</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="text-dark fw-medium" style="width: 45px;">BC =</span>
                                                <input type="number" id="s1_bc" class="form-control form-control-sm text-center bg-white" style="width:80px;">
                                                <span class="text-muted small">meter</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="text-dark fw-medium" style="width: 45px;">AC² =</span>
                                                <input type="number" id="s1_ac2" class="form-control form-control-sm text-center bg-white" style="width:100px;" readonly>
                                                <span class="text-muted small fst-italic">(otomatis)</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 pt-3 border-top">
                                                <span class="text-dark fw-bold" style="width: 45px;">AC =</span>
                                                <input type="number" id="s1_ac" class="form-control form-control-sm text-center bg-white fw-bold" style="width:80px;">
                                                <span class="fw-bold text-dark">meter</span>
                                            </div>
                                            <small class="text-muted d-block mt-3">*Isi AB, BC, dan AC. Kolom AC² akan terisi otomatis.</small>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-between align-items-center">
                                            <div id="s1_feedback" class="small fw-bold text-success"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded" onclick="cekSoal1()">
                                                Periksa Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-1 shadow-sm mb-3">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0 fw-bold">Soal 2: Tinggi Menara</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-5 mb-4 mb-lg-0">
                                    <p class="text-muted small" style="text-align: justify; line-height: 1.6;">
                                        Seorang siswa melihat puncak menara dengan jarak mendatar 24 meter dari kaki menara. Jika jarak garis pandang siswa ke puncak menara adalah 25 meter, tentukan tinggi menara tersebut!
                                    </p>
                                    <img src="/images/ilustrasi_soal2.png" 
                                        alt="Segitiga" 
                                        class="img-fluid mb-3" 
                                        style="max-height: 240px; object-fit: contain; width: 100%;">
                                    <div class="border-start border-success border-3 ps-3 mb-3">
                                        <strong class="text-success small d-block mb-1">Diketahui:</strong>
                                        <ul class="mb-0 mt-0 text-muted small ps-3">
                                            <li>Jarak mendatar (AB) = <strong>24 m</strong></li>
                                            <li>Garis pandang (AC) = <strong>25 m</strong></li>
                                        </ul>
                                    </div>
                                    <div class="border-start border-warning border-3 ps-3">
                                        <strong class="text-warning small d-block mb-1">Ditanya:</strong>
                                        <p class="mb-0 text-muted small">Tinggi menara (BC) = ... ?</p>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="bg-light border-0 rounded-3 p-4 h-100">
                                        <h6 class="fw-bold mb-3 text-dark">Langkah Penyelesaian:</h6>
                                        <p class="text-muted small mb-3">Pada segitiga siku-siku ABC, siku-siku di B. Maka:</p>
                                        <div class="p-3 bg-white border rounded shadow-sm">
                                            <div class="mb-3 text-center">
                                                <span class="fw-bold text-dark fs-5">BC² = AC² - AB²</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="text-dark fw-medium" style="width: 45px;">AB =</span>
                                                <input type="number" id="s2_ab" class="form-control form-control-sm text-center bg-white" style="width:80px;">
                                                <span class="text-muted small">meter</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="text-dark fw-medium" style="width: 45px;">AC =</span>
                                                <input type="number" id="s2_ac" class="form-control form-control-sm text-center bg-white" style="width:80px;">
                                                <span class="text-muted small">meter</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="text-dark fw-medium" style="width: 45px;">BC² =</span>
                                                <input type="number" id="s2_bc2" class="form-control form-control-sm text-center bg-white" style="width:100px;" readonly>
                                                <span class="text-muted small fst-italic">(otomatis)</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 pt-3 border-top">
                                                <span class="text-dark fw-bold" style="width: 45px;">BC =</span>
                                                <input type="number" id="s2_bc" class="form-control form-control-sm text-center bg-white fw-bold" style="width:80px;">
                                                <span class="fw-bold text-dark">meter</span>
                                            </div>
                                            <small class="text-muted d-block mt-3">*Isi AB, AC, dan BC. Kolom BC² otomatis.</small>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-between align-items-center">
                                            <div id="s2_feedback" class="small fw-bold text-success"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded" onclick="cekSoal2()">
                                                Periksa Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-1 shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0 fw-bold">Soal 3: Drone dan Dua Tenda</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-lg-5 mb-3">
                                    <p class="text-muted small" style="text-align: justify; line-height: 1.6;">
                                        Sebuah drone terbang pada ketinggian 15 meter. Dari posisi drone, operator melihat dua tenda, Tenda A dan Tenda B, yang berada dalam satu garis lurus di lapangan. Jarak pandang drone ke Tenda A adalah 25 meter, dan ke Tenda B adalah 17 meter. Berapakah jarak antara Tenda A dan Tenda B di permukaan lapangan?
                                    </p>
                                    <img src="/images/ilustrasi_soal3.png" 
                                        alt="Segitiga" 
                                        class="img-fluid mb-3" 
                                        style="max-height: 250px; object-fit: contain; width: 100%;"></ul>
                                    <div class="border-start border-success border-3 ps-3 mb-3">
                                        <strong class="text-success small d-block mb-1">Diketahui:</strong>
                                        <ul class="mb-0 mt-0 text-muted small ps-3">
                                            <li>Tinggi drone = <strong>15 m</strong></li>
                                            <li>Jarak pandang ke A = <strong>25 m</strong></li>
                                            <li>Jarak pandang ke B = <strong>17 m</strong></li>
                                        </ul>
                                    </div>
                                    <div class="border-start border-warning border-3 ps-3">
                                        <strong class="text-warning small d-block mb-1">Ditanya:</strong>
                                        <p class="mb-0 text-muted small">Jarak antara tenda A dan B (AB) = ... ?</p>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-lg-7">
                                    <div class="card bg-light border-0 rounded-3 h-100">
                                        <div class="card-body p-4">
                                            <h6 class="fw-bold mb-3 text-dark">Langkah Penyelesaian:</h6>
                                            <p class="text-muted small mb-3">Misal proyeksi drone di tanah adalah titik O. Maka OA dan OB adalah jarak horizontal ke tenda. Dengan Pythagoras:</p>
                                            <div class="p-3 bg-white border rounded shadow-sm">
                                                <div class="mb-3 text-center">
                                                    <span class="fw-bold text-dark">OA² = 25² - 15² &nbsp;&nbsp;&nbsp; OB² = 17² - 15²</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <span class="text-dark fw-medium" style="width: 190px;">Jarak horizontal ke A (OA) =</span>
                                                    <input type="number" id="s3_oa" class="form-control form-control-sm text-center bg-white" style="width:70px;">
                                                    <span class="text-muted small">meter</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <span class="text-dark fw-medium" style="width: 190px;">Jarak horizontal ke B (OB) =</span>
                                                    <input type="number" id="s3_ob" class="form-control form-control-sm text-center bg-white" style="width:70px;">
                                                    <span class="text-muted small">meter</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 pt-3 border-top">
                                                    <span class="text-dark fw-bold" style="width: 190px;">Jarak AB = |OA - OB| =</span>
                                                    <input type="number" id="s3_ab" class="form-control form-control-sm text-center bg-white fw-bold" style="width:70px">
                                                    <span class="fw-bold text-dark">meter</span>
                                                </div>
                                                <small class="text-muted d-block mt-3">*Kedua tenda berada di sisi yang sama dari drone, sehingga jaraknya selisih.</small>
                                            </div>
                                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                                <div id="s3_feedback" class="small fw-bold text-success"></div>
                                                <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded-pill" onclick="cekSoal3()">
                                                    Periksa Jawaban
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
    <!-- ================= HALAMAN 2 ================= -->
    <section class="materi-page d-none" data-page="1">
        <!-- Soal 3 (Drone) -->
        <section class="mb-4">
            
        </section>
    </section>

    <!-- ================= HALAMAN 3 ================= -->
    <section class="materi-page d-none" data-page="2">
        <!-- Rangkuman -->
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>Rangkuman</h4>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Teorema Pythagoras: pada segitiga siku-siku, kuadrat sisi miring sama dengan jumlah kuadrat sisi siku-sikunya.</li>
                            <li>Penerapan dalam kehidupan sehari-hari: menghitung jarak, tinggi, atau panjang lintasan yang tidak dapat diukur langsung.</li>
                            <li>Dalam soal-soal ini, kita menggunakan rumus Pythagoras untuk mencari jarak lurus (hipotenusa) atau salah satu sisi siku-siku.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Refleksi -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Refleksi</h4>
                        <small class="text-muted">Jawablah berdasarkan pemahamanmu</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="fw-semibold mb-2">1. Sebutkan contoh lain dalam kehidupan sehari-hari yang dapat diselesaikan dengan Teorema Pythagoras!</label>
                            <textarea class="form-control" rows="3" id="ref_1" placeholder="Tulis contohmu..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="fw-semibold mb-2">2. Menurutmu, apa manfaat mempelajari Teorema Pythagoras di luar sekolah?</label>
                            <textarea class="form-control" rows="3" id="ref_2" placeholder="Tulis pendapatmu..."></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-success fw-bold px-5 rounded-pill" onclick="simpanRefleksi()">Simpan Refleksi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pagination Navigasi Bawah -->
    <nav class="mt-4 mb-5">
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
                <button class="page-link next-btn">›</button>
            </li>
        </ul>
    </nav>
</div>

<!-- Script untuk interaktivitas -->
<script>
    // Variabel penghitung percobaan per soal
    let attemptSoal1 = 0;
    let attemptSoal2 = 0;
    let attemptSoal3 = 0;
    const maxAttempts = 3;

    // Fungsi bantu: cek apakah ada input kosong
    function cekAdaKosong(inputs) {
        return inputs.some(input => input.value.trim() === "");
    }

    // Fungsi bantu: set warna input (hijau jika benar, merah jika salah)
    function setWarnaInput(input, isCorrect) {
        input.classList.remove("border-success", "text-success", "border-danger", "text-danger");
        if (isCorrect) {
            input.classList.add("border-success", "text-success");
        } else {
            input.classList.add("border-danger", "text-danger");
        }
    }

    // ===== SOAL 1 =====
    function cekSoal1() {
        const ab = document.getElementById('s1_ab');
        const bc = document.getElementById('s1_bc');
        const ac = document.getElementById('s1_ac');
        const ac2 = document.getElementById('s1_ac2');

        // Hitung otomatis AC²
        let abVal = parseFloat(ab.value) || 0;
        let bcVal = parseFloat(bc.value) || 0;
        ac2.value = (abVal * abVal + bcVal * bcVal);

        const inputs = [ab, bc, ac];

        if (cekAdaKosong(inputs)) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Harap lengkapi semua kotak jawaban.',
                icon: 'warning',
                confirmButtonColor: '#198754'
            });
            return;
        }

        attemptSoal1++;
        const kunci = { ab: '40', bc: '30', ac: '50' };
        let semuaBenar = true;

        if (ab.value.trim() !== kunci.ab) { setWarnaInput(ab, false); semuaBenar = false; } else setWarnaInput(ab, true);
        if (bc.value.trim() !== kunci.bc) { setWarnaInput(bc, false); semuaBenar = false; } else setWarnaInput(bc, true);
        if (ac.value.trim() !== kunci.ac) { setWarnaInput(ac, false); semuaBenar = false; } else setWarnaInput(ac, true);

        if (semuaBenar) {
            Swal.fire({
                title: 'Benar!',
                text: 'Jawaban soal 1 tepat.',
                icon: 'success',
                confirmButtonColor: '#198754'
            });
            document.getElementById('s1_feedback').innerText = '✔️ Jawaban benar';
        } else {
            if (attemptSoal1 >= maxAttempts) {
                Swal.fire({
                    title: 'Kesempatan habis',
                    text: 'Ingin melihat jawaban yang benar?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Tampilkan',
                    cancelButtonText: 'Tutup',
                    confirmButtonColor: '#198754'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ab.value = kunci.ab; setWarnaInput(ab, true);
                        bc.value = kunci.bc; setWarnaInput(bc, true);
                        ac.value = kunci.ac; setWarnaInput(ac, true);
                        ac2.value = 2500;
                        document.getElementById('s1_feedback').innerText = 'Jawaban ditampilkan.';
                    }
                });
            } else {
                let sisa = maxAttempts - attemptSoal1;
                Swal.fire({
                    title: 'Kurang tepat',
                    text: `Masih ada kesalahan. Sisa percobaan: ${sisa}`,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    }

    // ===== SOAL 2 =====
    function cekSoal2() {
        const ab = document.getElementById('s2_ab');
        const ac = document.getElementById('s2_ac');
        const bc = document.getElementById('s2_bc');
        const bc2 = document.getElementById('s2_bc2');

        let abVal = parseFloat(ab.value) || 0;
        let acVal = parseFloat(ac.value) || 0;
        bc2.value = (acVal * acVal - abVal * abVal);

        const inputs = [ab, ac, bc];

        if (cekAdaKosong(inputs)) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Harap lengkapi semua kotak jawaban.',
                icon: 'warning',
                confirmButtonColor: '#198754'
            });
            return;
        }

        attemptSoal2++;
        const kunci = { ab: '24', ac: '25', bc: '7' };
        let semuaBenar = true;

        if (ab.value.trim() !== kunci.ab) { setWarnaInput(ab, false); semuaBenar = false; } else setWarnaInput(ab, true);
        if (ac.value.trim() !== kunci.ac) { setWarnaInput(ac, false); semuaBenar = false; } else setWarnaInput(ac, true);
        if (bc.value.trim() !== kunci.bc) { setWarnaInput(bc, false); semuaBenar = false; } else setWarnaInput(bc, true);

        if (semuaBenar) {
            Swal.fire({
                title: 'Benar!',
                text: 'Jawaban soal 2 tepat.',
                icon: 'success',
                confirmButtonColor: '#198754'
            });
            document.getElementById('s2_feedback').innerText = '✔️ Jawaban benar';
        } else {
            if (attemptSoal2 >= maxAttempts) {
                Swal.fire({
                    title: 'Kesempatan habis',
                    text: 'Ingin melihat jawaban yang benar?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Tampilkan',
                    cancelButtonText: 'Tutup',
                    confirmButtonColor: '#198754'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ab.value = kunci.ab; setWarnaInput(ab, true);
                        ac.value = kunci.ac; setWarnaInput(ac, true);
                        bc.value = kunci.bc; setWarnaInput(bc, true);
                        bc2.value = 49;
                        document.getElementById('s2_feedback').innerText = 'Jawaban ditampilkan.';
                    }
                });
            } else {
                let sisa = maxAttempts - attemptSoal2;
                Swal.fire({
                    title: 'Kurang tepat',
                    text: `Masih ada kesalahan. Sisa percobaan: ${sisa}`,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    }

    // ===== SOAL 3 =====
    function cekSoal3() {
        const oa = document.getElementById('s3_oa');
        const ob = document.getElementById('s3_ob');
        const ab = document.getElementById('s3_ab');

        const inputs = [oa, ob, ab];

        if (cekAdaKosong(inputs)) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Harap lengkapi semua kotak jawaban.',
                icon: 'warning',
                confirmButtonColor: '#198754'
            });
            return;
        }

        attemptSoal3++;
        const kunci = { oa: '20', ob: '8', ab: '12' };
        let semuaBenar = true;

        if (oa.value.trim() !== kunci.oa) { setWarnaInput(oa, false); semuaBenar = false; } else setWarnaInput(oa, true);
        if (ob.value.trim() !== kunci.ob) { setWarnaInput(ob, false); semuaBenar = false; } else setWarnaInput(ob, true);
        if (ab.value.trim() !== kunci.ab) { setWarnaInput(ab, false); semuaBenar = false; } else setWarnaInput(ab, true);

        if (semuaBenar) {
            Swal.fire({
                title: 'Benar!',
                text: 'Jawaban soal 3 tepat.',
                icon: 'success',
                confirmButtonColor: '#198754'
            });
            document.getElementById('s3_feedback').innerText = '✔️ Jawaban benar';
        } else {
            if (attemptSoal3 >= maxAttempts) {
                Swal.fire({
                    title: 'Kesempatan habis',
                    text: 'Ingin melihat jawaban yang benar?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Tampilkan',
                    cancelButtonText: 'Tutup',
                    confirmButtonColor: '#198754'
                }).then((result) => {
                    if (result.isConfirmed) {
                        oa.value = kunci.oa; setWarnaInput(oa, true);
                        ob.value = kunci.ob; setWarnaInput(ob, true);
                        ab.value = kunci.ab; setWarnaInput(ab, true);
                        document.getElementById('s3_feedback').innerText = 'Jawaban ditampilkan.';
                    }
                });
            } else {
                let sisa = maxAttempts - attemptSoal3;
                Swal.fire({
                    title: 'Kurang tepat',
                    text: `Masih ada kesalahan. Sisa percobaan: ${sisa}`,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    }

    // ===== REFLEKSI =====
    function simpanRefleksi() {
        const ref1 = document.getElementById('ref_1').value.trim();
        const ref2 = document.getElementById('ref_2').value.trim();
        if (ref1 === '' || ref2 === '') {
            Swal.fire({
                title: 'Perhatian',
                text: 'Harap isi kedua kolom refleksi.',
                icon: 'warning',
                confirmButtonColor: '#198754'
            });
        } else {
            Swal.fire({
                title: 'Terima kasih!',
                text: 'Refleksi berhasil disimpan.',
                icon: 'success',
                confirmButtonColor: '#198754'
            });
        }
    }

    // ===== AUTO HITUNG UNTUK SOAL 1 & 2 =====
    document.getElementById('s1_ab')?.addEventListener('input', function() {
        let ab = parseFloat(document.getElementById('s1_ab').value) || 0;
        let bc = parseFloat(document.getElementById('s1_bc').value) || 0;
        document.getElementById('s1_ac2').value = (ab * ab + bc * bc);
    });
    document.getElementById('s1_bc')?.addEventListener('input', function() {
        let ab = parseFloat(document.getElementById('s1_ab').value) || 0;
        let bc = parseFloat(document.getElementById('s1_bc').value) || 0;
        document.getElementById('s1_ac2').value = (ab * ab + bc * bc);
    });

    document.getElementById('s2_ab')?.addEventListener('input', function() {
        let ab = parseFloat(document.getElementById('s2_ab').value) || 0;
        let ac = parseFloat(document.getElementById('s2_ac').value) || 0;
        document.getElementById('s2_bc2').value = (ac * ac - ab * ab);
    });
    document.getElementById('s2_ac')?.addEventListener('input', function() {
        let ab = parseFloat(document.getElementById('s2_ab').value) || 0;
        let ac = parseFloat(document.getElementById('s2_ac').value) || 0;
        document.getElementById('s2_bc2').value = (ac * ac - ab * ab);
    });

    // ===== PAGINATION =====
    document.addEventListener('DOMContentLoaded', function () {
        const pages = document.querySelectorAll('.materi-page');
        const prevBtns = document.querySelectorAll('.prev-btn');
        const nextBtns = document.querySelectorAll('.next-btn');
        const pageBtns = document.querySelectorAll('.page-btn');
        const savedPage = localStorage.getItem('penerapanPage');

        let currentPage = 0;
        const totalPages = pages.length;

        function showPage(index) {
            if (index < 0 || index >= totalPages) return;

            pages.forEach(p => p.classList.add('d-none'));
            pages[index].classList.remove('d-none');

            currentPage = index;
            localStorage.setItem('penerapanPage', index);

            pageBtns.forEach(btn => {
                btn.parentElement.classList.remove('active');
                if (parseInt(btn.dataset.page) === index) {
                    btn.parentElement.classList.add('active');
                }
            });

            prevBtns.forEach(btn => {
                btn.disabled = (index === 0);
                btn.parentElement.classList.toggle('disabled', index === 0);
            });

            nextBtns.forEach(btn => {
                btn.disabled = (index === totalPages - 1);
                btn.parentElement.classList.toggle('disabled', index === totalPages - 1);
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        pageBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                showPage(parseInt(btn.dataset.page));
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', () => showPage(currentPage - 1));
        });

        nextBtns.forEach(btn => {
            btn.addEventListener('click', () => showPage(currentPage + 1));
        });

        showPage(savedPage ? parseInt(savedPage) : 0);
    });
</script>

@endsection