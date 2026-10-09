<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Makanan - Dashboard MBG</title>
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

        .navbar { background: rgba(255, 255, 255, 0.85); padding: 12px 30px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 50px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: rgba(0, 0, 0, 0.05); transform: translateY(-1px); }

        .container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        
        .form-card { background: rgba(255, 255, 255, 0.95); border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .form-card h2 { color: #0f172a; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 5px; }
        .form-card > p { color: #64748b; font-size: 14px; margin-bottom: 25px; font-weight: 500; }

        .form-group { margin-bottom: 22px; }
        label { display: block; font-weight: 800; font-size: 12px; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        input, select { width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #1e293b; transition: all 0.3s ease; background: white; font-family: inherit; }
        input:focus, select:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1); }
        
        .btn-submit { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); transition: all 0.3s; width: 100%; margin-top: 20px; text-transform: uppercase; }
        .btn-submit:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4); }

        .btn-back { display: block; text-align: center; margin-top: 20px; color: #64748b; text-decoration: none; font-size: 14px; font-weight: 700; transition: all 0.2s; }
        .btn-back:hover { color: #0f172a; }

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
                <a href="{{ route('sekolah.index') }}">🏫 Sekolah</a>
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
        <div class="form-card" data-aos="fade-up" data-aos-duration="1000">
            <h2 data-aos="fade-down">🚚 Jadwalkan Distribusi</h2>
            <p data-aos="fade-down" data-aos-delay="100">Kirim porsi makanan bergizi yang sudah matang ke sekolah.</p>

            <form action="{{ route('distribusi.store') }}" method="POST">
                @csrf

                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label>Pilih Menu Harian yang Tersedia</label>
                    <select name="menu_id" required>
                        <option value="">-- Pilih Menu (Berdasarkan Tanggal) --</option>
                        @foreach($menus as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->nama_menu }} - Dimasak: {{ \Carbon\Carbon::parse($m->tanggal_menu)->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label>Pilih Sekolah Tujuan Pengiriman</label>
                    <select name="sekolah_id" id="sekolah_select" onchange="setKapasitas()" required>
                        <option value="">-- Pilih Target Penerima --</option>
                        @foreach($sekolahs as $s)
                            <option value="{{ $s->id }}" data-siswa="{{ $s->jumlah_siswa }}">{{ $s->nama_sekolah }} (Target: {{ $s->jumlah_siswa }} Porsi)</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                        <label>Jumlah Porsi Dikirim</label>
                        <input type="number" name="jumlah_porsi" id="jumlah_porsi" min="1" required placeholder="Contoh: 500">
                    </div>

                    <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                        <label>Waktu Keberangkatan / Kirim</label>
                        <input type="datetime-local" name="waktu_kirim" value="{{ date('Y-m-d\TH:i') }}" required>
                    </div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="600">
                    <label>Nama Penanggung Jawab / Penerima (Opsional)</label>
                    <input type="text" name="penerima" placeholder="Contoh: Bapak Supir / Guru Piket">
                </div>

                <button type="submit" class="btn-submit" data-aos="zoom-in" data-aos-delay="700">🚚 Konfirmasi Pengiriman</button>
                <a href="{{ route('distribusi.index') }}" class="btn-back" data-aos="fade-up" data-aos-delay="800">Batalkan</a>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 30, duration: 800 });

        // FUNGSI JAVASCRIPT ASLI - DIPERTAHANKAN 100%
        function setKapasitas() {
            var select = document.getElementById('sekolah_select');
            var jumlahSiswa = select.options[select.selectedIndex].getAttribute('data-siswa');
            if(jumlahSiswa > 0) {
                document.getElementById('jumlah_porsi').value = jumlahSiswa;
            } else {
                document.getElementById('jumlah_porsi').value = '';
            }
        }
    </script>
</body>
</html>