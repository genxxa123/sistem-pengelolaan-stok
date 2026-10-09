<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Menu Harian - Dashboard MBG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), 
                        url("{{ asset('img/porsi.jpg') }}") no-repeat center center fixed; 
            background-size: cover; min-height: 100vh; color: #1e293b; 
        }

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
        input:focus, select:focus { outline: none; border-color: #0284c7; box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1); }
        
        .btn-cek { background: #f59e0b; color: white; width: 100%; padding: 16px; border: none; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); transition: all 0.3s; margin-bottom: 20px; text-transform: uppercase; }
        .btn-cek:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4); }

        .table-preview { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 13px; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .table-preview th { background: #f8fafc; padding: 12px 15px; text-align: left; color: #475569; font-weight: 700; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
        .table-preview td { padding: 12px 15px; border-bottom: 1px solid #f1f5f9; color: #334155; font-weight: 600; }

        .button-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn-simpan { background: linear-gradient(135deg, #0284c7, #0369a1); color: white; flex: 1; border: none; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; transition: all 0.3s; text-transform: uppercase; }
        .btn-simpan:hover:not([disabled]) { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(2, 132, 199, 0.4); }
        .btn-cancel { background: #e2e8f0; color: #475569; padding: 16px; border-radius: 12px; font-weight: 700; text-decoration: none; text-align: center; width: 150px; transition: all 0.3s; }
        .btn-cancel:hover { background: #cbd5e1; }

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
                <a href="{{ route('menu.index') }}" style="background: rgba(0,0,0,0.06);">🍽️ Menu Harian</a>
                <a href="{{ route('sekolah.index') }}">🏫 Target Penerima</a>
                <a href="{{ route('distribusi.index') }}">🚚 Distribusi</a>
            @elseif(Auth::user()->role === 'chef')
                <a href="{{ route('master_menu.index') }}">🍳 Master Menu</a>
                <a href="{{ route('menu.index') }}" style="background: rgba(0,0,0,0.06);">🍽️ Menu Harian</a>
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
            <h2 data-aos="fade-down">🍽️ Buat Menu Harian</h2>
            <p data-aos="fade-down" data-aos-delay="100">Kalkulasi porsi dan otomatisasi potong stok gudang hari ini.</p>

            @if(session('error'))
                <div class="error-message" data-aos="zoom-in"><strong>⚠️ Kesalahan:</strong> {{ session('error') }}</div>
            @endif

            <form action="{{ route('menu.store') }}" method="POST" id="formMenu" enctype="multipart/form-data">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                        <label>Tanggal Pelaksanaan Menu</label>
                        <input type="date" name="tanggal_menu" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                        <label>Jumlah Porsi Dimasak</label>
                        <input type="number" name="jumlah_porsi" id="jumlah_porsi" min="1" required placeholder="Contoh: 3000">
                    </div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                    <label>Pilih Master Template Resep</label>
                    <select name="master_menu_id" id="master_menu_id" required>
                        <option value="">-- Pilih Menu Dasar --</option>
                        @foreach($masterMenus as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_menu }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                    <label>Foto Dokumentasi (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" style="padding: 10px;">
                </div>

                <button type="button" class="btn-cek" id="btnCek" data-aos="zoom-in" data-aos-delay="600">🔍 Cek Ketersediaan Stok Fisik</button>

                <div id="areaPreview" style="display: none; background: rgba(241, 245, 249, 0.8); padding: 20px; border-radius: 16px; margin-bottom: 20px; border: 1px dashed #cbd5e1;">
                    <h4 style="margin-bottom: 10px; color: #0f172a;">Hasil Kalkulasi Kebutuhan Bahan:</h4>
                    <table class="table-preview">
                        <thead>
                            <tr>
                                <th>Bahan</th>
                                <th>Dibutuhkan</th>
                                <th>Tersedia</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelPreviewBahan">
                            </tbody>
                    </table>
                    <div id="pesanError" style="display: none; color: #dc2626; font-weight: bold; margin-top: 15px; text-align: center; font-size: 13px;">
                        ⚠️ Tidak bisa menyimpan! Ada bahan yang stoknya kurang. Silakan tambah stok terlebih dahulu.<br><br>
                        <button type="button" id="btnLaporAdmin" style="background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 800; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);">
                            🚨 Lapor Admin (Minta Restock)
                        </button>
                    </div>
                </div>

                <div class="button-group" data-aos="fade-up" data-aos-delay="700">
                    <button type="submit" class="btn-simpan" id="btnSimpan" disabled style="opacity: 0.5; cursor: not-allowed;">💾 Proses & Potong Stok Gudang</button>
                    <a href="{{ route('menu.index') }}" class="btn-cancel">Batalkan</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 30, duration: 800 });

        // FUNGSI JAVASCRIPT ASLI - DIPERTAHANKAN 100% UNTUK PENGECEKAN STOK
        document.getElementById('btnCek').addEventListener('click', function() {
            let menuId = document.getElementById('master_menu_id').value;
            let porsi = document.getElementById('jumlah_porsi').value;

            if(!menuId || !porsi) return alert('Pilih master menu dan tentukan porsi terlebih dahulu!');

            this.innerHTML = '⏳ Mengecek Database...';
            
            fetch("{{ route('menu.checkStock') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ master_menu_id: menuId, jumlah_porsi: porsi })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('areaPreview').style.display = 'block';
                let tbody = document.getElementById('tabelPreviewBahan');
                tbody.innerHTML = '';
                
                let bahanKurang = []; // Array untuk menampung nama bahan yang kurang

                data.detail.forEach(item => {
                    let color = item.cukup ? '' : 'background: #ffe5e5; color: #b91c1c;';
                    
                    // Jika stok tidak cukup, masukkan ke daftar bahan kurang
                    if(!item.cukup) {
                        bahanKurang.push(item.nama_bahan);
                    }

                    tbody.innerHTML += `
                        <tr style="${color}">
                            <td>${item.nama_bahan}</td>
                            <td><b>${item.kebutuhan} ${item.satuan}</b></td>
                            <td>${item.tersedia} ${item.satuan}</td>
                            <td>${item.status_icon}</td>
                        </tr>
                    `;
                });

                let btnSimpan = document.getElementById('btnSimpan');
                if(data.bisa_dibuat) {
                    btnSimpan.disabled = false;
                    btnSimpan.style.opacity = '1';
                    btnSimpan.style.cursor = 'pointer';
                    document.getElementById('pesanError').style.display = 'none';
                } else {
                    btnSimpan.disabled = true;
                    btnSimpan.style.opacity = '0.5';
                    btnSimpan.style.cursor = 'not-allowed';
                    document.getElementById('pesanError').style.display = 'block';
                    
                    // Aksi untuk tombol Lapor Admin
                    let btnLapor = document.getElementById('btnLaporAdmin');
                    let namaMenu = document.getElementById('master_menu_id').options[document.getElementById('master_menu_id').selectedIndex].text;
                    
                    // Reset tampilan tombol lapor jika di-klik ulang
                    btnLapor.innerHTML = '🚨 Lapor Admin (Minta Restock)';
                    btnLapor.disabled = false;
                    btnLapor.style.background = '#ef4444';

                    btnLapor.onclick = function() {
                        this.innerHTML = '⏳ Mengirim Laporan...';
                        
                        fetch("{{ route('menu.laporStok') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ 
                                menu: namaMenu, 
                                bahan_kurang: bahanKurang.join(', ') // Menggabungkan array menjadi teks
                            })
                        })
                        .then(res => res.json())
                        .then(resData => {
                            this.innerHTML = '✅ Laporan Berhasil Terkirim!';
                            this.disabled = true;
                            this.style.background = '#10b981'; // Berubah hijau
                        });
                    }
                }
                this.innerHTML = '🔍 Cek Ulang Ketersediaan';
            });
        });
    </script>
</body>
</html>