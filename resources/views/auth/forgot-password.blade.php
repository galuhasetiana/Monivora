<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password — Monifora</title>

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
            width:400px;
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
            margin-top:10px;
            border:none;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:20px;
            background:#B87A3A;
            border:none;
            border-radius:30px;
            cursor:pointer;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Lupa Password</h2>

    <form action="{{ route('password.reset') }}" method="GET">

        <input
            type="email"
            name="email"
            placeholder="Masukkan Email"
            required
        >

        <button type="submit">
            Lanjut
        </button>
    </form>
</div>

</body>
</html>