<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Resmi MBG - Makanan Bergizi Gratis</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.8)), 
                        url("{{ asset('img/mbg.jpg') }}") no-repeat center center fixed; 
            background-size: cover; 
            color: #f8fafc; 
            line-height: 1.6; 
            overflow-x: hidden; 
        }
        
        /* Navbar Kaca */
        .navbar { background: rgba(255, 255, 255, 0.1); padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; position: fixed; width: 100%; top: 0; z-index: 1000; backdrop-filter: blur(15px); border-bottom: 1px solid rgba(255,255,255,0.2); transition: all 0.3s; }
        .logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo img { height: 45px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
        .logo-text h1 { font-size: 22px; color: white; font-weight: 800; letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.5); margin: 0; }
        .logo-text p { font-size: 11px; color: #cbd5e1; font-weight: 600; margin: 0; letter-spacing: 0.5px; text-transform: uppercase; }
        
        .nav-links { display: flex; gap: 15px; align-items: center; }
        .btn-login { background: linear-gradient(135deg, #10b981, #059669); color: white; text-decoration: none; padding: 12px 28px; border-radius: 50px; font-weight: 800; font-size: 14px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4); text-transform: uppercase; letter-spacing: 1px; }
        .btn-login:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.6); }

        /* Hero Section Kaca */
        .hero { min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 120px 20px 80px; position: relative; }
        .hero-content { max-width: 900px; background: rgba(255, 255, 255, 0.1); padding: 50px; border-radius: 30px; backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .hero h2 { font-size: 42px; color: white; margin-bottom: 20px; font-weight: 800; line-height: 1.2; letter-spacing: -1px; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .hero h2 span { color: #f59e0b; }
        .hero p { font-size: 18px; color: #e2e8f0; margin-bottom: 35px; font-weight: 500; text-shadow: 0 1px 3px rgba(0,0,0,0.5); }
        
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 16px 40px; text-decoration: none; border-radius: 50px; font-weight: 800; font-size: 16px; transition: all 0.3s; display: inline-block; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
        .btn-primary:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.6); }

        /* Fitur Grid Kaca */
        .features-container { padding: 40px 5%; max-width: 1200px; margin: -80px auto 50px; position: relative; z-index: 10; }
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        
        .info-card { background: rgba(255, 255, 255, 0.95); padding: 40px 30px; border-radius: 24px; text-align: center; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.5); backdrop-filter: blur(10px); color: #1e293b; }
        .info-card:hover { transform: translateY(-15px); box-shadow: 0 20px 40px rgba(0,0,0,0.2); border-color: #3b82f6; }
        
        .info-icon { font-size: 50px; margin-bottom: 20px; display: inline-block; background: #f1f5f9; width: 90px; height: 90px; line-height: 90px; border-radius: 50%; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1)); }
        .info-card h4 { color: #0f172a; font-size: 20px; margin-bottom: 15px; font-weight: 800; }
        .info-card p { font-size: 14px; color: #475569; font-weight: 500; }

        footer { text-align: center; padding: 40px 20px; background: rgba(15, 23, 42, 0.9); border-top: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; backdrop-filter: blur(10px); }
        footer p { margin-bottom: 5px; font-size: 14px; }
        footer strong { color: white; font-size: 16px; }

        @media (max-width: 768px) {
            .hero h2 { font-size: 32px; }
            .hero-content { padding: 30px 20px; }
            .features-container { margin-top: -40px; }
        }
    </style>
</head>
<body>
    <nav class="navbar" data-aos="fade-down" data-aos-duration="800">
        <a href="#" class="logo">
            <img src="{{ asset('img/logo_sppg.png') }}" alt="Logo MBG">
            <div class="logo-text">
                <h1>MBG PASAMAN</h1>
                <p>Sistem Logistik & Distribusi Terpadu</p>
            </div>
        </a>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-login">Masuk Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">🔑 Login Sistem</a>
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content" data-aos="zoom-in" data-aos-duration="1000">
            <h2>Mewujudkan Generasi Emas Melalui<br><span>Gizi yang Merata & Transparan</span></h2>
            <p>Sistem Informasi Manajemen Logistik (SIMLOG) untuk program Makan Bergizi Gratis (MBG) terpusat di kawasan Lubuk Sikaping dan sekitarnya. Memastikan setiap porsi makanan disalurkan dengan akurasi stok, standarisasi nutrisi, dan pelaporan yang akuntabel.</p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Akses Dashboard Anda ➔</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Mulai Kelola Sistem ➔</a>
                @endauth
            @endif
        </div>
    </section>

    <div class="features-container">
        <div class="cards-grid">
            <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                <div class="info-icon">📦</div>
                <h4>Manajemen Stok Terpadu</h4>
                <p>Memantau ketersediaan bahan pangan secara <i>real-time</i> di gudang. Dilengkapi pelacakan usia bahan makanan menggunakan metode FEFO agar terhindar dari kadaluarsa.</p>
            </div>
            <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                <div class="info-icon">🍳</div>
                <h4>Standarisasi Resep Dapur</h4>
                <p>Ahli gizi merancang Master Menu terstandarisasi. Memastikan takaran kalori, protein, dan nutrisi sama rata untuk setiap anak yang menerima porsi makanan.</p>
            </div>
            <div class="info-card" data-aos="fade-up" data-aos-delay="600">
                <div class="info-icon">🚚</div>
                <h4>Distribusi & Laporan Cerdas</h4>
                <p>Otomatisasi pemotongan stok gudang saat dapur memproduksi menu harian. Riwayat distribusi tercatat akurat dan siap dicetak sebagai laporan pertanggungjawaban resmi.</p>
            </div>
        </div>
    </div>

    <footer>
        <p><strong>Sistem Manajemen Makan Bergizi Gratis (MBG)</strong></p>
        <p>Mendukung terwujudnya visi kesehatan anak bangsa melalui transparansi digital.</p>
        <p style="margin-top: 15px; font-size: 12px; color: #64748b;">© {{ date('Y') }} Hak Cipta Dilindungi.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50, duration: 800 });
        
        // Efek blur navbar saat di-scroll
        window.addEventListener('scroll', function() {
            var navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(15, 23, 42, 0.85)';
                navbar.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.1)';
                navbar.style.borderBottom = '1px solid rgba(255,255,255,0.2)';
            }
        });
    </script>
</body>
</html>