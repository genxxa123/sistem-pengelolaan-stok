<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Manajemen Persediaan MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Background Utama Menggunakan Gambar Pilihanmu secara Full Screen */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.4)), 
                        url("{{ asset('img/sppg.jpeg') }}") no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh; 
            color: #1e293b; 
        }

        /* Navbar Modern Transparan Kaca */
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
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 1350px; margin: 0 auto; padding: 30px 20px; }
        
        /* Hero Banner */
        .page-header { 
            background: rgba(255, 255, 255, 0.2);
            padding: 45px 40px; 
            border-radius: 24px; 
            margin-bottom: 35px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white; 
        }
        .page-header h1 { font-size: 36px; font-weight: 800; margin-bottom: 10px; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .page-header p { font-size: 15px; color: #f8fafc; max-width: 650px; line-height: 1.6; font-weight: 600; text-shadow: 0 1px 2px rgba(0,0,0,0.2); }

        /* Quick Actions - Kartu Efek Kaca */
        .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 45px; }
        .action-card { 
            background: rgba(255, 255, 255, 0.85); 
            padding: 30px 20px; 
            border-radius: 24px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            text-align: center; 
            text-decoration: none; 
            color: inherit; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
        }
        .action-card:hover { transform: translateY(-10px) scale(1.02); background: rgba(255, 255, 255, 0.95); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); }
        .action-icon { font-size: 45px; margin-bottom: 20px; height: 80px; width: 80px; background: rgba(0, 61, 130, 0.05); border-radius: 20px; display: flex; align-items: center; justify-content: center; transition: all 0.3s; color: #003d82; }
        .action-title { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
        .action-desc { font-size: 13px; color: #475569; line-height: 1.5; font-weight: 500; }
        
        .action-card.bahan:hover .action-icon { background: #e0f2fe; color: #0284c7; }
        .action-card.stok:hover .action-icon { background: #fef08a; color: #ca8a04; }
        .action-card.master:hover .action-icon { background: #dcfce7; color: #16a34a; }
        .action-card.menu:hover .action-icon { background: #fee2e2; color: #dc2626; }

        /* Stats Grid */
        .section-title { color: white; margin-bottom: 20px; font-size: 22px; font-weight: 800; display: flex; align-items: center; gap: 10px; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 45px; }
        .stat-card { 
            background: rgba(255, 255, 255, 0.9); 
            padding: 25px; 
            border-radius: 20px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-bottom: 5px solid #003d82; 
            transition: all 0.3s ease; 
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1); background: rgba(255, 255, 255, 0.95); }
        .stat-card h3 { color: #475569; font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }
        .stat-card .number { font-size: 38px; font-weight: 800; color: #0f172a; line-height: 1; letter-spacing: -1px; }
        .stat-card .subtitle { font-size: 12px; color: #64748b; margin-top: 10px; font-weight: 600; }

        /* Grid untuk Tabel */
        .dashboard-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 45px; }
        @media (max-width: 992px) { .dashboard-grid { grid-template-columns: 1fr; } }

        /* Konten Tabel Utama - Efek Kaca Bersih */
        .content { 
            background: rgba(255, 255, 255, 0.9); 
            border-radius: 24px; 
            padding: 30px; 
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            overflow: hidden;
        }
        
        .section-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0; }
        .section-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #0f172a; }
        .icon-warning { background: #fef08a; }
        .icon-info { background: #e0f2fe; }
        .section-header h2 { font-size: 19px; color: #0f172a; font-weight: 800; flex: 1; margin: 0; letter-spacing: -0.5px; }
        
        .badge { padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        .badge-primary { background: #e0f2fe; color: #0284c7; }

        .table-wrapper { overflow-x: auto; border-radius: 14px; border: 1px solid #e2e8f0; background: white; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fafc; border-bottom: 2px solid #e2e8f0; }
        th { padding: 15px; text-align: left; font-weight: 700; font-size: 12px; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 13px; font-weight: 600; }
        tbody tr:hover { background: #f8fafc; }

        .status { display: inline-block; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 11px; text-align: center; letter-spacing: 0.5px; }
        .status-expired { background: #fee2e2; color: #dc2626; }
        .status-warning { background: #fef08a; color: #ca8a04; }
        .status-ok { background: #dcfce7; color: #16a34a; }
        .status-menu { background: #e0f2fe; color: #0284c7; }

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
            <a href="{{ route('dashboard') }}" style="background: rgba(0,0,0,0.06);">🏠 Dashboard</a>
            @if(Auth::user()->role === 'admin')
                @php
                    // Menghitung jumlah notifikasi yang belum dibaca
                    $notifCount = \App\Models\Notifikasi::where('is_read', false)->count();
                @endphp
                <a href="#" id="bellNotif" style="position: relative; background: transparent; padding: 10px;">
                    <span style="font-size: 18px;">🔔</span>
                    @if($notifCount > 0)
                        <span style="position: absolute; top: 0px; right: 0px; background: #ef4444; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: 900;">{{ $notifCount }}</span>
                    @endif
                </a>
                <a href="{{ route('bahan.index') }}">📦 Bahan</a>
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
            <h1 data-aos="slide-right" data-aos-delay="200">Command Center MBG</h1>
            <p data-aos="slide-right" data-aos-delay="400">Pusat Informasi Cerdas Manajemen Bahan Baku, Jadwal Resep, dan Riwayat Produksi Dapur Program Makan Bergizi Gratis.</p>
        </div>

        <div class="quick-actions">
            <a href="{{ route('bahan.index') }}" class="action-card bahan" data-aos="fade-up" data-aos-delay="100">
                <div class="action-icon">📦</div>
                <div class="action-title">Data Bahan Baku</div>
                <div class="action-desc">Kelola master bahan mentah & satuan dapur.</div>
            </a>
            <a href="{{ route('stok.index') }}" class="action-card stok" data-aos="fade-up" data-aos-delay="200">
                <div class="action-icon">📊</div>
                <div class="action-title">Stok In & FEFO</div>
                <div class="action-desc">Input stok masuk & pantau sistem kadaluarsa.</div>
            </a>
            <a href="{{ route('master_menu.index') }}" class="action-card master" data-aos="fade-up" data-aos-delay="300">
                <div class="action-icon">🍳</div>
                <div class="action-title">Template Resep</div>
                <div class="action-desc">Buat inovasi resep & takaran baku (BOM).</div>
            </a>
            <a href="{{ route('menu.index') }}" class="action-card menu" data-aos="fade-up" data-aos-delay="400">
                <div class="action-icon">🍽️</div>
                <div class="action-title">Produksi Dapur</div>
                <div class="action-desc">Proses pesanan harian & potong stok otomatis.</div>
            </a>
        </div>

        <div class="section-title" data-aos="fade-right">📈 Rekapitulasi Sistem Terkini</div>
        
        <div class="stats-container">
            <div class="stat-card" style="border-color: #3b82f6;" data-aos="zoom-in" data-aos-delay="100">
                <h3>📦 Jenis Bahan</h3>
                <div class="number">{{ \App\Models\Bahan::count() }}</div>
                <div class="subtitle">Item Terdaftar di Sistem</div>
            </div>

            <div class="stat-card" style="border-color: #10b981;" data-aos="zoom-in" data-aos-delay="200">
                <h3>🍳 Master Resep</h3>
                <div class="number">{{ \App\Models\MasterMenu::count() }}</div>
                <div class="subtitle">Menu Siap Produksi</div>
            </div>

            <div class="stat-card" style="border-color: #8b5cf6;" data-aos="zoom-in" data-aos-delay="300">
                <h3>🍽️ Riwayat Masak</h3>
                <div class="number">{{ \App\Models\Menu::count() }}</div>
                <div class="subtitle">Total Aktivitas Dapur</div>
            </div>

            <div class="stat-card" style="border-color: #ef4444;" data-aos="zoom-in" data-aos-delay="400">
                <h3>❌ Stok Expired</h3>
                <div class="number">
                    @php
                        $expired = 0;
                        $warning = 0;
                        $hariIni = \Carbon\Carbon::today();
                        foreach($stokFefo as $s) {
                            $kadaluarsa = \Carbon\Carbon::parse($s->tanggal_kadaluarsa);
                            if ($kadaluarsa->lt($hariIni)) $expired++;
                            elseif ($kadaluarsa->gte($hariIni) && $hariIni->diffInDays($kadaluarsa) <= 5) $warning++;
                        }
                    @endphp
                    {{ $expired }}
                </div>
                <div class="subtitle">Batch tidak bisa dipakai</div>
            </div>

            <div class="stat-card" style="border-color: #f59e0b;" data-aos="zoom-in" data-aos-delay="500">
                <h3>⚠️ Hampir Expired</h3>
                <div class="number">{{ $warning }}</div>
                <div class="subtitle">Sisa waktu &lt; 5 hari</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="content" data-aos="fade-up" data-aos-delay="200">
                <div class="section-header">
                    <div class="section-icon icon-warning">📋</div>
                    <h2>Monitoring FEFO Stok</h2>
                    <div class="badge badge-danger">🔴 Perlu Cek</div>
                </div>

                @if(count($stokFefo) > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Bahan</th>
                                    <th>Sisa</th>
                                    <th>Tgl Expired</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(array_slice($stokFefo->toArray(), 0, 7) as $s) @php
                                        $s = (object)$s;
                                        $bahan = \App\Models\Bahan::find($s->bahan_id);
                                        $kadaluarsa = \Carbon\Carbon::parse($s->tanggal_kadaluarsa);
                                        $sisaHari = $hariIni->diffInDays($kadaluarsa);
                                        
                                        if ($kadaluarsa->lt($hariIni)) {
                                            $statusClass = 'status-expired';
                                            $statusText = 'KADALUARSA';
                                        } elseif ($sisaHari <= 7) {
                                            $statusClass = 'status-warning';
                                            $statusText = $sisaHari . ' HARI';
                                        } else {
                                            $statusClass = 'status-ok';
                                            $statusText = 'AMAN';
                                        }
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $bahan->nama_bahan ?? 'Data Dihapus' }}</strong></td>
                                        <td>{{ $s->jumlah }} <small>{{ $bahan->satuan ?? '' }}</small></td>
                                        <td>{{ $kadaluarsa->format('d M Y') }}</td>
                                        <td><span class="status {{ $statusClass }}">{{ $statusText }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <h3>✨ Stok Logistik Aman</h3>
                        <p>Semua stok berada dalam kondisi segar dan baik.</p>
                    </div>
                @endif
            </div>

            <div class="content" data-aos="fade-up" data-aos-delay="400">
                <div class="section-header">
                    <div class="section-icon icon-info">🧑‍🍳</div>
                    <h2>Aktivitas Dapur Terkini</h2>
                    <div class="badge badge-primary">🔵 Terbaru</div>
                </div>

                @php
                    $recentMenus = \App\Models\Menu::orderBy('created_at', 'desc')->take(6)->get();
                @endphp

                @if(count($recentMenus) > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal Masak</th>
                                    <th>Nama Menu / Pesanan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMenus as $rm)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($rm->tanggal_menu)->format('d M Y') }}</td>
                                        <td><strong>{{ $rm->nama_menu }}</strong></td>
                                        <td><span class="status status-menu">SELESAI</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: right; margin-top: 15px;">
                        <a href="{{ route('menu.index') }}" style="font-size: 13px; color: #0284c7; text-decoration: none; font-weight: 800;">Lihat Semua Riwayat ➔</a>
                    </div>
                @else
                    <div class="empty-state">
                        <h3>🍽️ Belum Ada Produksi</h3>
                        <p>Belum ada jadwal menu harian yang diproses oleh dapur.</p>
                    </div>
                @endif
            </div>
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

    <div id="notifModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(5px);">
    <div style="background: white; width: 500px; max-width: 90%; border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 18px; color: #0f172a;">🔔 Laporan dari Chef</h3>
            <button id="closeNotif" style="background: #fee2e2; color: #dc2626; border: none; font-size: 14px; font-weight: bold; padding: 5px 10px; border-radius: 8px; cursor: pointer;">Tutup ✖</button>
        </div>
        
        <div style="max-height: 350px; overflow-y: auto; padding-right: 10px;">
            @php
                // Ambil semua notifikasi, urutkan dari yang paling baru
                $listNotif = \App\Models\Notifikasi::orderBy('created_at', 'desc')->get();
            @endphp
            
            @forelse($listNotif as $n)
                <div style="padding: 15px; border-radius: 12px; margin-bottom: 10px; background: {{ $n->is_read ? '#f8fafc' : '#fef2f2' }}; border: 1px solid {{ $n->is_read ? '#e2e8f0' : '#fecaca' }};">
                    <p style="margin: 0; font-size: 13px; color: #1e293b; line-height: 1.5;">{{ $n->pesan }}</p>
                    <small style="color: #64748b; font-weight: bold; margin-top: 5px; display: block;">⏳ {{ $n->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p style="text-align: center; color: #64748b; font-size: 14px; padding: 20px;">Tidak ada laporan masuk.</p>
            @endforelse
        </div>

        @if($notifCount > 0)
        <div style="margin-top: 20px; text-align: right; border-top: 2px solid #f1f5f9; padding-top: 15px;">
            <form action="{{ route('menu.tandaiDibaca') }}" method="POST">
                @csrf
                <button type="submit" style="background: #10b981; color: white; border: none; padding: 12px 20px; border-radius: 10px; cursor: pointer; font-weight: 800; transition: 0.3s;">
                    ✅ Tandai Semua Sudah Dibaca
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

<script>
    // Script untuk membuka dan menutup pop-up notifikasi
    document.getElementById('bellNotif').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('notifModal').style.display = 'flex';
    });
    document.getElementById('closeNotif').addEventListener('click', function() {
        document.getElementById('notifModal').style.display = 'none';
    });
</script>
</body>
</html>