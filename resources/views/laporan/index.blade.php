<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Resmi Pertanggungjawaban Logistik</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <style>
        /* === GAYA LAYAR / DASHBOARD === */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #e2e8f0; color: #1e293b; }
        
        /* Navbar Kaca (Tidak ikut tercetak) */
        .navbar { background: rgba(255, 255, 255, 0.95); padding: 12px 30px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 20px; position: sticky; top: 0; z-index: 100; border-bottom: 3px solid #F39C12; }
        .logo-section { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 40px; width: auto; object-fit: contain; }
        .navbar-spacer { flex: 1; }
        .navbar-menu { display: flex; gap: 8px; }
        .navbar-menu a { color: #1e293b; text-decoration: none; padding: 10px 18px; border-radius: 10px; transition: all 0.3s; font-size: 13px; font-weight: 700; }
        .navbar-menu a:hover { background: #f1f5f9; transform: translateY(-1px); }

        /* Filter Section (Tidak ikut tercetak) */
        .filter-section { background: #0f172a; color: white; padding: 20px 30px; border-radius: 16px; margin: 30px auto; max-width: 900px; display: flex; gap: 15px; justify-content: center; align-items: center; flex-wrap: wrap; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .filter-section label { font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .filter-section input, .filter-section select { padding: 10px 15px; border-radius: 8px; border: 1px solid #475569; background: #1e293b; color: white; font-family: inherit; font-weight: 600; outline: none; }
        .filter-section input:focus, .filter-section select:focus { border-color: #3b82f6; }
        .filter-btn { background: #f39c12; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; transition: 0.3s; }
        .filter-btn:hover { background: #d68910; }
        .print-btn { background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; transition: 0.3s; margin-top: 15px; }
        .print-btn:hover { background: #059669; }

        /* === GAYA KERTAS CETAK (A4) === */
        .document-wrapper { 
            width: 100%; 
            max-width: 800px; 
            margin: 20px auto 50px auto; 
            padding: 40px; 
            background: #fff; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            font-family: 'Times New Roman', Times, serif; 
            color: #000;
            line-height: 1.4;
        }

        /* Kop Surat Resmi */
        .kop-surat { display: flex; align-items: center; border-bottom: 4px solid #000; padding-bottom: 15px; margin-bottom: 3px; }
        .kop-surat::after { content: ''; display: block; border-bottom: 1px solid #000; position: relative; top: 18px; }
        .logo-kop { width: 90px; height: auto; margin-right: 20px; }
        .teks-kop { flex: 1; text-align: center; }
        .teks-kop h2 { font-size: 18px; text-transform: uppercase; margin: 0; font-weight: bold; }
        .teks-kop h1 { font-size: 22px; text-transform: uppercase; margin: 5px 0; font-weight: bold; }
        .teks-kop p { font-size: 12px; margin: 0; font-style: italic; }
        
        .garis-bawah-kop { border-top: 1px solid #000; margin-bottom: 25px; }

        .title-block { text-align: center; margin-bottom: 20px; }
        .title-block h3 { margin: 0; text-decoration: underline; text-transform: uppercase; font-size: 16px; }
        .title-block p { margin: 5px 0; font-size: 14px; }

        table.list-table { width: 100%; margin: 10px 0 20px 0; font-size: 13px; border: none; border-collapse: collapse; }
        table.list-table td { padding: 6px 8px; border: none; vertical-align: top; }

        h4 { margin: 25px 0 10px 0; font-size: 13px; text-transform: uppercase; border-left: 4px solid #000; padding-left: 8px; background: #f9f9f9; page-break-after: avoid; }
        
        table { page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        thead { display: table-header-group; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        table.data-table th { border: 1px solid #000; padding: 8px; background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; }
        table.data-table td { border: 1px solid #000; padding: 8px; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer-sig { margin-top: 50px; width: 100%; display: flex; justify-content: space-between; font-size: 13px; page-break-inside: avoid; }
        .sig-box { width: 250px; text-align: center; }
        .sig-space { height: 80px; }
        
        .no-print-btns { text-align: center; margin-top: 30px; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* === MEDIA PRINT === */
        @media print {
            @page { size: A4 portrait; margin: 1.5cm; }
            body { background: #fff; -webkit-print-color-adjust: exact; }
            .document-wrapper { box-shadow: none; margin: 0; padding: 0; width: 100%; max-width: 100%; }
            .no-print { display: none !important; }
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
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
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

    <div class="no-print filter-section">
        <div style="border-left: 2px solid #475569; height: 30px; margin: 0 10px;"></div>
        <a href="{{ route('laporan.distribusi') }}" class="btn-switch" style="background: #f59e0b; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; text-decoration: none; display: inline-block;">🚚 Ke Laporan Distribusi</a>
        <form action="{{ route('laporan.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; width: 100%; justify-content: center;">
            <label>Pilih Periode:</label>
            <input type="date" name="tanggal_awal" value="{{ $tglAwalInput }}" required>
            <span style="font-weight: 800;">s/d</span>
            <input type="date" name="tanggal_akhir" value="{{ $tglAkhirInput }}" required>
            
            <label style="margin-left: 10px;">Kategori:</label>
            <select name="kategori">
                <option value="">Semua Kategori</option>
                @foreach($daftarKategori as $kat)
                    <option value="{{ $kat }}" {{ $kategoriInput == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            <button type="submit" class="filter-btn">🔄 Tampilkan Data</button>
        </form>
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

        <div class="title-block">
            <h3>
                LAPORAN PERTANGGUNGJAWABAN LOGISTIK 
                @if(!empty($kategoriInput))
                    - KATEGORI {{ strtoupper($kategoriInput) }}
                @endif
            </h3>
            <p>Nomor: {{ $nomorLaporan }}</p>
        </div>

        <p style="font-size: 13px; text-align: justify; margin-bottom: 15px;">
            Berdasarkan hasil pemantauan sistem inventaris dan logistik pada periode <strong>{{ $awalPeriode->format('d F Y') }}</strong> s/d <strong>{{ $akhirPeriode->format('d F Y') }}</strong>, bersama ini dilaporkan ringkasan operasional sebagai berikut:
        </p>

        <table class="list-table">
            <tr>
                <td width="3%">1.</td>
                <td width="40%">Total Realisasi Belanja Masuk</td><td width="2%">:</td>
                <td width="55%"><strong>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Total Produksi Dapur</td><td>:</td>
                <td><strong>{{ number_format($totalProduksiPorsi, 0, ',', '.') }} Porsi</strong></td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Penyaluran ke Sekolah Target</td><td>:</td>
                <td><strong>{{ number_format($persentaseDistribusi, 1) }} % ({{ number_format($totalTersalurkan, 0, ',', '.') }} Porsi)</strong></td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Taksiran Nilai Penyusutan Gudang (Waste)</td><td>:</td>
                <td><strong style="color:#d63031;">Rp {{ number_format($totalKerugian, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Estimasi Total Nilai Aset Saat Ini (Sisa Gudang)</td><td>:</td>
                <td><strong style="color:#27ae60;">Rp {{ number_format($totalNilaiAset, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <h4>A. SISA STOK GUDANG TERKINI (ASET FAKTUAL)</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Bahan Baku</th>
                    <th width="25%">Jumlah Sisa</th>
                    <th width="30%">Estimasi Nilai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekapSisaStok as $index => $s)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $s->nama_bahan }}</td>
                    <td class="text-center">{{ rtrim(rtrim(number_format($s->total_jumlah, 2, ',', '.'), '0'), ',') }} {{ $s->satuan }}</td>
                    <td class="text-right">Rp {{ number_format($s->estimasi_nilai, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center" style="font-style: italic;">Gudang kosong (Tidak ada sisa stok).</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4>B. DATA PENERIMAAN / BELANJA LOGISTIK</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Bahan Baku</th>
                    <th width="25%">Kuantitas Dibeli</th>
                    <th width="25%">Nilai Beli</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporanMasuk as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $m->bahan->nama_bahan }}</td>
                    <td class="text-center">{{ rtrim(rtrim(number_format($m->jumlah_awal, 2, ',', '.'), '0'), ',') }} {{ $m->bahan->satuan }}</td>
                    <td class="text-right">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center" style="font-style: italic;">Nihil (Tidak ada belanja pada periode ini).</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4>C. LOG PRODUKSI MENU HARIAN (DAPUR)</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="30%">Hari & Tanggal</th>
                    <th>Nama Menu / Porsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailMenus as $dm)
                <tr>
                    <td class="text-center">
                        <strong>{{ \Carbon\Carbon::parse($dm->tanggal_menu)->isoFormat('dddd') }}</strong>, 
                        <br>{{ \Carbon\Carbon::parse($dm->tanggal_menu)->isoFormat('D MMMM Y') }}
                    </td>
                    <td>{{ $dm->nama_menu }}</td>
                </tr>
                @empty
                <tr><td colspan="2" class="text-center" style="font-style: italic;">Nihil (Dapur belum memproduksi menu pada periode ini).</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4>D. REKAPITULASI PEMAKAIAN BAHAN</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Bahan Baku</th>
                    <th width="35%">Total Diproses Dapur</th>
                </tr>
            </thead>
            <tbody>
                @php $noDapur = 1; @endphp
                @forelse($pemakaianDapur as $bahan_id => $details)
                <tr>
                    <td class="text-center">{{ $noDapur++ }}</td>
                    <td>{{ $details->first()->bahan->nama_bahan }}</td>
                    <td class="text-center">
                        {{ rtrim(rtrim(number_format($details->sum('jumlah_digunakan'), 2, ',', '.'), '0'), ',') }} {{ $details->first()->bahan->satuan }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center" style="font-style: italic;">Nihil.</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4>E. LAPORAN PENYUSUTAN (WASTE/RUSAK)</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th width="25%">Kuantitas</th>
                    <th>Keterangan / Alasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporanRusak as $r)
                <tr>
                    <td>{{ $r->stokBahan->bahan->nama_bahan }}</td>
                    <td class="text-center">{{ rtrim(rtrim(number_format($r->jumlah_rusak, 2, ',', '.'), '0'), ',') }} {{ $r->stokBahan->bahan->satuan }}</td>
                    <td>{{ $r->keterangan }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center" style="font-style: italic;">Nihil (Tidak ada kerusakan tercatat).</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-sig">
            <div class="sig-box">
                <p>Mengetahui/Menyetujui,<br><strong>Kepala Satuan Pelayanan</strong></p>
                <div class="sig-space"></div>
                <p><strong>( ________________________ )</strong><br>NIP. .....................................</p>
            </div>
            <div class="sig-box">
                <p>Pasaman, {{ date('d F Y') }}<br><strong>Pejabat Pembuat Laporan</strong></p>
                <div class="sig-space"></div>
                <p><strong>( {{ Auth::user()->name }} )</strong><br>NIP. .....................................</p>
            </div>
        </div>

        <div class="no-print no-print-btns">
            <button onclick="window.print()" class="print-btn" style="margin: 0 auto; display: inline-flex;">🖨️ CETAK DOKUMEN RESMI</button>
        </div>
        
    </div>
</body>
</html>