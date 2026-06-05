<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login — Monifora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:#080f25; color:#c89b5a; height:100vh; display:flex; }
        .wrapper { display:flex; width:100%; }
        .left { width:50%; display:flex; justify-content:center; align-items:center; }
        .left img { width:600px; margin-left:200px; }
        .right { width:50%; display:flex; justify-content:center; align-items:center; }
        .container { width:350px; }
        h1 { text-align:center; margin-bottom:40px; letter-spacing:3px; font-weight:normal; }
        .form-group { margin-bottom:25px; }
        label { display:block; font-size:14px; margin-bottom:8px; letter-spacing:2px; }
        input {
            width:100%; padding:10px 0; border:none;
            border-bottom:1px solid #c89b5a; background:transparent; color:#fff; outline:none;
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
        .error-msg { color:#f87171; font-size:13px; margin-top:4px; }
        .alert-error {
            background:#7f1d1d; color:#fca5a5;
            padding:10px 14px; border-radius:10px; margin-bottom:20px; font-size:13px;
        }
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
            <h1>LOGIN</h1>

            {{-- Error dari Auth::attempt --}}
            @if ($errors->has('email') && !$errors->has('email', 'default'))
                <div class="alert-error">{{ $errors->first('email') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

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

                <div style="text-align:right; margin-top:-10px; margin-bottom:20px;">
                    <a href="{{ route('password.request') }}"
                    style="color:#c89b5a; font-size:13px; text-decoration:none;">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="btn">MASUK</button>
            </form>

            <div class="footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
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
