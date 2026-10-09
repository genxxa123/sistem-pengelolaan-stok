<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Distribusi MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        /* GAYA LAYAR (SCREEN) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #e2e8f0; color: #1e293b; }
        
        .navbar { background: rgba(255, 255, 255, 0.95); padding: 12px 30px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; border-bottom: 3px solid #10b981; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 40px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: #f1f5f9; transform: translateY(-1px); }

        .filter-section { background: #0f172a; color: white; padding: 20px 30px; border-radius: 16px; margin: 30px auto; max-width: 900px; display: flex; gap: 15px; justify-content: center; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .filter-section label { font-weight: 700; font-size: 13px; text-transform: uppercase; }
        .filter-section input { padding: 10px 15px; border-radius: 8px; border: 1px solid #475569; background: #1e293b; color: white; font-family: inherit; font-weight: 600; outline: none; }
        .filter-btn { background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; transition: 0.3s; }
        .filter-btn:hover { background: #059669; }
        .btn-switch { background: #f59e0b; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; transition: 0.3s; text-decoration: none; }
        .btn-switch:hover { background: #d97706; }

        /* GAYA KERTAS (A4 PRINT) */
        .document-wrapper { width: 100%; max-width: 850px; margin: 0 auto 50px auto; padding: 50px; background: #fff; box-shadow: 0 15px 35px rgba(0,0,0,0.1); font-family: 'Times New Roman', Times, serif; color: #000; line-height: 1.5; }
        .kop-surat { display: flex; align-items: center; border-bottom: 4px solid #000; padding-bottom: 15px; margin-bottom: 3px; }
        .kop-surat::after { content: ''; display: block; border-bottom: 1px solid #000; position: relative; top: 18px; }
        .logo-kop { width: 90px; height: auto; margin-right: 20px; }
        .teks-kop { flex: 1; text-align: center; }
        .teks-kop h2 { font-size: 18px; text-transform: uppercase; margin: 0; font-weight: normal; }
        .teks-kop h1 { font-size: 22px; text-transform: uppercase; margin: 3px 0; font-weight: bold; }
        .teks-kop p { font-size: 12px; margin: 0; }
        .garis-bawah-kop { border-top: 1px solid #000; margin-bottom: 25px; }

        .judul-laporan { text-align: center; margin-bottom: 30px; }
        .judul-laporan h3 { text-decoration: underline; font-size: 16px; margin: 0 0 5px 0; text-transform: uppercase; }
        
        .info-grid { margin-bottom: 20px; font-size: 13px; }
        
        .tabel-resmi { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        .tabel-resmi th, .tabel-resmi td { border: 1px solid #000; padding: 8px 10px; }
        .tabel-resmi th { background-color: #f0f0f0; text-align: center; font-weight: bold; text-transform: uppercase; }
        .tabel-resmi td.angka { text-align: right; }
        .tabel-resmi td.tengah { text-align: center; }

        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; text-transform: uppercase; background: #e2e8f0; padding: 5px 10px; border-left: 4px solid #000; }

        .summary-box { border: 2px solid #000; padding: 15px; margin-bottom: 30px; text-align: center; font-size: 14px; background: #fafafa; }

        .footer-sig { display: flex; justify-content: space-between; margin-top: 50px; font-size: 13px; text-align: center; page-break-inside: avoid; }
        .sig-box { width: 250px; }
        .sig-space { height: 80px; }

        @media print {
            @page { size: A4 portrait; margin: 1.5cm; }
            body { background: white; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .document-wrapper { box-shadow: none; margin: 0; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="navbar no-print">
        <a href="{{ route('dashboard') }}" class="logo-section">
            <img src="{{ asset('img/logo_sppg.png') }}" alt="Logo MBG" class="logo-img">
        </a>
        <div class="navbar-spacer"></div>
        <div class="navbar-menu">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('bahan.index') }}">📦 Bahan</a>
                <a href="{{ route('stok.index') }}">📊 Stok</a>
                <a href="{{ route('laporan.index') }}" style="background: rgba(0,0,0,0.06);">📑 Laporan</a>
                <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}">🍽️ Menu Harian</a>
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}">🚚 Distribusi</a>
            @endif
        </div>
    </div>

    <div class="filter-section no-print">
        <form method="GET" action="{{ route('laporan.distribusi') }}" style="display: flex; gap: 10px; align-items: center;">
            <label>Periode:</label>
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal', $awalPeriode->format('Y-m-d')) }}">
            <span style="font-weight: bold;">s/d</span>
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir', $akhirPeriode->format('Y-m-d')) }}">
            <button type="submit" class="filter-btn">🔄 Terapkan Filter</button>
        </form>
        <div style="border-left: 2px solid #475569; height: 30px; margin: 0 10px;"></div>
        <a href="{{ route('laporan.index') }}" class="btn-switch">📦 Ke Laporan Logistik</a>
        <button type="button" class="filter-btn" style="background: #3b82f6;" onclick="window.print()">🖨️ Cetak PDF</button>
    </div>

    <div class="document-wrapper">
        <div class="kop-surat">
            <img src="{{ asset('img/logo_sppg.png') }}" alt="Logo Satuan" class="logo-kop">
            <div class="teks-kop">
                <h2>PEMERINTAH PROVINSI SUMATERA BARAT</h2>
                <h1>SATUAN PELAYANAN PROGRAM GIZI (SPPG)</h1>
                <p>Lungguak Batu, Nagari Koto Kaciak Bara, Kec. Bonjol, Kab. Pasaman, Sumatra barat</p>
            </div>
        </div>
        <div class="garis-bawah-kop"></div>

        <div class="judul-laporan">
            <h3>LAPORAN PENYALURAN DAN DISTRIBUSI GIZI</h3>
            <p>Nomor Dokumen: DIST/MBG/{{ date('Y/m') }}</p>
        </div>

        <div class="info-grid">
            <table style="font-size: 13px;">
                <tr><td width="120">Periode Laporan</td><td>: <strong>{{ \Carbon\Carbon::parse($awalPeriode)->format('d F Y') }} - {{ \Carbon\Carbon::parse($akhirPeriode)->format('d F Y') }}</strong></td></tr>
                <tr><td>Tanggal Cetak</td><td>: {{ date('d F Y H:i') }} WIB</td></tr>
            </table>
        </div>

        <div class="summary-box">
            <strong>Total Keseluruhan Porsi Tersalurkan: <span style="font-size: 16px;">{{ number_format($totalTersalurkan, 0, ',', '.') }} Porsi</span></strong>
        </div>

        <div class="section-title">A. Rekapitulasi Berdasarkan Kategori Penerima</div>
        <table class="tabel-resmi" style="width: 70%; margin: 0 auto 30px auto;">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="50%">Kategori Penerima Manfaat</th>
                    <th width="40%">Total Porsi Disalurkan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tengah">1</td><td>👦 Anak Sekolah (SD/SMP/SMA)</td>
                    <td class="tengah"><strong>{{ number_format($rekapKategori['Sekolah'] ?? 0, 0, ',', '.') }} Porsi</strong></td>
                </tr>
                <tr>
                    <td class="tengah">2</td><td>👶 Balita (Posyandu)</td>
                    <td class="tengah"><strong>{{ number_format($rekapKategori['Balita'] ?? 0, 0, ',', '.') }} Porsi</strong></td>
                </tr>
                <tr>
                    <td class="tengah">3</td><td>🤰 Ibu Hamil (Bumil)</td>
                    <td class="tengah"><strong>{{ number_format($rekapKategori['Bumil'] ?? 0, 0, ',', '.') }} Porsi</strong></td>
                </tr>
                <tr>
                    <td class="tengah">4</td><td>🤱 Ibu Menyusui (Busui)</td>
                    <td class="tengah"><strong>{{ number_format($rekapKategori['Busui'] ?? 0, 0, ',', '.') }} Porsi</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">B. Rincian Pengiriman per Titik Lokasi</div>
        <table class="tabel-resmi">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Waktu Kirim</th>
                    <th width="25%">Nama Lokasi / Sekolah</th>
                    <th width="15%">Kategori</th>
                    <th width="25%">Menu Masakan</th>
                    <th width="15%">Jumlah Porsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distribusi as $index => $d)
                <tr>
                    <td class="tengah">{{ $index + 1 }}</td>
                    <td class="tengah">{{ \Carbon\Carbon::parse($d->waktu_kirim)->format('d/m/Y') }}</td>
                    <td>{{ $d->sekolah->nama_sekolah ?? '-' }}</td>
                    <td class="tengah">{{ $d->sekolah->kategori_penerima ?? 'Sekolah' }}</td>
                    <td>{{ $d->menu->nama_menu ?? '-' }}</td>
                    <td class="tengah"><strong>{{ number_format($d->jumlah_porsi, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr><td colspan="6" class="tengah" style="font-style: italic;">Tidak ada data distribusi pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-sig">
            <div class="sig-box">
                <p>Mengetahui/Menyetujui,<br><strong>Kepala Dinas Terkait</strong></p>
                <div class="sig-space"></div>
                <p><strong>( ________________________ )</strong><br>NIP. .....................................</p>
            </div>
            <div class="sig-box">
                <p>Pasaman, {{ date('d F Y') }}<br><strong>Penanggung Jawab Distribusi</strong></p>
                <div class="sig-space"></div>
                <p><strong>( {{ Auth::user()->name }} )</strong><br>NIP. .....................................</p>
            </div>
        </div>

    </div>
</body>
</html>