<?php

namespace App\Http\Controllers;

use App\Models\MasterMenu;
use App\Models\Resep;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MasterMenuController extends Controller
{
    // Menampilkan halaman index master menu (opsional)
    public function index()
    {
        $masterMenus = MasterMenu::with('reseps.bahan')->get();
        return view('master_menu.index', compact('masterMenus'));
    }

    // Menampilkan Form Tambah Master Menu & Resep
    public function create()
    {
        $bahans = Bahan::all();
        return view('master_menu.create', compact('bahans'));
    }

    // Menyimpan Data Master Menu dan Bahan-bahannya
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'bahan_id' => 'required|array',
            'bahan_id.*' => 'required|exists:bahan,id',
            'takaran' => 'required|array',
            'takaran.*' => 'required|numeric|min:0.0001',
        ], [
            'bahan_id.required' => 'Minimal harus ada 1 bahan yang dipilih.',
            'takaran.*.min' => 'Takaran bahan tidak boleh 0 atau minus.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Simpan Nama Menu ke tabel master_menus
                $masterMenu = MasterMenu::create([
                    'nama_menu' => $request->nama_menu,
                ]);

                // 2. Looping data array dari input form dinamis dan simpan ke tabel reseps
                foreach ($request->bahan_id as $index => $bahanId) {
                    Resep::create([
                        'master_menu_id' => $masterMenu->id,
                        'bahan_id' => $bahanId,
                        'takaran' => $request->takaran[$index],
                    ]);
                }
            });

            return redirect()->route('menu.create') // Arahkan kembali ke pembuatan menu harian
                ->with('success', 'Master Menu dan Resep berhasil ditambahkan!');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan menu: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Menghapus Master Menu
    public function destroy(MasterMenu $masterMenu)
    {
        DB::transaction(function () use ($masterMenu) {
            // Karena di migration kita menggunakan cascadeOnDelete, 
            // menghapus master menu otomatis menghapus detail resepnya juga.
            $masterMenu->delete();
        });

        return redirect()->route('master_menu.index')
            ->with('success', 'Master menu berhasil dihapus.');
    }
}