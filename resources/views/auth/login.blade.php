<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem MBG</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f5f7fa; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: white; width: 100%; max-width: 400px; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-top: 5px solid #003d82; }
        .logo-area { text-align: center; margin-bottom: 30px; }
        .logo-area h1 { color: #003d82; font-size: 24px; font-weight: 700; }
        .logo-area p { color: #666; font-size: 13px; margin-top: 5px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #333; margin-bottom: 8px; }
        input { width: 100%; padding: 12px 15px; border: 2px solid #e0e6ed; border-radius: 8px; font-size: 14px; transition: border-color 0.3s; }
        input:focus { border-color: #003d82; outline: none; }
        .btn-submit { width: 100%; padding: 14px; background: linear-gradient(90deg, #003d82 0%, #00509e 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 15px; cursor: pointer; transition: opacity 0.3s; margin-top: 10px; }
        .btn-submit:hover { opacity: 0.9; }
        .auth-links { text-align: center; margin-top: 20px; font-size: 13px; color: #666; }
        .auth-links a { color: #003d82; text-decoration: none; font-weight: 600; }
        .alert { background: #ffe5e5; color: #d63031; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border-left: 4px solid #d63031; }
        .alert-success { background: #d4edda; color: #155724; border-left-color: #28a745; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo-area">
            <h1>🏛️ Dashboard MBG</h1>
            <p>Sistem Manajemen Persediaan Terpadu</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert">
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@mbg.com" autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-submit">Masuk ke Sistem</button>
        </form>

        <div class="auth-links">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>
</body>
</html>