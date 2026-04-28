<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Petunjuk Penggunaan</title>

    <!-- Font & Bootstrap -->
    <!-- Font & Bootstrap (mengikuti contoh) -->
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'PT Sans', system-ui, -apple-system, "Segoe UI", Roboto;
            background: #ffffff;
        }

        .guide-card {
            border-radius: 12px;
        }

        .accordion-button {
            background-color: #198754;
            color: white;
            font-weight: 600;
        }

        .accordion-button:not(.collapsed) {
            background-color: #198754 !important;
            color: white !important;
        }

        .accordion-body {
            background: #ffffff;
        }

        .step-modern {
            list-style: none;
            padding-left: 0;
        }

        .step-modern li {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .step-badge {
            width: 26px;
            height: 26px;
            background: #198754;
            color: white;
            border-radius: 50%;
            text-align: center;
            font-size: 0.8rem;
            line-height: 26px;
            font-weight: bold;
        }

        .info-highlight {
            background: #e9f7ef;
            border-left: 4px solid #198754;
            padding: 0.8rem;
            border-radius: 6px;
            margin-top: 1rem;
        }

        .img-preview {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>

<main class="d-flex flex-column py-4">
    <div class="container">

        <!-- Tombol kembali (ikut struktur info) -->
        <a href="{{ url('/') }}" class="btn btn-outline-primary mb-3" style="border-radius:10px;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="row">
            <div class="col-12">
                <div class="card guide-card shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="text-center">Petunjuk Penggunaan</h2>
                        <p class="text-center text-muted mb-4">
                            Pilih bagian di bawah untuk melihat panduan penggunaan media pembelajaran.
                        </p>

                        <!-- ISI LAMA (TIDAK DIUBAH) -->
                        <div class="accordion" id="guideAccordion">

                            <!-- Beranda -->
                            <div class="accordion-item">
                                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#beranda">
                                    Halaman Beranda
                                </button>
                                <div id="beranda" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <img src="{{ asset('images/petunjuk/1.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span><strong>Tombol Daftar dan Masuk</strong>untuk registrasi dan masuk ke akun</li>
                                            <li><span class="step-badge">2</span><strong>Navigasi</strong>digunakan untuk berpindah dan mengakses halaman seperti Informasi, Materi Belajar, dan Petunjuk Penggunaan</li>
                                            <li><span class="step-badge">3</span><strong>Masuk untuk Mulai</strong>digunakan untuk memulai pembelajaran dengan masuk ke akun terlebih dahulu sebelum mengakses materi.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Daftar dan Masuk -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#daftar">
                                    Cara Mendaftar dan Masuk
                                </button>
                                <div id="daftar" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <img src="{{ asset('images/petunjuk/2.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span>Isi Nama Lengkap, Email, dan Kata Sandi.</li>
                                            <li><span class="step-badge">2</span>Navigasi ke untuk pendaftaran, kembali ke beranda atau sudah punya akun.</li>
                                        </ul>
                                        <img src="{{ asset('images/petunjuk/2,1.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span>Isi Email, dan Kata Sandi untuk masuk.</li>
                                            <li><span class="step-badge">2</span>Navigasi ke untuk halaman Beranda, dan untuk Daftar.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Materi -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#materi">
                                    Materi Belajar
                                </button>
                                <div id="materi" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <img src="{{ asset('images/petunjuk/3.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span><strong>Nama dan Email</strong>pengguna ditampilkan sebagai identitas setelah berhasil masuk, dan terdapat halaman profil dan logout saat di klik. </li>
                                            <li><span class="step-badge">2</span><strong>Navigasi Halaman Materi</strong>digunakan untuk berpindah halaman, terdapat di atas dan bawah setiap halaman materi.</li>
                                            <li><span class="step-badge">3</span><strong><i>Sidebar</i> materi dan kuis</strong>digunakan untuk berpindah halaman setiap subbab dan mengakses kuis setiap subbab.</li>
                                            <li><span class="step-badge">4</span><strong>Navigasi Halaman</strong>digunakan untuk berpindah halaman Dashboard, Leaderboard, dan Nilai.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Latihan Kuis -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#kuis">
                                    Latihan dan Kuis
                                </button>
                                <div id="kuis" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <!-- Kuis -->
                                        <img src="{{ asset('images/petunjuk/5.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span><strong>Soal-soal latihan</strong>berupa gambar, arahan, dan pertanyaan yang harus di selesaikan.</li>
                                            <li><span class="step-badge">2</span><strong>Langkah penyelesaian</strong>berupa langkah-langkah yang harus diikuti untuk menyelesaikan soal-soal latihan.</li>
                                        </ul>
                                        <!-- Latihan -->
                                        <img src="{{ asset('images/petunjuk/4.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span><strong>Navigasi Soal</strong>digunakan untuk berpindah soal, dan terdapat keterangan warna sesuai status soal.</li>
                                            <li><span class="step-badge">2</span><strong>Judul dan Status Kuis</strong>terdapat informasi tentang kuis yang sedang dikerjakan, Durasi, Jumlah Soal, dan Nilai Maksimal.</li>
                                            <li><span class="step-badge">3</span><strong>Gambar, Soal, dan Pilihan Jawaban</strong>digunakan untuk menampilkan informasi soal dan pilihan jawaban.</li>
                                            <li><span class="step-badge">4</span><strong>Navigasi Soal dan ragu-ragu</strong>digunakan untuk berpindah nomor dan menandai soal yang masih ragu untuk dijawab.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Elemen Gamifikasi -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#kuis">
                                    Elemen Gamifikasi
                                </button>
                                <div id="kuis" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <!-- Kuis -->
                                        <img src="{{ asset('images/petunjuk/6.png') }}" class="img-preview">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span><strong>Elemen Gamifikasi pada Dashboard</strong>terdapat tiga elemen yaitu Progres, Poin, dan Lencana.</li>
                                            <li><span class="step-badge">2</span><strong>Elemen Gamifikasi <i>Leaderboard</i></strong>menampilkan peringkat pengguna berdasarkan poin yang mereka kumpulkan.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            

                            <!-- Hubungi Saya -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#kontak">
                                    Hubungi Saya
                                </button>
                                <div id="kontak" class="accordion-collapse collapse">
                                    <div class="accordion-body">

                                        <ul class="step-modern">
                                            <li><span class="step-badge">1</span> <a href="mailto:mnurfadhillah20@@gmail.com">Email: mnurfadhillah20@gmail.com</a></li>
                                            <li><span class="step-badge">2</span> WhatsApp: <a href="https://wa.me/6285750693123" target="_blank">085750693123 (Muhammad Nur Fadhillah)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END -->

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>