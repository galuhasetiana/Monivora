<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi — Monifora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:linear-gradient(to bottom,#09122c,#0f172a); color:#fff; padding:30px 60px; }

        .header {
            display:grid; grid-template-columns:1fr auto 1fr;
            align-items:center; margin-bottom:40px;
        }
        .greeting small { color:#94a3b8; font-size:14px; }
        .greeting h2 { font-size:20px; margin-top:4px; }
        .center-logo img { width:160px; }
        .icons { text-align:right; }
        .header-icon {
            width:42px; height:42px; padding:8px;
            background:#2B2B2B; border-radius:50%; margin-left:10px; cursor:pointer;
        }
        .back-link {
            display:inline-block; margin-bottom:20px;
            color:#94a3b8; text-decoration:none; font-size:14px;
        }
        .back-link:hover { color:#fff; }

        .notif-card {
            background:#3a3a3f; border-radius:25px;
            padding:25px 30px; margin-bottom:25px; transition:0.3s;
        }
        .notif-card:hover { transform:translateY(-3px); }
        .notif-title {
            font-size:18px; margin-bottom:8px;
            display:flex; align-items:center; gap:10px;
        }
        .notif-desc { font-size:14px; color:#d1d5db; margin-bottom:10px; }
        .notif-time { font-size:12px; color:#9ca3af; }
        .warning { color:#facc15; }
        .danger  { color:#ef4444; }
        .empty   { text-align:center; color:#94a3b8; margin-top:60px; font-size:15px; }
    </style>
</head>
<body>

<div class="header">
    <div class="greeting">
        <small>Selamat Pagi</small>
        <h2>Hi, {{ auth()->user()->name }}</h2>
    </div>
    <div class="center-logo">
        <img src="{{ asset('images/Logo-Monifora.png') }}" alt="Monifora">
    </div>
    <div class="icons">
        <img src="{{ asset('images/IconNotif.png') }}" class="header-icon" alt="">
        <img src="{{ asset('images/IconProfil.png') }}" class="header-icon" alt="">
    </div>
</div>

<a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>

@forelse($notifikasi as $n)
<div class="notif-card">
    <div class="notif-title">
        {{ $n->judul }}
        @if($n->type === 'warning')
            <span class="warning">⚠</span>
        @elseif($n->type === 'danger')
            <span class="danger">‼</span>
        @endif
    </div>
    <div class="notif-desc">{{ $n->isi }}</div>
    <div class="notif-time">
        {{ $n->created_at->diffForHumans() }}
    </div>
</div>
@empty
    <div class="empty">Tidak ada notifikasi saat ini.</div>
@endforelse

</body>
</html>
