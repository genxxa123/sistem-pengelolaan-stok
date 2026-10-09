<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Dashboard - MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            /* Overlay warna gelap hangat (kecoklatan/oranye) agar tulisan tetap terbaca */
            background: linear-gradient(rgba(40, 20, 10, 0.65), rgba(30, 15, 10, 0.75)), 
                        url("{{ asset('img/dapur.jpg') }}") no-repeat center center fixed; 
            background-size: cover; min-height: 100vh; color: #1e293b; 
        }

        /* Navbar Kaca Spesial Chef */
        .navbar { background: rgba(255, 255, 255, 0.9); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(15px); border-bottom: 3px solid #ea580c; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: #ffedd5; color: #ea580c; transform: translateY(-1px); }

        .container { padding: 40px 20px; max-width: 1200px; margin: 0 auto; }

        /* Banner Sambutan Chef */
        .welcome-card { background: linear-gradient(135deg, rgba(234, 88, 12, 0.9), rgba(194, 65, 12, 0.95)); padding: 40px; border-radius: 24px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 15px 35px rgba(234, 88, 12, 0.3); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 30px; }
        .welcome-text h1 { font-size: 32px; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .welcome-text p { font-size: 15px; font-weight: 500; opacity: 0.9; }
        .welcome-icon { font-size: 60px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2)); }

        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 25px; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }
        
        /* Kartu Kaca Utama */
        .card { background: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 24px; box-shadow: 0 8px 32px rgba(0,0,0,0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .card h3 { color: #0f172a; font-size: 20px; font-weight: 800; border-bottom: 2px dashed #cbd5e1; padding-bottom: 15px; margin-bottom: 20px; letter-spacing: -0.5px; }

        /* Tombol Aksi Kaca */
        .btn-action { display: block; text-align: center; background: linear-gradient(135deg, #ea580c, #c2410c); color: white; text-decoration: none; padding: 14px 20px; border-radius: 12px; font-weight: 800; font-size: 14px; margin-bottom: 15px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3); text-transform: uppercase; }
        .btn-action:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(234, 88, 12, 0.4); }
        
        .btn-action-alt { display: block; text-align: center; background: #fff7ed; color: #ea580c; border: 2px solid #fdba74; text-decoration: none; padding: 14px 20px; border-radius: 12px; font-weight: 800; font-size: 14px; transition: all 0.3s; text-transform: uppercase; }
        .btn-action-alt:hover { background: #ffedd5; transform: translateY(-3px); box-shadow: 0 4px 15px rgba(253, 186, 116, 0.4); }

        /* Statistik Dapur */
        .stats-container { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 25px; }
        .stat-box { background: rgba(248, 250, 252, 0.8); padding: 20px; border-radius: 16px; text-align: center; border: 1px dashed #cbd5e1; transition: 0.3s; }
        .stat-box:hover { border-color: #ea580c; background: white; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .stat-box .number { font-size: 28px; font-weight: 800; color: #ea580c; margin-bottom: 5px; }
        .stat-box .label { font-size: 11px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Tabel Jadwal Masak */
        .table-wrapper { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; background: white; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 15px; text-align: left; font-size: 12px; color: #475569; border-bottom: 2px solid #e2e8f0; font-weight: 800; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #1e293b; font-weight: 600; vertical-align: middle; }
        tbody tr:hover { background: #fff7ed; }

        .btn-edit { background: #fef08a; color: #ca8a04; padding: 8px 16px; border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; border: none; transition: all 0.2s; text-transform: uppercase; display: inline-block; }
        .btn-edit:hover { background: #fde047; transform: translateY(-2px); }

        .empty-state { text-align: center; padding: 40px 20px; color: #64748b; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1; }
        .empty-state h4 { font-size: 16px; font-weight: 800; color: #334155; margin-bottom: 5px; }

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
            <a href="{{ route('dashboard') }}" style="background: #ffedd5; color: #ea580c;">🏠 Dashboard Dapur</a>
            <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
            <a href="{{ route('menu.index') }}">🍽️ Menu Harian</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left: 15px;">
                @csrf
                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 11px 22px; border-radius: 10px; cursor: pointer; font-weight: 700; transition: background 0.3s;">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card" data-aos="zoom-in" data-aos-duration="1000">
            <div class="welcome-text">
                <h1>Halo, Chef {{ Auth::user()->name }} 👨‍🍳</h1>
                <p>Selamat datang di Dapur Utama. Siapkan resep dan pantau jadwal masak hari ini untuk memotong stok secara otomatis.</p>
            </div>
            <div class="welcome-icon">🥘</div>
        </div>

        <div class="grid">
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <h3>⚡ Akses Cepat</h3>
                <a href="{{ route('master_menu.create') }}" class="btn-action">🍳 Buat Master Resep Baru</a>
                <a href="{{ route('menu.create') }}" class="btn-action-alt">📅 Jadwalkan Menu Hari Ini</a>
                
                <div class="stats-container">
                    <div class="stat-box">
                        <div class="number">{{ $totalResep }}</div>
                        <div class="label">Master Resep</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ count($menuHariIni) }}</div>
                        <div class="label">Menu Hari Ini</div>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px dashed #cbd5e1; margin: 25px 0;">
                <p style="font-size: 12px; color: #64748b; font-weight: 600; line-height: 1.6; text-align: center;">
                    💡 Pastikan Anda membuat <strong>Master Menu</strong> terlebih dahulu sebelum menjadwalkan <strong>Menu Harian</strong>.
                </p>
            </div>

            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <h3>🍽️ Daftar Menu Harian (Dimasak Hari Ini)</h3>
                
                @if(count($menuHariIni) > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal Masak</th>
                                    <th>Nama Masakan</th>
                                    <th>Aksi Dapur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menuHariIni as $menu)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($menu->tanggal_menu)->format('d F Y') }}</td>
                                    <td><strong style="color: #ea580c;">{{ $menu->nama_menu }}</strong></td>
                                    <td>
                                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn-edit">🔍 Lihat / Edit Menu</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <h4>Belum Ada Jadwal Masak</h4>
                        <p style="font-size: 13px;">Tidak ada menu yang dijadwalkan untuk dimasak hari ini. Silakan buat melalui Akses Cepat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
        <p style="margin-top: 5px; color: #cbd5e1; font-weight: 500;">Pusat Produksi & Dapur Utama</p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, offset: 30, duration: 800 }); </script>
</body>
</html>