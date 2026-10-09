<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Harian - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/porsi.jpg') }}") no-repeat center center fixed; 
            background-size: cover; min-height: 100vh; color: #1e293b; 
        }

        .navbar { background: rgba(255, 255, 255, 0.85); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        
        .form-card { background: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .form-card h2 { color: #0f172a; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 5px; }
        .form-card > p { color: #64748b; font-size: 14px; margin-bottom: 25px; font-weight: 500; }

        .error-message { background: #fee2e2; border-left: 5px solid #dc2626; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #7f1d1d; font-weight: 600; }

        .form-group { margin-bottom: 22px; }
        label { display: block; font-weight: 700; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        input { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; }
        input:focus { outline: none; border-color: #0284c7; box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1); }
        .help-text { font-size: 11px; color: #64748b; margin-top: 6px; font-weight: 500; }

        .button-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn-submit { background: linear-gradient(135deg, #0284c7, #0369a1); color: white; flex: 1; border: none; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; transition: all 0.3s; text-transform: uppercase; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(2, 132, 199, 0.4); }
        .btn-cancel { background: #e2e8f0; color: #475569; padding: 16px; border-radius: 12px; font-weight: 700; text-decoration: none; text-align: center; width: 150px; transition: all 0.3s; }
        .btn-cancel:hover { background: #cbd5e1; }

        .footer { text-align: center; padding: 30px; color: white; font-size: 13px; margin-top: 20px; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('dashboard') }}" class="logo-section">
            <img src="{{ asset('img/logo_sppg.png') }}" alt="Logo MBG" class="logo-img">
        </a>
        <div class="navbar-spacer"></div>
        <div class="navbar-menu">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('bahan.index') }}">📦 Bahan</a>
                <a href="{{ route('stok.index') }}">📊 Stok</a>
                <a href="{{ route('laporan.index') }}">📑 Laporan</a>
                <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}" style="background: rgba(0,0,0,0.06);">🍽️ Menu Harian</a>
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}">🚚 Distribusi</a>
            @elseif(Auth::user()->role === 'chef')
                <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}" style="background: rgba(0,0,0,0.06);">🍽️ Menu Harian</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left: 15px;">
                @csrf
                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 11px 22px; border-radius: 10px; cursor: pointer; font-weight: 700; transition: background 0.3s;">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="form-card" data-aos="fade-up" data-aos-duration="1000">
            <h2 data-aos="fade-down">✏️ Edit Menu Harian</h2>
            <p data-aos="fade-down" data-aos-delay="100">Perbarui informasi jadwal atau ubah foto dokumentasi masakan.</p>

            @if ($errors->any())
                <div class="error-message" data-aos="zoom-in">
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin-left: 20px; margin-top: 8px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label for="tanggal_menu">Tanggal Pelaksanaan Menu <span style="color: #ef4444;">*</span></label>
                    <input type="date" id="tanggal_menu" name="tanggal_menu" value="{{ old('tanggal_menu', $menu->tanggal_menu) }}" required>
                    <div class="help-text">Perbarui tanggal jika ada perubahan jadwal.</div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label for="nama_menu">Nama Menu <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="nama_menu" name="nama_menu" placeholder="Contoh: Nasi Goreng, Soto Ayam, dll" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                    <div class="help-text">Perbarui nama masakan jika diperlukan.</div>
                </div>

                 <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                    <label>Foto Dokumentasi Masakan (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" style="padding: 10px;">
                    <div class="help-text">Sebagai Quality Control, unggah bukti masakan. Biarkan kosong jika tidak ingin mengubah foto lama.</div>
                </div>

                <div class="button-group" data-aos="fade-up" data-aos-delay="500">
                    <button type="submit" class="btn-submit">🔄 Perbarui Data Menu</button>
                    <a href="{{ route('menu.index') }}" class="btn-cancel">Batalkan</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, offset: 30, duration: 800 }); </script>
</body>
</html>