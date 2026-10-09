<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.4)), 
                        url("{{ asset('img/admin.jpg') }}") no-repeat center center fixed; 
            background-size: cover; min-height: 100vh; color: #1e293b; 
        }

        .navbar { background: rgba(255, 255, 255, 0.85); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        
        .page-header { background: rgba(255, 255, 255, 0.2); padding: 25px 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: space-between; }
        .header-content h1 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .header-content p { font-size: 14px; color: #f1f5f9; font-weight: 500; }
        .btn-back { background: rgba(255, 255, 255, 0.9); color: #1e293b; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); transition: all 0.3s; }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); background: white; }

        .form-card { background: rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        
        .info-box { background: #e0f2fe; border-left: 5px solid #0284c7; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #0c4a6e; font-weight: 600; }
        .error-box { background: #fee2e2; border-left: 5px solid #dc2626; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #7f1d1d; }

        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-weight: 700; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; }
        .form-control:focus { outline: none; border-color: #003d82; box-shadow: 0 0 0 4px rgba(0, 61, 130, 0.1); }
        .help-text { font-size: 11px; color: #64748b; margin-top: 6px; font-weight: 500; }

        .btn-submit { display: block; width: 100%; background: linear-gradient(135deg, #FFD700, #F39C12); color: #003d82; border: none; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3); transition: all 0.3s; margin-top: 30px; text-transform: uppercase; }
        .btn-submit:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 25px rgba(243, 156, 18, 0.4); }
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
                <a href="{{ route('stok.index') }}" style="background: rgba(0,0,0,0.06);">📊 Stok</a>
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
                <h1>Tambah Stok Bahan</h1>
                <p>Masukkan informasi persediaan yang baru tiba di gudang.</p>
            </div>
            <a href="{{ route('stok.index') }}" class="btn-back" data-aos="zoom-in" data-aos-delay="400">⬅️ Kembali</a>
        </div>

        <div class="form-card" data-aos="fade-up" data-aos-duration="1000">
            <div class="info-box" data-aos="fade-up">
                ℹ️ <strong>Catatan:</strong> Pastikan tanggal kadaluarsa lebih besar dari tanggal masuk untuk validasi data yang benar.
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

            <form method="POST" action="{{ route('stok.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                    <label for="bahan_id" class="form-label">Pilih Bahan <span style="color: #ef4444;">*</span></label>
                    <select id="bahan_id" name="bahan_id" class="form-control" required>
                        <option value="">-- Pilih Bahan --</option>
                        @foreach($bahan as $b)
                            <option value="{{ $b->id }}" {{ old('bahan_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_bahan }} ({{ $b->satuan }})
                            </option>
                        @endforeach
                    </select>
                    <div class="help-text">Pilih jenis bahan dari daftar yang sudah didaftarkan</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span style="color: #ef4444;">*</span></label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
                    </div>

                    <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                        <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa <span style="color: #ef4444;">*</span></label>
                        <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" class="form-control" value="{{ old('tanggal_kadaluarsa') }}" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                        <label for="jumlah" class="form-label">Jumlah Stok <span style="color: #ef4444;">*</span></label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Masukkan jumlah" value="{{ old('jumlah') }}" min="0.1" step="any" required oninput="hitungTotal()">
                    </div>

                    <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                        <label for="harga_satuan" class="form-label">Harga Per Satuan (Rp) <span style="color: #ef4444;">*</span></label>
                        <input type="number" id="harga_satuan" name="harga_satuan" class="form-control" placeholder="Contoh: 15000" value="{{ old('harga_satuan') }}" min="0" required oninput="hitungTotal()">
                    </div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="600">
                    <label class="form-label">Total Harga Pembelian (Otomatis)</label>
                    <input type="text" id="harga_total_display" class="form-control" readonly style="background-color: #f1f5f9; color: #0284c7; font-weight: 800; cursor: not-allowed; border-color: #cbd5e1;" placeholder="Rp 0">
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="700">
                    <label class="form-label">Bukti Foto Bahan (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="form-control" style="padding: 10px;">
                    <div class="help-text">Unggah foto kondisi stok bahan saat diterima. Format: JPG/PNG, Max: 2MB.</div>
                </div>

                <button type="submit" class="btn-submit" data-aos="zoom-in" data-aos-delay="800">💾 Simpan Stok Gudang</button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 30, duration: 800 });

        // FUNGSI JAVASCRIPT ASLI - TIDAK DIRUBAH
        function hitungTotal() {
            let jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
            let hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
            let total = jumlah * hargaSatuan;
            document.getElementById('harga_total_display').value = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>