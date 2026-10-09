<?php

namespace App\Http\Controllers;

use App\Models\StokBahan;
use App\Models\Menu;
use App\Models\MenuDetail;
use App\Models\Distribusi;
use App\Models\BarangRusak;
use App\Models\Bahan; // Tambahkan ini agar model Bahan bisa dipanggil
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan Default Periode & Filter Kategori
        $defaultAwal = Carbon::now()->startOfMonth()->format('Y-m-d');
        $defaultAkhir = Carbon::now()->endOfMonth()->format('Y-m-d');

        $tglAwalInput = $request->input('tanggal_awal', $defaultAwal);
        $tglAkhirInput = $request->input('tanggal_akhir', $defaultAkhir);
        $kategoriInput = $request->input('kategori'); // Tangkap input kategori

        // Ambil daftar kategori unik untuk dropdown
        $daftarKategori = Bahan::whereNotNull('kategori')->distinct()->pluck('kategori');

        $awalPeriode = Carbon::parse($tglAwalInput)->startOfDay();
        $akhirPeriode = Carbon::parse($tglAkhirInput)->endOfDay();

        // 3. DATA BELANJA (INBOUND)
        $queryMasuk = StokBahan::with('bahan')->whereBetween('tanggal_masuk', [$awalPeriode, $akhirPeriode]);
        if ($kategoriInput) { // JIKA FILTER KATEGORI DIPILIH
            $queryMasuk->whereHas('bahan', function($q) use ($kategoriInput) {
                $q->where('kategori', $kategoriInput);
            });
        }
        $laporanMasuk = $queryMasuk->get();
        $totalBelanja = $laporanMasuk->sum('harga');

        // 4. DATA PEMAKAIAN DAPUR
        $detailMenus = Menu::whereBetween('tanggal_menu', [$awalPeriode, $akhirPeriode])->orderBy('tanggal_menu', 'asc')->get();
        $menuIds = $detailMenus->pluck('id');
        
        $queryPemakaian = MenuDetail::with('bahan')->whereIn('menu_id', $menuIds);
        if ($kategoriInput) { // JIKA FILTER KATEGORI DIPILIH
            $queryPemakaian->whereHas('bahan', function($q) use ($kategoriInput) {
                $q->where('kategori', $kategoriInput);
            });
        }
        $pemakaianDapur = $queryPemakaian->get()->groupBy('bahan_id');

        $totalProduksiPorsi = 0;
        foreach($detailMenus as $m) {
            preg_match('/\d+/', $m->nama_menu, $matches);
            $totalProduksiPorsi += isset($matches[0]) ? (int)$matches[0] : 0;
        }

        // 5. DATA BARANG RUSAK (WASTE)
        $queryRusak = BarangRusak::with('stokBahan.bahan')->whereBetween('tanggal_lapor', [$awalPeriode, $akhirPeriode]);
        if ($kategoriInput) { // JIKA FILTER KATEGORI DIPILIH
            $queryRusak->whereHas('stokBahan.bahan', function($q) use ($kategoriInput) {
                $q->where('kategori', $kategoriInput);
            });
        }
        $laporanRusak = $queryRusak->get();
            
        $totalKerugian = 0;
        foreach($laporanRusak as $r) {
            if($r->stokBahan && $r->stokBahan->jumlah_awal > 0) {
                $hargaPerSatuan = $r->stokBahan->harga / $r->stokBahan->jumlah_awal;
                $totalKerugian += ($r->jumlah_rusak * $hargaPerSatuan);
            }
        }

        // 6. DATA DISTRIBUSI SEKOLAH
        $totalTersalurkan = Distribusi::whereBetween('waktu_kirim', [$awalPeriode, $akhirPeriode])->sum('jumlah_porsi');
        $persentaseDistribusi = $totalProduksiPorsi > 0 ? ($totalTersalurkan / $totalProduksiPorsi) * 100 : 0;

        // 7. DATA SISA STOK TERKINI (ASET GUDANG) 
        $querySisa = StokBahan::with('bahan')->where('jumlah', '>', 0);
        if ($kategoriInput) { // JIKA FILTER KATEGORI DIPILIH
            $querySisa->whereHas('bahan', function($q) use ($kategoriInput) {
                $q->where('kategori', $kategoriInput);
            });
        }
        $sisaStokMentah = $querySisa->get()->groupBy('bahan_id');
        
        $rekapSisaStok = [];
        $totalNilaiAset = 0;
        
        foreach ($sisaStokMentah as $bahanId => $stokList) {
            $bahan = $stokList->first()->bahan;
            $totalJumlah = $stokList->sum('jumlah');
            
            $nilaiItem = 0;
            foreach($stokList as $s) {
                if($s->jumlah_awal > 0) {
                   $hargaSatuan = $s->harga / $s->jumlah_awal;
                   $nilaiItem += ($s->jumlah * $hargaSatuan);
                }
            }
            
            $rekapSisaStok[] = (object)[
                'nama_bahan' => $bahan->nama_bahan,
                'satuan' => $bahan->satuan,
                'total_jumlah' => $totalJumlah,
                'estimasi_nilai' => $nilaiItem
            ];
            
            $totalNilaiAset += $nilaiItem;
        }

        $nomorLaporan = "SPPG/" . date('Y') . "/LOG/" . $awalPeriode->format('m/d');

        return view('laporan.index', compact(
            'laporanMasuk', 'totalBelanja', 
            'pemakaianDapur', 'totalProduksiPorsi', 'detailMenus',
            'totalTersalurkan', 'persentaseDistribusi',
            'laporanRusak', 'totalKerugian',
            'rekapSisaStok', 'totalNilaiAset',
            'awalPeriode', 'akhirPeriode', 'nomorLaporan',
            'tglAwalInput', 'tglAkhirInput', 'kategoriInput', 'daftarKategori' // <-- Pastikan variabel ini dikirim ke view
        ));
    }

    public function distribusi(Request $request)
    {
        $awalPeriode = $request->tanggal_awal ? \Carbon\Carbon::parse($request->tanggal_awal) : \Carbon\Carbon::now()->startOfMonth();
        $akhirPeriode = $request->tanggal_akhir ? \Carbon\Carbon::parse($request->tanggal_akhir) : \Carbon\Carbon::now()->endOfMonth();

        // Ambil data distribusi yang statusnya 'Sampai' atau 'Dikirim' (bukan Batal)
        $distribusi = \App\Models\Distribusi::with(['sekolah', 'menu'])
            ->whereDate('waktu_kirim', '>=', $awalPeriode->format('Y-m-d'))
            ->whereDate('waktu_kirim', '<=', $akhirPeriode->format('Y-m-d'))
            ->where('status', '!=', 'Batal')
            ->orderBy('waktu_kirim', 'asc')
            ->get();

        // Hitung rekapitulasi per Kategori Penerima
        $rekapKategori = [
            'Sekolah' => 0,
            'Balita' => 0,
            'Bumil' => 0,
            'Busui' => 0
        ];

        foreach ($distribusi as $d) {
            $kat = $d->sekolah->kategori_penerima ?? 'Sekolah';
            if (isset($rekapKategori[$kat])) {
                $rekapKategori[$kat] += $d->jumlah_porsi;
            }
        }

        $totalTersalurkan = array_sum($rekapKategori);

        return view('laporan.distribusi', compact('awalPeriode', 'akhirPeriode', 'distribusi', 'rekapKategori', 'totalTersalurkan'));
    }
}