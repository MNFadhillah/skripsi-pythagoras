@extends('layouts.siswa')

@section('title', 'PythaLearn - Penerapan Teorema Pythagoras')

@push('scripts')
<script>
    window.completedCheckpoints = JSON.parse('{!! json_encode($completedCheckpoints ?? []) !!}');
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/materi4.js') }}"></script>
@endpush

@section('content')
<div class="container">
    <div class="card shadow-sm border-1 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">

                {{-- KIRI: Progress Bar --}}
                <div class="col-lg-3">
                    <div class="d-flex flex-column">
                        <small class="text-muted fw-bold mb-2">Progres Materi Anda</small>
                        <div class="progress" style="height: 15px; border-radius: 10px;">
                            @php $progressVal = $materiProgress ?? 0; @endphp
                            {{-- Tambahkan ID materiProgressBar --}}
                            <div id="materiProgressBar" class="progress-bar bg-success" role="progressbar" style="--w: {{ $progressVal }}%; width: var(--w);" aria-valuenow="{{ $progressVal }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        {{-- Tambahkan ID materiProgressText --}}
                        <small id="materiProgressText" class="text-success fw-bold mt-1">{{ $progressVal }}% Selesai</small>
                    </div>
                </div>

                {{-- TENGAH: Judul & Navigasi --}}
                <div class="col-lg-6 text-center mt-3 mt-lg-0">
                    <h4 class="fw-bold mb-3">Penerapan Teorema Pythagoras</h4>
                    <nav>
                        <ul class="pagination justify-content-center mb-0 flex-wrap gap-2 materi-pagination">
                            <li class="page-item">
                                <button class="page-link px-3 py-2 prev-btn rounded shadow-sm">Sebelumnya</button>
                            </li>
                            {{-- Looping 4 Halaman (0 sampai 3) --}}
                            @for ($i = 0; $i <= 3; $i++)
                                <li class="page-item {{ $i == 0 ? 'active' : '' }}">
                                <button class="page-link px-3 py-2 page-btn rounded shadow-sm" data-page="{{ $i }}">{{ $i + 1 }}</button>
                                </li>
                                @endfor
                                <li class="page-item">
                                    <button class="page-link px-3 py-2 next-btn rounded shadow-sm">Berikutnya</button>
                                </li>
                        </ul>
                    </nav>
                </div>

                {{-- KANAN: Poin --}}
                <div class="col-lg-3 text-lg-end text-center mt-3 mt-lg-0">
                    <div class="d-inline-block badge bg-success text-white px-4 py-3 rounded-pill shadow-sm fs-6">
                        <i class="bi bi-coin me-2 fs-5 align-middle"></i>
                        <span id="poinDisplay" class="fw-bold align-middle">{{ auth()->user()->points }} Poin</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= HALAMAN 1 (PAGE 0) ================= -->
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

        <!-- Tahukah Kamu? -->
        <section class="mb-4">
            <div class="card shadow-sm border-1">
                <div class="card-header text-center bg-light">
                    <h4>Tahukah Kamu?</h4>
                </div>

                <div class="card-body bg-white">
                    <div class="mb-2">
                        <p class="text-justify">
                            Masih ingatkah dengan cerita Ahmad yang melihat kemegahan Jembatan Barito saat menaiki kelotok? Saat itu, Ahmad penasaran bagaimana cara menghitung panjang kabel baja yang membentang miring menghubungkan tiang penyangga dan badan jembatan. <br>
                            Nah, di materi sebelumnya kita sudah membuktikan bahwa Teorema Pythagoras berlaku pada segitiga siku-siku yang terbentuk di jembatan tersebut. Sekarang, saatnya kita membantu Ahmad menjawab rasa penasarannya dengan menerapkan rumus Teorema Pythagoras secara langsung untuk menghitung panjang kabel baja itu!
                        </p>
                    </div>

                    <hr class="border-secondary opacity-25 my-4">

                    <div class="row">

                        <div class="col-lg-5 mb-4 mb-lg-0">
                            <p class="fw-bold mb-2">Perhatikan gambar di bawah ini:</p>
                            <div class="bg-white rounded-3 border shadow-sm p-2 mb-3 text-center">
                                <img src="{{ asset('images/jembatan_barito_2.png') }}" class="img-fluid rounded" alt="Ilustrasi Jembatan Barito" style="width: 100%; max-height: 280px; object-fit: cover;">
                            </div>
                            <div class="bg-white rounded-3 border shadow-sm p-2 mb-3 text-center">
                                <img src="{{ asset('images/segitiga_jembatan.png') }}" class="img-fluid rounded" alt="Ilustrasi Segitiga Jembatan" style="width: 100%; max-height: 280px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body p-4 bg-white rounded-3">
                                    <p class="text-justify mb-4">
                                        Misalkan Ahmad mendapatkan informasi bahwa tinggi tiang penyangga jembatan dari badan jalan adalah <strong>24 meter</strong>, dan panjang jalan dari tiang hingga titik ujung kabel baja adalah <strong>10 meter</strong>. Maka panjang kabel baja tersebut dapat diketahui dengan penyelesaian:
                                    </p>

                                    <div class="mb-4" id="box_step1">
                                        <label class="fw-bold small mb-2 text-dark">1. Berdasarkan gambar dan cerita, Bagian jembatan apa yang akan kita cari panjangnya adalah ....</label>
                                        <select id="ap_step1" class="form-select border-success">
                                            <option value="" selected disabled>-- Pilih Sisi --</option>
                                            <option value="tiang">Tinggi Tiang</option>
                                            <option value="jalan">Panjang Jalan</option>
                                            <option value="kabel">Panjang Kabel Baja</option>
                                        </select>
                                    </div>

                                    <div class="mb-4" id="box_step2">
                                        <label class="fw-bold small mb-2 text-dark">2. Berdasarkan sisi yang kita cari, operator apa yang harus digunakan pada rumus Teorema Pythagoras adalah ....</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-outline-success w-100 btn-operator" data-val="tambah">Ditambah (+)</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-outline-success w-100 btn-operator" data-val="kurang">Dikurang (-)</button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ap_step2" value="">
                                    </div>

                                    <div class="mb-4" id="box_step3">
                                        <label class="fw-bold small mb-2 text-dark">3. Berdasarkan analisis di atas, rumus mana yang paling tepat digunakan adalah ....</label>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-outline-success w-100 btn-rumus" data-val="benar">Kabel² = Tiang² + Jalan²</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-outline-success w-100 btn-rumus" data-val="salah1">Kabel² = Tiang² - Jalan²</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-outline-success w-100 btn-rumus" data-val="salah2">Tiang² = Kabel² - Jalan²</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-outline-success w-100 btn-rumus" data-val="salah3">Jalan² = Tiang² + Kabel²</button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ap_step3" value="">
                                    </div>

                                    <div class="mb-4" id="box_step4">
                                        <label class="fw-bold small mb-2 text-dark">4. Sekarang, mari hitung nilainya ke dalam rumus yang tepat!</label>
                                        <div class="bg-light p-3 border border-success rounded">
                                            <div class="d-flex align-items-center gap-2 mb-2 justify-content-center">
                                                <span class="fw-medium" style="width: 60px;">Kabel² =</span>
                                                <input type="number" id="ap_t1" class="form-control form-control-sm text-center border-success" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">² + </span>
                                                <input type="number" id="ap_j1" class="form-control form-control-sm text-center border-success" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">²</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-2 mb-2 justify-content-center">
                                                <span class="fw-medium" style="width: 60px;">Kabel² =</span>
                                                <input type="number" id="ap_t2" class="form-control form-control-sm text-center border-success" style="width:70px;" placeholder="...">
                                                <span class="fw-bold"> + </span>
                                                <input type="number" id="ap_j2" class="form-control form-control-sm text-center border-success" style="width:70px;" placeholder="...">
                                            </div>

                                            <div class="d-flex align-items-center gap-2 mb-3 justify-content-center">
                                                <span class="fw-medium" style="width: 60px;">Kabel² =</span>
                                                <input type="number" id="ap_jum" class="form-control form-control-sm text-center border-success" style="width:90px;" placeholder="...">
                                            </div>

                                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                                <span class="fw-bold text-dark">Kabel = &radic;</span>
                                                <input type="number" id="ap_akar" class="form-control form-control-sm text-center fw-bold border-success" style="width:70px;" placeholder="...">
                                                <span class="fw-bold mx-1">=</span>
                                                <input type="number" id="ap_final" class="form-control form-control-sm text-center fw-bold text-success border-success bg-white shadow-sm" style="width:70px;" placeholder="...">
                                                <span class="fw-bold text-dark">meter</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                                        <div id="ap_feedback" class="small fw-bold"></div>
                                        <button class="btn btn-success fw-bold px-4 shadow-sm" onclick="cekApersepsiLengkap()">Cek Jawaban</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </section>

    <!-- ================= HALAMAN 2 (PAGE 1) ================= -->
    <section class="materi-page d-none" data-page="1">
        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-light">
                    <h4 class="mb-0">Contoh 1</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                        <div class="small">
                            <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi di bawah. Lengkapi data yang diketahui dan selesaikan langkah perhitungannya dengan mengisi kotak yang kosong.
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-5 mb-4 mb-md-0">
                            <p class=" small text-justify">
                                Budi sedang bermain layang-layang di lapangan. Jarak mendatar dari tempat Budi berdiri hingga tepat di bawah posisi layang-layang adalah <strong>40 meter</strong>. Jika tinggi layang-layang dari permukaan tanah adalah <strong>30 meter</strong> (mengabaikan tinggi Budi), tentukan panjang benang layang-layang yang terulur!
                            </p>
                            <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                <img src="{{ asset('images/contoh_1_penerapan.jpg') }}" class="img-fluid" style="max-height: auto;" alt="Ilustrasi Layang-Layang">
                            </div>

                            <div class="card border mb-3 shadow-sm">
                                <div class="card-header border-bottom bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                </div>
                                <div class="card-body small py-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="width: 250px;">Jarak Budi ke tinggi layang-layang (AB) :</span>
                                        <select id="c1_dik_ab" class="form-select form-select-sm text-center border-secondary mx-2" style="width: 120px;">
                                            <option value=""></option>
                                            <option value="40">40</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span>m</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span style="width: 250px;">Tinggi layang-layang (BC) :</span>
                                        <select id="c1_dik_bc" class="form-select form-select-sm text-center border-secondary mx-2" style="width: 120px;">
                                            <option value=""></option>
                                            <option value="40">40</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span>m</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border shadow-sm">
                                <div class="card-header border-bottom bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                </div>
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center small ">
                                        <span>Panjang benang (</span>
                                        <select id="c1_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width: 120px;">
                                            <option value=""></option>
                                            <option value="AB">AB</option>
                                            <option value="BC">BC</option>
                                            <option value="AC">AC</option>
                                        </select>
                                        <span>) = ...?</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-header bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                </div>
                                <div class="card-body bg-light">

                                    <!-- Langkah 1: Interaktif dengan Dropdown -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">1. Pilih Rumus Pythagoras</span>
                                        <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                            <select id="c1_rumus" class="form-select form-select-sm text-center fw-bold w-auto cursor-pointer">
                                                <option value="">-- Pilih Rumus --</option>
                                                <option value="AC">AC² = AB² + BC²</option>
                                                <option value="AB">AB² = AC² - BC²</option>
                                                <option value="BC">BC² = AC² - AB²</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Langkah 2: Substitusi, Hasil Pangkat, dan Penjumlahan -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">2. Substitusi & Hitung Nilai AC²</span>

                                        <!-- Tahap 2A: Masukkan nilai awal -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3">
                                            <span class="fw-bold">AC² =</span>
                                            <input type="number" id="c1_ab" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">² +</span>
                                            <input type="number" id="c1_bc" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">²</span>
                                        </div>

                                        <!-- Tahap 2B: Masukkan hasil pangkat -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AC² =</span>
                                            <input type="number" id="c1_ab_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                            <span class="fw-bold">+</span>
                                            <input type="number" id="c1_bc_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                        </div>

                                        <!-- Tahap 2C: Masukkan hasil penjumlahan akhir -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AC² =</span>
                                            <input type="number" id="c1_ac2" class="form-control form-control-sm text-center fw-bold text-primary" style="width:100px;" placeholder="...">
                                        </div>
                                    </div>

                                    <!-- Langkah 3: Akar interaktif -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">3. Hitung Panjang AC</span>
                                        <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
                                            <span class="fw-bold">AC =</span>
                                            <span class="fs-5 fw-bold">√</span>
                                            <input type="number" id="c1_akar_val" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                            <span class="fw-bold">=</span>
                                            <input type="number" id="c1_ac" class="form-control form-control-sm text-center fw-bold text-success" style="width:80px;" placeholder="...">
                                            <span class="fw-bold">m</span>
                                        </div>
                                    </div>

                                    <!-- Footer / Tombol -->
                                    <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                        <div id="c1_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                        <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh1Penerapan()">
                                            Cek Jawaban
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-light">
                    <h4 class="mb-0">Contoh 2</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                        <div class="small">
                            <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi di bawah. Lengkapi data yang diketahui dan selesaikan langkah perhitungannya.
                        </div>
                    </div>
                    <div class="row mt-4">
                        <!-- Kolom Kiri: Soal, Diketahui, Ditanya -->
                        <div class="col-md-5 mb-4 mb-md-0">
                            <p class="small text-justify">
                                Seorang pengemudi ojek online menempuh perjalanan sejauh <strong>20 km</strong> ke arah barat kemudian <strong>15 km</strong> ke arah utara untuk mengantar penumpang. Tentukan jarak garis lurus dari titik awal ke titik akhir perjalanan yang ditempuh oleh pengemudi ojek!
                            </p>
                            <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                <img src="{{ asset('images/contoh_2_penerapan.jpg') }}" class="img-fluid" style="max-height: auto;" alt="Ilustrasi Jarak Ojek Online">
                            </div>

                            <!-- Bagian Diketahui -->
                            <div class="card border mb-3 shadow-sm">
                                <div class="card-header border-bottom bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                </div>
                                <div class="card-body small py-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="width: 250px;">Jarak tempuh ke arah barat (NO) :</span>
                                        <select id="c2_dik_mn" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select>
                                        <span>km</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span style="width: 250px;">Jarak tempuh ke arah utara (MN) :</span>
                                        <select id="c2_dik_no" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select>
                                        <span>km</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Ditanya -->
                            <div class="card border shadow-sm">
                                <div class="card-header border-bottom bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                </div>
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center small">
                                        <span>Jarak lurus (</span>
                                        <select id="c2_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="MN">MN</option>
                                            <option value="NO">NO</option>
                                            <option value="MO">MO</option>
                                        </select>
                                        <span>) = ...?</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Kolom Kanan: Langkah Penyelesaian -->
                        <div class="col-md-7 mt-4 mt-md-0">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-header bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                </div>
                                <div class="card-body bg-light">

                                    <!-- Langkah 1: Interaktif dengan Dropdown -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">1. Pilih Rumus Pythagoras</span>
                                        <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                            <select id="c2_rumus" class="form-select form-select-sm text-center fw-bold w-auto cursor-pointer">
                                                <option value="">-- Pilih Rumus --</option>
                                                <option value="MO">MO² = MN² + NO²</option>
                                                <option value="MN">MN² = MO² - NO²</option>
                                                <option value="NO">NO² = MO² - MN²</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Langkah 2: Substitusi, Hasil Pangkat, dan Penjumlahan -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">2. Substitusi & Hitung Nilai MO²</span>

                                        <!-- Tahap 2A: Masukkan nilai awal (15 dan 20) -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3">
                                            <span class="fw-bold">MO² =</span>
                                            <input type="number" id="c2_mn" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">² +</span>
                                            <input type="number" id="c2_no" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">²</span>
                                        </div>

                                        <!-- Tahap 2B: Masukkan hasil pangkat (225 dan 400) -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">MO² =</span>
                                            <input type="number" id="c2_mn_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                            <span class="fw-bold">+</span>
                                            <input type="number" id="c2_no_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                        </div>

                                        <!-- Tahap 2C: Masukkan hasil penjumlahan akhir (625) -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">MO² =</span>
                                            <input type="number" id="c2_mo2" class="form-control form-control-sm text-center fw-bold text-primary" style="width:100px;" placeholder="...">
                                        </div>
                                    </div>

                                    <!-- Langkah 3: Akar interaktif -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">3. Hitung Jarak Lurus (MO)</span>
                                        <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
                                            <span class="fw-bold">MO =</span>
                                            <span class="fs-5 fw-bold">√</span>
                                            <input type="number" id="c2_akar_val" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                            <span class="fw-bold">=</span>
                                            <input type="number" id="c2_mo" class="form-control form-control-sm text-center fw-bold text-success" style="width:80px;" placeholder="...">
                                            <span class="fw-bold">km</span>
                                        </div>
                                    </div>

                                    <!-- Footer / Tombol -->
                                    <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                        <div id="c2_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                        <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh2Penerapan()">
                                            Cek Jawaban
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-light">
                    <h4 class="mb-0">Contoh 3</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-light shadow-sm border-start border-success border-4" role="alert">
                        <div class="small">
                            <strong>Petunjuk:</strong> Perhatikan soal dan ilustrasi di bawah. Lengkapi data yang diketahui dan selesaikan langkah perhitungannya.
                        </div>
                    </div>
                    <div class="row mt-4">

                        <!-- Kolom Kiri: Soal, Diketahui, Ditanya -->
                        <div class="col-md-5 mb-4 mb-md-0">
                            <p class="small text-justify">
                                Seorang pengamat berada di puncak mercusuar (titik D) yang tingginya <strong>15 meter</strong>. Ia melihat dua buah perahu, Perahu A dan Perahu B, yang berlayar sebaris lurus di laut. Jarak pandang garis lurus dari pengamat ke Perahu A adalah <strong>25 meter</strong>, dan ke Perahu B adalah <strong>17 meter</strong>. Berapakah jarak antara Perahu A dan Perahu B?
                            </p>
                            <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                <img src="{{ asset('images/contoh_3_penerapan.jpg') }}" class="img-fluid" style="max-height: auto;" alt="Ilustrasi Mercusuar">
                            </div>

                            <!-- Bagian Diketahui -->
                            <div class="card border mb-3 shadow-sm">
                                <div class="card-header border-bottom bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                </div>
                                <div class="card-body small py-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="width: 220px;">Tinggi mercusuar (DC) :</span>
                                        <select id="c3_dik_dc" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="15">15</option>
                                            <option value="17">17</option>
                                            <option value="25">25</option>
                                        </select>
                                        <span>m</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="width: 220px;">Jarak pandang ke A (DA) :</span>
                                        <select id="c3_dik_da" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="15">15</option>
                                            <option value="17">17</option>
                                            <option value="25">25</option>
                                        </select>
                                        <span>m</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span style="width: 220px;">Jarak pandang ke B (DB) :</span>
                                        <select id="c3_dik_db" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="15">15</option>
                                            <option value="17">17</option>
                                            <option value="25">25</option>
                                        </select>
                                        <span>m</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Ditanya -->
                            <div class="card border shadow-sm">
                                <div class="card-header border-bottom bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                </div>
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center small ">
                                        <span>Jarak antara perahu (</span>
                                        <select id="c3_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width:120px;">
                                            <option value=""></option>
                                            <option value="AC">AC</option>
                                            <option value="BC">BC</option>
                                            <option value="AB">AB</option>
                                        </select>
                                        <span>) = ...?</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Langkah Penyelesaian -->
                        <div class="col-md-7">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-header bg-light py-2">
                                    <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                </div>
                                <div class="card-body bg-light">

                                    <!-- Langkah 1: Hitung AC (Segitiga ACD) -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">1. Hitung jarak mercusuar ke perahu A (AC)</span>
                                        <div class="fst-italic text-muted mb-2">Fokus pada segitiga siku-siku ACD (siku di C).</div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AC² = DA² - DC²</span>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AC² =</span>
                                            <input type="number" id="c3_da" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">² -</span>
                                            <input type="number" id="c3_dc1" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">²</span>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AC² =</span>
                                            <input type="number" id="c3_da_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">-</span>
                                            <input type="number" id="c3_dc1_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AC = √</span>
                                            <input type="number" id="c3_ac2_val" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">=</span>
                                            <input type="number" id="c3_ac" class="form-control form-control-sm text-center fw-bold text-success" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">m</span>
                                        </div>
                                    </div>

                                    <!-- Langkah 2: Hitung BC (Segitiga BCD) -->
                                    <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">2. Hitung jarak mercusuar ke perahu B (BC)</span>
                                        <div class="fst-italic text-muted mb-2">Fokus pada segitiga siku-siku BCD (siku di C).</div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">BC² = DB² - DC²</span>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">BC² =</span>
                                            <input type="number" id="c3_db" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">² -</span>
                                            <input type="number" id="c3_dc2" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">²</span>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">BC² =</span>
                                            <input type="number" id="c3_db_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">-</span>
                                            <input type="number" id="c3_dc2_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">BC = √</span>
                                            <input type="number" id="c3_bc2_val" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">=</span>
                                            <input type="number" id="c3_bc" class="form-control form-control-sm text-center fw-bold text-success" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">m</span>
                                        </div>
                                    </div>

                                    <!-- Langkah 3: Jarak AB -->
                                    <div class="p-3 mb-3 bg-white border border-primary rounded-3 shadow-sm text-center small">
                                        <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">3. Tentukan jarak AB</span>
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AB = AC - BC</span>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                            <span class="fw-bold">AB =</span>
                                            <input type="number" id="c3_ac_final" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">-</span>
                                            <input type="number" id="c3_bc_final" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                            <span class="fw-bold">=</span>
                                            <input type="number" id="c3_ab" class="form-control form-control-sm text-center fw-bold text-primary" style="width:70px;" placeholder="...">
                                            <span class="fw-bold">m</span>
                                        </div>
                                    </div>

                                    <!-- Footer / Tombol -->
                                    <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                        <div id="c3_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                        <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekContoh3Penerapan()">
                                            Cek Jawaban
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <!-- ================= HALAMAN 3 (PAGE 2) ================= -->
    <section class="materi-page d-none" data-page="2">
        <div class="card shadow-sm mb-4 border-1">
            <div class="card-header text-center bg-light">
                <h4>Ayo Berlatih</h4>
            </div>
            <div class="card-body bg-white">
                <!-- Petunjuk -->
                <div class="alert alert-light shadow-sm border-start border-success border-4 mb-4">
                    <h6 class="fw-bold">Petunjuk Pengerjaan:</h6>
                    <ul class="mb-0 small">
                        <li>Perhatikan gambar dan angka yang diketahui di sebelah kiri.</li>
                        <li>Lengkapi data pada bagian <strong>Diketahui</strong> dan <strong>Ditanya</strong>.</li>
                        <li>Isi kotak-kotak kosong pada langkah penyelesaian di sebelah kanan.</li>
                        <li>Klik tombol <strong>Cek Jawaban</strong> di setiap nomor untuk memeriksa hasilmu.</li>
                    </ul>
                </div>

                <!-- Soal 1 (Klotok) -->
                <div class="card border-1 shadow-sm mb-4 border-top border-success border-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold text-success">Soal 1: Klotok di Sungai Barito</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <!-- Kolom Kiri: Soal, Diketahui, Ditanya -->
                            <div class="col-md-5 mb-4 mb-md-0">
                                <p class="fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                    <img src="{{ asset('images/ilustrasi_soal1.jpg') }}" class="img-fluid p-2" style="max-height: auto;" alt="Soal 1">
                                </div>
                                <p class="small text-justify mb-4">Pak Rahman mengemudikan klotok. Ia menyeberang ke arah timur <strong>40 m</strong> dan terbawa arus ke arah selatan <strong>30 m</strong>. Tentukan jarak lurus dari titik awal ke titik akhir.</p>

                                <div class="card border mb-3 shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                    </div>
                                    <div class="card-body small py-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 140px;">Gerak timur (AB) :</span>
                                            <select id="s1_dik_ab" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="width: 140px;">Gerak selatan (BC) :</span>
                                            <select id="s1_dik_bc" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center small">
                                            <span style="width: 140px;">Jarak lurus (</span>
                                            <select id="s1_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="AB">AB</option>
                                                <option value="BC">BC</option>
                                                <option value="AC">AC</option>
                                            </select>
                                            <span>) = ...?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Langkah Penyelesaian -->
                            <div class="col-md-7 mt-4 mt-md-0">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light py-2 border-bottom">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body bg-light">
                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">1. Pilih Rumus Pythagoras</span>
                                            <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                                <select id="s1_rumus" class="form-select form-select-sm text-center fw-bold w-auto cursor-pointer">
                                                    <option value="">-- Pilih Rumus --</option>
                                                    <option value="AC">AC² = AB² + BC²</option>
                                                    <option value="AB">AB² = AC² - BC²</option>
                                                    <option value="BC">BC² = AC² - AB²</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">2. Substitusi & Hitung Nilai AC²</span>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3">
                                                <span class="fw-bold">AC² =</span>
                                                <input type="number" id="s1_ab" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">² +</span>
                                                <input type="number" id="s1_bc" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">²</span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">AC² =</span>
                                                <input type="number" id="s1_ab_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                                <span class="fw-bold">+</span>
                                                <input type="number" id="s1_bc_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">AC² =</span>
                                                <input type="number" id="s1_ac2" class="form-control form-control-sm text-center fw-bold text-primary" style="width:100px;" placeholder="...">
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">3. Hitung Jarak Lurus (AC)</span>
                                            <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
                                                <span class="fw-bold">AC =</span>
                                                <span class="fs-5 fw-bold">√</span>
                                                <input type="number" id="s1_akar_val" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                                <span class="fw-bold">=</span>
                                                <input type="number" id="s1_ac" class="form-control form-control-sm text-center fw-bold text-success" style="width:80px;" placeholder="...">
                                                <span class="fw-bold">m</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                            <div id="s1_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                            <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekSoal1()">
                                                <i class="fas fa-check-circle me-1"></i> Cek Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Soal 2 (Menara) -->
                <div class="card border-1 shadow-sm mb-4 border-top border-success border-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold text-success">Soal 2</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <!-- Kolom Kiri: Soal, Diketahui, Ditanya -->
                            <div class="col-md-5 mb-4 mb-md-0">
                                <p class="fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                    <img src="{{ '/images/ilustrasi_soal2.jpg' }}" class="img-fluid p-2" style="max-height: auto;" alt="Soal 2">
                                </div>
                                <p class="small text-justify mb-4">Seorang siswa melihat puncak menara dengan jarak 25 meter, dan jarak siswa tersebut dengan menara adalah 24 meter. Tentukan tinggi menara tersebut.</p>

                                <div class="card border mb-3 shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                    </div>
                                    <div class="card-body small py-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: auto;">Jarak siswa dengan menara (AB) :</span>
                                            <select id="s2_dik_ab" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="7">7</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="width: a;">Jarak pandang siswa ke menara (AC) :</span>
                                            <select id="s2_dik_ac" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="7">7</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center small">
                                            <span style="width: 140px;">Tinggi menara (</span>
                                            <select id="s2_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="AB">AB</option>
                                                <option value="BC">BC</option>
                                                <option value="AC">AC</option>
                                            </select>
                                            <span>) = ...?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Langkah Penyelesaian -->
                            <div class="col-md-7 mt-4 mt-md-0">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light py-2 border-bottom">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body bg-light">
                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">1. Pilih Rumus Pythagoras</span>
                                            <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                                <select id="s2_rumus" class="form-select form-select-sm text-center fw-bold w-auto cursor-pointer">
                                                    <option value="">-- Pilih Rumus --</option>
                                                    <option value="AC">AC² = AB² + BC²</option>
                                                    <option value="AB">AB² = AC² - BC²</option>
                                                    <option value="BC">BC² = AC² - AB²</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">2. Substitusi & Hitung Nilai BC²</span>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3">
                                                <span class="fw-bold">BC² =</span>
                                                <input type="number" id="s2_ac" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">² -</span>
                                                <input type="number" id="s2_ab" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">²</span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">BC² =</span>
                                                <input type="number" id="s2_ac_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                                <span class="fw-bold">-</span>
                                                <input type="number" id="s2_ab_kuadrat" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">BC² =</span>
                                                <input type="number" id="s2_bc2" class="form-control form-control-sm text-center fw-bold text-primary" style="width:100px;" placeholder="...">
                                            </div>
                                        </div>

                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">3. Hitung Tinggi Menara (BC)</span>
                                            <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
                                                <span class="fw-bold">BC =</span>
                                                <span class="fs-5 fw-bold">√</span>
                                                <input type="number" id="s2_akar_val" class="form-control form-control-sm text-center" style="width:80px;" placeholder="...">
                                                <span class="fw-bold">=</span>
                                                <input type="number" id="s2_bc" class="form-control form-control-sm text-center fw-bold text-success" style="width:80px;" placeholder="...">
                                                <span class="fw-bold">m</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
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

                <!-- Soal 3 (Drone) -->
                <div class="card border-1 shadow-sm border-top border-success border-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold text-success">Soal 3</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            <!-- Kolom Kiri: Soal, Diketahui, Ditanya -->
                            <div class="col-md-5 mb-4 mb-md-0">
                                <p class="fw-bold mb-2 small">Perhatikan gambar di bawah ini:</p>
                                <div class="bg-white rounded-3 shadow-sm border p-3 d-flex justify-content-center align-items-center mb-4 overflow-hidden">
                                    <img src="{{ asset('/images/ilustrasi_soal3.jpg') }}" class="img-fluid p-2" style="max-height: auto;" alt="Soal 3">
                                </div>
                                <p class="small text-justify mb-4">Sebuah drone diterbangkan dan memantau tenda A dengan jarak pandang lurus sejauh <strong>20 m</strong>, dan jarak tenda A terhadap titik yang tepat di bawah drone adalah sejauh <strong>16 m</strong>. Di arah yang sama, drone juga melihat tenda B dengan jarak pandang lurus <strong>15 m</strong>. Tentukan jarak mendatar dari titik tepat di bawah drone ke tenda B.</p>

                                <div class="card border mb-3 shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-success">Diketahui</h6>
                                    </div>
                                    <div class="card-body small py-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 150px;">Jarak pandang A (DA) :</span>
                                            <select id="s3_dik_da" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="20">20</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="width: 150px;">Jarak mendatar A (AC) :</span>
                                            <select id="s3_dik_ac" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="20">20</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="width: 150px;">Jarak pandang B (DB) :</span>
                                            <select id="s3_dik_db" class="form-select form-select-sm text-center border-secondary mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="20">20</option>
                                            </select>
                                            <span>m</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border shadow-sm">
                                    <div class="card-header border-bottom bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-warning">Ditanya</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center small">
                                            <span>Jarak mendatar B (</span>
                                            <select id="s3_ditanya" class="form-select form-select-sm text-center border-warning fw-bold text-dark mx-2" style="width:120px;">
                                                <option value=""></option>
                                                <option value="DC">DC</option>
                                                <option value="BC">BC</option>
                                                <option value="AB">AB</option>
                                            </select>
                                            <span>) = ...?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Langkah Penyelesaian -->
                            <div class="col-md-7 mt-4 mt-md-0">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light py-2 border-bottom">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body bg-light">

                                        <!-- Langkah 1: Hitung DC -->
                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">1. Hitung tinggi drone (DC)</span>
                                            <div class="fst-italic text-muted mb-2">Fokus pada segitiga siku-siku ACD (siku di C).</div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">DC² = DA² - AC²</span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">DC² =</span>
                                                <input type="number" id="s3_da" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">² -</span>
                                                <input type="number" id="s3_ac1" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">²</span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">DC² =</span>
                                                <input type="number" id="s3_da_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">-</span>
                                                <input type="number" id="s3_ac1_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">DC = √</span>
                                                <input type="number" id="s3_dc2_val" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">=</span>
                                                <input type="number" id="s3_dc" class="form-control form-control-sm text-center fw-bold text-success" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">m</span>
                                            </div>
                                        </div>

                                        <!-- Langkah 2: Hitung BC -->
                                        <div class="p-3 mb-3 bg-white border border-success rounded-3 shadow-sm text-center small">
                                            <span class="d-block fw-bold text-dark mb-2 border-bottom pb-2">2. Hitung jarak mendatar tenda B (BC)</span>
                                            <div class="fst-italic text-muted mb-2">Fokus pada segitiga siku-siku BCD (siku di C).</div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">BC² = DB² - DC²</span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">BC² =</span>
                                                <input type="number" id="s3_db" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">² -</span>
                                                <input type="number" id="s3_dc2" class="form-control form-control-sm text-center" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">²</span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">BC² =</span>
                                                <input type="number" id="s3_db_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">-</span>
                                                <input type="number" id="s3_dc2_kuadrat" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                                                <span class="fw-bold">BC = √</span>
                                                <input type="number" id="s3_bc2_val" class="form-control form-control-sm text-center" style="width:70px;" placeholder="...">
                                                <span class="fw-bold">=</span>
                                                <input type="number" id="s3_bc" class="form-control form-control-sm text-center fw-bold text-primary" style="width:60px;" placeholder="...">
                                                <span class="fw-bold">m</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex flex-column flex-xl-row justify-content-between align-items-center border-top pt-3">
                                            <div id="s3_feedback" class="small fw-bold mb-3 mb-xl-0"></div>
                                            <button class="btn btn-success px-4 fw-bold shadow-sm" onclick="cekSoal3()">
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

    <!-- ================= HALAMAN 4 (PAGE 3) ================= -->
    <section class="materi-page d-none" data-page="3">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-1">
                    <div class="card-header text-center bg-light">
                        <h4>Rangkuman Materi</h4>
                    </div>

                    <div class="card-body p-4 bg-white">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 fw-bold" style="width: 30px; height: 30px;">1</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Teorema Pythagoras</strong>: Pada setiap segitiga siku-siku, kuadrat sisi miring (hipotenusa) selalu sama dengan jumlah kuadrat sisi siku-sikunya. Teorema ini hanya berlaku untuk bangun segitiga siku-siku.
                                </p>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 fw-bold" style="width: 30px; height: 30px;">2</div>
                            <div class="ms-3">
                                <p class="text-muted mb-2" style="line-height: 1.6;">
                                    <strong>Penerapan dalam Kehidupan Sehari-hari</strong>: Teorema Pythagoras digunakan untuk memecahkan masalah kontekstual yang tidak dapat diukur secara langsung. Kegunaan utamanya antara lain:
                                </p>
                                <ul class="text-muted mb-0 ps-3" style="line-height: 1.6;">
                                    <li class="mb-1">Menghitung jarak terdekat atau jarak lurus antara dua titik/tempat.</li>
                                    <li class="mb-1">Menentukan tinggi bangunan, menara, atau pohon.</li>
                                    <li>Menghitung panjang kabel penahan, panjang lintasan miring, maupun tangga yang bersandar.</li>
                                </ul>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 fw-bold" style="width: 30px; height: 30px;">3</div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="line-height: 1.6;">
                                    <strong>Langkah Penyelesaian Masalah Kontekstual</strong>: <br>
                                    1. Membaca dan memahami inti masalah.<br>
                                    2. Membuat sketsa gambar atau memodelkan masalah menjadi bentuk segitiga siku-siku.<br>
                                    3. Menentukan sisi-sisi yang diketahui dan sisi yang ditanyakan.<br>
                                    4. Menerapkan rumus Teorema Pythagoras untuk menyelesaikan perhitungan.<br>
                                    5. Menafsirkan hasil perhitungan kembali ke dalam konteks masalah awal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-center bg-light">
                        <h4 class="mb-0">Refleksi Akhir Pembelajaran</h4>
                        <small class="text-muted">
                            Jawablah berdasarkan pemahamanmu terkait penerapan Teorema Pythagoras. Ini langkah terakhirmu!
                        </small>
                    </div>

                    <div class="card-body p-4 bg-white">

                        <div class="mb-4">
                            <label class="fw-semibold mb-2 text-dark">
                                1. Setelah mempelajari berbagai contoh penerapan, apakah menurutmu pembuatan sketsa (gambar) segitiga siku-siku sangat penting sebelum mulai menghitung?
                            </label>

                            <div class="mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ref_penerapan_1" id="ref_penerapan_1_ya" value="sangat_penting">
                                    <label class="form-check-label" for="ref_penerapan_1_ya">Sangat Penting</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ref_penerapan_1" id="ref_penerapan_1_tidak" value="tidak_penting">
                                    <label class="form-check-label" for="ref_penerapan_1_tidak">Tidak Terlalu Penting</label>
                                </div>
                            </div>

                            <textarea class="form-control shadow-sm" rows="3" id="ref_penerapan_1_text" placeholder="Jelaskan alasanmu di sini..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold mb-2 text-dark">
                                2. Coba perhatikan lingkungan di sekitarmu (rumah, sekolah, atau jalanan). Sebutkan satu masalah atau situasi nyata yang bisa kamu selesaikan menggunakan Teorema Pythagoras!
                            </label>
                            <textarea class="form-control shadow-sm" rows="3" id="ref_penerapan_2_text" placeholder="Tuliskan situasi yang kamu temukan..."></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted small">Setelah menyimpan refleksi ini, bersiaplah untuk mengerjakan kuis guna menguji seluruh pemahamanmu tentang Teorema Pythagoras.</p>
                        </div>

                        <div class="text-center mt-4 border-top pt-4">
                            <button class="btn btn-success fw-bold shadow-sm px-4" onclick="cekRefleksiPenerapan()">
                                <i class="fas fa-save me-1"></i> Simpan Refleksi
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pagination Navigasi Bawah -->
    <div class="d-flex justify-content-center align-items-center mt-5 mb-5 pt-4 border-top">
        <nav>
            <ul class="pagination justify-content-center mb-0 flex-wrap gap-2 materi-pagination">
                <li class="page-item">
                    <button class="page-link px-3 py-2 prev-btn rounded shadow-sm">Sebelumnya</button>
                </li>
                {{-- Looping 4 Halaman (0 sampai 5) --}}
                @for ($i = 0; $i <= 3; $i++)
                    <li class="page-item {{ $i == 0 ? 'active' : '' }}">
                    <button class="page-link px-3 py-2 page-btn rounded shadow-sm" data-page="{{ $i }}">{{ $i + 1 }}</button>
                    </li>
                    @endfor
                    <li class="page-item">
                        <button class="page-link px-3 py-2 next-btn rounded shadow-sm">Berikutnya</button>
                    </li>
            </ul>
        </nav>
    </div>
</div>

@endsection