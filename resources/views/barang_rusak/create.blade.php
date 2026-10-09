<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Barang Rusak - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/br.jpeg') }}") no-repeat center center fixed; 
            background-size: cover; min-height: 100vh; color: #1e293b; 
        }

        /* Navbar Kaca */
        .navbar { background: rgba(255, 255, 255, 0.85); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 700px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header Kaca */
        .page-header { background: rgba(255, 255, 255, 0.2); padding: 25px 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: space-between; }
        .header-content h1 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .header-content p { font-size: 14px; color: #f1f5f9; font-weight: 500; }
        .btn-back { background: rgba(255, 255, 255, 0.9); color: #1e293b; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); transition: all 0.3s; }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); background: white; }

        /* Form Kaca */
        .form-card { background: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        
        .info-box { background: #fee2e2; border-left: 5px solid #dc2626; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #7f1d1d; font-weight: 600; }
        .error-box { background: #fee2e2; border-left: 5px solid #dc2626; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #7f1d1d; }

        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-weight: 700; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; }
        .form-control:focus { outline: none; border-color: #dc2626; box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1); }
        
        .btn-submit { display: block; width: 100%; background: linear-gradient(135deg, #ef4444, #b91c1c); color: white; border: none; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); transition: all 0.3s; margin-top: 30px; text-transform: uppercase; }
        .btn-submit:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4); }

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
                <h1>Lapor Kerusakan</h1>
                <p>Catat penyusutan untuk memotong stok fisik di gudang.</p>
            </div>
            <a href="{{ route('barang_rusak.index') }}" class="btn-back" data-aos="zoom-in" data-aos-delay="400">⬅️ Kembali</a>
        </div>

        <div class="form-card" data-aos="fade-up" data-aos-duration="1000">
            <div class="info-box" data-aos="fade-up">
                ⚠️ <strong>Peringatan:</strong> Data yang diinput akan otomatis memotong jumlah stok bahan bersangkutan.
            </div>

            @if ($errors->any())
                <div class="error-box" data-aos="fade-up">
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin-left: 20px; margin-top: 8px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('barang_rusak.store') }}" method="POST">
                @csrf

                <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                    <label class="form-label">Pilih Stok Fisik di Gudang <span style="color: #ef4444;">*</span></label>
                    <select name="stok_bahan_id" class="form-control" required>
                        <option value="">-- Pilih Batch Stok --</option>
                        @foreach($stokTersedia as $stok)
                            <option value="{{ $stok->id }}">
                                {{ $stok->bahan->nama_bahan }} (Sisa: {{ $stok->jumlah }} {{ $stok->bahan->satuan }}) - Exp: {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d/m/y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label class="form-label">Tanggal Ditemukan Rusak <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="tanggal_lapor" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label class="form-label">Jumlah Yang Dibuang <span style="color: #ef4444;">*</span></label>
                    <input type="number" step="0.01" name="jumlah_rusak" class="form-control" min="0.1" required placeholder="Contoh: 5">
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                    <label class="form-label">Alasan / Keterangan Kerusakan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Telur pecah karena jatuh atau Sayur membusuk">
                </div>

                <button type="submit" class="btn-submit" data-aos="zoom-in" data-aos-delay="500">🗑️ Proses Pembuangan Stok</button>
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