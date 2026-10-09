<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bahan - Sistem Manajemen Persediaan MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Full Screen Fixed Background yang Sama dengan Halaman Daftar */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.4)), 
                        url("{{ asset('img/gudang.jpeg') }}") no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh; 
            color: #1e293b; 
        }

        /* Navbar Modern Transparan Kaca - Seragam */
        .navbar { 
            background: rgba(255, 255, 255, 0.85); 
            padding: 12px 30px; 
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); 
            display: flex; 
            align-items: center; 
            gap: 20px; 
            position: sticky; 
            top: 0; 
            z-index: 100; 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 3px solid #F39C12; 
        }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        /* Logo a.png Wajib - Konsisten */
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header Halaman Bertema Kaca */
        .page-header { 
            background: rgba(255, 255, 255, 0.2);
            padding: 25px 30px; 
            border-radius: 20px; 
            margin-bottom: 30px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-content h1 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .header-content p { font-size: 14px; color: #f1f5f9; font-weight: 500; }

        /* Tombol Kembali yang Lembut */
        .btn-back { background: rgba(255, 255, 255, 0.9); color: #1e293b; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); transition: all 0.3s; }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); background: white; }

        /* Area Form Kaca Transparan - Glassmorphism */
        .form-card { 
            background: rgba(255, 255, 255, 0.9); 
            border-radius: 24px; 
            padding: 40px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        /* Styling Input Modern */
        .form-group { margin-bottom: 25px; }
        .form-label { display: block; font-weight: 700; font-size: 13px; color: #475569; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control { width: 100%; padding: 15px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; }
        .form-control:focus { outline: none; border-color: #003d82; box-shadow: 0 0 0 4px rgba(0, 61, 130, 0.1); background: white; }
        
        /* Styling Validasi Error */
        .error-feedback { color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 8px; display: flex; align-items: center; gap: 5px; }

        /* Tombol Simpan yang Menonjol */
        .btn-submit { display: block; width: 100%; background: linear-gradient(135deg, #FFD700, #F39C12); color: #003d82; border: none; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3); transition: all 0.3s; margin-top: 30px; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-submit:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 25px rgba(243, 156, 18, 0.4); }

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
                <a href="{{ route('bahan.index') }}" style="background: rgba(0,0,0,0.06);">📦 Bahan</a>
                <a href="{{ route('stok.index') }}">📊 Stok</a>
                <a href="{{ route('laporan.index') }}">📑 Laporan</a>
                <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}">🍽️ Menu Harian</a>
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}">🚚 Distribusi</a>
            @elseif(Auth::user()->role === 'chef')
                <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}">🍽️ Menu Harian</a>
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
        <div class="page-header" data-aos="fade-in" data-aos-duration="1000">
            <div class="header-content" data-aos="slide-right" data-aos-delay="200">
                <h1>Tambah Bahan</h1>
                <p>Silakan lengkapi formulir untuk mendaftarkan bahan baru.</p>
            </div>
            <a href="{{ route('bahan.index') }}" class="btn-back" data-aos="zoom-in" data-aos-delay="400">
                ⬅️ Kembali ke Daftar
            </a>
        </div>

        <div class="form-card" data-aos="fade-up" data-aos-duration="1000">
            <form action="{{ route('bahan.store') }}" method="POST">
                @csrf

                <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                    <label for="nama_bahan" class="form-label">Nama Bahan Baku</label>
                    <input type="text" name="nama_bahan" id="nama_bahan" class="form-control @error('nama_bahan') is-invalid @enderror" placeholder="Contoh: Beras Raja, Ayam Potong, Kecap Manis" value="{{ old('nama_bahan') }}" required>
                    @error('nama_bahan')
                        <div class="error-feedback">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label for="satuan" class="form-label">Satuan Ukuran</label>
                    <select name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" required>
                        <option value="">-- Pilih Satuan --</option>
                        <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                        <option value="gr" {{ old('satuan') == 'gr' ? 'selected' : '' }}>Gram (gr)</option>
                        <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter (L)</option>
                        <option value="ml" {{ old('satuan') == 'ml' ? 'selected' : '' }}>Mililiter (ml)</option>
                        <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Piece/Potong (pcs)</option>
                        <option value="dus" {{ old('satuan') == 'dus' ? 'selected' : '' }}>Dus (box)</option>
                        <option value="kaleng" {{ old('satuan') == 'kaleng' ? 'selected' : '' }}>Kaleng (tin)</option>
                        <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol (bottle)</option>
                        <option value="ikat" {{ old('satuan') == 'ikat' ? 'selected' : '' }}>Ikat (bundle)</option>
                    </select>
                    <div style="font-size: 11px; color: #64748b; margin-top: 5px;">Pilih satuan yang sesuai dengan jenis bahan</div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label for="kategori" class="form-label">Kategori Bahan</label>
                    <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Sayuran" {{ old('kategori') == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                        <option value="Daging/Ikan" {{ old('kategori') == 'Daging/Ikan' ? 'selected' : '' }}>Daging & Ikan</option>
                        <option value="Karbohidrat" {{ old('kategori') == 'Karbohidrat' ? 'selected' : '' }}>Karbohidrat (Beras, Mie, Kentang)</option>
                        <option value="Bumbu" {{ old('kategori') == 'Bumbu' ? 'selected' : '' }}>Bumbu Dapur</option>
                        <option value="Buah" {{ old('kategori') == 'Buah' ? 'selected' : '' }}>Buah-buahan</option>
                        <option value="Protein" {{ old('kategori') == 'Protein' ? 'selected' : '' }}>Protein</option>
                    </select>
                    <div style="font-size: 11px; color: #64748b; margin-top: 5px;">Pilih kelompok kategori bahan makanan ini</div>
                </div>

                <button type="submit" class="btn-submit" data-aos="zoom-in" data-aos-delay="400">
                    💾 Simpan Data Bahan Baru
                </button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bersama Group (MBG)</strong></p>
        <p>© 2026 Terintegrasi untuk Pengelolaan Stok dan Monitoring FEFO Akurat.</p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 30,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>
</html>