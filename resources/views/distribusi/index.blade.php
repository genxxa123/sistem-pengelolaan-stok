<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Distribusi - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/dis.jpg') }}") no-repeat center center fixed; 
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

        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header Kaca */
        .page-header { background: rgba(255, 255, 255, 0.2); padding: 25px 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: space-between; }
        .header-content h1 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); margin-bottom: 5px; }
        .header-content p { font-size: 14px; color: #f1f5f9; font-weight: 500; }

        .btn-add { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 800; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3); transition: all 0.3s; display: inline-flex; align-items: center; border: none; cursor: pointer; text-transform: uppercase; }
        .btn-add:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4); }

        .alert-success { background: #dcfce7; color: #166534; padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; border-left: 5px solid #16a34a; font-weight: 600; font-size: 14px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        /* Konten Kaca Utama */
        .content-card { background: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); overflow: hidden; }
        
        .table-wrapper { overflow-x: auto; border-radius: 14px; border: 1px solid #e2e8f0; background: white; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fafc; border-bottom: 2px solid #e2e8f0; }
        th { padding: 15px; text-align: left; font-weight: 800; font-size: 12px; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 13px; font-weight: 600; vertical-align: middle; }
        tbody tr:hover { background: #f8fafc; }

        .badge-status { display: inline-block; padding: 6px 12px; background: #e0f2fe; color: #0284c7; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #bae6fd; }

        .btn-action-group { display: flex; gap: 8px; align-items: center; }
        .btn-edit, .btn-delete { display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px; border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; text-transform: uppercase; }
        .btn-edit { background: #fef08a; color: #ca8a04; }
        .btn-edit:hover { background: #fde047; transform: translateY(-2px); }
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background: #fecaca; transform: translateY(-2px); }

        .empty-state { text-align: center; padding: 50px 20px; color: #64748b; }
        .empty-state h3 { font-size: 18px; margin-bottom: 8px; color: #334155; font-weight: 800; }
        
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
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}" style="background: rgba(0,0,0,0.06);">🚚 Distribusi</a>
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
                <h1>🚚 Riwayat Distribusi</h1>
                <p>Data pengiriman makanan bergizi ke sekolah-sekolah penerima.</p>
            </div>
            <a href="{{ route('distribusi.create') }}" class="btn-add" data-aos="zoom-in" data-aos-delay="400">
                ➕ Jadwalkan Kirim
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success" data-aos="zoom-in" data-aos-delay="100">✅ {{ session('success') }}</div>
        @endif

        <div class="content-card" data-aos="fade-up" data-aos-delay="500">
            @if(count($distribusi) > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu Kirim</th>
                                <th>Sekolah Tujuan</th>
                                <th>Menu Dimasak</th>
                                <th>Total Porsi</th>
                                <th>Penerima</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distribusi as $d)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($d->waktu_kirim)->format('d M Y - H:i') }}</td>
                                <td><strong>{{ $d->sekolah->nama_sekolah ?? 'Sekolah Dihapus' }}</strong></td>
                                <td>{{ $d->menu->nama_menu ?? 'Menu Dihapus' }}</td>
                                <td><span style="color: #ea580c; font-weight: 800; background: #ffedd5; padding: 4px 10px; border-radius: 6px;">{{ number_format($d->jumlah_porsi, 0, ',', '.') }} Porsi</span></td>
                                <td style="color: #64748b;">{{ $d->penerima ?? '-' }}</td>
                                <td><span class="badge-status">🚚 {{ $d->status }}</span></td>
                                <td>
                                    <div class="btn-action-group">
                                        <a href="{{ route('distribusi.edit', $d->id) }}" class="btn-edit">✏️ Edit</a>
                                        <form action="{{ route('distribusi.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="margin:0;">
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
                <div class="empty-state">
                    <h3>🚚 Belum Ada Riwayat Pengiriman</h3>
                    <p>Jadwalkan pengiriman logistik makanan pertama Anda.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, offset: 30, duration: 800 }); </script>
</body>
</html>