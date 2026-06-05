<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monifora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body {
            background:#080f25; height:100vh;
            display:flex; justify-content:center; align-items:center; color:#d4a057;
        }
        .container { text-align:center; }
        .logo { width:700px; max-width:90%; }
        .tagline { font-size:25px; margin-top:-100px; margin-bottom:30px; letter-spacing:1px; }
        .btn-start {
            background:#c8a35f; color:#0b1330; border:none;
            padding:16px 50px; font-size:18px; border-radius:40px;
            cursor:pointer; transition:0.3s; font-weight:500; text-decoration:none;
            display:inline-block;
        }
        .btn-start:hover { background:#d4a057; transform:scale(1.05); }
    </style>
</head>
<body>
<div class="container">
    <img src="{{ asset('images/Logo-Monifora.png') }}" alt="Monifora" class="logo">

    <div class="tagline">SMART MONEY, BETTER LIFE!</div>

    {{-- Arahkan ke dashboard jika sudah login, atau ke halaman masuk --}}
    @auth
        <a href="{{ route('dashboard') }}" class="btn-start">Ke Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="btn-start">Mulai Sekarang!</a>
    @endauth
</div>
</body>
</html>
