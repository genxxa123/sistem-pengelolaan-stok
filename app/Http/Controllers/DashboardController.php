<?php

namespace App\Http\Controllers;

use App\Models\StokBahan;
use App\Models\Bahan;
use App\Models\Menu;
use App\Models\MasterMenu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();
        $role = Auth::user()->role;

        // Data dasar stok untuk Admin (FEFO)
        $stokFefo = StokBahan::with('bahan')
            ->where('jumlah', '>', 0)
            ->orderBy('tanggal_kadaluarsa', 'asc')
            ->get();

        if ($role === 'admin') {
            // Dashboard Lengkap untuk Admin
            return view('dashboard.index', compact('stokFefo'));
            
        } else {
            // Dashboard Ringkas untuk Chef
            // 1. Ambil menu yang dijadwalkan hari ini
            $menuHariIni = Menu::whereDate('tanggal_menu', $hariIni)->get();
            
            // 2. HITUNG TOTAL MASTER RESEP (Ini yang tadi kurang)
            $totalResep = MasterMenu::count();
            
            // 3. Kirim semua variabel ke view chef
            return view('dashboard.chef', compact('menuHariIni', 'hariIni', 'totalResep'));
        }
    }
}