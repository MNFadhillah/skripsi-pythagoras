@php
abort_unless(auth()->check() && auth()->user()->role === 'siswa', 403);
$hasKelas = !empty(auth()->user()->kelas_id);

// Penentuan mode sidebar dilakukan di server (tanpa flicker)
$isMateriPage = request()->is('siswa/pendahuluan/*') ||
request()->is('siswa/konsep/*') ||
request()->is('siswa/tripel/*') ||
request()->is('siswa/istimewa/*') ||
request()->is('siswa/penerapan/*') ||
request()->is('siswa/aktivitas/*');
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @stack('head')
</head>

<body>
    <header class="topbar">
        <div class="container-fluid">
            <div class="row align-items-center position-relative w-100 m-0">
                <div class="col-auto d-flex align-items-center px-0">
                    <a href="{{ url('/') }}" class="fw-bold h3 mb-0 text-decoration-none ms-2">
                        PythaLearn
                    </a>
                    <button class="btn p-0 d-flex align-items-center justify-content-center position-relative ms-3"
                        type="button" id="sidebarToggle"
                        style="width: 40px; height: 40px; border: none; background: transparent;">
                        <i class="bi bi-list text-white" style="font-size: 2rem; line-height: 1;"></i>
                    </button>
                </div>

                <div class="col d-none d-md-flex justify-content-center">
                    {{-- dikosongkan --}}
                </div>

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
                        <button class="btn btn-light rounded-circle p-0 border-0 shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if(auth()->user()->avatar)
                            <img src="{{ asset('images/avatars/' . auth()->user()->avatar) }}"
                                alt="Avatar"
                                class="rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <i class="bi bi-person-fill text-success fs-4"></i>
                            @endif
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
                                    <button type="submit" class="dropdown-item text-danger btn-logout">
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

            {{-- MODE MENU UTAMA --}}
            <div id="sidebarMainMenu" class="{{ $isMateriPage ? 'd-none' : '' }}">
                <div class="heading mt-0 pt-0">MENU</div>
                <div class="d-grid gap-2 mb-4">
                    <a href="{{ route('siswa.menu.dashboard') }}"
                        class="main-menu-item {{ request()->is('siswa/menu/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 text-dark"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.menu.leaderboard') }}"
                        class="main-menu-item {{ request()->is('siswa/menu/leaderboard') ? 'active' : '' }}">
                        <i class="bi bi-trophy text-warning"></i>
                        <span class="menu-text">Leaderboard</span>
                    </a>
                    <a href="{{ route('siswa.menu.nilai_siswa') }}"
                        class="main-menu-item {{ request()->is('siswa/menu/nilai_siswa') ? 'active' : '' }}">
                        <i class="bi bi-journal-check text-info"></i>
                        <span class="menu-text">Nilai Saya</span>
                    </a>
                </div>
                <button class="btn btn-success w-100" id="btnDaftarMateri">
                    <i class="bi bi-book me-2"></i> <span class="menu-text">Daftar Materi</span>
                </button>
            </div>

            {{-- MODE MATERI --}}
            <div id="sidebarMateri" class="{{ $isMateriPage ? 'd-block' : 'd-none' }}">
                <button class="btn btn-outline-success btn-sm w-100 mb-3" id="btnKembaliMenu">
                    <i class="bi bi-arrow-left me-1"></i> <span class="menu-text">Kembali</span>
                </button>

                @php
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
                    <div class="heading">DAFTAR MATERI</div>

                    {{-- Pendahuluan --}}
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
                                <a href="{{ route('siswa.pendahuluan.bahan_ajar') }}"
                                    class="list-group-item list-group-item-action {{ request()->is('siswa/pendahuluan/bahan-ajar') ? 'active' : '' }}">
                                    <span class="menu-text">Bahan Ajar</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Konsep Pythagoras --}}
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
                                @php $kuisKonsep = isset($aktivitas) ? $aktivitas->where('kategori', 'konsep')->first() : null; @endphp
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

                    {{-- Tripel Pythagoras --}}
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
                                @php $kuisTripel = isset($aktivitas) ? $aktivitas->where('kategori', 'tripel')->first() : null; @endphp
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

                    {{-- Segitiga Istimewa --}}
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
                                @php $kuisIstimewa = isset($aktivitas) ? $aktivitas->where('kategori', 'istimewa')->first() : null; @endphp
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

                    {{-- Penerapan Teorema --}}
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
                                @php $kuisPenerapan = isset($aktivitas) ? $aktivitas->where('kategori', 'penerapan')->first() : null; @endphp
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

                    {{-- Evaluasi Akhir --}}
                    <div class="list-group sidebar-evaluasi">
                        <div class="heading">EVALUASI</div>
                        @php $evaluasi = isset($aktivitas) ? $aktivitas->where('kategori', 'evaluasi')->first() : null; @endphp
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
            </div>

        </aside>

        <div class="content-area" role="main">
            <main class="content-wrapper">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@4/tex-mml-chtml.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        (function() {
            window.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('mainSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const toggleBtn = document.getElementById('sidebarToggle');
                const btnDaftarMateri = document.getElementById('btnDaftarMateri');
                const btnKembali = document.getElementById('btnKembaliMenu');
                const mainMenu = document.getElementById('sidebarMainMenu');
                const materiMenu = document.getElementById('sidebarMateri');

                if (!toggleBtn) return;

                // Hapus event listener lama dari script.js (jika ada)
                const newToggleBtn = toggleBtn.cloneNode(true);
                toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);

                // Toggle sidebar
                newToggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (window.innerWidth <= 991.98) {
                        sidebar.classList.toggle('active');
                        overlay.classList.toggle('active');
                    } else {
                        document.body.classList.toggle('sidebar-closed');
                    }
                });

                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    });
                }

                if (btnDaftarMateri) {
                    btnDaftarMateri.addEventListener('click', function() {
                        mainMenu.classList.add('d-none');
                        mainMenu.classList.remove('d-block');
                        materiMenu.classList.add('d-block');
                        materiMenu.classList.remove('d-none');
                    });
                }

                if (btnKembali) {
                    btnKembali.addEventListener('click', function() {
                        materiMenu.classList.add('d-none');
                        materiMenu.classList.remove('d-block');
                        mainMenu.classList.add('d-block');
                        mainMenu.classList.remove('d-none');
                    });
                }

                // Tutup sidebar mobile setelah klik menu
                document.querySelectorAll('#sidebarMainMenu .main-menu-item, #sidebarMateri .list-group-item').forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 991.98) {
                            sidebar.classList.remove('active');
                            overlay.classList.remove('active');
                        }
                    });
                });

                window.addEventListener('resize', function() {
                    if (window.innerWidth > 991.98) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });
        })();


        document.addEventListener('DOMContentLoaded', function() {
            cekKunciKuisAktifDariLayout();
        });

        window.addEventListener('pageshow', function() {
            cekKunciKuisAktifDariLayout();
        });

        function cekKunciKuisAktifDariLayout() {
            const rawLock = localStorage.getItem('active_quiz_lock');
            if (!rawLock) return;

            let lock = null;

            try {
                lock = JSON.parse(rawLock);
            } catch (e) {
                localStorage.removeItem('active_quiz_lock');
                return;
            }

            if (!lock || !lock.quiz_url || !lock.aktivitas_id) {
                localStorage.removeItem('active_quiz_lock');
                return;
            }

            const currentUrl = window.location.href;

            // Kalau sedang di halaman kuis, jangan ganggu.
            if (currentUrl === lock.quiz_url) return;

            // Kalau sedang membuka halaman kerjakan kuis lain, jangan paksa dulu.
            if (currentUrl.includes('/siswa/aktivitas/') && currentUrl.includes('/kerjakan')) {
                return;
            }

            catatPelanggaranBackBrowser(lock);

            const pesan = 'Kamu masih sedang mengerjakan kuis. Selesaikan kuis terlebih dahulu sebelum kembali ke materi.';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kuis Masih Berlangsung',
                    text: pesan,
                    confirmButtonText: 'Kembali ke Kuis',
                    confirmButtonColor: '#146b42',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = lock.quiz_url;
                });
            } else {
                alert(pesan);
                window.location.href = lock.quiz_url;
            }
        }

        function catatPelanggaranBackBrowser(lock) {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');

            if (!csrfMeta || !lock.violation_url) return;

            fetch(lock.violation_url, {
                method: 'POST',
                keepalive: true,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    aktivitas_id: lock.aktivitas_id,
                    jenis: 'browser_back_to_materi',
                    detail: 'Siswa kembali ke materi menggunakan tombol back browser saat kuis masih berlangsung.'
                })
            }).catch(function() {});
        }
    </script>

    @stack('scripts')
</body>

</html>