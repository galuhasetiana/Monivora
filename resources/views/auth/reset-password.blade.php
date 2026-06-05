<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password — Monifora</title>

    <style>
        body{
            background:#0D1229;
            color:white;
            font-family:Poppins,sans-serif;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .card{
            width:450px;
            background:#232634;
            padding:30px;
            border-radius:15px;
        }

        h2{
            text-align:center;
            color:#B87A3A;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:none;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            background:#B87A3A;
            border:none;
            border-radius:30px;
            cursor:pointer;
        }

        .error{
            color:#ff8080;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>Password Baru</h2>

    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input
            type="email"
            name="email"
            value="{{ request('email') }}"
            readonly
        >

        <input
            type="password"
            name="password"
            placeholder="Password Baru"
            required
        >

        <input
            type="password"
            name="password_confirmation"
            placeholder="Konfirmasi Password"
            required
        >

        <button type="submit">
            Simpan Password Baru
        </button>
    </form>

</div>

</body>
</html>