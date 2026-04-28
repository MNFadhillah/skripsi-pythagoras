@php
abort_unless(auth()->check() && auth()->user()->role === 'siswa', 403);
$hasKelas = !empty(auth()->user()->kelas_id); // true jika sudah punya kelas

@endphp

<!doctype html>
<html lang="id">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="route-progress" content="/progress/update">
    <meta name="user-kelas-id" content="{{ auth()->user()->kelas_id ?? '' }}">
    <title>@yield('title','Dashboard Siswa - PythaLearn')</title>

    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('head')
</head>

<body>
    <header class="topbar">
        <div class="container-fluid">
            {{-- PERBAIKAN: Hapus style="height:64px;" pada class row di bawah ini --}}
            <div class="row align-items-center position-relative w-100 m-0">

                {{-- Kiri: Brand & Tombol Burger --}}
                <div class="col-auto d-flex align-items-center px-0">

                    {{-- 1. Brand --}}
                    <a href="{{ url('/') }}" class="fw-bold h3 mb-0 text-decoration-none ms-2">
                        PythaLearn
                    </a>

                    {{-- 2. Tombol Burger --}}
                    <button class="btn p-0 d-flex align-items-center justify-content-center position-relative ms-3"
                        type="button"
                        id="sidebarToggle"
                        style="width: 40px; height: 40px; border: none; background: transparent;">
                        <i class="bi bi-list text-white" style="font-size: 2rem; line-height: 1; pointer-events: none;"></i>
                    </button>

                </div>

                {{-- Tengah: Menu (HANYA DESKTOP) --}}
                <div class="col d-none d-md-flex justify-content-center">
                    <nav>
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="{{ route('siswa.menu.dashboard') }}" class="nav-link px-3 {{ request()->is('siswa/menu/dashboard') ? 'fw-bold text-white' : 'text-white-50' }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siswa.menu.leaderboard') }}" class="nav-link px-3 {{ request()->is('siswa/menu/leaderboard') ? 'fw-bold text-white' : 'text-white-50' }}">Leaderboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siswa.menu.nilai_siswa') }}" class="nav-link px-3 {{ request()->is('siswa/menu/nilai_siswa') ? 'fw-bold text-white' : 'text-white-50' }}">Nilai Saya</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                {{-- Kanan: Info user --}}
                <div class="col-auto d-flex align-items-center px-0 gap-2">
                    <div class="text-end d-none d-md-block">
                        <div class="fw-semibold text-white" style="font-size: 0.9rem;">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-white-50 small" style="font-size: 0.75rem;">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" data-bs-toggle="dropdown">
                            <i class="bi bi-person text-success fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <a href="{{ route('siswa.profile') }}" class="dropdown-item" style="color: #212529 !important; --bs-dropdown-link-active-bg: #f8f9fa">
                                    <i class="bi bi-person-badge me-2 text-success"></i> Profil Saya
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" style="--bs-dropdown-link-active-bg: #f8f9fa" class="dropdown-item text-danger btn-logout">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="app-container">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <aside class="sidebar d-lg-block" id="mainSidebar" role="navigation" aria-label="Sidebar">

            {{-- === MENU TAMBAHAN KHUSUS MOBILE (DIGABUNG KE SIDEBAR) === --}}
            <div class="d-md-none mb-3 pb-3 border-bottom">
                <div class="heading text-start  mb-2" style="font-size: 1rem; opacity: 0.7;">MENU UTAMA</div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('siswa.menu.dashboard') }}" class="list-group-item list-group-item-action">
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.menu.leaderboard') }}" class="list-group-item list-group-item-action">
                        <span class="menu-text">Leaderboard</span>
                    </a>
                    <a href="{{ route('siswa.menu.nilai_siswa') }}" class="list-group-item list-group-item-action">
                        <span class="menu-text">Nilai Saya</span>
                    </a>
                </div>
            </div>

            @php
            // Logika penanda menu aktif (tetap)
            $isPendahuluan = request()->is('siswa/pendahuluan/*');
            $isKonsep = request()->is('siswa/konsep/*');
            $isTripel = request()->is('siswa/tripel/*');
            $isIstimewa = request()->is('siswa/istimewa/*');
            $isPenerapan = request()->is('siswa/penerapan/*');
            $currentAktivitasId = request()->route('id');

            $activeKategori = null;
            if($currentAktivitasId && isset($aktivitas) && $aktivitas->count() > 0) {
            $act = $aktivitas->firstWhere('id', $currentAktivitasId);
            if($act) $activeKategori = $act->kategori;
            }
            @endphp

            <div class="accordion" id="sidebarAccordion">

                {{-- JUDUL --}}
                <div class="heading text-nowrap overflow-hidden">DAFTAR MATERI</div>

                {{-- 0. PENDAHULUAN --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPendahuluan">
                        <button class="accordion-button {{ $isPendahuluan ? 'bg-success text-white' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapsePendahuluan">
                            <i class="bi bi-book fs-5 me-2"></i>
                            <span class="menu-text">Pendahuluan</span>
                        </button>
                    </h2>
                    <div id="collapsePendahuluan" class="accordion-collapse collapse {{ $isPendahuluan ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('siswa.pendahuluan.pengantar') }}" class="list-group-item list-group-item-action {{ request()->is('siswa/pendahuluan/pengantar') ? 'active' : '' }}">
                                <span class="menu-text">Pengantar Bab</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 1. KONSEP PYTHAGORAS --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingKonsep">
                        <button class="accordion-button {{ ($isKonsep || $activeKategori == 'konsep') ? 'bg-success text-white' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseKonsep">
                            <i class="bi bi-lightbulb fs-5 me-2"></i>
                            <span class="menu-text">Konsep Pythagoras</span>
                        </button>
                    </h2>
                    <div id="collapseKonsep" class="accordion-collapse collapse {{ ($isKonsep || $activeKategori == 'konsep') ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('siswa.konsep.materi') }}" class="list-group-item list-group-item-action {{ request()->is('siswa/konsep/materi') ? 'active' : '' }}">
                                <span class="menu-text">Materi</span>
                            </a>
                            @php
                            $kuisKonsep = isset($aktivitas) ? $aktivitas->where('kategori', 'konsep')->first() : null;
                            @endphp
                            @if($kuisKonsep)
                            <a href="{{ route('siswa.kuis.show', $kuisKonsep->id) }}"
                                class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$kuisKonsep->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text">Kuis 1 – Teorema Pythagoras</span>
                            </a>
                            @else
                            <a href="javascript:void(0)"
                                onclick="Swal.fire('Belum Tersedia', 'Kuis ini belum dibuat oleh guru untuk kelas Anda.', 'info'); return false;"
                                class="list-group-item list-group-item-action text-muted">
                                <span class="menu-text">Kuis 1 – Teorema Pythagoras</span>
                                <i class="bi bi-lock-fill ms-1 small"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 2. TRIPEL PYTHAGORAS --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTripel">
                        <button class="accordion-button {{ ($isTripel || $activeKategori == 'tripel') ? 'bg-success text-white' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTripel">
                            <i class="bi bi-123 fs-5 me-2"></i>
                            <span class="menu-text">Tripel Pythagoras</span>
                        </button>
                    </h2>
                    <div id="collapseTripel" class="accordion-collapse collapse {{ ($isTripel || $activeKategori == 'tripel') ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('siswa.tripel.materi') }}" class="list-group-item list-group-item-action {{ request()->is('siswa/tripel/materi') ? 'active' : '' }}">
                                <span class="menu-text">Materi</span>
                            </a>
                            @php
                            $kuisTripel = isset($aktivitas) ? $aktivitas->where('kategori', 'tripel')->first() : null;
                            @endphp
                            @if($kuisTripel)
                            <a href="{{ route('siswa.kuis.show', $kuisTripel->id) }}"
                                class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$kuisTripel->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text">Kuis 2 – Tripel Pythagoras</span>
                            </a>
                            @else
                            <a href="javascript:void(0)"
                                onclick="Swal.fire('Belum Tersedia', 'Kuis ini belum dibuat oleh guru untuk kelas Anda.', 'info'); return false;"
                                class="list-group-item list-group-item-action text-muted">
                                <span class="menu-text">Kuis 2 – Tripel Pythagoras</span>
                                <i class="bi bi-lock-fill ms-1 small"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 3. SEGITIGA ISTIMEWA --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingIstimewa">
                        <button class="accordion-button {{ ($isIstimewa || $activeKategori == 'istimewa') ? 'bg-success text-white' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseIstimewa">
                            <i class="bi bi-triangle fs-5 me-2"></i>
                            <span class="menu-text">Segitiga Istimewa</span>
                        </button>
                    </h2>
                    <div id="collapseIstimewa" class="accordion-collapse collapse {{ ($isIstimewa || $activeKategori == 'istimewa') ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('siswa.istimewa.materi') }}" class="list-group-item list-group-item-action {{ request()->is('siswa/istimewa/materi') ? 'active' : '' }}">
                                <span class="menu-text">Materi</span>
                            </a>
                            @php
                            $kuisIstimewa = isset($aktivitas) ? $aktivitas->where('kategori', 'istimewa')->first() : null;
                            @endphp
                            @if($kuisIstimewa)
                            <a href="{{ route('siswa.kuis.show', $kuisIstimewa->id) }}"
                                class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$kuisIstimewa->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text">Kuis 3 – Segitiga Istimewa</span>
                            </a>
                            @else
                            <a href="javascript:void(0)"
                                onclick="Swal.fire('Belum Tersedia', 'Kuis ini belum dibuat oleh guru untuk kelas Anda.', 'info'); return false;"
                                class="list-group-item list-group-item-action text-muted">
                                <span class="menu-text">Kuis 3 – Segitiga Istimewa</span>
                                <i class="bi bi-lock-fill ms-1 small"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 4. PENERAPAN TEOREMA --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPenerapan">
                        <button class="accordion-button {{ ($isPenerapan || $activeKategori == 'penerapan') ? 'bg-success text-white' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapsePenerapan">
                            <i class="bi bi-buildings fs-5 me-2"></i>
                            <span class="menu-text">Penerapan Teorema</span>
                        </button>
                    </h2>
                    <div id="collapsePenerapan" class="accordion-collapse collapse {{ ($isPenerapan || $activeKategori == 'penerapan') ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('siswa.penerapan.materi') }}" class="list-group-item list-group-item-action {{ request()->is('siswa/penerapan/materi') ? 'active' : '' }}">
                                <span class="menu-text">Materi</span>
                            </a>
                            @php
                            $kuisPenerapan = isset($aktivitas) ? $aktivitas->where('kategori', 'penerapan')->first() : null;
                            @endphp
                            @if($kuisPenerapan)
                            <a href="{{ route('siswa.kuis.show', $kuisPenerapan->id) }}"
                                class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$kuisPenerapan->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text">Kuis 4 – Penerapan Teorema Pythagoras</span>
                            </a>
                            @else
                            <a href="javascript:void(0)"
                                onclick="Swal.fire('Belum Tersedia', 'Kuis ini belum dibuat oleh guru untuk kelas Anda.', 'info'); return false;"
                                class="list-group-item list-group-item-action text-muted">
                                <span class="menu-text">Kuis 4 – Penerapan Teorema Pythagoras</span>
                                <i class="bi bi-lock-fill ms-1 small"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- EVALUASI AKHIR --}}
                <div class="list-group sidebar-evaluasi">
                    <div class="heading mt-2 text-nowrap overflow-hidden">EVALUASI</div>
                    @php
                    $evaluasi = isset($aktivitas) ? $aktivitas->where('kategori', 'evaluasi')->first() : null;
                    @endphp
                    @if($evaluasi)
                    <a href="{{ route('siswa.kuis.show', $evaluasi->id) }}"
                        class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$evaluasi->id.'/kerjakan') ? 'active' : '' }}">
                        <span class="menu-text">Evaluasi Akhir</span>
                    </a>
                    @else
                    <a href="javascript:void(0)"
                        onclick="Swal.fire('Belum Tersedia', 'Evaluasi akhir belum dibuat oleh guru untuk kelas Anda.', 'info'); return false;"
                        class="list-group-item list-group-item-action text-muted">
                        <span class="menu-text">Evaluasi Akhir</span>
                        <i class="bi bi-lock-fill ms-1 small"></i>
                    </a>
                    @endif
                </div>

            </div>


        </aside>
        <!-- CONTENT AREA -->
        <div class="content-area" role="main">
            <main class="content-wrapper">
                @yield('content')
            </main>
        </div>
    </div> <!-- /.app-container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@4/tex-mml-chtml.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')


</body>

</html>