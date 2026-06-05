<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi — Monifora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:#080f25; color:#c89b5a; height:100vh; display:flex; }
        .wrapper { display:flex; width:100%; }
        .left { width:50%; display:flex; justify-content:center; align-items:center; background:#080f25; }
        .left img { width:600px; margin-left:200px; }
        .right { width:50%; display:flex; justify-content:center; align-items:center; }
        .container { width:350px; }
        h1 { text-align:center; margin-bottom:40px; letter-spacing:3px; font-weight:normal; }
        .form-group { margin-bottom:25px; }
        label { display:block; font-size:14px; margin-bottom:8px; letter-spacing:2px; }
        input {
            width:100%; padding:10px 0; border:none;
            border-bottom:1px solid #c89b5a; background:transparent; color:#fff; font-size:14px; outline:none;
        }
        .password-container { position:relative; }
        .toggle { position:absolute; right:0; top:15px; cursor:pointer; }
        .btn {
            width:100%; padding:15px; border:none; border-radius:30px;
            background:#c89b5a; color:#0a0f1f; font-size:16px;
            letter-spacing:2px; cursor:pointer; margin-top:20px;
        }
        .btn:hover { background:#b3864f; }
        .footer { text-align:center; margin-top:20px; font-size:13px; }
        .footer a { color:#c89b5a; text-decoration:none; font-weight:bold; }
        .error-msg { color:#f87171; font-size:12px; margin-top:4px; }
        @media(max-width:768px){
            .wrapper { flex-direction:column; }
            .left, .right { width:100%; }
            .left img { width:150px; margin-left:0; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="left">
        <img src="{{ asset('images/Logo-Monifora.png') }}" alt="Logo Monifora">
    </div>

    <div class="right">
        <div class="container">
            <h1>REGISTRASI AKUN</h1>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="form-group">
                    <label>FULL NAME</label>
                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>EMAIL</label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="Masukkan email" required>
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group password-container">
                    <label>PASSWORD</label>
                    <input type="password" name="password" id="password" required>
                    <span class="toggle" onclick="togglePassword('password')">
                        <img src="{{ asset('images/see.png') }}" width="20" alt="">
                    </span>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group password-container">
                    <label>CONFIRM PASSWORD</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                    <span class="toggle" onclick="togglePassword('password_confirmation')">
                        <img src="{{ asset('images/see.png') }}" width="20" alt="">
                    </span>
                </div>

                <button type="submit" class="btn">REGISTRASI</button>
            </form>

            <div class="footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
