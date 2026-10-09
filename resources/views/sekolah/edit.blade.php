<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penerima - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/s.jpg') }}") no-repeat center center fixed; 
            background-size: cover; min-height: 100vh; color: #1e293b; 
        }

        /* Navbar Kaca Lengkap */
        .navbar { background: rgba(255, 255, 255, 0.85); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 700px; margin: 50px auto; padding: 0 20px; }
        
        /* Kartu Kaca (Glassmorphism) */
        .card { background: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .card h2 { color: #0f172a; font-size: 24px; font-weight: 800; margin-bottom: 25px; border-bottom: 2px dashed #cbd5e1; padding-bottom: 15px; letter-spacing: -0.5px; }
        
        .form-group { margin-bottom: 22px; }
        label { display: block; font-weight: 700; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        input, textarea, select { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; font-family: inherit; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1); }
        
        .btn-submit { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 16px; border: none; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; width: 100%; margin-top: 15px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); text-transform: uppercase; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4); }
        
        .btn-back { display: block; text-align: center; margin-top: 20px; color: #64748b; text-decoration: none; font-size: 14px; font-weight: 700; transition: all 0.2s; }
        .btn-back:hover { color: #0f172a; }

        .error-message { background: #fee2e2; border-left: 5px solid #dc2626; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #7f1d1d; font-weight: 600; }

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
                <a href="{{ route('menu.index') }}">🍽️ Menu Harian</a>
                <a href="{{ route('sekolah.index') }}" style="background: rgba(0,0,0,0.06);">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}">🚚 Distribusi</a>
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
        <div class="card" data-aos="fade-up" data-aos-duration="1000">
            <h2 data-aos="fade-down" data-aos-delay="100">✏️ Edit Target Penerima</h2>
            
            @if ($errors->any())
                <div class="error-message" data-aos="zoom-in">
                    <ul style="margin-left: 20px;">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sekolah.update', $sekolah->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label>Nama Sekolah / Kelompok</label>
                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label>Kategori Penerima</label>
                    <select name="kategori_penerima" required>
                        <option value="Sekolah" {{ (isset($sekolah->kategori_penerima) && $sekolah->kategori_penerima == 'Sekolah') ? 'selected' : '' }}>👦 Anak Sekolah (SD/SMP/SMA)</option>
                        <option value="Balita" {{ (isset($sekolah->kategori_penerima) && $sekolah->kategori_penerima == 'Balita') ? 'selected' : '' }}>👶 Balita (Posyandu)</option>
                        <option value="Bumil" {{ (isset($sekolah->kategori_penerima) && $sekolah->kategori_penerima == 'Bumil') ? 'selected' : '' }}>🤰 Ibu Hamil (Bumil)</option>
                        <option value="Busui" {{ (isset($sekolah->kategori_penerima) && $sekolah->kategori_penerima == 'Busui') ? 'selected' : '' }}>🤱 Ibu Menyusui (Busui)</option>
                    </select>
                </div>
                
                <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                    <label>Jumlah Penerima (Target Porsi)</label>
                    <input type="number" name="jumlah_siswa" value="{{ old('jumlah_siswa', $sekolah->jumlah_siswa) }}" required>
                </div>
                
                <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="4" required>{{ old('alamat', $sekolah->alamat) }}</textarea>
                </div>
                
                <button type="submit" class="btn-submit" data-aos="zoom-in" data-aos-delay="600">🔄 Simpan Perubahan</button>
                <a href="{{ route('sekolah.index') }}" class="btn-back" data-aos="fade-up" data-aos-delay="700">Batalkan dan Kembali</a>
            </form>
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, offset: 30, duration: 800 }); </script>
</body>
</html>