<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Master Menu & Resep - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/resep.jpg') }}") no-repeat center center fixed; 
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

        .container { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        
        /* Form Kaca */
        .form-card { background: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .form-card h2 { color: #0f172a; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 5px; }
        .form-card > p { color: #64748b; font-size: 14px; margin-bottom: 25px; font-weight: 500; }

        .error-message { background: #fee2e2; border-left: 5px solid #dc2626; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; color: #7f1d1d; font-weight: 600; }

        .form-group { margin-bottom: 22px; }
        label { display: block; font-weight: 700; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        input, select { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; }
        input:focus, select:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        
        /* Baris Resep */
        .bahan-row { display: flex; gap: 15px; align-items: flex-end; margin-bottom: 15px; background: rgba(241, 245, 249, 0.7); padding: 20px; border-radius: 16px; border: 1px dashed #cbd5e1; transition: all 0.3s; }
        .bahan-row:hover { border-color: #10b981; background: rgba(241, 245, 249, 0.9); }
        .bahan-row > div { flex: 1; }
        
        .btn { padding: 14px 20px; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; text-align: center; transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Tombol JS Tambah Bahan */
        .btn-tambah { background: white; margin-bottom: 25px; width: 100%; border: 2px dashed #3b82f6; color: #3b82f6; font-size: 14px; }
        .btn-tambah:hover { background: #eff6ff; transform: translateY(-2px); }
        
        /* Tombol JS Hapus Baris */
        .btn-hapus { background: #fee2e2; color: #dc2626; flex: 0 0 auto !important; padding: 14px 18px; border-radius: 12px; font-size: 18px; }
        .btn-hapus:hover { background: #ef4444; color: white; transform: scale(1.05); }

        .btn-simpan { background: linear-gradient(135deg, #10b981, #059669); color: white; width: 100%; font-size: 15px; margin-top: 10px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
        .btn-simpan:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); }

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
                <a href="{{ route('master_menu.index') }}" style="background: rgba(0,0,0,0.06);">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}">🍽️ Menu Harian</a>
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}">🚚 Distribusi</a>
            @elseif(Auth::user()->role === 'chef')
                <a href="{{ route('master_menu.index') }}" style="background: rgba(0,0,0,0.06);">🍳 Master Menu</a>
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
        <div class="form-card" data-aos="fade-up" data-aos-duration="1000">
            <h2 data-aos="fade-down" data-aos-delay="100">🍳 Buat Master Menu Baru</h2>
            <p data-aos="fade-down" data-aos-delay="200">Tambahkan nama menu dan komposisi bahan baku untuk 1 porsi.</p>

            @if ($errors->any())
                <div class="error-message" data-aos="zoom-in">
                    <strong>Peringatan, terdapat kesalahan:</strong>
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="error-message" data-aos="zoom-in"><strong>⚠️ Kesalahan:</strong> {{ session('error') }}</div>
            @endif

            <form action="{{ route('master_menu.store') }}" method="POST">
                @csrf
                
                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label>Nama Menu Harian</label>
                    <input type="text" name="nama_menu" placeholder="Contoh: Nasi Goreng Spesial" required value="{{ old('nama_menu') }}">
                </div>

                <hr style="border: 0; border-top: 2px dashed #cbd5e1; margin: 30px 0;" data-aos="fade-in" data-aos-delay="400">

                <h4 style="margin-bottom: 15px; color: #0f172a; font-size: 16px; font-weight: 800;" data-aos="fade-right" data-aos-delay="400">Komposisi Resep (BOM) per 1 Porsi:</h4>
                
                <div id="bahan-container" data-aos="fade-up" data-aos-delay="500">
                    <div class="bahan-row">
                        <div>
                            <label>Pilih Bahan Baku</label>
                            <select name="bahan_id[]" required>
                                <option value="">-- Pilih --</option>
                                @foreach($bahans as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_bahan }} ({{ $b->satuan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Takaran (Sesuai Satuan)</label>
                            <input type="number" name="takaran[]" step="any" min="0.0001" placeholder="Contoh: 0.025" required>
                        </div>
                        <div>
                            <button type="button" class="btn btn-hapus" style="visibility: hidden;">🗑️</button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-tambah" id="btnTambahBahan" data-aos="zoom-in" data-aos-delay="600">➕ Tambah Bahan Lain</button>

                <button type="submit" class="btn btn-simpan" data-aos="zoom-in" data-aos-delay="700">💾 Simpan Master Menu</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 30, duration: 800 });

        // FUNGSI JAVASCRIPT ASLI - DIPERTAHANKAN 100%
        document.getElementById('btnTambahBahan').addEventListener('click', function() {
            // Ambil container bahan
            const container = document.getElementById('bahan-container');
            // Ambil baris pertama sebagai template untuk dicloning
            const firstRow = container.querySelector('.bahan-row');
            // Kloning baris tersebut
            const newRow = firstRow.cloneNode(true);
            
            // Kosongkan nilai input di baris baru
            newRow.querySelector('input').value = '';
            newRow.querySelector('select').selectedIndex = 0;
            
            // Tampilkan tombol hapus pada baris baru
            const btnHapus = newRow.querySelector('.btn-hapus');
            btnHapus.style.visibility = 'visible';
            
            // Tambahkan event listener untuk tombol hapus
            btnHapus.addEventListener('click', function() {
                newRow.remove();
            });

            // Tambahkan baris baru ke container
            container.appendChild(newRow);
        });
    </script>
</body>
</html>