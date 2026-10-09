<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Target Penerima - Dashboard MBG</title>
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

        .container { max-width: 1250px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header Kaca */
        .page-header { background: rgba(255, 255, 255, 0.2); padding: 25px 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .page-header h1 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); margin-bottom: 5px; }
        .page-header p { font-size: 14px; color: #f1f5f9; font-weight: 500; }

        .alert-success { background: #dcfce7; color: #166534; padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; border-left: 5px solid #16a34a; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        .grid-layout { display: grid; grid-template-columns: 1fr 2fr; gap: 25px; }
        @media (max-width: 992px) { .grid-layout { grid-template-columns: 1fr; } }
        
        /* Kartu Kaca (Glassmorphism) */
        .card { background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .card h3 { color: #0f172a; font-size: 18px; font-weight: 800; margin-bottom: 20px; border-bottom: 2px dashed #cbd5e1; padding-bottom: 15px; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 700; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        input, textarea, select { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; font-family: inherit; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        
        .btn-submit { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 16px; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; width: 100%; margin-top: 10px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); text-transform: uppercase; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); }
        
        /* Tabel */
        .table-wrapper { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; background: white; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 15px; text-align: left; font-size: 12px; color: #475569; border-bottom: 2px solid #e2e8f0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #1e293b; font-weight: 500; }
        tbody tr:hover { background: #f8fafc; }

        .btn-action-group { display: flex; gap: 8px; align-items: center; }
        .btn-edit, .btn-delete { display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px; border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; text-transform: uppercase; }
        .btn-edit { background: #e0f2fe; color: #0284c7; }
        .btn-edit:hover { background: #bae6fd; transform: translateY(-2px); }
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background: #fecaca; transform: translateY(-2px); }

        .badge-kategori { display: inline-block; padding: 6px 12px; background: #e0f2fe; color: #0284c7; border-radius: 6px; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #bae6fd; }

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
        <div class="page-header" data-aos="fade-in" data-aos-duration="1000">
            <h1 data-aos="fade-right" data-aos-delay="200">🏫 Master Data Target Penerima MBG</h1>
            <p data-aos="fade-right" data-aos-delay="300">Kelola daftar titik target distribusi (Sekolah, Posyandu, Bumil, Busui).</p>
        </div>

        @if(session('success'))
            <div class="alert-success" data-aos="zoom-in" data-aos-delay="100">✅ {{ session('success') }}</div>
        @endif

        <div class="grid-layout">
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <h3>➕ Tambah Titik Target Baru</h3>
                <form action="{{ route('sekolah.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Sekolah / Kelompok</label>
                        <input type="text" name="nama_sekolah" required placeholder="Contoh: SDN 01 / Posyandu Mawar">
                    </div>

                    <div class="form-group">
                        <label>Kategori Penerima MBG</label>
                        <select name="kategori_penerima" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Sekolah">👦 Anak Sekolah (SD/SMP/SMA)</option>
                            <option value="Balita">👶 Balita (Posyandu)</option>
                            <option value="Bumil">🤰 Ibu Hamil (Bumil)</option>
                            <option value="Busui">🤱 Ibu Menyusui (Busui)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Target Porsi (Jumlah Penerima)</label>
                        <input type="number" name="jumlah_siswa" required placeholder="Contoh: 50">
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="4" required placeholder="Jl. Pendidikan No..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">💾 Simpan Data Target</button>
                </form>
            </div>

            <div class="card" data-aos="fade-up" data-aos-delay="600">
                <h3>📋 Daftar Target Terdaftar</h3>
                @if(count($sekolah) > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Lokasi</th>
                                    <th>Kategori</th>
                                    <th>Porsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sekolah as $s)
                                <tr>
                                    <td>
                                        <strong>{{ $s->nama_sekolah }}</strong><br>
                                        <small style="color: #64748b;">{{ $s->alamat }}</small>
                                    </td>
                                    <td><span class="badge-kategori">{{ $s->kategori_penerima ?? 'Sekolah' }}</span></td>
                                    <td><span style="background: #dcfce7; color: #16a34a; padding: 6px 12px; border-radius: 6px; font-weight: 800; font-size: 12px;">{{ $s->jumlah_siswa }} Porsi</span></td>
                                    <td>
                                        <div class="btn-action-group">
                                            <a href="{{ route('sekolah.edit', $s->id) }}" class="btn-edit">✏️ Edit</a>
                                            <form action="{{ route('sekolah.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="margin:0;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-delete">🗑️ Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                        <h4 style="font-size: 16px; margin-bottom: 5px;">Belum Ada Data Target</h4>
                        <p style="font-size: 13px;">Gunakan form di sebelah kiri untuk mendaftarkan lokasi pengiriman.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, offset: 30, duration: 800 }); </script>
</body>
</html>