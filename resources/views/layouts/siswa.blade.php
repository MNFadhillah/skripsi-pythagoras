<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title','Dashboard Siswa - PythaLearn')</title>

    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">
    @stack('head')
</head>

<body>

<header class="topbar">
    <div class="container-fluid">
        <div class="row align-items-center position-relative" style="height:64px;">

            {{-- Kiri: Brand & Tombol Burger --}}
            <div class="col-auto d-flex align-items-center">
                
                {{-- 1. Brand Name --}}
                <a href="{{ url('/') }}" class="fw-bold h2 text-decoration-none text-white m-0 me-3" style="line-height: 1;">
                    PythaLearn
                </a>

                {{-- 2. Tombol Burger --}}
                <button class="btn p-0 d-flex align-items-center justify-content-center position-relative" 
                        type="button" 
                        id="sidebarToggle"
                        style="width: 48px; height: 48px; border: none; background: transparent; z-index: 1050;">
                    
                    {{-- Ikon diberi pointer-events: none agar klik selalu kena tombolnya, bukan ikonnya --}}
                    <i class="bi bi-list text-white" style="font-size: 2rem; line-height: 1; pointer-events: none;"></i>
                
                </button>

            </div>

            {{-- Tengah: Menu (HANYA DESKTOP) --}}
            <div class="position-absolute top-50 start-50 translate-middle d-none d-md-block">
                <nav>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a href="{{ route('siswa.menu.dashboard') }}" class="nav-link px-2 {{ request()->is('siswa/menu/dashboard') ? 'fw-semibold text-dark' : 'text-muted' }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.menu.leaderboard') }}" class="nav-link px-2 {{ request()->is('siswa/menu/leaderboard') ? 'fw-semibold text-dark' : 'text-muted' }}">Leaderboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.menu.nilai_siswa') }}" class="nav-link px-2 {{ request()->is('siswa/menu/nilai_siswa') ? 'fw-semibold text-dark' : 'text-muted' }}">Nilai Saya</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.menu.petunjuk') }}" class="nav-link px-2 {{ request()->is('siswa/menu/petunjuk') ? 'fw-semibold text-dark' : 'text-muted' }}">Petunjuk</a>
                        </li>
                    </ul>
                </nav>
            </div>

            {{-- Kanan: Info user --}}
            <div class="col-auto ms-auto d-flex align-items-center gap-2">
                <div class="text-end d-none d-md-block">
                    <div class="fw-semibold">@yield('user_name','Siswa')</div>
                    <div class="text-muted small">@yield('user_email','')</div>
                </div>
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                    <i class="bi bi-person text-secondary fs-5"></i>
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
                <a href="{{ route('siswa.menu.petunjuk') }}" class="list-group-item list-group-item-action">
                    <span class="menu-text">Petunjuk</span>
                </a>
            </div>
        </div>

        @php
            // Logika penanda menu aktif (Highlighter)
            $isPendahuluan = request()->is('siswa/pendahuluan/*');
            $isKonsep      = request()->is('siswa/konsep/*');
            $isTripel      = request()->is('siswa/tripel/*');
            $isIstimewa    = request()->is('siswa/istimewa/*');
            $isPenerapan   = request()->is('siswa/penerapan/*');
            
            $currentAktivitasId = request()->route('aktivitas'); 
            $activeKategori = null;
            
            // Cek dulu apakah $aktivitas ada dan tidak kosong sebelum diproses
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

            {{-- 1. MENEMUKAN KONSEP --}}
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
                            <span class="menu-text ">Materi</span>
                        </a>
                        @if(isset($aktivitas))
                            @php $kuisKonsep = $aktivitas->where('kategori', 'konsep'); @endphp
                            @foreach($kuisKonsep as $item)
                            <a href="{{ route('siswa.kuis.show', $item->id) }}" 
                            class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$item->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text ">{{ $item->judul }}</span>
                            </a>
                            @endforeach
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
                            <span class="menu-text ">Materi</span>
                        </a>
                        @if(isset($aktivitas))
                            @php $kuisTripel = $aktivitas->where('kategori', 'tripel'); @endphp
                            @foreach($kuisTripel as $item)
                            <a href="{{ route('siswa.kuis.show', $item->id) }}" 
                            class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$item->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text ">{{ $item->judul }}</span>
                            </a>
                            @endforeach
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
                            <span class="menu-text ">Materi</span>
                        </a>
                        @if(isset($aktivitas))
                            @php $kuisIstimewa = $aktivitas->where('kategori', 'istimewa'); @endphp
                            @foreach($kuisIstimewa as $item)
                            <a href="{{ route('siswa.kuis.show', $item->id) }}" 
                            class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$item->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text ">{{ $item->judul }}</span>
                            </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- 4. PENERAPAN --}}
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
                            <span class="menu-text ">Materi</span>
                        </a>
                        @if(isset($aktivitas))
                            @php $kuisPenerapan = $aktivitas->where('kategori', 'penerapan'); @endphp
                            @foreach($kuisPenerapan as $item)
                            <a href="{{ route('siswa.kuis.show', $item->id) }}" 
                            class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$item->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text ">{{ $item->judul }}</span>
                            </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- EVALUASI AKHIR --}}
            <div class="heading mt-2 text-nowrap overflow-hidden">EVALUASI</div>
            <div class="list-group sidebar-evaluasi">
                @if(isset($aktivitas))
                    @php $evaluasi = $aktivitas->where('kategori', 'evaluasi'); @endphp
                    @if($evaluasi->count() > 0)
                        @foreach($evaluasi as $item)
                            <a href="{{ route('siswa.kuis.show', $item->id) }}" 
                            class="list-group-item list-group-item-action {{ request()->is('siswa/aktivitas/'.$item->id.'/kerjakan') ? 'active' : '' }}">
                                <span class="menu-text">{{ $item->judul }}</span>
                            </a>
                        @endforeach
                    @else
                        <a href="#" onclick="Swal.fire('Belum Tersedia', 'Evaluasi akhir belum dibuka.', 'info'); return false;" 
                        class="list-group-item list-group-item-action text-muted fst-italic">
                            <span class="menu-text">Evaluasi Akhir (Belum Tersedia)</span>
                        </a>
                    @endif
                @else
                    {{-- Fallback jika variabel $aktivitas tidak ada --}}
                    <a href="#" class="list-group-item list-group-item-action text-muted fst-italic">
                        <span class="menu-text">Data Belum Dimuat</span>
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
