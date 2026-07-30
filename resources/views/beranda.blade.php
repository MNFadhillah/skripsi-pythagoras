<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PythaLearn</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #379080;
            /* hijau utama */
            --accent: #FCE225;
            /* kuning aksen */
            --dark: #09473D;
            /* hijau gelap */
            --muted: #6c757d;
            --bg-hero: linear-gradient(135deg, rgba(55, 144, 128, 0.9), rgba(9, 71, 61, 0.9));
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'PT Sans', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* HERO */
        .hero {
            background: var(--bg-hero);
            color: white;
            padding: 1rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero .glass {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 6px 18px rgba(9, 71, 61, 0.18);
        }

        .brand {
            font-weight: 700;
            letter-spacing: 0.4px;
            color: black;
        }

        .badge-accent {
            background: var(--accent);
            color: #083b34;
            font-weight: 600;
            border-radius: 999px;
            padding: .35rem .75rem;
        }

        /* HERO IMAGE CONTROL */
        .hero-image {
            max-width: 100%;
            /* KUNCI UTAMA: mengecilkan gambar */
            max-height: 340px;
            /* batasi tinggi agar tidak mendominasi */
            height: auto;
            object-fit: contain;
        }

        /* FEATURE CARDS */
        .feature-card {
            border-radius: 12px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(16, 78, 69, 0.08);
        }

        /* CTA */
        .cta-btn {
            background: linear-gradient(90deg, var(--primary), var(--dark));
            border: none;
            color: white;
            padding: .8rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(55, 144, 128, 0.18);
        }

        .btn-start {
            background-color: #09473D;
            color: #fff;
            border-radius: 8px;
            transition: 0.25s ease-in-out;
        }

        .btn-start:hover {
            background-color: #0A5E4F;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        /* PERBAIKAN ALIGNMENT HERO - TANPA MENGUBAH UKURAN LAYOUT */
        .hero-title,
        .hero-description {
            text-align: justify;
            text-align-last: left;
        }

        /* posisi tombol desktop tetap seperti semula */
        .hero-action {
            text-align: left;
        }

        /* hanya di HP tombol dibuat tengah */
        @media (max-width: 767.98px) {
            .hero-action {
                text-align: center;
            }

            .hero-action .btn-start {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">

            <!-- Brand -->
            <div class="brand">
                <a href="{{ url('/') }}" class="fw-bold h2 text-decoration-none" style="color:var(--dark)">PythaLearn</a>
            </div>
            <!-- MENU -->
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    @guest
                    {{-- BELUM LOGIN --}}
                    <li class="nav-item ms-2">
                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm">
                            Daftar
                        </a>
                    </li>

                    <li class="nav-item ms-2">
                        <a href="{{ route('login') }}" class="btn btn-success btn-sm text-white">
                            Masuk
                        </a>
                    </li>
                    @endguest

                    @auth
                    {{-- SUDAH LOGIN --}}
                    <li class="nav-item ms-2">
                        <a href="{{ auth()->user()->role === 'guru'
                ? route('guru.dashboard')
                : route('siswa.menu.dashboard') }}"
                            class="btn btn-success btn-sm text-white">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item ms-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">
                                Logout
                            </button>
                        </form>
                    </li>
                    @endauth

                </ul>

            </div>
        </div>

    </nav>

    <div class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="glass">
                        <div class="row align-items-center">

                            <!-- KOLOM KIRI : TEKS -->
                            <div class="col-md-8">
                                <h1 class="hero-title">
                                    PythaLearn : Web Pembelajaran Interaktif Teorema Pythagoras
                                </h1>

                                <p class="lead text-white hero-description">
                                    Web ini dirancang untuk meningkatkan pemahaman konsep Teorema Pythagoras melalui penerapan Model <i>Drills and Practice</i> yang dipadukan dengan gamifikasi, sehingga mendorong keterlibatan aktif siswa dan memperkuat pemahaman konsep.
                                </p>

                                <div class="hero-action">
                                    @auth
                                    {{-- TOMBOL SESUAI ROLE --}}
                                    @if(auth()->user()->role === 'guru')
                                    <a href="{{ route('guru.dashboard') }}"
                                        class="btn btn-start py-2 px-4">
                                        <i class="bi bi-person-badge me-2"></i>
                                        Halaman Guru
                                    </a>
                                    @else
                                    <a href="{{ route('siswa.menu.dashboard') }}"
                                        class="btn btn-start py-2 px-4">
                                        <i class="bi bi-rocket-takeoff-fill me-2"></i>
                                        Ayo Mulai!
                                    </a>
                                    @endif
                                    @else
                                    <a href="{{ route('login') }}" class="btn btn-start py-2 px-4">
                                        Masuk untuk Mulai
                                    </a>
                                    @endauth
                                </div>
                            </div>

                            <!-- KOLOM KANAN : GAMBAR -->
                            <div class="col-md-4 text-center">
                                <img
                                    src="{{ asset('images/ornamen_landing.png') }}"
                                    alt="Ilustrasi Teorema Pythagoras"
                                    class="img-fluid hero-image">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Fitur -->
    <section id="fitur" class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="{{ route('informasi') }}" class="info-box-link text-decoration-none">
                        <div class="card feature-card p-3 h-100 rounded-3 d-flex flex-row align-items-center gap-3">
                            <div class="rounded-3 p-3" style="min-width:64px;min-height:64px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-info-circle fs-2" style="color:var(--primary)"></i>
                            </div>
                            <div>
                                <h5>Informasi</h5>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    @auth
                    @if(auth()->user()->role === 'guru')
                    <a href="{{ route('guru.dashboard') }}" class="info-box-link text-decoration-none">
                        <div class="card feature-card p-3 h-100 rounded-3 d-flex flex-row align-items-center gap-3">
                            <div class="rounded-3 p-3" style="min-width:64px;min-height:64px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-person-badge fs-2" style="color:var(--primary)"></i>
                            </div>
                            <div>
                                <h5>Halaman Guru</h5>
                            </div>
                        </div>
                    </a>
                    @else
                    <a href="{{ route('siswa.menu.dashboard') }}" class="info-box-link text-decoration-none">
                        <div class="card feature-card p-3 h-100 rounded-3 d-flex flex-row align-items-center gap-3">
                            <div class="rounded-3 p-3" style="min-width:64px;min-height:64px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-journal-bookmark fs-2" style="color:var(--primary)"></i>
                            </div>
                            <div>
                                <h5>Materi Belajar</h5>
                            </div>
                        </div>
                    </a>
                    @endif
                    @else
                    {{-- Belum login: arahkan ke halaman login --}}
                    <a href="{{ route('login') }}" class="info-box-link text-decoration-none">
                        <div class="card feature-card p-3 h-100 rounded-3 d-flex flex-row align-items-center gap-3">
                            <div class="rounded-3 p-3" style="min-width:64px;min-height:64px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-journal-bookmark fs-2" style="color:var(--primary)"></i>
                            </div>
                            <div>
                                <h5>Materi Belajar</h5>
                            </div>
                        </div>
                    </a>
                    @endauth
                </div>
                <div class="col-md-4">
                    <a href="{{ route('petunjuk') }}" class="info-box-link text-decoration-none">
                        <div class="card feature-card p-3 h-100 rounded-3 d-flex flex-row align-items-center gap-3">
                            <div class="rounded-3 p-3" style="min-width:64px;min-height:64px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-list fs-2" style="color:var(--primary)"></i>
                            </div>
                            <div>
                                <h5>Petunjuk Penggunaan</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>