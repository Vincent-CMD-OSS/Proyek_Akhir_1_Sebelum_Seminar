<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name', 'Panti Asuhan Rumah Harapan') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5; /* Warna latar yang lebih netral */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .login-card {
            background-color: #ffffff;
            padding: 30px 40px; /* Padding lebih lega */
            border-radius: 12px; /* Border radius lebih besar */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Shadow lebih soft */
            width: 100%;
            max-width: 420px; /* Lebar card */
            text-align: center;
        }
        .login-card .logo {
            /* Ganti dengan SVG atau image logo Anda jika ada */
            font-size: 32px;
            font-weight: bold;
            color: #4A5568; /* Warna logo disesuaikan */
            margin-bottom: 15px;
            /* Jika pakai image:
            width: 80px;
            height: auto;
            margin-bottom: 20px; */
        }
        .login-card h1 {
            font-size: 26px; /* Ukuran font judul */
            color: #2D3748; /* Warna teks judul */
            margin-bottom: 10px;
            font-weight: 600;
        }
        .login-card p.subtitle {
            font-size: 15px; /* Ukuran font subjudul */
            color: #718096; /* Warna teks subjudul */
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600; /* Label lebih bold */
            font-size: 14px;
            color: #4A5568;
        }
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%; /* Input full width */
            padding: 12px 15px; /* Padding input */
            border: 1px solid #CBD5E0; /* Border input */
            border-radius: 8px; /* Border radius input */
            font-size: 16px;
            box-sizing: border-box; /* Agar padding tidak menambah lebar total */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #3182CE; /* Warna border saat focus */
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.2); /* Efek shadow saat focus */
            outline: none;
        }
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            text-align: left;
        }
        .form-check input[type="checkbox"] {
            margin-right: 10px; /* Jarak checkbox dengan label */
            width: 18px; /* Ukuran checkbox */
            height: 18px;
            accent-color: #3182CE; /* Warna centang */
        }
        .form-check label {
            font-weight: normal;
            color: #4A5568;
            font-size: 14px;
            margin-bottom: 0; /* Reset margin bottom untuk label checkbox */
        }
        .btn-login {
            background-color: #3182CE; /* Warna tombol primer */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
            text-transform: uppercase; /* Styling teks tombol */
            letter-spacing: 0.5px; /* Spasi antar huruf */
        }
        .btn-login:hover {
            background-color: #2B6CB0; /* Warna tombol saat hover */
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            text-align: left;
            font-size: 14px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-danger ul {
            margin: 0;
            padding-left: 20px; /* Indentasi untuk list error */
        }
        .alert-success { /* Untuk pesan status setelah logout */
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">{{ config('app.name') }}</div>
        <h1>Welcome back!</h1>
        <p class="subtitle">Enter your credentials to access your admin panel.</p>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       placeholder="Enter your mail address">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required
                       placeholder="Enter password">
            </div>
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>
</body>
</html>