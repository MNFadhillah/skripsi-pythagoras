<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard Admin • PythaLearn')</title>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack('head')

    <style>
        :root {
            --primary: #2E8B57;
            --dark: #1E5631;
            --sidebar-w: 260px;
            --sidebar-mini-w: 80px;
            --header-h: 65px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'PT Sans', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            background: #ffffff;
            border-right: 1px solid #eaeaea;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            height: var(--header-h);
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            color: #fff;
            margin-right: -1px;
            position: relative;
            z-index: 1042;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
            font-weight: 700;
            font-size: 1.25rem;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }

        #btnSidebarToggle {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-content {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .list-group-item {
            border: none;
            border-radius: 6px !important;
            margin-bottom: 4px;
            color: #555;
            font-weight: 500;
            display: flex;
            align-items: center;
            height: 48px;
            white-space: nowrap;
        }

        .list-group-item i {
            font-size: 1.2rem;
            min-width: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
        }

        .list-group-item.active {
            background-color: var(--primary) !important;
            color: #fff;
        }

        .list-group-item:hover:not(.active) {
            background-color: #f0fdf4;
            color: var(--primary);
        }

        .topbar {
            height: var(--header-h);
            background: var(--primary);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-w);
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .main-wrapper {
            margin-top: var(--header-h);
            margin-left: var(--sidebar-w);
            min-height: calc(100vh - var(--header-h));
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-mini-w);
        }

        body.sidebar-collapsed .topbar {
            left: var(--sidebar-mini-w);
        }

        body.sidebar-collapsed .main-wrapper {
            margin-left: var(--sidebar-mini-w);
        }

        body.sidebar-collapsed .brand-text,
        body.sidebar-collapsed .nav-text,
        body.sidebar-collapsed .menu-heading {
            display: none;
        }

        body.sidebar-collapsed .sidebar-header {
            padding: 0;
            justify-content: center;
        }

        body.sidebar-collapsed .brand-wrapper {
            display: none;
        }

        body.sidebar-collapsed .list-group-item {
            justify-content: center;
            padding: 0;
        }

        body.sidebar-collapsed .list-group-item i {
            margin-right: 0;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                left: calc(var(--sidebar-w) * -1);
            }

            .topbar {
                left: 0;
            }

            .main-wrapper {
                margin-left: 0;
            }

            body.mobile-open .sidebar {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1035;
                display: none;
            }

            body.mobile-open .sidebar-overlay {
                display: block;
            }

            .mobile-toggle-btn {
                display: block !important;
            }

            #btnSidebarToggle {
                display: none;
            }

            .sidebar-header {
                justify-content: center;
            }
        }

        .mobile-toggle-btn {
            display: none;
            font-size: 1.5rem;
            color: white;
            border: none;
            background: none;
            margin-right: 1rem;
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="overlay"></div>

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="brand-wrapper">
                <i class="bi bi-mortardboard-fill me-2"></i>
                <span class="brand-text">PythaLearn</span>
            </a>
            <button id="btnSidebarToggle"><i class="bi bi-list"></i></button>
        </div>
        <div class="sidebar-content">
            <div class="list-group">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span class="nav-text">Dashboard Admin</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span class="nav-text">Manajemen User</span>
                </a>
                <a href="{{ route('admin.kelas.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> <span class="nav-text">Manajemen Kelas</span>
                </a>
            </div>
        </div>
    </aside>

    <header class="topbar">
        <button class="mobile-toggle-btn" id="btnMobileToggle"><i class="bi bi-list"></i></button>
        <div class="ms-auto d-flex align-items-center">
            <div class="text-end d-none d-sm-block me-3 text-white">
                <div class="fw-bold lh-1" style="font-size: 0.85rem;">{{ auth()->user()->name }}</div>
                <small class="opacity-75" style="font-size: 0.7rem;">{{ auth()->user()->email }}</small>
            </div>
            <div class="dropdown">
                <button class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;" data-bs-toggle="dropdown">
                    <i class="bi bi-person-fill text-success fs-5"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-3 py-2">
                    <li><a class="dropdown-item py-2" href="{{ route('admin.profile') }}"><i class="bi bi-person-circle me-2 text-success"></i> Profil Saya</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="main-wrapper">
        <main class="content-body">
            @yield('content')
        </main>
        <footer class="py-3 px-4 bg-white border-top text-center text-muted mt-auto">
            <small>&copy; {{ date('Y') }} <strong>PythaLearn</strong>. Dashboard Admin.</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnSidebarToggle').on('click', function() {
                $('body').toggleClass('sidebar-collapsed');
            });
            $('#btnMobileToggle').on('click', function() {
                $('body').addClass('mobile-open');
            });
            $('#overlay').on('click', function() {
                $('body').removeClass('mobile-open');
            });
            $(window).resize(function() {
                if ($(window).width() >= 992) $('body').removeClass('mobile-open');
                else $('body').removeClass('sidebar-collapsed');
            });
        });
    </script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>