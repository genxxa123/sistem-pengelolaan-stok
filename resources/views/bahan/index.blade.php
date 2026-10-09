<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bahan - Sistem Manajemen Persediaan MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Full Screen Fixed Background dengan Gambar Pilihanmu */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.4)), 
                        url("{{ asset('img/gudang.jpeg') }}") no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh; 
            color: #1e293b; 
        }

        /* Navbar Modern Transparan Kaca - Seragam dengan Dashboard */
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
        /* Logo a.png Wajib - Memenuhi Permintaan Dosen */
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 1300px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header Halaman Bertema Putih - Glassmorphism */
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

        /* Tombol Tambah yang Menonjol */
        .btn-add { background: linear-gradient(135deg, #FFD700, #F39C12); color: #003d82; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3); transition: all 0.3s; }
        .btn-add:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 8px 20px rgba(243, 156, 18, 0.4); }

        /* Area Konten Utama Kaca Transparan */
        .content-card { 
            background: rgba(255, 255, 255, 0.9); 
            border-radius: 24px; 
            padding: 30px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            overflow: hidden;
        }
        
        /* Styling Tabel Modern */
        .table-wrapper { overflow-x: auto; border-radius: 14px; border: 1px solid #e2e8f0; background: white; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fafc; border-bottom: 2px solid #e2e8f0; }
        th { padding: 15px; text-align: left; font-weight: 700; font-size: 12px; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 13px; font-weight: 600; }
        tbody tr:hover { background: #f8fafc; }

        /* Styling Action Buttons */
        .btn-action-view { text-decoration: none; color: #0284c7; padding: 6px 12px; background: #e0f2fe; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        
        /* Status Empty State */
        .empty-state { text-align: center; padding: 50px 20px; color: #64748b; }
        .empty-state h3 { font-size: 18px; margin-bottom: 8px; color: #334155; font-weight: 700; }

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
                <h1>Daftar Bahan Baku</h1>
                <p>Kelola master bahan mentah & satuan yang terdaftar di dapur.</p>
            </div>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('bahan.create') }}" class="btn-add" data-aos="zoom-in" data-aos-delay="400">
                    ➕ Tambah Bahan Baru
                </a>
            @endif
        </div>

        <div class="content-card" data-aos="fade-up" data-aos-duration="1000">
            @if(count($bahan) > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bahan as $index => $b)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td><strong>{{ $b->nama_bahan }}</strong></td>
                                    <td>
                                        <span style="background: #e2e8f0; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; color: #1e293b; text-transform: uppercase;">
                                            {{ $b->satuan }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <h3>📦 Belum Ada Data Bahan</h3>
                    <p>Silakan tambahkan bahan persediaan terlebih dahulu dengan mengklik tombol Tambah.</p>
                </div>
            @endif
        </div> 
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
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