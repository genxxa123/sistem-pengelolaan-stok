<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Menu & Resep - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/resep.jpg') }}") no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh; 
            color: #1e293b; 
        }

        /* Navbar Kaca */
        .navbar { background: rgba(255, 255, 255, 0.85); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header Kaca */
        .page-header { background: rgba(255, 255, 255, 0.2); padding: 25px 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: space-between; }
        .header-content h1 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); margin-bottom: 5px; }
        .header-content p { font-size: 14px; color: #f1f5f9; font-weight: 500; }

        .btn-add { background: linear-gradient(135deg, #10b981, #059669); color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); transition: all 0.3s; display: inline-flex; align-items: center; border: none; cursor: pointer; }
        .btn-add:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4); }

        /* Kartu Menu Kaca */
        .menu-card { background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 25px; margin-bottom: 25px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); transition: all 0.3s ease; }
        .menu-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15); border-color: #10b981; }
        
        .menu-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e2e8f0; }
        .menu-icon { width: 45px; height: 45px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; font-weight: bold; box-shadow: 0 4px 10px rgba(16,185,129,0.3); }
        .menu-title { flex: 1; }
        .menu-title h3 { color: #0f172a; font-size: 20px; font-weight: 800; margin-bottom: 3px; letter-spacing: -0.5px; }
        .menu-title p { color: #64748b; font-size: 13px; margin: 0; font-weight: 600; }
        
        .menu-items { list-style: none; padding: 0; margin: 0; }
        .menu-items li { display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; border-bottom: 1px dashed #cbd5e1; color: #334155; font-size: 14px; font-weight: 600; }
        .menu-items li:last-child { border-bottom: none; }
        .menu-items li:nth-child(odd) { background: rgba(241, 245, 249, 0.5); border-radius: 8px; }
        .menu-items strong { color: #0f172a; }
        .jumlah { background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 800; }

        .btn-delete { background: #fee2e2; color: #dc2626; padding: 10px 16px; border-radius: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; cursor: pointer; border: none; transition: all 0.2s; box-shadow: 0 2px 5px rgba(220, 38, 38, 0.1); }
        .btn-delete:hover { background: #ef4444; color: white; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3); }

        .empty-state { text-align: center; padding: 60px 20px; color: #f8fafc; background: rgba(255,255,255,0.1); border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .empty-state h3 { font-size: 22px; font-weight: 800; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        
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
        <div class="page-header" data-aos="fade-in" data-aos-duration="1000">
            <div class="header-content" data-aos="slide-right" data-aos-delay="200">
                <h1>📋 Master Menu & Resep</h1>
                <p>Kelola template menu masakan dan komposisi takaran bahan baku.</p>
            </div>
            <a href="{{ route('master_menu.create') }}" class="btn-add" data-aos="zoom-in" data-aos-delay="400">
                ➕ Buat Master Menu Baru
            </a>
        </div>

        <div>
            @if(count($masterMenus) > 0)
                @foreach($masterMenus as $index => $m)
                    <div class="menu-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="menu-header">
                            <div class="menu-icon">🍳</div>
                            <div class="menu-title">
                                <h3>{{ $m->nama_menu }}</h3>
                                <p>Komposisi Resep untuk <b>1 Porsi</b></p>
                            </div>
                        </div>

                        @if(count($m->reseps) > 0)
                            <ul class="menu-items">
                                @foreach($m->reseps as $resep)
                                    <li>
                                        <strong>{{ $resep->bahan->nama_bahan }}</strong>
                                        <span class="jumlah">{{ $resep->takaran }} {{ $resep->bahan->satuan }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p style="color: #64748b; font-size: 13px; text-align: center; padding: 20px; font-weight: 600;">
                                ℹ️ Menu ini belum memiliki resep komposisi.
                            </p>
                        @endif

                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px;">
                            <form action="{{ route('master_menu.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus master menu ini? Jika dihapus, menu harian yang menggunakan resep ini mungkin akan kehilangan referensinya.');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">🗑️ Hapus Master Menu</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state" data-aos="zoom-in">
                    <h3>🍳 Belum Ada Master Menu</h3>
                    <p>Sistem ini membutuhkan Master Menu (Template Resep) agar fitur pemotongan stok otomatis berjalan. Silakan buat resep dasar pertama Anda.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistem Manajemen Persediaan Makan Bergizi Gratis (MBG)</strong></p>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init({ once: true, offset: 30, duration: 800, easing: 'ease-out-cubic' }); </script>
</body>
</html>