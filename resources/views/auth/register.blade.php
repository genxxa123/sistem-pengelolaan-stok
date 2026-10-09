<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem MBG</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    <style>
        /* CSS yang sama dengan halaman login */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f5f7fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;}
        .auth-card { background: white; width: 100%; max-width: 450px; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-top: 5px solid #27ae60; }
        .logo-area { text-align: center; margin-bottom: 30px; }
        .logo-area h1 { color: #27ae60; font-size: 24px; font-weight: 700; }
        .logo-area p { color: #666; font-size: 13px; margin-top: 5px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #333; margin-bottom: 8px; }
        input { width: 100%; padding: 12px 15px; border: 2px solid #e0e6ed; border-radius: 8px; font-size: 14px; transition: border-color 0.3s; }
        input:focus { border-color: #27ae60; outline: none; }
        .btn-submit { width: 100%; padding: 14px; background: linear-gradient(90deg, #27ae60 0%, #2ecc71 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 15px; cursor: pointer; transition: opacity 0.3s; margin-top: 10px; }
        .btn-submit:hover { opacity: 0.9; }
        .auth-links { text-align: center; margin-top: 20px; font-size: 13px; color: #666; }
        .auth-links a { color: #27ae60; text-decoration: none; font-weight: 600; }
        .alert { background: #ffe5e5; color: #d63031; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border-left: 4px solid #d63031; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo-area">
            <h1>📝 Pendaftaran Admin</h1>
            <p>Buat akun baru untuk mengakses sistem</p>
        </div>

        @if($errors->any())
            <div class="alert">
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Budi Santoso">
            </div>
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@mbg.com">
            </div>
            <div class="form-group">
                <label>Pilih Peran (Role)</label>
                <select name="role" required style="width: 100%; padding: 12px 15px; border: 2px solid #e0e6ed; border-radius: 8px; font-size: 14px; background: white;">
                    <option value="admin">Admin Gudang</option>
                    <option value="chef">Chef (Kepala Dapur)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password">
            </div>
            <button type="submit" class="btn-submit">Daftarkan Akun</button>
        </form>

        <div class="auth-links">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
</body>
</html>