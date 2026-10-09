<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Menu;
use App\Models\MenuDetail;
use App\Models\StokBahan;
use App\Models\Bahan;
use App\Models\MasterMenu;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::with('detail.bahan')->orderBy('tanggal_menu', 'desc')->get();
        return view('menu.index', compact('menu'));
    }

    public function create()
    {
        $masterMenus = MasterMenu::all();
        return view('menu.create', compact('masterMenus'));
    }

    // FUNGSI AJAX UNTUK CEK STOK
    public function checkStock(Request $request)
    {
        $request->validate([
            'master_menu_id' => 'required|exists:master_menus,id',
            'jumlah_porsi' => 'required|integer|min:1'
        ]);

        $masterMenu = MasterMenu::with('reseps.bahan')->find($request->master_menu_id);
        $porsi = $request->jumlah_porsi;
        
        $hasilCheck = [];
        $bisaDibuat = true;

        foreach ($masterMenu->reseps as $resep) {
            $kebutuhan = $resep->takaran * $porsi;
            
            $stokTersedia = StokBahan::where('bahan_id', $resep->bahan_id)
                ->where('jumlah', '>', 0)
                ->whereDate('tanggal_kadaluarsa', '>=', now()->toDateString())
                ->sum('jumlah');

            // TAMBAHKAN (float) DI DEPAN VARIABEL UNTUK MEMBERSIHKAN ANGKA NOL
            $stokTersedia = (float)$stokTersedia;
            $kebutuhan = (float)$kebutuhan;

            $cukup = $stokTersedia >= $kebutuhan;
            
            if (!$cukup) {
                $bisaDibuat = false;
            }

            $hasilCheck[] = [
                'nama_bahan' => $resep->bahan->nama_bahan,
                'satuan' => $resep->bahan->satuan,
                'kebutuhan' => $kebutuhan,
                'tersedia' => $stokTersedia,
                'status_icon' => $cukup ? '✅ Cukup' : '❌ Kurang',
                'cukup' => $cukup
            ];
        }

        return response()->json([
            'bisa_dibuat' => $bisaDibuat,
            'detail' => $hasilCheck
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_menu' => 'required|date',
            'master_menu_id' => 'required|exists:master_menus,id',
            'jumlah_porsi' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto menu
        ]);

        try {
            // Upload foto DILUAR transaction agar file tersimpan
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('menu_foto', 'public');
            }

            DB::transaction(function () use ($request, $fotoPath) {
                $masterMenu = MasterMenu::findOrFail($request->master_menu_id);
                $reseps = Resep::where('master_menu_id', $masterMenu->id)->get();

                if ($reseps->isEmpty()) {
                    throw new Exception("Menu {$masterMenu->nama_menu} belum memiliki resep bahan.");
                }

                // 1. Validasi Stok Backend (Keamanan Ganda)
                foreach ($reseps as $resep) {
                    $kebutuhanTotal = $resep->takaran * $request->jumlah_porsi;
                    
                    $totalStok = StokBahan::where('bahan_id', $resep->bahan_id)
                        ->where('jumlah', '>', 0) 
                        ->whereDate('tanggal_kadaluarsa', '>=', now()->toDateString()) 
                        ->sum('jumlah');

                    if ($totalStok < $kebutuhanTotal) {
                        $bahan = Bahan::find($resep->bahan_id);
                        throw new Exception("Stok {$bahan->nama_bahan} kurang! Butuh {$kebutuhanTotal} {$bahan->satuan}, Sisa: {$totalStok} {$bahan->satuan}.");
                    }
                }

                // 2. Simpan Riwayat Menu
                $menu = Menu::create([
                    'tanggal_menu' => $request->tanggal_menu,
                    'nama_menu' => $masterMenu->nama_menu . ' (' . $request->jumlah_porsi . ' Porsi)',
                    'foto' => $fotoPath, // <--- Simpan path fotonya
                ]);

                // 3. Eksekusi FEFO
                foreach ($reseps as $resep) {
                    $kebutuhanTotal = $resep->takaran * $request->jumlah_porsi;

                    MenuDetail::create([
                        'menu_id' => $menu->id,
                        'bahan_id' => $resep->bahan_id,
                        'jumlah_digunakan' => $kebutuhanTotal,
                    ]);

                    $stokList = StokBahan::where('bahan_id', $resep->bahan_id)
                        ->where('jumlah', '>', 0) 
                        ->whereDate('tanggal_kadaluarsa', '>=', now()->toDateString())
                        ->orderBy('tanggal_kadaluarsa', 'asc') 
                        ->lockForUpdate() 
                        ->get();

                    $sisaKebutuhan = $kebutuhanTotal;

                    foreach ($stokList as $stok) {
                        if ($sisaKebutuhan <= 0) break; 

                        if ($stok->jumlah >= $sisaKebutuhan) {
                            $stok->jumlah -= $sisaKebutuhan;
                            $stok->save();
                            $sisaKebutuhan = 0;
                        } else {
                            $sisaKebutuhan -= $stok->jumlah;
                            $stok->jumlah = 0;
                            $stok->save();
                        }
                    }
                }
            });

            return redirect()->route('menu.index')
                ->with('success', 'Menu berhasil diproses! Stok bahan resep berkurang secara FEFO.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput(); 
        }
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'tanggal_menu' => 'required|date',
            'nama_menu' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = ['tanggal_menu' => $request->tanggal_menu, 'nama_menu' => $request->nama_menu];

        if ($request->hasFile('foto')) {
            if ($menu->foto) Storage::disk('public')->delete($menu->foto);
            $data['foto'] = $request->file('foto')->store('menu_foto', 'public');
        }

        $menu->update($data);
        return redirect()->route('menu.index')->with('success', 'Menu diperbarui');
    }

    // ... DI DALAM METHOD destroy() ...
    public function destroy(Menu $menu)
    {
        DB::transaction(function () use ($menu) {
            $menu->detail()->delete();
            // Hapus foto dari server jika ada
            if ($menu->foto) Storage::disk('public')->delete($menu->foto);
            $menu->delete();
        });
        return redirect()->route('menu.index')->with('success', 'Menu dihapus');
    }

    public function laporStok(Request $request)
    {
        // 1. Tangkap data yang dikirim oleh AJAX (JavaScript) dari halaman Chef
        $namaMenu = $request->menu;
        $bahanKurang = $request->bahan_kurang;

        // 2. Rangkai pesan notifikasinya agar informatif untuk Admin
        $pesanLengkap = "🚨 Kritis! Chef ingin menjadwalkan menu '{$namaMenu}', tetapi bahan baku berikut tidak mencukupi di gudang: {$bahanKurang}. Mohon segera lakukan pengecekan dan restock.";

        // 3. Simpan pesan tersebut ke dalam database tabel notifikasis
        Notifikasi::create([
            'pesan' => $pesanLengkap,
            'is_read' => false // false artinya notifikasi belum dibaca
        ]);

        // 4. Beri respon kembali ke AJAX bahwa penyimpanan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Notifikasi berhasil terkirim ke Admin'
        ]);
    }

    public function tandaiDibaca()
    {
        // Ubah semua notifikasi yang belum dibaca menjadi sudah dibaca
        \App\Models\Notifikasi::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua laporan Chef telah ditandai sebagai dibaca.');
    }
}