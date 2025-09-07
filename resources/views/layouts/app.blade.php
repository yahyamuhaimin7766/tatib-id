<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SITATIB')</title>

    {{-- Ikon Untuk Browser --}}
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- CSS Frameworks --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ======================================================= --}}
    {{-- SEMUA GAYA CSS LENGKAP --}}
    {{-- ======================================================= --}}
    <style>
        body {
            background-color: #f4f7f6;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #1d2b64;
            background-image: linear-gradient(160deg, #1d2b64 0%, #4a54c8 100%);
            color: white;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Tampilan di Desktop (Layar besar) */
        @media (min-width: 768px) {
            .sidebar-desktop {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 280px;
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
            }

            .main-content {
                margin-left: 280px;
                padding: 2rem;
            }
        }

        /* Tampilan di HP (Layar kecil) */
        @media (max-width: 767.98px) {
            .main-content {
                padding: 1rem;
            }

            .sidebar-mobile {
                width: 280px;
                border: none;
            }
        }

        /* CSS Styling Sidebar */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s ease-in-out;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: rgba(255, 255, 255, 0.5);
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: bold;
            border-left-color: #ffffff;
        }

        .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 1.5rem;
        }

        /* CSS Styling Card */
        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 0.75rem;
        }

        .card-header {
            background-color: #ffffff;
            color: #333;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }

        /* CSS LENGKAP UNTUK AUTOCOMPLETE */
        .ui-autocomplete {
            position: absolute;
            cursor: default;
            z-index: 1055 !important;
            background: #ffffff !important;
            border: 1px solid #ced4da !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            padding: 0.5rem 0 !important;
            list-style-type: none !important;
        }

        .ui-menu-item {
            padding: 0 !important;
        }

        .ui-menu-item-wrapper {
            display: block;
            padding: 0.5rem 1rem !important;
            color: #212529 !important;
            text-decoration: none;
        }

        .ui-state-active,
        .ui-widget-content .ui-state-active {
            background: #0d6efd !important;
            color: #ffffff !important;
            border: none !important;
        }
    </style>
</head>

<body>
    {{-- Sidebar untuk Tampilan HP (Offcanvas) --}}
    <div class="offcanvas offcanvas-start sidebar sidebar-mobile" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center text-white">
                <img src="{{ asset('images/contohlogo.png') }}" alt="Logo Sekolah"
                    style="width: 40px; height: 40px; margin-right: 15px;">
                <div class="text-start">
                    <h5 class="mb-0">SITATIB</h5>
                    <small class="text-light opacity-75">Sistem Tata Tertib</small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-3">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}"><i class="fas fa-home fa-fw me-2"></i>Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('violations.create') ? 'active' : '' }}"
                        href="{{ route('violations.create') }}"><i
                            class="fas fa-exclamation-triangle fa-fw me-2"></i>Input Pelanggaran</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                        href="{{ route('reports.index') }}"><i class="fas fa-chart-bar fa-fw me-2"></i>Rekap</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('raids.*') ? 'active' : '' }}"
                        href="{{ route('raids.index') }}"><i class="fas fa-search fa-fw me-2"></i>Razia</a></li>
                {{-- Fitur Skor Kebersihan dinonaktifkan --}}
                <li class="nav-item"><a
                        class="nav-link {{ request()->routeIs('admin.*') || request()->routeIs('admin.students.*') ? 'active' : '' }}"
                        href="{{ route('admin.index') }}"><i class="fas fa-cog fa-fw me-2"></i>Admin</a></li>
            </ul>
            <div class="pt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100"><i class="fas fa-sign-out-alt me-2"></i>
                        Logout</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar untuk Tampilan Desktop (Fixed) --}}
    <nav class="d-none d-md-flex flex-column sidebar sidebar-desktop p-3">
        <div class="sidebar-header d-flex align-items-center mb-4 text-white">
            <img src="{{ asset('images/contohlogo.png') }}" alt="Logo Sekolah"
                style="width: 40px; height: 40px; margin-right: 15px;">
            <div class="text-start">
                <h5 class="mb-0">SITATIB</h5>
                <small class="text-light opacity-75">Sistem Tata Tertib</small>
            </div>
        </div>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                    href="{{ route('home') }}"><i class="fas fa-home fa-fw me-2"></i>Home</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('violations.create') ? 'active' : '' }}"
                    href="{{ route('violations.create') }}"><i class="fas fa-exclamation-triangle fa-fw me-2"></i>Input
                    Pelanggaran</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                    href="{{ route('reports.index') }}"><i class="fas fa-chart-bar fa-fw me-2"></i>Rekap</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('raids.*') ? 'active' : '' }}"
                    href="{{ route('raids.index') }}"><i class="fas fa-search fa-fw me-2"></i>Razia</a></li>
            {{-- Fitur Skor Kebersihan dinonaktifkan --}}
            <li class="nav-item"><a
                    class="nav-link {{ request()->routeIs('admin.*') || request()->routeIs('admin.students.*') ? 'active' : '' }}"
                    href="{{ route('admin.index') }}"><i class="fas fa-cog fa-fw me-2"></i>Admin</a></li>
        </ul>
        <div class="pt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100"><i class="fas fa-sign-out-alt me-2"></i>
                    Logout</button>
            </form>
        </div>
    </nav>

    {{-- Konten Utama dengan Header Mobile --}}
    <main class="main-content">
        <header
            class="d-md-none d-flex justify-content-between align-items-center mb-3 p-3 bg-white shadow-sm sticky-top">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/contohlogo.png') }}" alt="Logo Sekolah"
                    style="width: 30px; height: 30px; margin-right: 10px;">
                <h5 class="mb-0">SITATIB</h5>
            </div>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>
        </header>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>

</html>
