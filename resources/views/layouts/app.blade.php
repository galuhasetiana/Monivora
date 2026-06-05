<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Monifora — @yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:#0D1229; color:#fff; }

        /* ── WRAPPER ── */
        .wrapper { display:flex; height:100vh; }

        /* ── SIDEBAR ── */
        .sidebar {
            width:260px; background:#0a1525;
            padding:30px 20px; display:flex; flex-direction:column;
        }
        .greeting-sidebar {
            margin-bottom:25px; padding:12px;
            border-radius:12px; background:rgba(255,255,255,0.03);
        }
        .greeting-sidebar small { color:#94a3b8; font-size:14px; }
        .greeting-sidebar strong { display:block; font-size:16px; margin-top:4px; }

        .menu { list-style:none; }
        .menu li {
            padding:14px 12px; border-radius:12px;
            margin-bottom:8px; color:rgba(255,255,255,0.7); cursor:pointer; transition:0.3s;
        }
        .menu li a {
            display:flex; align-items:center; gap:10px;
            text-decoration:none; color:inherit;
        }
        .menu li:hover, .menu li.active { background:#B87A3A; color:#fff; font-weight:500; }
        .menu-icon { width:18px; height:18px; }

        /* menu item tanpa kotak aktif */
        .menu-text {
            padding:10px 12px; color:rgba(255,255,255,0.7); cursor:pointer; transition:0.3s;
        }
        .menu-text:hover { color:#B87A3A; }
        .menu-text.active-text { color:#B87A3A; font-weight:600; }

        /* ── MAIN ── */
        .main { flex:1; padding:30px 40px; overflow-y:auto; }

        /* ── HEADER ── */
        .header {
            display:grid; grid-template-columns:1fr auto 1fr;
            align-items:center; margin-bottom:30px;
        }
        .center-logo img { width:180px; }
        .icons { text-align:right; }
        .header-icon {
            width:46px; height:46px; padding:8px;
            background:#232634; border-radius:50%; margin-left:8px; cursor:pointer;
        }

        /* ── ALERT ── */
        .alert {
            padding:12px 18px; border-radius:10px; margin-bottom:20px; font-size:14px;
        }
        .alert-success { background:#14532d; color:#86efac; }
        .alert-danger  { background:#7f1d1d; color:#fca5a5; }
    </style>

    @stack('styles')
</head>
<body>
<div class="wrapper">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="greeting-sidebar">
            <small>Selamat Pagi</small>
            <strong>Hi, {{ auth()->user()->name }}</strong>
        </div>

        <ul class="menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/IconBeranda.png') }}" class="menu-icon" alt="">
                    Beranda
                </a>
            </li>
            <li class="{{ request()->routeIs('transaksi.create') ? 'active' : '' }}">
                <a href="{{ route('transaksi.create') }}">
                    <img src="{{ asset('images/IconTambah.png') }}" class="menu-icon" alt="">
                    Tambah Transaksi
                </a>
            </li>
            <li class="{{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                <a href="{{ route('transaksi.index') }}">
                    <img src="{{ asset('images/IconRiwayat.png') }}" class="menu-icon" alt="">
                    Riwayat Transaksi
                </a>
            </li>

            {{-- Menu tanpa box aktif --}}
            <li class="menu-text {{ request()->routeIs('target.*') ? 'active-text' : '' }}">
                <a href="{{ route('target.index') }}" style="text-decoration:none;color:inherit;">
                    Target Harian
                </a>
            </li>
            <li class="menu-text {{ request()->routeIs('ekspor.*') ? 'active-text' : '' }}">
                <a href="{{ route('ekspor.index') }}" style="text-decoration:none;color:inherit;">
                    Ekspor Data
                </a>
            </li>
            <li class="menu-text">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                        style="background:none;border:none;color:inherit;cursor:pointer;font-size:inherit;padding:0;">
                        Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>

    {{-- MAIN --}}
    <div class="main">

        {{-- HEADER --}}
        <div class="header">
            <div></div>
            <div class="center-logo">
                <img src="{{ asset('images/Logo-Monifora.png') }}" alt="Monifora">
            </div>
            <div class="icons">
                <a href="{{ route('notifikasi.index') }}">
                    <img src="{{ asset('images/IconNotif.png') }}" class="header-icon" alt="Notifikasi">
                </a>
                <a href="{{ route('profil.index') }}">
                    <img src="{{ asset('images/IconProfil.png') }}" class="header-icon" alt="Profil">
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- KONTEN HALAMAN --}}
        @yield('content')

    </div>
</div>

@stack('scripts')
</body>
</html>