@extends('layouts.siswa')

@section('title', 'PythaLearn')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/responsifitas_materi1.css') }}?v={{ filemtime(public_path('css/responsifitas_materi1.css')) }}">
@endpush

@push('scripts')
<script>
    window.completedCheckpoints = <?php echo json_encode($completedCheckpoints ?? []); ?>;
</script>

<script src="{{ asset('js/materi1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush


@section('content')
<div class="container">
    <div class="card shadow-sm border-1 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                {{-- KIRI: Progress Bar --}}
                <div class="col-lg-2">
                    <div class="d-flex flex-column">
                        <small class="text-muted fw-bold mb-2">Progres Materi Anda</small>
                        <div class="progress" style="height: 15px; border-radius: 10px;">
                            @php $progressVal = $materiProgress ?? 0; @endphp

                            {{-- TAMBAHKAN ID materiProgressBar DI SINI --}}
                            <div id="materiProgressBar"
                                class="progress-bar bg-success"
                                role="progressbar"
                                style="--w: {{ $progressVal }}%; width: var(--w);"
                                aria-valuenow="{{ $progressVal }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>

                        {{-- TAMBAHKAN ID materiProgressText DI SINI --}}
                        <small id="materiProgressText" class="text-success fw-bold mt-1">
                            {{ $progressVal }}% Selesai
                        </small>
                    </div>
                </div>

                {{-- TENGAH: Judul & Navigasi --}}
                <div class="col-lg-7 text-center mt-3 mt-lg-0">
                    <h4 class="fw-bold mb-3">Menemukan Konsep Pythagoras</h4>
                    <nav>
                        <ul class="pagination justify-content-center mb-0 flex-wrap gap-2 materi-pagination">
                            <li class="page-item">
                                <button class="page-link px-3 py-2 prev-btn rounded shadow-sm">Sebelumnya</button>
                            </li>
                            {{-- Looping 7 Halaman (0 sampai 6) --}}
                            @for ($i = 0; $i <= 6; $i++)
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
                        {{-- TAMBAHKAN ID DI SINI --}}
                        <span id="poinDisplay" class="fw-bold align-middle">{{ auth()->user()->points }} Poin</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- HALAMAN 1 -->
    <section class="materi-page" data-page="0">
        <div class="container-fluid p-0">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Tujuan Pembelajaran</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-dark">Setelah menyelesaikan pembelajaran pada media ini, peserta didik diharapkan mencapai tujuan berikut:</p>
                            <ol class="mb-0 ps-3">
                                <li class="mb-3">
                                    <strong>Peserta didik mampu menentukan panjang sisi segitiga menggunakan teorema Pythagoras.</strong>
                                    <br>
                                    <small>Pada bagian ini, kamu akan menghitung panjang salah satu sisi segitiga siku-siku apabila panjang dua sisi lainnya sudah diketahui.</small>
                                </li>
                                <li class="mb-3">
                                    <strong>Peserta didik mampu menganalisis beberapa informasi untuk membuktikan kebenaran teorema Pythagoras.</strong>
                                    <br>
                                    <small>Pada bagian ini, kamu akan mengamati dan menganalisis hubungan luas persegi pada sisi-sisi segitiga siku-siku melalui visualisasi interaktif.</small>
                                </li>
                                <li class="mb-3">
                                    <strong>Peserta didik mampu membuat pembuktian berupa skema atau prosedur terhadap rumus teorema Pythagoras.</strong>
                                    <br>
                                    <small>Pada bagian ini, kamu akan belajar menyusun skema atau langkah-langkah prosedur matematis dalam membuktikan dan menerapkan rumus teorema Pythagoras.</small>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HALAMAN 2 -->
    <section class="materi-page" data-page="1">

        <div class="container-fluid p-0">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Ayo Mengingat Kembali</h4>
                        </div>
                        <div class="card-body p-3">

                            <div class="text-center mb-3">
                                <button class="btn btn-outline-success btn-sm fw-bold"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalPetunjuk">
                                    Petunjuk Pengerjaan
                                </button>
                            </div>

                            <div class="card border-success border-4 shadow-sm mb-4">
                                <div class="card-body">
                                    <p class="text-justify mb-0">
                                        Suatu hari, Ahmad sedang dalam perjalanan menuju Taman Wisata Alam (TWA) Pulau Bakut menggunakan kelotok.
                                        Saat melintas di bawah Jembatan Barito, ia takjub melihat kemegahan konstruksinya.
                                        Pandangannya tertuju pada
                                        <span class="fw-bold text-danger clickable-text" style="cursor: pointer;" onclick="showPart('text-tegak')">Tiang Penyangga</span>
                                        yang tegak lurus dengan
                                        <span class="fw-bold text-success clickable-text" style="cursor: pointer;" onclick="showPart('text-datar')">Badan Jembatan</span>.
                                        Keduanya dihubungkan oleh
                                        <span class="fw-bold text-warning clickable-text" style="cursor: pointer;" onclick="showPart('text-miring')">Kabel Baja</span>
                                        yang membentuk sisi miring. Pernahkah terlintas di benak kamu, berapakah panjang kabel baja tersebut? dan bagaimana cara menghitungnya?
                                    </p>
                                </div>
                            </div>

                            <div class="row justify-content-center mb-4">
                                <div class="col-lg-10">
                                    <div class="overflow-hidden rounded border shadow-sm">
                                        <div class="interactive-image-container position-relative">
                                            <img src="/images/jembatan-barito-new.jpg"
                                                class="img-fluid w-100"
                                                style="object-fit: cover; max-height: 480px;"
                                                alt="Jembatan Barito">

                                            <!-- SVG OVERLAY UNTUK GARIS MERAH -->
                                            <svg class="highlight-svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                                                <!-- Tiang Penyangga: vertikal merah -->
                                                <line id="line-tegak"
                                                    x1="35" y1="1" x2="36" y2="68"
                                                    stroke="#dc3545" stroke-width="2" stroke-linecap="round" class="highlight-line" />

                                                <!-- Badan Jembatan: horizontal hijau -->
                                                <line id="line-datar"
                                                    x1="37" y1="68" x2="90" y2="80"
                                                    stroke="#198754" stroke-width="2" stroke-linecap="round" class="highlight-line" />

                                                <!-- Kabel Baja: diagonal kuning -->
                                                <line id="line-miring"
                                                    x1="35" y1="1" x2="90" y2="80"
                                                    stroke="#ffc107" stroke-width="2" stroke-linecap="round" class="highlight-line" />
                                            </svg>


                                            <div class="text-overlay-container">
                                                <div id="text-tegak" class="overlay-text text-tegak">
                                                    <div class="text-label bg-danger text-white px-2 py-1 rounded">
                                                        TIANG PENYANGGA<i class="bi bi-arrow-right ms-1"></i>
                                                    </div>
                                                </div>
                                                <div id="text-datar" class="overlay-text text-datar">
                                                    <div class="text-label bg-success text-white px-2 py-1 rounded">
                                                        BADAN JEMBATAN<i class="bi bi-arrow-up ms-1"></i>
                                                    </div>
                                                </div>
                                                <div id="text-miring" class="overlay-text text-miring">
                                                    <div class="text-label bg-warning text-dark px-2 py-1 rounded">
                                                        <i class="bi bi-arrow-down-left me-1"></i>KABEL BAJA
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <p class="text-center text-muted small mt-2 fw-bold">Gambar 1 jembatan barito</p>
                                    <div class="text-end mt-2">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="resetHighlight()">
                                            Reset Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mb-4">
                                <div class="col-lg-10 text-center">
                                    <p class="fw-bold mb-3">
                                        Dari bagian jembatan yang diamati tersebut, terbentuk sebuah segitiga seperti gambar di bawah:
                                    </p>
                                    <div class="d-inline-block border rounded bg-light p-3 shadow-sm">
                                        <img src="/images/segitiga_jembatan.png"
                                            class="img-fluid"
                                            style="max-height: 250px;"
                                            alt="Segitiga Jembatan Barito">
                                    </div>
                                    <p class="text-center text-muted mt-2 small fw-bold">Gambar 2 Ilustrasi sisi segitiga siku-siku dari sisi jembatan barito</p>
                                </div>
                            </div>

                            <div class="card shadow-sm border-0 bg-light">
                                <div class="card-body p-4">
                                    <p class="fw-semibold text-center mb-3">
                                        Berdasarkan gambar di atas, <strong>tiang penyangga</strong>, <strong>badan jembatan</strong>,
                                        dan <strong>kabel baja</strong> membentuk sebuah segitiga.
                                        Menurut pengamatanmu berdasarkan sudutnya, segitiga apakah yang terbentuk?
                                    </p>

                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="input-group mb-2">
                                                <select class="form-select border-success" id="inputJawaban">
                                                    <option value="" selected disabled>-- Pilih Jenis Segitiga --</option>
                                                    <option value="siku-siku">Segitiga Siku-siku</option>
                                                    <option value="lancip">Segitiga Lancip</option>
                                                    <option value="tumpul">Segitiga Tumpul</option>
                                                </select>
                                                <button class="btn btn-success fw-bold px-4" onclick="cekJawabanSegitigaSikuSiku()">
                                                    Cek Jawaban
                                                </button>
                                            </div>
                                            <div id="feedbackPesan" class="fw-bold text-center mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 d-none" id="penjelasan-pythagoras">
                <div class="col-12">
                    <div class="card border-success border-4 shadow-sm animate__animated animate__fadeIn">
                        <div class="card-body p-4">
                            <p class="mb-3 text-justify">
                                Tahukah kamu? Setiap kali kita bertemu dengan segitiga siku-siku, ada satu aturan matematika terkenal yang selalu mengikutinya, yaitu <strong>Teorema Pythagoras</strong>. Nah, dengan menggunakan Teorema Pythagoras, kita bisa menjawab rasa penasaran Ahmad tadi untuk mengetahui panjang kabel baja serta cara menghitungnya tanpa harus mengukur secara manual. Namun, sebelum mempelajarinya lebih jauh, kita harus mengetahui bagian-bagian penting dari segitiga siku-siku terlebih dahulu.
                            </p>

                            <p class="mb-0 mt-3 fw-bold text-primary text-center fs-5">
                                Ayo amati dan cocokkan sisi-sisi di bawah ini!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <div class="card bg-white shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="text-center mb-0">Ayo Amati dan Cocokkan</h4>
                        </div>
                        <div class="card-body">

                            <div class="card border-success border-2 mb-2">
                                <div class="card-body">
                                    <h5 class="fw-bold">Petunjuk Pengerjaan</h5>
                                    <ol class="mb-0 ps-3 small">
                                        <li>Perhatikan kembali gambar 2. bagian jembatan barito di atas.</li>
                                        <li>Tentukan apakah bagian tersebut termasuk <strong>Sisi Siku-siku</strong> atau <strong>Sisi Miring</strong>.</li>
                                        <li><strong>Klik & Tahan (Drag)</strong> tombol jawaban yang sesuai, lalu <strong>Lepaskan (Drop)</strong> ke dalam kotak kosong yang tersedia.</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <p class="small text-muted mb-2">
                                                <strong>Tiang Penyangga</strong> dan <strong>Badan Jembatan</strong> saling bertemu membentuk sudut siku-siku. Kedua bagian ini disebut ....
                                            </p>
                                            <div class="drop-zone drop-zone-box w-100" data-correct="siku"></div>
                                            <div class="feedback-msg mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <p class="small text-muted mb-2">
                                                <strong>Kabel Baja</strong> membentang menghubungkan tiang dan lantai di depan sudut siku-siku. Bagiain ini disebut sebagai ....
                                            </p>
                                            <div class="drop-zone drop-zone-box w-100" data-correct="miring"></div>
                                            <div class="feedback-msg mt-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 justify-content-center p-3 bg-white rounded border mb-4" id="drag-source">
                                <div class="drag-item badge bg-success fs-6 p-3 shadow-sm"
                                    draggable="true"
                                    id="item-siku"
                                    data-value="siku"
                                    style="cursor: grab;">Sisi Siku-siku
                                </div>

                                <div class="drag-item badge bg-success fs-6 p-3 shadow-sm"
                                    draggable="true"
                                    id="item-miring"
                                    data-value="miring"
                                    style="cursor: grab;">Sisi Miring
                                </div>
                            </div>

                            <div class="action-buttons mt-4 d-flex justify-content-between px-3">
                                <button class="btn btn-outline-secondary" id="reset-matching">Ulangi</button>
                                <button class="btn btn-success fw-bold" id="check-matching">Cek Jawaban
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-none" id="penguatan-materi-dragdrop">
                <div class="col-12">
                    <div class="card border-success border-4 shadow-sm animate__animated animate__fadeIn">
                        <div class="card-body p-4">
                            <p class="mb-0 text-justify text-dark">
                                Nah, untuk menjawab rasa penasaran Ahmad tentang panjang kabel baja tadi, kita akan menggunakan hubungan antara panjang kedua <strong>sisi siku-siku</strong> dan <strong>sisi miring (hipotenusa)</strong>. Hubungan inilah yang harus selalu kamu ingat untuk memahami <strong>Teorema Pythagoras</strong>. Selanjutnya, mari kita pelajari bagaimana cara merumuskan dan menghitungnya!
                            </p>
                        </div>
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
                            <li>Berdasarkan pengamatanmu jawablah pertanyaan yang tersedia dengan memilih pada menu pilihan, lalu klik tombol cek jawaban.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="mb-4 mt-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Ayo Mengingat Kembali</h4>
                </div>

                <div class="card-body">
                    <h5 class="fw-bold">1. Bilangan Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        Sebelum mempelajari tentang Teorema Pythagoras kita akan mengingat kembali bilangan kuadrat. Masih ingatkah kamu menemukan bilangan kuadrat? Ayo lengkapi tabel di bawah ini!
                    </p>

                    <div class="card border-success shadow-sm border-2 mb-2">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Petunjuk Pengerjaan:</h6>
                            <ol class="mb-0 small">
                                <li>Perhatikan tabel bentuk kuadrat di bawah ini.</li>
                                <li>Lengkapi setiap kolom sesuai hubungan antara bentuk perkalian, bentuk kuadrat, dan nilainya.</li>
                                <li>Isilah semua bagian titik-titik yang masih kosong dengan jawaban yang tepat.</li>
                                <li>Periksa kembali jawabanmu agar sesuai dengan pola yang telah dicontohkan.</li>
                                <li>Klik <strong>Cek Jawaban</strong> untuk memeriksa jawaban kamu.</li>
                            </ol>
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
                                                style="width: 80px;" data-answer="9" placeholder="...">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>\(5\)</td>
                                        <td>\(5 \times 5\)</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-start">
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1"
                                                    style="width: 80px; height: 35px;" data-answer="5" placeholder="...">
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
                                                    style="width: 80px;" data-answer="8" placeholder="...">
                                                <span>×</span>
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1"
                                                    style="width: 80px;" data-answer="8" placeholder="...">
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
                                                    style="width: 80px;" data-answer="9" placeholder="...">
                                                <span>×</span>
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1"
                                                    style="width: 80px;" data-answer="9" placeholder="...">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-start">
                                                <input type="number" class="form-control text-center fw-bold input-kuadrat px-1"
                                                    style="width: 80px; height: 35px;" data-answer="9" placeholder="...">
                                                \(^2\)
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control d-inline-block text-center fw-bold input-kuadrat px-1"
                                                style="width: 80px;" data-answer="81" placeholder="...">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mb-3">
                            <button class="btn btn-success px-5 fw-bold shadow-sm" id="btnCekKuadrat">
                                Cek Jawaban
                            </button>
                        </div>
                    </div>

                    <!-- <div id="penguatan-materi" class="d-none mt-3 mb-3   animate__animated animate__fadeInUp">
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
                    </div> -->
                    <h5 class="fw-bold mt-5">2. Akar Kuadrat</h5>
                    <hr>

                    <p class="text-justify">
                        Selain bilangan kuadrat, kita akan mengingat kembali tentang <strong>Akar kuadrat</strong>. Perhatikan contoh di bawah ini dan lengkapi kolom yang kosong dengan jawaban yang tepat!
                    </p>

                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8">
                            <div class="card bg-white border shadow-sm">
                                <div class="card-body text-center">
                                    <p class="mb-3 fs-5">
                                        Jika <strong>\(a^2 = b\)</strong>, maka <strong>\(\sqrt{b} = a\)</strong>
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
                                            <th style="width:35%">Bentuk</th>
                                            <th style="width:35%">Sifat</th>
                                            <th style="width:20%">Syarat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <tr>
                                            <td>i.</td>
                                            <td class="text-start ps-4">\(\sqrt{a \times b}\)</td>
                                            <td class="text-start ps-4">\(\sqrt{a} \times \sqrt{b}\)</td>
                                            <td>\(a \ge 0, b \ge 0\)</td>
                                        </tr>
                                        <tr>
                                            <td>ii.</td>
                                            <td class="text-start ps-4">\(\sqrt{\frac{a}{b}}\)</td>
                                            <td class="text-start ps-4">\(\frac{\sqrt{a}}{\sqrt{b}}\)</td>
                                            <td>\(a \ge 0, b \ne 0\)</td>
                                        </tr>
                                        <tr>
                                            <td>iii.</td>
                                            <td class="text-start ps-4">\(a\sqrt{b} + a\sqrt{c}\)</td>
                                            <td class="text-start ps-4">\(a(\sqrt{b} + \sqrt{c})\)</td>
                                            <td>\(b \ge 0, c \ge 0\)</td>
                                        </tr>
                                        <tr>
                                            <td>iv.</td>
                                            <td class="text-start ps-4">\(\sqrt{a} \times \sqrt{a}\)</td>
                                            <td class="text-start ps-4">\(a\)</td>
                                            <td>\(a \ge 0\)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card border-success shadow-sm border-2 mb-2">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">Petunjuk Pengerjaan:</h6>
                            <ol class="mb-0 small">
                                <li>Perhatikan soal-soal akar kuadrat di bawah ini.</li>
                                <li>Lengkapi setiap soal sesuai hasil akar kuadrat, sifat-sifat kuadrat.</li>
                                <li>Isilah semua bagian yang masih kosong dengan jawaban yang tepat.</li>
                                <li>Periksa kembali jawabanmu dan klik <strong>Cek Jawaban</strong> untuk memeriksa jawaban kamu.</li>
                            </ol>
                        </div>
                    </div>

                    <div id="akar-container">
                        <div class="row g-3 justify-content-center">

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm px-2">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-5">\(\sqrt{36}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold"
                                            style="max-width: 80px; width: 100%;" data-answer="6" placeholder="...">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm px-2">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-5">\(\sqrt{49}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold"
                                            style="max-width: 80px; width: 100%;" data-answer="7" placeholder="...">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm px-2">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-5">\(\sqrt{81}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold"
                                            style="max-width: 80px; width: 100%;" data-answer="9" placeholder="...">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm px-2">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-6">\(\sqrt{4} \times \sqrt{9}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold"
                                            style="max-width: 80px; width: 100%;" data-answer="6" placeholder="...">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card bg-white border text-center h-100 py-4 shadow-sm px-2">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                        <label class="form-label fw-bold mb-0 fs-6">\(\sqrt{4 \times 25}\)</label>
                                        <span class="fw-bold fs-5">=</span>
                                        <input type="number" class="form-control text-center input-akar fw-bold"
                                            style="max-width: 90px; width: 100%;" data-answer="10" placeholder="...">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center mt-4 mb-3">
                            <button class="btn btn-success px-5 fw-bold shadow-sm" id="btnCekAkar">
                                Cek Jawaban
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
                            <div class="col-12 col-lg-6 order-2 order-lg-1">
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
                                                    <strong>....</strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm border-success"
                                                    id="inputTitikSudut"
                                                    placeholder="...">

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
                                                    <strong>Tepat Sekali.</strong> Sudut B memiliki ukuran 90° dan disebut juga sudut siku-siku. Oleh karena itu, segitiga tersebut termasuk jenis <strong>segitiga siku-siku</strong>.
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


                            {{-- KOLOM KANAN: GEOGEBRA --}}
                            <div class="col-lg-6 order-1 order-lg-2">
                                <div class="p-3 border border-success border-opacity-25 rounded bg-white shadow-sm materi1-geogebra-box">

                                    {{-- GeoGebra Full & Center --}}
                                    <div class="materi1-geogebra-frame" style="width: 100%; height: 60vh; min-height: 400px; display: flex;">
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
                                    <canvas id="triangleCanvas" style="cursor: crosshair; display: block; width: 100%; height: 100%; touch-action: none;"></canvas>
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
                                            <p class="small fw-bold text-muted mt-1 mb-0">Selesaikan instruksi di atas untuk membuka soal dan jawab dengan tepat!.</p>
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
                                                <button type="submit" id="btnPeriksaQuiz" class="btn btn-success fw-bold shadow-sm px-4" disabled>Cek Jawaban</button>
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
                            Sedangkan untuk menyatakan <strong>panjang/ukuran</strong> dari ruas garis tersebut, cukup ditulis sebagai \(AB\).
                            <br>
                            Selain menggunakan dua huruf kapital (misal: \(AB\)), kita juga bisa menamai sisi menggunakan
                            <strong>satu huruf kecil</strong> dengan syarat memperhatikan sudut yang berhadapan dengan sisi tersebut.
                        </p>

                        <div class="row align-items-center g-4 materi1-penamaan-intro">
                            <div class="col-md-6">
                                <div class="p-3 bg-white rounded border border-success border-4 shadow-sm d-flex flex-column align-items-center justify-content-center h-100 materi1-penamaan-image-box">

                                    <img src="/images/mengenal_sisi_segitiga_sikusiku.png"
                                        alt="Mengenal Sisi Segitiga Siku-siku"
                                        class="img-fluid"
                                        style="max-height: 205px; object-fit: contain;">

                                    <p class="text-center text-muted small mt-2 fw-bold mb-0">
                                        Gambar 3 Segitiga siku-siku ABC
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="alert alert-light border-start border-success border-4 shadow-sm mb-0 h-100 d-flex flex-column justify-content-center materi1-penamaan-rule-box">
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
                                    <p class="text-center text-muted small fw-bold">
                                        Gambar 4 Segitiga siku-siku ABC
                                    </p>
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
                                    <p class="text-center text-muted small fw-bold">
                                        Gambar 5 Segitiga siku-siku MNO
                                    </p>
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
                                    <p class="text-center text-muted small fw-bold">
                                        Gambar 6 Segitiga siku-siku PQR
                                    </p>
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
                                <p class="text-center text-muted small mt-2 fw-bold">
                                    Gambar 7 Segitiga siku-siku sisi e, f, dan g
                                </p>
                            </div>

                            {{-- Kolom Tabel --}}
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th width="20%">Nama Sisi</th>
                                                <th width="40%">Titik Sudut di depan sisi</th>
                                                <th width="40%">Ruas Garis yang terbentuk</th>
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
                                <p class="text-center text-muted small mt-2 fw-bold">
                                    Gambar 8 Segitiga siku-siku sisi h, i, dan j
                                </p>
                            </div>

                            {{-- Kolom Tabel --}}
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th width="20%">Nama Sisi</th>
                                                <th width="40%">Titik Sudut di depan sisi</th>
                                                <th width="40%">Ruas Garis yang terbentuk</th>
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
                                Cek Jawaban
                            </button>
                            <div id="final-feedback" class="mt-3 fw-bold fs-5"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= HALAMAN 4 ================= -->
    <section class="materi-page d-none" data-page="3">
        <div class="row">

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
                        <p class="mb-0 text-justify">
                            Masih ingatkah kamu dengan pertanyaan tentang bagian jembatan sebelumnya? Kita ingin tahu bagaimana cara menghitung panjang kabel baja jembatan sebagai sisi miring suatu segitiga siku-siku.
                            Untuk menemukannya, kita bisa mengilustrasikan bagian jembatan sebagai segitiga siku-siku dan menempelkan sebuah persegi pada setiap sisi segitiga siku-siku tersebut. Mari amati hubungan persegi pada sisi-sisi pada segitiga siku-siku ini melalui Geogebra di bawah!
                        </p>

                        <div class="d-flex justify-content-center mb-2 mt-3">
                            <button type="button" class="btn btn-outline-success shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalPetunjukAktivitas">
                                Petunjuk Pengerjaan
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="geogebra-container border rounded shadow-sm" style="overflow: hidden; min-height: 500px;">
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

                        <div class="modal fade" id="modalPetunjukAktivitas" tabindex="-1" aria-labelledby="modalPetunjukLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                <div class="modal-content border-success border-2">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold text-success" id="modalPetunjukLabel">Petunjuk Pengerjaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ol class="ps-3 small text-muted mb-0" style="text-align: justify;">
                                            <li class="mb-2">Perhatikan segitiga siku-siku yang ditampilkan pada bidang koordinat.</li>
                                            <li class="mb-2">Klik tombol <strong>Tampilkan Persegi A</strong> dan <strong>Tampilkan Persegi B</strong>.</li>
                                            <li class="mb-2"><strong>Hitunglah secara manual</strong> jumlah kotak satuan pada sisi pinggir (Panjang Sisi) dan jumlah total kotak kecil (Luas Persegi) dari masing-masing bangun.</li>
                                            <li class="mb-2">Klik tombol <strong>Tampilkan Persegi C</strong> untuk melihat persegi pada sisi miring.</li>
                                            <li class="mb-2">Klik <strong>Mulai Animasi Hubungan</strong>. Amati perpindahan kotak dari Persegi A dan B ke Persegi C.</li>
                                            <li>Catat hasil hitunganmu ke dalam tabel di bawah ini.</li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success fw-bold" data-bs-dismiss="modal">Saya Mengerti</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4 shadow-sm border-success">
                                    <div class="card-body">

                                        <p class="mb-3 text-justify">
                                            Setelah melakukan percobaan di atas, perhatikan ukuran sisi segitiga siku-siku dan ukuran persegi yang menempel pada sisi-sisinya. Hitunglah panjang sisi dan luas dari masing-masing persegi tersebut, dan masukkan hasilnya ke dalam tabel yang tersedia.
                                        </p>

                                        <div class="alert alert-light border border-success mb-4">
                                            <p class="mb-0 small fw-bold text-dark">Tugasmu:</p>
                                            <ol class="mb-0 small text-muted ps-3">
                                                <li>Hitung <strong>panjang sisi persegi</strong> atau perhatikan dan hitung jumlah kotak yang ada pada sisi persegi.</li>
                                                <li>Hitung <strong>luas persegi</strong> dengan rumus \(\text{Sisi} \times \text{Sisi}\) atau perhatikan dan hitung jumlah seluruh kotak yang ada pada setiap persegi.</li>
                                                <li>Isilah hasil perhitungan kamu ke dalam tabel berikut untuk Persegi A, B, dan C.</li>
                                            </ol>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle bg-white mb-3">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th class="align-middle">Panjang dan Luas Persegi</th>
                                                        <th>Persegi A</th>
                                                        <th>Persegi B</th>
                                                        <th>Persegi C</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold text-start">Panjang Sisi</td>
                                                        <td><input type="number" id="sisi_a" class="form-control text-center mx-auto fw-bold" style="width: 80px;" placeholder="..."></td>
                                                        <td><input type="number" id="sisi_b" class="form-control text-center mx-auto fw-bold" style="width: 80px;" placeholder="..."></td>
                                                        <td><input type="number" id="sisi_c" class="form-control text-center mx-auto fw-bold" style="width: 80px;" placeholder="..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-start">Luas Persegi (sisi x sisi)</td>

                                                        {{-- Penjabaran Persegi A --}}
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <input type="number" id="luas_a_1" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                <span class="fw-bold">×</span>
                                                                <input type="number" id="luas_a_2" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                <span class="fw-bold">=</span>
                                                                <div class="d-flex align-items-start">
                                                                    <input type="number" id="luas_a_sq" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                    <sup class="fw-bold mt-1">2</sup>
                                                                </div>
                                                                <span class="fw-bold">=</span>
                                                                <input type="number" id="luas_a_hasil" class="form-control text-center px-1 fw-bold text-primary" style="width: 65px;" placeholder="...">
                                                            </div>
                                                        </td>

                                                        {{-- Penjabaran Persegi B --}}
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <input type="number" id="luas_b_1" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                <span class="fw-bold">×</span>
                                                                <input type="number" id="luas_b_2" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                <span class="fw-bold">=</span>
                                                                <div class="d-flex align-items-start">
                                                                    <input type="number" id="luas_b_sq" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                    <sup class="fw-bold mt-1">2</sup>
                                                                </div>
                                                                <span class="fw-bold">=</span>
                                                                <input type="number" id="luas_b_hasil" class="form-control text-center px-1 fw-bold text-primary" style="width: 65px;" placeholder="...">
                                                            </div>
                                                        </td>

                                                        {{-- Penjabaran Persegi C --}}
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <input type="number" id="luas_c_1" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                <span class="fw-bold">×</span>
                                                                <input type="number" id="luas_c_2" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                <span class="fw-bold">=</span>
                                                                <div class="d-flex align-items-start">
                                                                    <input type="number" id="luas_c_sq" class="form-control text-center px-1" style="width: 65px;" placeholder="...">
                                                                    <sup class="fw-bold mt-1">2</sup>
                                                                </div>
                                                                <span class="fw-bold">=</span>
                                                                <input type="number" id="luas_c_hasil" class="form-control text-center px-1 fw-bold text-primary" style="width: 65px;" placeholder="...">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <button class="btn btn-success fw-bold mb-2" onclick="cekTabelGeoGebra()">Cek Jawaban Tabel</button>
                                        <div id="feedbackTabelGeoGebra" class="mb-2 fw-semibold"></div>

                                        <hr class="border-success my-4">

                                        <div class="mb-4">
                                            <h6 class="fw-bold">1. Berdasarkan pengamatanmu pada tabel di atas, persegi manakah yang memiliki luas paling besar?</h6>
                                            <p class="text-justify">
                                                Perhatikan angka-angka pada baris <strong>Luas Persegi</strong> di tabelmu, coba tentukan persegi mana yang paling besar dari ketiga luas persegi tersebut dengan memilih salah satu kotak di bawah ini.
                                            </p>

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-outline-success w-100 h-100 p-2 shadow-sm text-center btn-soal1" onclick="cekSoal1geogebra('salah', this)">
                                                        <span class="fw-bold">Persegi A</span><br>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-outline-success w-100 h-100 p-2 shadow-sm text-center btn-soal1" onclick="cekSoal1geogebra('salah', this)">
                                                        <span class="fw-bold">Persegi B</span><br>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-outline-success w-100 h-100 p-2 shadow-sm text-center btn-soal1" onclick="cekSoal1geogebra('benar', this)">
                                                        <span class="fw-bold">Persegi C</span><br>
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="feedbackSalah1" class="alert alert-danger d-none small text-center fw-bold animate__animated animate__fadeIn">
                                                Jawaban Kamu kurang tepat. Coba perhatikan lagi tabelmu, mana angka yang paling tinggi?
                                            </div>

                                            <div id="feedbackBenar1" class="alert alert-success d-none small text-center fw-bold animate__animated animate__fadeIn">
                                                Jawaban Kamu Benar! Persegi C memiliki luas yang paling besar.
                                            </div>
                                        </div>

                                        <div>
                                            <h6 class="fw-bold mb-2">2. Temukan hubungan luas persegi yang menempel pada sisi segitiga siku-siku!</h6>
                                            <p class="mb-3 text-justify">
                                                Perhatikan kembali angka-angka pada baris <strong>Luas Persegi</strong> di tabelmu, coba temukan hubungan matematika yang menurutmu paling tepat antara ketiga luas persegi tersebut dengan memilih salah satu kotak di bawah ini.
                                            </p>

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-outline-success w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="cekPilihan('salah', this)">
                                                        <span class="fw-bold">Luas Persegi A + Luas Persegi C = Luas Persegi B</span>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-outline-success w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="cekPilihan('benar', this)">
                                                        <span class="fw-bold">Luas Persegi A + Luas Persegi B = Luas Persegi C</span>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-outline-success w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="cekPilihan('salah', this)">
                                                        <span class="fw-bold">Luas Persegi C + Luas Persegi B = Luas Persegi A</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="feedbackSalah" class="mb-3 fw-bold small text-center text-danger d-none">
                                                Masih kurang tepat. Cek kembali hasil penjumlahanmu.
                                            </div>

                                            <div id="feedbackBenar" class="mb-3 fw-bold small text-center text-success d-none">
                                                Jawaban kamu benar!
                                            </div>

                                            <div id="boxPenjelasanAkhir" class="alert bg-white border border-success shadow-sm d-none animate__animated animate__fadeIn">
                                                <h6 class="fw-bold text-success mb-2"><i class="bi bi-check-circle-fill me-1"></i>Tepat Sekali!</h6>
                                                <p class="mb-3 text-justify small text-dark">
                                                    Berdasarkan percobaan di atas, kita menemukan bahwa <strong>Luas Persegi A + Luas Persegi B = Luas Persegi C</strong> dengan penyelesaian:
                                                </p>

                                                <div class="text-center fw-bold text-dark bg-light p-3 rounded border mb-3">

                                                    <div class="mb-2">
                                                        Luas Persegi A + Luas Persegi B = Luas Persegi C <br>
                                                        <span class="text-primary fs-5">9 + 16 = 25</span>
                                                    </div>

                                                    <hr class="my-3">

                                                    <div class="mb-3 text-start px-md-3 small fw-normal">
                                                        <p class="mb-2">
                                                            Ingat kembali bahwa rumus Luas Persegi adalah <strong>sisi &times; sisi</strong> atau <strong>sisi&sup2;</strong>. Karena persegi-persegi tersebut menempel tepat pada sisi segitiga, maka panjang sisi perseginya sama dengan panjang sisi segitiga siku-siku!
                                                        </p>
                                                        <ul class="mb-0 text-dark">
                                                            <li>Panjang <strong>sisi siku-siku 1 (BC)</strong> = 3</li>
                                                            <li>Panjang <strong>sisi siku-siku 2 (AC)</strong> = 4</li>
                                                            <li>Panjang <strong>sisi miring (AB)</strong> = 5</li>
                                                        </ul>
                                                    </div>

                                                    <hr class="my-3">

                                                    <div class="mb-2">
                                                        <p class="small fw-normal mb-2 text-muted">Sehingga, jika dituliskan dalam bentuk panjang sisi segitiga, hubungannya menjadi:</p>
                                                        <div class="p-2 mb-2 rounded bg-white border border-secondary d-inline-block">
                                                            <span class="text-danger">\( (\text{sisi siku-siku 1})^2 + (\text{sisi siku-siku 2})^2 = (\text{sisi miring})^2 \)</span>
                                                        </div>
                                                        <br>
                                                        <span class="fs-5">\( 3^2 + 4^2 = 5^2 \)</span>
                                                    </div>

                                                </div>

                                                <div class="p-3 rounded border border-success bg-success bg-opacity-10 text-center">
                                                    <p class="mb-3 small text-center text-dark">
                                                        Jika <strong>sisi siku-siku</strong> kita misalkan sebagai variabel <strong>a</strong> dan <strong>b</strong>, serta <strong>sisi miring</strong> kita misalkan sebagai <strong>c</strong>, maka kesimpulannya adalah: <br><br>
                                                        <em>"Sisi siku-siku yang dikuadratkan dan dijumlahkan hasilnya akan sama dengan kuadrat sisi miringnya."</em><br><br>
                                                        Inilah hubungan yang dikenal dengan <strong>Teorema Pythagoras</strong>:
                                                    </p>

                                                    <h3 class="fw-bold mb-0 text-success">
                                                        \( a^2 + b^2 = c^2 \)
                                                    </h3>
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

                                <p class="text-justify mb-3">
                                    Berdasarkan aktivitas sebelumnya, hubungan yang kalian temukan merupakan <strong>Dalil Pythagoras</strong>, yang berbunyi:
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
                            <p class="text-center text-muted small mt-2 fw-bold">Gambar 9 segitiga siku-siku ABC</p>
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
        </div>
    </section>

    <!-- ================= HALAMAN 5 ================= -->
    <section class="materi-page d-none" data-page="4">
        <div class="row">

            <!-- ================================= -->
            <!-- CONTOH SOAL 1 -->
            <!-- ================================= -->
            <div class="col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Contoh 1</h4>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-white shadow-sm border-start border-success border-4" role="alert">
                            <div class="small">
                                <strong>Petunjuk:</strong> Perhatikan ilustrasi gambar di bawah ini, kemudian lengkapi data yang diketahui dan selesaikan perhitungannya.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-justify mb-4">
                                    <p class="text-dark mb-0">
                                        Sebuah tangga menuju laboratorium sekolah memiliki jarak 4 meter daripada dinding dan ketinggian tangga tersebut 3 meter dari lantai. Jika Ahmad ingin menuju laboratorium dan menaiki tangga, berapakah jarak yang harus ditempuh oleh Ahmad hingga sampai ke atas?
                                    </p>
                                </div>
                                <div class="bg-white rounded-3 shadow-sm border p-4">

                                    <div class="row g-4">

                                        <!-- Gambar 1 -->
                                        <div class="col-md-6">
                                            <div class="text-center h-100 d-flex flex-column align-items-center">

                                                <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                                                    <img src="/images/contoh_soal_1.png"
                                                        class="img-fluid"
                                                        style="max-height: 280px;"
                                                        alt="Ilustrasi Tangga">
                                                </div>

                                                <p class="text-muted small mt-2 fw-bold">
                                                    Gambar 10 Ilustrasi siswa menaiki tangga
                                                </p>

                                            </div>
                                        </div>

                                        <!-- Gambar 2 -->
                                        <div class="col-md-6">
                                            <div class="text-center h-100 d-flex flex-column align-items-center">

                                                <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                                                    <img src="/images/contoh_soal_1_2.png"
                                                        class="img-fluid"
                                                        style="max-height: 280px;"
                                                        alt="Sketsa Segitiga">
                                                </div>

                                                <p class="text-muted small mt-2 fw-bold">
                                                    Gambar 11 Ilustrasi sisi tangga pada segitiga siku-siku
                                                </p>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card border mb-4">
                                    <div class="card-header border">
                                        <h6 class="fw-bold mb-0 small text-dark">Diketahui</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="flex-grow-1" style="max-width: 200px;">Jarak ujung tangga atau panjang AC =</span>
                                            <input type="number" id="c1_dik_b" class="form-control form-control-sm text-center border-secondary mx-2" style="width: 70px;" placeholder="...">
                                            <span>m.</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="flex-grow-1" style="max-width: 200px;">Tinggi Dinding atau panjang BC =</span>
                                            <input type="number" id="c1_dik_a" class="form-control form-control-sm text-center border-secondary mx-2" style="width: 70px;" placeholder="...">
                                            <span>m.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border">
                                    <div class="card-header border">
                                        <h6 class="fw-bold mb-0 small text-dark">Ditanya</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 text-muted small">Panjang sisi miring AB.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="card h-100 border">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body">
                                        <ol class="ps-3 mb-0 text-muted list-group-numbered-custom">
                                            <li>
                                                <strong>Karena mencari sisi miring (hipotenusa), kita gunakan rumus pythagoras</strong>

                                                <div class="p-3 bg-white border rounded shadow-sm">
                                                    <small class="fst-italic text-secondary d-block mb-3 text-center">Rumus: \( AB^2 = BC^2 + AC^2 \)</small>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="fw-bold text-dark text-nowrap">\( AB^2 = \)</span>
                                                        <div class="input-group input-group-sm" style="width: 75px;">
                                                            <input type="number" id="c1_step1_a" class="form-control text-center px-1" placeholder="...">
                                                            <span class="input-group-text px-2">²</span>
                                                        </div>
                                                        <span class="fw-bold">+</span>
                                                        <div class="input-group input-group-sm" style="width: 75px;">
                                                            <input type="number" id="c1_step1_b" class="form-control text-center px-1" placeholder="...">
                                                            <span class="input-group-text px-2">²</span>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="text-dark text-nowrap">\( AB^2 = \)</span>
                                                        <input type="number" id="c1_step2_a_sq" class="form-control form-control-sm text-center bg-white" style="width:70px;" placeholder="...">
                                                        <span>+</span>
                                                        <input type="number" id="c1_step2_b_sq" class="form-control form-control-sm text-center bg-white" style="width:70px;" placeholder="...">
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="text-dark text-nowrap">\( AB^2 = \)</span>
                                                        <input type="number" id="c1_step3_sum" class="form-control form-control-sm text-center bg-white fw-bold" style="width:90px;" placeholder="...">
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2">
                                                        <span class="text-dark text-nowrap">\( AB \) = &radic;</span>
                                                        <input type="number" id="c1_step4_root" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                        <span class="text-nowrap">=</span>
                                                        <input type="number" id="c1_final" class="form-control form-control-sm text-center text-success fw-bold px-1" style="width:80px;" placeholder="...">
                                                        <span class="fw-bold text-dark text-nowrap">meter</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>

                                        <div class="mt-4 d-flex justify-content-between align-items-center border-top pt-3">
                                            <div id="c1_feedback" class="small fw-bold"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekContoh1()">
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

            <!-- ================================= -->
            <!-- CONTOH SOAL 2 -->
            <!-- ================================= -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Contoh 2</h4>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-white shadow-sm border-start border-success border-4" role="alert">
                            <div class="small">
                                <strong>Petunjuk:</strong> Perhatikan ilustrasi gambar di bawah ini, kemudian lengkapi data yang diketahui dan selesaikan perhitungannya.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-justify mb-4">
                                    <p class="text-dark mb-0">
                                        Diketahui dua segitiga siku-siku seperti gambar di bawah. Panjang \( AB = 13 \text{ cm} \), \( AC = 12 \text{ cm} \), dan \( CD = 3 \text{ cm} \). Hitunglah panjang garis <strong>\( BD \)</strong>!
                                    </p>
                                </div>

                                <div class="bg-white rounded-3 shadow-sm border p-4 d-flex flex-column justify-content-center align-items-center text-center">

                                    <img src="/images/contoh_soal_2.png"
                                        class="img-fluid"
                                        style="max-height: 280px;"
                                        alt="Contoh 2">

                                    <p class="text-muted small mt-2 fw-bold mb-0">
                                        Gambar 12 Segitiga siku-siku berdempetan.
                                    </p>

                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card border mb-4">
                                    <div class="card-header border">
                                        <h6 class="fw-bold mb-0 small text-dark">Diketahui</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="flex-grow-1" style="max-width: 200px;">Panjang sisi miring AB =</span>
                                            <input type="number" id="c2_dik_ab" class="form-control form-control-sm text-center border-secondary mx-2" style="width: 70px;" placeholder="...">
                                            <span>cm.</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="flex-grow-1" style="max-width: 200px;">Panjang sisi siku-siku AC =</span>
                                            <input type="number" id="c2_dik_ac" class="form-control form-control-sm text-center border-secondary mx-2" style="width: 70px;" placeholder="...">
                                            <span>cm.</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="flex-grow-1" style="max-width: 200px;">Panjang sisi siku-siku CD =</span>
                                            <input type="number" id="c2_dik_cd" class="form-control form-control-sm text-center border-secondary mx-2" style="width: 70px;" placeholder="...">
                                            <span>cm.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border">
                                    <div class="card-header border">
                                        <h6 class="fw-bold mb-0 small text-dark">Ditanya</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 text-muted small">Panjang sisi \( BD = ...? \)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card h-100 border">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="fw-bold mb-0 small text-dark"><i class="fas fa-calculator me-2"></i>Langkah Penyelesaian</h6>
                                    </div>
                                    <div class="card-body">
                                        <ol class="ps-3 mb-0 text-muted list-group-numbered-custom">

                                            <li class="mb-4">
                                                <strong>Cari panjang sisi \( BC \) terlebih dahulu:</strong>
                                                <p class="text-muted mb-2 small">
                                                    Gunakan segitiga \( ABC \). Karena \( BC \) adalah salah satu sisi siku-siku, maka kurangkan kuadrat sisi miring dengan sisi siku-siku lainnya.
                                                </p>

                                                <div class="p-3 bg-white border rounded shadow-sm">
                                                    <small class="fst-italic text-secondary d-block mb-3 text-center">Rumus: \( BC^2 = AB^2 - AC^2 \)</small>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="fw-bold text-dark text-nowrap">\( BC^2 = \)</span>
                                                        <div class="input-group input-group-sm" style="width: 75px;">
                                                            <input type="number" id="c2_step1_ab" class="form-control text-center px-1" placeholder="...">
                                                            <span class="input-group-text px-2">²</span>
                                                        </div>
                                                        <span class="fw-bold text-dark">-</span>
                                                        <div class="input-group input-group-sm" style="width: 75px;">
                                                            <input type="number" id="c2_step1_ac" class="form-control text-center px-1" placeholder="...">
                                                            <span class="input-group-text px-2">²</span>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="text-dark text-nowrap">\( BC^2 = \)</span>
                                                        <input type="number" id="c2_step1_res1" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                        <span class="text-nowrap">-</span>
                                                        <input type="number" id="c2_step1_res2" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2">
                                                        <span class="text-dark text-nowrap">\( BC \) = &radic;</span>
                                                        <input type="number" id="c2_step1_sqrt" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                        <span class="text-nowrap">=</span>
                                                        <input type="number" id="c2_bc_result" class="form-control form-control-sm text-center fw-bold text-success px-1" style="width:80px;" placeholder="...">
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <strong>Hitung panjang garis \( BD \):</strong>
                                                <p class="text-muted mb-2 small">
                                                    Gunakan segitiga \( BCD \). Kita cari sisi siku-siku \( BD \).
                                                </p>

                                                <div class="p-3 bg-white border rounded shadow-sm">
                                                    <small class="fst-italic text-secondary d-block mb-3 text-center">Rumus: \( BD^2 = BC^2 - CD^2 \)</small>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="fw-bold text-dark text-nowrap">\( BD^2 = \)</span>
                                                        <div class="input-group input-group-sm" style="width: 75px;">
                                                            <input type="number" id="c2_step2_bc" class="form-control text-center px-1" placeholder="...">
                                                            <span class="input-group-text px-2">²</span>
                                                        </div>
                                                        <span class="fw-bold text-dark">-</span>
                                                        <div class="input-group input-group-sm" style="width: 75px;">
                                                            <input type="number" id="c2_step2_cd" class="form-control text-center px-1" placeholder="...">
                                                            <span class="input-group-text px-2">²</span>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2 mb-3">
                                                        <span class="text-dark text-nowrap">\( BD^2 = \)</span>
                                                        <input type="number" id="c2_step2_res1" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                        <span class="text-nowrap">-</span>
                                                        <input type="number" id="c2_step2_res2" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                    </div>

                                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 gap-md-2">
                                                        <span class="text-dark text-nowrap">\( BD \) = &radic;</span>
                                                        <input type="number" id="c2_step2_sqrt" class="form-control form-control-sm text-center bg-white px-1" style="width:70px;" placeholder="...">
                                                        <span class="text-nowrap">=</span>
                                                        <input type="number" id="c2_final" class="form-control form-control-sm text-center text-success fw-bold px-1" style="width:80px;" placeholder="...">
                                                        <span class="fw-bold text-dark text-nowrap">cm</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>

                                        <div class="mt-4 d-flex justify-content-between align-items-center border-top pt-3">
                                            <div id="c2_feedback" class="small fw-bold"></div>
                                            <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekContoh2()">
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

    <!-- Halaman 6 -->
    <section class="materi-page d-none" data-page="5">
        <div class="row justify-content-center">
            <!-- ================================= -->
            <!-- AYO BERLATIH -->
            <!-- ================================= -->

            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header text-center border-bottom py-3">
                        <h4>Ayo Berlatih</h4>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-white shadow-sm border-start border-success border-4 mb-4">
                            <h6 class="fw-bold">Petunjuk Pengerjaan:</h6>
                            <ol class="mb-0 small text-muted text-justify">
                                <li>Amati gambar dan informasi yang diketahui di kolom sebelah kiri pada setiap soal.</li>
                                <li><strong>Pada Soal 1</strong> pilihlah sisi yang dicari pada pilihan yang tersedia dan isilah sisi yang sudah diketahui, lalu pilih operator dan rumus teorema pythagoras yang paling tepat.</li>
                                <li><strong>Pada Soal 2 dan 3</strong> Tarik <em>(drag)</em> item kotak yang tersedia di kiri, lalu lepas <em>(drop)</em> ke dalam area kotak putus-putus yang sesuai di sebelah kanan dan lengkap perhitungannya</li>
                                <li>Klik tombol <strong class="text-success">Cek Jawaban</strong> di setiap akhir nomor untuk memeriksa apakah langkah penyelesaianmu sudah benar.</li>
                            </ol>
                        </div>

                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0 fw-bold">Soal 1</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-5 mb-3">
                                        <p class="text-muted fw-bold mb-2 small">Perhatikan gambar segitiga siku-siku di bawah ini:</p>
                                        <div class="bg-white rounded-3 border border-dark mb-3 d-flex flex-column justify-content-center align-items-center text-center">

                                            <img src="/images/segitiga_latihan1_nomor1.png"
                                                class="img-fluid p-2"
                                                style="max-height: 300px;"
                                                alt="Soal 1">

                                            <p class="text-muted small mt-2 fw-bold mb-2">
                                                Gambar 13 Segitiga siku-siku ABC latihan 1
                                            </p>

                                        </div>
                                        <div class="alert bg-light border border-dark text-justify small shadow-sm">
                                            Berdasarkan gambar di atas, temukan rumus Pythagoras yang sesuai berdasarkan petunjuk yang tersedia!
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="card bg-white border border-dark rounded-3 h-100 shadow-sm">
                                            <div class="card-body">

                                                <div class="d-flex flex-column gap-3">

                                                    <div class="p-3 border-1 border-dark rounded">
                                                        <p class="mb-2 fw-bold text-dark small">Berdasarkan gambar di samping, sisi apa yang akan kita cari panjangnya?</p>
                                                        <select id="s1_tanya" class="form-select form-select-sm border-dark bg-white text-dark mb-3">
                                                            <option value="">-- Pilih sisi yang dicari --</option>
                                                            <option value="miring">Sisi miring (Hipotenusa)</option>
                                                            <option value="siku_ac">Sisi siku-siku (AC)</option>
                                                            <option value="siku_bc">Sisi siku-siku (BC)</option>
                                                        </select>

                                                        <p class="fw-bold text-dark small">Sisi apa saja yang sudah diketahui nilainya?</p>
                                                        <div class="d-flex align-items-center gap-2 small">
                                                            <input type="text" class="form-control form-control-sm text-center border-dark bg-white" style="width: 80px;" placeholder="..." id="s1_diketahui_1">
                                                            <span class="text-dark">dan</span>
                                                            <input type="text" class="form-control form-control-sm text-center border-dark bg-white" style="width: 80px;" placeholder="..." id="s1_diketahui_2">
                                                        </div>
                                                    </div>

                                                    <div class="p-3 border-1 border-dark rounded">
                                                        <p class="mb-2 fw-bold text-justify small">Berdasarkan sisi yang kita cari, operator apa yang harus digunakan pada rumus Teorema Pythagoras untuk menemukan sisi yang dicari?</p>
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <button class="btn btn-outline-dark w-100 btn-sm fw-bold btn-pilihan" onclick="pilihRumusAnalisis('benar', this)">
                                                                    Ditambah (+)
                                                                </button>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-outline-dark w-100 btn-sm fw-bold btn-pilihan" onclick="pilihRumusAnalisis('salah', this)">
                                                                    Dikurang (-)
                                                                </button>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-outline-dark w-100 btn-sm fw-bold btn-pilihan" onclick="pilihRumusAnalisis('salah', this)">
                                                                    Dikali (x)
                                                                </button>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-outline-dark w-100 btn-sm fw-bold btn-pilihan" onclick="pilihRumusAnalisis('salah', this)">
                                                                    Dibagi (/)
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="p-3 border-1 border-dark rounded">
                                                        <p class="mb-2 fw-bold text-dark small">Berdasarkan analisis di atas, rumus Teorema Pythagoras mana yang paling tepat digunakan?</p>
                                                        <div class="row g-3 mt-2">
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-outline-dark w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="pilihRumusAnalisis('benar', this)">
                                                                    <span class="fw-bold">AC² = AB² + BC²</span>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-outline-dark w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="pilihRumusAnalisis('salah1', this)">
                                                                    <span class="fw-bold">AC² = AB² - BC²</span>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-outline-dark w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="pilihRumusAnalisis('salah2', this)">
                                                                    <span class="fw-bold">AC² = BC² - AB²</span>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-outline-dark w-100 h-100 p-2 shadow-sm text-center btn-pilihan" onclick="pilihRumusAnalisis('salah3', this)">
                                                                    <span class="fw-bold">AC = AB - BC</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div id="s1_feedback" class="small fw-bold text-success"></div>
                                                    <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekLatihanAnalisis1()">
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
                                <h5 class="mb-0 fw-bold">Soal 2: Menyusun Informasi dan Rumus</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-5 mb-4">
                                        <p class="text-muted fw-bold mb-2 small">Perhatikan gambar segitiga siku-siku MNO di bawah ini:</p>
                                        <div class="bg-white rounded-3 border border-dark mb-3 d-flex flex-column justify-content-center align-items-center text-center">

                                            <img src="/images/segitiga_latihan1_nomor2.png"
                                                class="img-fluid p-2"
                                                style="max-height: 250px;"
                                                alt="Segitiga MNO">

                                            <p class="text-muted small mt-2 fw-bold mb-2">
                                                Gambar 14 Segitiga siku-siku MNO latihan 1
                                            </p>

                                        </div>
                                        <div class="alert bg-light border border-dark text-justify small shadow-sm">
                                            Berdasarkan segitiga siku-siku di atas, tentukan panjang sisi miring MO!
                                        </div>

                                        {{-- Pilihan Item Soal 2 yang Sudah Diperbaiki (ID Unik) --}}
                                        <div class="p-3 bg-white border border-dark rounded shadow-sm mb-3">
                                            <h6 class="text-dark small"><strong>Pilihan Item</strong></h6>
                                            <p class="text-dark mb-3 small"> Tarik (drag) kotak-kotak item di bawah ini ke area yang sesuai untuk menyusun jawaban yang tepat!</p>

                                            <div class="d-flex flex-wrap gap-2" id="drag-items-container">
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-8cm" data-value="8cm">8 cm</div>
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-15cm" data-value="15cm">15 cm</div>
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-17cm" data-value="salah_17">17 cm</div>

                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-mo" data-value="MO">MO</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-mn" data-value="MN">MN</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-no" data-value="NO">NO</div>

                                                <div class="p-2 bg-dark border border-dark text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-tanya" data-value="tanya">Panjang sisi miring MO</div>
                                                <div class="p-2 bg-dark border border-dark text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s2-siku" data-value="salah_siku">Panjang sisi siku-siku</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="card bg-white border border-dark rounded-3 shadow-sm">
                                            <div class="card-body px-2 px-md-3">

                                                <div class="d-flex flex-column gap-3">

                                                    <div class="p-2 p-md-3 bg-light border border-dark rounded">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <strong class="text-dark small d-block">Diketahui:</strong>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <span class="text-dark fw-bold small d-block mb-2">Panjang sisi siku-siku (MN) =</span>
                                                                <div class="drop-zone rounded d-flex align-items-center justify-content-center p-1 w-100" style="min-height: 40px; border: 2px dashed #adb5bd; background-color: #f8f9fa;" data-target="s2_diketahui_mn"></div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <span class="text-dark fw-bold small d-block mb-2">Panjang sisi siku-siku (NO) =</span>
                                                                <div class="drop-zone rounded d-flex align-items-center justify-content-center p-1 w-100" style="min-height: 40px; border: 2px dashed #adb5bd; background-color: #f8f9fa;" data-target="s2_diketahui_no"></div>
                                                            </div>

                                                            <div class="col-12 mt-2">
                                                                <strong class="text-dark small d-block mb-2">Ditanya:</strong>
                                                                <div class="drop-zone rounded d-flex align-items-center justify-content-center p-1 w-100" style="min-height: 42px; border: 2px dashed #adb5bd; background-color: #f8f9fa;" data-target="s2_ditanya"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="p-2 p-md-3 bg-light border border-dark rounded">
                                                        <p class="text-dark small text-center mb-3">Karena kita mencari sisi miring, susun rumus Pythagoras yang tepat dengan menarik nama-nama sisi ke dalam kotak di bawah ini!</p>

                                                        <div class="d-flex flex-nowrap align-items-center justify-content-center gap-1 mb-3 p-2 bg-white border border-dark rounded shadow-sm overflow-x-auto">
                                                            <div class="d-flex align-items-start text-nowrap">
                                                                <div class="drop-zone rounded d-flex align-items-center justify-content-center p-1" style="min-width: 55px; min-height: 38px; border: 2px dashed #adb5bd; background-color: #f8f9fa;" data-target="s2_rumus_miring"></div>
                                                                <span class="text-dark fw-bold ms-1">²</span>
                                                            </div>

                                                            <span class="fw-bold text-dark mx-1 text-nowrap">=</span>

                                                            <div class="d-flex align-items-start text-nowrap">
                                                                <div class="drop-zone rounded d-flex align-items-center justify-content-center p-1" style="min-width: 55px; min-height: 38px; border: 2px dashed #adb5bd; background-color: #f8f9fa;" data-target="s2_rumus_tegak1"></div>
                                                                <span class="text-dark fw-bold ms-1">²</span>
                                                            </div>

                                                            <span class="fw-bold text-dark mx-1 text-nowrap">+</span>

                                                            <div class="d-flex align-items-start text-nowrap">
                                                                <div class="drop-zone rounded d-flex align-items-center justify-content-center p-1" style="min-width: 55px; min-height: 38px; border: 2px dashed #adb5bd; background-color: #f8f9fa;" data-target="s2_rumus_tegak2"></div>
                                                                <span class="text-dark fw-bold ms-1">²</span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex flex-nowrap align-items-center justify-content-center gap-1 mb-2 overflow-x-auto w-100 pb-1">
                                                            <div class="input-group input-group-sm" style="min-width: 65px; width: 70px;">
                                                                <input type="text" id="s2_inp_mo_1" class="form-control text-center bg-white border-dark shadow-sm fw-bold px-1" placeholder="...">
                                                                <span class="input-group-text bg-white border-dark text-dark fw-bold px-1">²</span>
                                                            </div>
                                                            <span class="fw-bold text-dark text-nowrap">=</span>
                                                            <div class="input-group input-group-sm" style="min-width: 65px; width: 70px;">
                                                                <input type="number" id="s2_inp_mn" class="form-control text-center bg-white border-dark shadow-sm px-1" placeholder="...">
                                                                <span class="input-group-text bg-white border-dark text-dark fw-bold px-1">²</span>
                                                            </div>
                                                            <span class="fw-bold text-dark text-nowrap">+</span>
                                                            <div class="input-group input-group-sm" style="min-width: 65px; width: 70px;">
                                                                <input type="number" id="s2_inp_no" class="form-control text-center bg-white border-dark shadow-sm px-1" placeholder="...">
                                                                <span class="input-group-text bg-white border-dark text-dark fw-bold px-1">²</span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex flex-nowrap align-items-center justify-content-center gap-1 mb-2 overflow-x-auto w-100 pb-1">
                                                            <div class="input-group input-group-sm" style="min-width: 65px; width: 70px;">
                                                                <input type="text" id="s2_inp_mo_2" class="form-control text-center bg-white border-dark shadow-sm fw-bold px-1" placeholder="...">
                                                                <span class="input-group-text bg-white border-dark text-dark fw-bold px-1">²</span>
                                                            </div>
                                                            <span class="fw-bold text-dark text-nowrap">=</span>
                                                            <input type="number" id="s2_res_mn_sq" class="form-control form-control-sm text-center bg-white border-dark shadow-sm px-1" style="min-width: 65px; width: 70px;" placeholder="...">
                                                            <span class="fw-bold text-dark text-nowrap">+</span>
                                                            <input type="number" id="s2_res_no_sq" class="form-control form-control-sm text-center bg-white border-dark shadow-sm px-1" style="min-width: 65px; width: 70px;" placeholder="...">
                                                        </div>

                                                        <div class="d-flex flex-nowrap align-items-center justify-content-center gap-1 mb-2 overflow-x-auto w-100 pb-1">
                                                            <div class="input-group input-group-sm" style="min-width: 65px; width: 70px;">
                                                                <input type="text" id="s2_inp_mo_3" class="form-control text-center bg-white border-dark shadow-sm fw-bold px-1" placeholder="...">
                                                                <span class="input-group-text bg-white border-dark text-dark fw-bold px-1">²</span>
                                                            </div>
                                                            <span class="fw-bold text-dark text-nowrap">=</span>
                                                            <input type="number" id="s2_res_sum" class="form-control form-control-sm text-center bg-white border-dark fw-bold shadow-sm px-1" style="min-width: 80px; width: 90px;" placeholder="...">
                                                        </div>

                                                        <div class="d-flex flex-nowrap align-items-center justify-content-center gap-1 mb-3 overflow-x-auto w-100 pb-1">
                                                            <input type="text" id="s2_inp_mo_4" class="form-control form-control-sm text-center bg-white border-dark shadow-sm fw-bold px-1" style="min-width: 55px; width: 60px;" placeholder="...">
                                                            <span class="fw-bold text-dark text-nowrap">=</span>
                                                            <span class="text-dark fw-bold text-nowrap">&radic;</span>
                                                            <input type="number" id="s2_res_sqrt" class="form-control form-control-sm text-center bg-white border-dark fw-bold shadow-sm px-1" style="min-width: 55px; width: 60px;" placeholder="...">
                                                            <span class="text-dark fw-bold text-nowrap">=</span>
                                                            <input type="number" id="s2_final" class="form-control form-control-sm text-center bg-white fw-bold text-dark border-dark shadow-sm px-1" style="min-width: 60px; width: 65px;" placeholder="...">
                                                            <span class="fw-bold text-dark text-nowrap">cm</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4 d-flex justify-content-between align-items-center border-top border-dark pt-3">
                                                    <div id="s2_feedback" class="small fw-bold text-success"></div>
                                                    <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekLatihanAnalisis2()">
                                                        Cek Jawaban
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow mb-4" id="soal3-container">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0 fw-bold">Soal 3: Penyelesaian Segitiga Bertingkat Kompleks</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- KIRI: KONTEN GAMBAR DAN ITEM DRAG --}}
                                    <div class="col-lg-5 mb-4">
                                        <p class="text-muted fw-bold mb-2 small">Perhatikan gabungan bangun segitiga siku-siku di bawah ini:</p>
                                        <div class="bg-white rounded-3 border border-dark mb-3 d-flex flex-column justify-content-center align-items-center text-center">
                                            <img src="/images/segitiga_latihan1_nomor3.png" class="img-fluid p-2" style="max-height: 240px;" alt="Gabungan Segitiga Siku-siku">
                                            <p class="text-muted small mt-2 fw-bold mb-2">Gambar 15 Tiga segitiga siku-siku berdempetan</p>
                                        </div>

                                        <div class="p-3 bg-white border border-dark rounded shadow-sm">
                                            <h6 class="text-dark small"><strong>Pilihan Item Soal 3</strong></h6>
                                            <p class="text-dark mb-3 small">Tarik komponen berikut ke dalam kotak analisis jawaban yang tepat!</p>

                                            <div class="d-flex flex-wrap gap-2" id="drag-items-container-s3">
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-24" data-value="24">24 cm</div>
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-7" data-value="7">7 cm</div>
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-16" data-value="16">16 cm</div>
                                                <div class="p-2 bg-secondary border border-secondary text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-12" data-value="12">12 cm</div>

                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-ae" data-value="AE">AE</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-ce" data-value="CE">CE</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-ad" data-value="AD">AD</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-bd" data-value="BD">BD</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-ac" data-value="AC">AC</div>
                                                <div class="p-2 bg-success border border-success text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-ab" data-value="AB">AB</div>

                                                <div class="p-2 bg-dark border border-dark text-white rounded shadow-sm draggable-item cursor-grab fw-bold small user-select-none" draggable="true" id="item-s3-bc" data-value="BC">Sisi BC</div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- KANAN: AREA VALIDASI PERHITUNGAN BERTINGKAT --}}
                                    <div class="col-lg-7">
                                        <div class="card bg-white border border-dark rounded-3 shadow-sm">
                                            <div class="card-body px-2 px-md-3">

                                                {{-- Analisis Awal --}}
                                                <div class="p-2 p-md-3 bg-light border border-dark rounded mb-3">
                                                    <strong class="text-dark small d-block mb-2">1. Analisis Identifikasi Masalah:</strong>
                                                    <div class="row g-2 text-dark small">
                                                        <div class="col-6">AE = <div class="drop-zone rounded d-inline-flex align-items-center justify-content-center p-1 w-100" style="min-height:35px; border:2px dashed #adb5bd;" data-target="s3_diket_ae"></div>
                                                        </div>
                                                        <div class="col-6">CE = <div class="drop-zone rounded d-inline-flex align-items-center justify-content-center p-1 w-100" style="min-height:35px; border:2px dashed #adb5bd;" data-target="s3_diket_ce"></div>
                                                        </div>
                                                        <div class="col-6">AD = <div class="drop-zone rounded d-inline-flex align-items-center justify-content-center p-1 w-100" style="min-height:35px; border:2px dashed #adb5bd;" data-target="s3_diket_ad"></div>
                                                        </div>
                                                        <div class="col-6">BD = <div class="drop-zone rounded d-inline-flex align-items-center justify-content-center p-1 w-100" style="min-height:35px; border:2px dashed #adb5bd;" data-target="s3_diket_bd"></div>
                                                        </div>
                                                        <div class="col-12 mt-2">Ditanya: <div class="drop-zone rounded d-inline-flex align-items-center justify-content-center p-1" style="width:120px; min-height:35px; border:2px dashed #adb5bd;" data-target="s3_ditanya"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Tahap 1: Hitung AC --}}
                                                <div class="p-2 p-md-3 bg-light border border-dark rounded mb-3 small">
                                                    <strong class="text-dark d-block mb-2">2. Tahap I: Cari Sisi Miring AC pada \(\triangle AEC\)</strong>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(AC^2\) = </span>
                                                        <div class="drop-zone rounded" style="width:50px; min-height:30px; border:2px dashed #adb5bd;" data-target="s3_ac_drop1"></div><span>² +</span>
                                                        <div class="drop-zone rounded" style="width:50px; min-height:30px; border:2px dashed #adb5bd;" data-target="s3_ac_drop2"></div><span>²</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(AC^2\) = </span>
                                                        <input type="number" id="s3_ac_sq1" class="form-control form-control-sm text-center px-1" style="width:60px;"><span>² +</span>
                                                        <input type="number" id="s3_ac_sq2" class="form-control form-control-sm text-center px-1" style="width:60px;"><span>²</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(AC^2\) = </span>
                                                        <input type="number" id="s3_ac_sum1" class="form-control form-control-sm text-center px-1" style="width:65px;"><span> +</span>
                                                        <input type="number" id="s3_ac_sum2" class="form-control form-control-sm text-center px-1" style="width:65px;">
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <span>\(AC\) = &radic;<input type="number" id="s3_ac_total" class="form-control form-control-sm d-inline-block text-center px-1" style="width:65px;"> = </span>
                                                        <input type="number" id="s3_ac_sqrt_val" class="d-none" value="625">
                                                        <input type="number" id="s3_ac_final" class="form-control form-control-sm text-center fw-bold text-success px-1" style="width:60px;"> <span>cm</span>
                                                    </div>
                                                </div>

                                                {{-- Tahap 2: Hitung AB --}}
                                                <div class="p-2 p-md-3 bg-light border border-dark rounded mb-3 small">
                                                    <strong class="text-dark d-block mb-2">3. Tahap II: Cari Sisi Miring AB pada \(\triangle ADB\)</strong>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(AB^2\) = </span>
                                                        <div class="drop-zone rounded" style="width:50px; min-height:30px; border:2px dashed #adb5bd;" data-target="s3_ab_drop1"></div><span>² +</span>
                                                        <div class="drop-zone rounded" style="width:50px; min-height:30px; border:2px dashed #adb5bd;" data-target="s3_ab_drop2"></div><span>²</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(AB^2\) = </span>
                                                        <input type="number" id="s3_ab_sq1" class="form-control form-control-sm text-center px-1" style="width:60px;"><span>² +</span>
                                                        <input type="number" id="s3_ab_sq2" class="form-control form-control-sm text-center px-1" style="width:60px;"><span>²</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(AB^2\) = </span>
                                                        <input type="number" id="s3_ab_sum1" class="form-control form-control-sm text-center px-1" style="width:65px;"><span> +</span>
                                                        <input type="number" id="s3_ab_sum2" class="form-control form-control-sm text-center px-1" style="width:65px;">
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <span>\(AB\) = &radic;<input type="number" id="s3_ab_total" class="form-control form-control-sm d-inline-block text-center px-1" style="width:65px;"> = </span>
                                                        <input type="number" id="s3_ab_sqrt_val" class="d-none" value="400">
                                                        <input type="number" id="s3_ab_final" class="form-control form-control-sm text-center fw-bold text-success px-1" style="width:60px;"> <span>cm</span>
                                                    </div>
                                                </div>

                                                {{-- Tahap 3: Hitung BC --}}
                                                <div class="p-2 p-md-3 bg-light border border-dark rounded small">
                                                    <strong class="text-dark d-block mb-2">4. Tahap III: Cari Sisi Siku-siku Utama BC pada \(\triangle ABC\)</strong>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(BC^2\) = </span>
                                                        <div class="drop-zone rounded" style="width:50px; min-height:30px; border:2px dashed #adb5bd;" data-target="s3_bc_drop1"></div><span>² -</span>
                                                        <div class="drop-zone rounded" style="width:50px; min-height:30px; border:2px dashed #adb5bd;" data-target="s3_bc_drop2"></div><span>²</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(BC^2\) = </span>
                                                        <input type="number" id="s3_bc_sq1" class="form-control form-control-sm text-center px-1" style="width:60px;"><span>² -</span>
                                                        <input type="number" id="s3_bc_sq2" class="form-control form-control-sm text-center px-1" style="width:60px;"><span>²</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                                        <span>\(BC^2\) = </span>
                                                        <input type="number" id="s3_bc_diff1" class="form-control form-control-sm text-center px-1" style="width:65px;"><span> -</span>
                                                        <input type="number" id="s3_bc_diff2" class="form-control form-control-sm text-center px-1" style="width:65px;">
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <span>\(BC\) = &radic;<input type="number" id="s3_bc_total" class="form-control form-control-sm d-inline-block text-center px-1" style="width:65px;"> = </span>
                                                        <input type="number" id="s3_bc_sqrt_val" class="d-none" value="225">
                                                        <input type="number" id="s3_bc_final" class="form-control form-control-sm text-center fw-bold text-success px-1" style="width:60px;"> <span>cm</span>
                                                    </div>
                                                </div>

                                                {{-- Tombol Aksi Akhir Soal 3 --}}
                                                <div class="mt-4 d-flex justify-content-between align-items-center border-top border-dark pt-3">
                                                    <div id="s3_feedback" class="small fw-bold text-success"></div>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="resetSoal3()">Reset</button>
                                                        <button type="button" class="btn btn-success btn-sm px-4 fw-bold shadow-sm" onclick="cekLatihanAnalisis3()">Cek Jawaban</button>
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
            </div>
        </div>
    </section>

    <!-- Halaman 7 -->
    <section class="materi-page d-none" data-page="6">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-center bg-success text-white">
                        <h4 class="mb-0 fw-bold">Rangkuman Materi</h4>
                    </div>

                    <div class="card-body p-4 bg-white">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 fw-bold" style="width: 32px; height: 32px;">1</div>
                            <div class="ms-3">
                                <p class="text-dark mb-0" style="line-height: 1.6;">
                                    <strong>Bilangan kuadrat</strong> adalah perkalian antara bilangan tersebut dengan dirinya sendiri. <strong>Akar kuadrat</strong> adalah kebalikan dari operasi kuadrat, yaitu bilangan tak negatif yang jika dikuadratkan akan menghasilkan bilangan yang sama dengan bilangan semula.
                                </p>
                            </div>
                        </div>

                        <hr class="border-secondary my-4">

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 fw-bold" style="width: 32px; height: 32px;">2</div>
                            <div class="ms-3">
                                <p class="text-dark mb-0" style="text-align: justify; line-height: 1.6;">
                                    <strong>Teorema Pythagoras</strong> menyatakan bahwa kuadrat sisi miring pada segitiga siku-siku sama dengan jumlah kuadrat sisi-sisi penyikunya.
                                </p>
                            </div>
                        </div>

                        <hr class="border-secondary my-4">

                        <div class="d-flex align-items-start">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 fw-bold" style="width: 32px; height: 32px;">3</div>
                            <div class="ms-3 w-100">
                                <div class="row align-items-center g-4">
                                    <div class="col-md-7">
                                        <div class="p-3 bg-light rounded border border-success border-opacity-25 text-center">
                                            <div class="mb-3">
                                                <p>Pada Segitiga di samping berlaku rumus Teorema Pythagoras:</p>
                                                <h4 class="fw-bold text-success mb-0">\( c^2 = a^2 + b^2 \) (Mencari Sisi miring)</h4>
                                            </div>
                                            <div class="text-muted small  text-center">
                                                <p>Rumus lain yang berlaku:</p>
                                                <h4 class="fw-bold text-success mb-0">\( a^2 = c^2 - b^2 \) (Mencari Sisi Siku-Siku)</h4>
                                                <h4 class="fw-bold text-success mb-0">\( b^2 = c^2 - a^2 \) (Mencari Sisi Siku-Siku)</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-center d-flex flex-column align-items-center">
                                        <img src="/images/segitiga_versilain.png"
                                            alt="Rangkuman Teorema Pythagoras"
                                            class="img-fluid rounded border border-secondary shadow-sm"
                                            style="max-width: 200px;">
                                        <p class="text-muted small mt-2 fw-bold mb-0">
                                            Gambar 16 Segitiga siku-siku rangkuman
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-center bg-light border-bottom border-success border-3">
                        <h4 class="mb-1 fw-bold text-dark">Refleksi Belajar</h4>
                        <small class="text-muted">
                            Tidak ada jawaban benar atau salah. Jawablah jujur sesuai dengan apa yang kamu rasakan dan pahami hari ini!
                        </small>
                    </div>

                    <div class="card-body p-4">
                        <form id="formRefleksi" action="{{ url('/siswa/refleksi/simpan') }}" onsubmit="event.preventDefault(); cekRefleksi();">
                            @csrf
                            <input type="hidden" name="kode_materi" value="materi_teorema_pythagoras">
                            <div class="mb-4">
                                <label class="fw-semibold text-dark">
                                    1. Saat mempelajari materi konsep Teorema Pythagoras tadi, apakah kamu merasa kesulitan saat mengaitkannya dengan bilangan kuadrat dan akar kuadrat?
                                </label>

                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input border-secondary cursor-pointer" type="radio" name="ref1_opsi" id="ref1_ya" value="ya" required>
                                        <label class="form-check-label text-dark cursor-pointer" for="ref1_ya">Ya, lumayan sulit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input border-secondary cursor-pointer" type="radio" name="ref1_opsi" id="ref1_tidak" value="tidak" required>
                                        <label class="form-check-label text-dark cursor-pointer" for="ref1_tidak">Tidak, cukup mudah</label>
                                    </div>
                                </div>

                                <textarea name="ref1_text" id="ref1_text" class="form-control border-secondary mt-2 shadow-sm" rows="3" placeholder="Ceritakan sedikit, bagian mana yang terasa sulit atau bagian mana yang paling mudah..." required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fw-semibold text-dark">
                                    2. Coba ceritakan menggunakan bahasamu sendiri, apa kesimpulan yang kamu dapatkan tentang hubungan sisi-sisi pada segitiga siku-siku?
                                </label>
                                <textarea name="ref2" id="ref2" class="form-control border-secondary mt-2 shadow-sm" rows="3" placeholder="Tuliskan pemahamanmu di sini..." required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="fw-semibold text-dark">
                                    3. Jika kamu diminta menjelaskan cara mencari panjang sisi miring (hipotenusa) kepada temanmu yang belum paham, bagaimana cara kamu menjelaskannya?
                                </label>
                                <textarea name="ref3" id="ref3" class="form-control border-secondary mt-2 shadow-sm" rows="3" placeholder="Tuliskan langkah-langkah penjelasanmu..." required></textarea>
                            </div>

                            <div id="refleksi_feedback" class="text-center w-100 mb-3"></div>

                            <div class="text-center mt-4">
                                <button type="submit" id="btnSimpanRefleksi" class="btn btn-success px-5 fw-bold shadow-sm">
                                    Simpan Refleksi
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top border-secondary">
                            <p class="text-muted mb-0">Setelah menyimpan refleksi, silakan lanjut ke Kuis 1 untuk menguji kemampuanmu!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<!-- Pagination -->
<div class="d-flex justify-content-center align-items-center mt-5 pt-4 border-top">
    <nav>
        <ul class="pagination justify-content-center mb-0 flex-wrap gap-2 materi-pagination">
            <li class="page-item">
                <button class="page-link px-3 py-2 prev-btn rounded shadow-sm">Sebelumnya</button>
            </li>
            {{-- Looping 7 Halaman (0 sampai 6) --}}
            @for ($i = 0; $i <= 6; $i++)
                <li class="page-item {{ $i == 0 ? 'active' : '' }}">
                <button class="page-link px-3 py-2 page-btn-bottom rounded shadow-sm" data-page="{{ $i }}">{{ $i + 1 }}</button>
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