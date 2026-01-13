<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard Guru • PythaLearn')</title>

    <!-- JQUERY HARUS DULUAN -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Font & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack('head')

    <style>
        :root{
            --primary: #2E8B57;   /* Hijau utama (Sea Green) */
            --accent:  #A1E8AF;   /* Hijau muda aksen */
            --dark:    #1E5631;   /* Hijau gelap */
            --light-green: #E8F5E9; /* Hijau sangat muda */
            --topbar-h: 64px;    
            --sidebar-w: 240px;
        }

    html,body{height:100%;}

    body {
        font-family: 'PT Sans', 'Open Sans', system-ui;
        background:#f7f9f8;
        color:#0b2b27;
        margin:0;
    }

    /* === TOPBAR: fixed di atas === */
    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: var(--topbar-h);
        background: var(--primary);
        color: #fff;
        border-bottom: none;
        z-index: 1100;
        display:flex;
        align-items:center;
        padding: 0;
    }

    .topbar .brand a{
        font-size: 1.4rem;
        font-weight: 700;
        color:#fff;
        text-decoration:none;
    }

    .topbar .nav-link{
        font-size: .95rem;
        transition: .15s;
    }
    .topbar .nav-link,
    .topbar .nav-link.text-light{
        color: rgba(255,255,255,.8) !important;
    }
    .topbar .nav-link:hover{
        color:#fff !important;
    }
    .topbar .nav-link.active-link{
        font-weight:600;
        color:#fff !important;
    }

    .topbar-user-name{
        color:#fff;
    }
    .topbar-user-email{
        color:rgba(255,255,255,.8);
    }

    /* ruang konten di bawah topbar */
    .app-container {
        display:flex;
        min-height: calc(100vh - var(--topbar-h));
        padding-top: var(--topbar-h); 
        width:100%;
    }

    /* Sidebar */
    .sidebar {
        width: var(--sidebar-w);
        background:#fff;
        border-right:1px solid #e9e9e9;
        padding:1.2rem;
        position: sticky;
        top: var(--topbar-h);
        height: calc(100vh - var(--topbar-h));
        overflow-y: auto;
        z-index: 1000;
    }

    .sidebar .heading {
        font-size:.85rem;
        font-weight:700;
        color:var(--primary);
        text-align:center;
        margin-bottom:.75rem;
    }

    .list-group-item {
        border: 0;
        border-radius: .5rem;
        padding: .6rem .9rem;
        color: var(--dark);
        transition: all 0.2s ease;
    }
    .list-group-item + .list-group-item { margin-top:.45rem; }

    .list-group-item:hover {
        background: rgba(46, 139, 87, 0.08);
        color: var(--primary);
        transform: translateX(3px);
    }
    .list-group .active {
        background: var(--dark);
        color: #fff;
        font-weight:600;
    }

    /* Content area */
    .content-area {
        flex:1;
        display:flex;
        flex-direction:column;
        min-height: calc(100vh - var(--topbar-h));
        background: #f6f8f7;
    }
    .content-wrapper {
        padding: 1.6rem;
    }

    /* Dashboard Card Styles */
    .dashboard-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #eaeaea;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .dashboard-card .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .dashboard-card h5 {
        color: var(--dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .dashboard-card p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .quick-action-btn {
        background: white;
        border: 2px dashed var(--primary);
        color: var(--primary);
        padding: 1.2rem;
        border-radius: 12px;
        transition: all 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .quick-action-btn:hover {
        background: var(--light-green);
        border-color: var(--dark);
        color: var(--dark);
    }

    .quick-action-btn i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .section-title {
        color: var(--dark);
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent);
    }

    .welcome-header {
        background: linear-gradient(135deg, var(--primary), var(--dark));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .welcome-header h1 {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-header p {
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Mobile behaviour */
    @media (max-width: 991px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
            top: 0;
            border-right: 0;
            border-bottom: 1px solid #e9e9e9;
        }
        .app-container { 
            flex-direction: column; 
        }
        .topbar-center-nav{
            display:none !important;
        }
    }
    /* Agar backdrop (layar gelap) ada di BELAKANG navbar */
    .modal-backdrop {
        z-index: 1040 !important; 
    }
    
    /* Agar modalnya sendiri ada di BELAKANG navbar tapi di DEPAN backdrop */
    .modal {
        z-index: 1050 !important;
    }
    </style>
</head>

<body>

    <!-- TOPBAR (fixed) -->
    <header class="topbar">
        <div class="container-fluid">
            <div class="row align-items-center position-relative" height="var(--topbar-h);">

                {{-- Kiri: Brand --}}
                <div class="col-auto d-flex align-items-center">
                    <a href="{{ url('/') }}"
                    class="fw-bold h2 text-decoration-none ms-2"">
                        PythaLearn
                    </a>
                </div>
                {{-- Kanan: Info user --}}
                <div class="col-auto ms-auto d-flex align-items-center gap-2 me-3">
                    <div class="text-end d-none d-md-block">
                        <div class="fw-semibold topbar-user-name">@yield('user_name','Guru')</div>
                        <div class="small topbar-user-email">@yield('user_email','')</div>
                    </div>
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                         style="width:40px; height:40px;">
                        <i class="bi bi-person text-secondary fs-5"></i>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="app-container">
        <!-- SIDEBAR (desktop) -->
        <aside class="sidebar d-none d-lg-block" role="navigation" aria-label="Sidebar">
            <div class="mb-4">
                <div class="heading">MENU UTAMA</div>

                <div class="list-group">
                    <a href="{{ url('/guru/dashboard') }}" class="list-group-item list-group-item-action {{ request()->is('guru/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard Guru
                    </a>

                    <a href="{{ url('/guru/data_siswa') }}" class="list-group-item list-group-item-action {{ request()->is('guru/data_siswa') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> Data Siswa
                    </a>

                    <a href="{{ url('/guru/data_nilai') }}" class="list-group-item list-group-item-action {{ request()->is('guru/data_nilai') ? 'active' : '' }}">
                        <i class="bi bi-list-check me-2"></i> Data Nilai
                    </a>

                    <a href="{{ url('/guru/data_kelas') }}" class="list-group-item list-group-item-action {{ request()->is('guru/data_kelas') ? 'active' : '' }}">
                        <i class="bi bi-house me-2"></i> Data Kelas
                    </a>

                    <a href="{{ url('/guru/paket_soal') }}" class="list-group-item list-group-item-action {{ request()->is('guru/paket_soal') ? 'active' : '' }}">
                        <i class="bi bi-box me-2"></i> Paket Soal
                    </a>

                    <a href="{{ route('guru.data_soal') }}" class="list-group-item list-group-item-action {{ request()->is('guru/data_soal') ? 'active' : '' }}">
                        <i class="bi bi-journal-text me-2"></i> Data Soal
                    </a>

                    <a href="{{ route('guru.aktivitas') }}" class="list-group-item list-group-item-action {{ request()->is('guru/aktivitas') ? 'active' : '' }}">
                        <i class="bi bi-journal-text me-2"></i> Aktivitas Siswa
                    </a>

                    <a href="/guru/data_evaluasi" class="list-group-item list-group-item-action {{ request()->is('guru/data_evaluasi') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check me-2"></i> Data Evaluasi
                    </a>
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

    <footer class="py-3 text-center small text-muted">
        &copy; {{ date('Y') }} PythaLearn
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS (setelah jQuery) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    
</body>
</html>