<?php

namespace App\Http\Controllers;

use App\Models\BarangRusak;
use App\Models\StokBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangRusakController extends Controller
{
    public function index()
    {
        $barangRusak = BarangRusak::with('stokBahan.bahan')->orderBy('tanggal_lapor', 'desc')->get();
        return view('barang_rusak.index', compact('barangRusak'));
    }

    public function create()
    {
        // Hanya tampilkan stok yang jumlahnya masih lebih dari 0
        $stokTersedia = StokBahan::with('bahan')->where('jumlah', '>', 0)->orderBy('tanggal_kadaluarsa', 'asc')->get();
        return view('barang_rusak.create', compact('stokTersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_bahan_id' => 'required',
            'tanggal_lapor' => 'required|date',
            'jumlah_rusak' => 'required|numeric|min:0.1',
            'keterangan' => 'required|string|max:255'
        ]);

        $stok = StokBahan::findOrFail($request->stok_bahan_id);

        // Validasi: Tidak boleh membuang lebih dari stok yang ada
        if ($request->jumlah_rusak > $stok->jumlah) {
            return back()->with('error', 'Gagal! Jumlah rusak ('.$request->jumlah_rusak.') melebihi sisa stok yang ada ('.$stok->jumlah.').')->withInput();
        }

        DB::transaction(function() use ($request, $stok) {
            // 1. Catat riwayat kerusakan
            BarangRusak::create($request->all());
            
            // 2. Kurangi fisik stok di gudang
            $stok->jumlah -= $request->jumlah_rusak;
            $stok->save();
        });

        return redirect()->route('barang_rusak.index')
            ->with('success', 'Laporan barang rusak berhasil dicatat dan stok gudang telah dikurangi.');
    }

    public function destroy($id) {
    $item = \App\Models\BarangRusak::findOrFail($id);
    $stok = \App\Models\StokBahan::find($item->stok_bahan_id);

    if ($stok) {
        // Kembalikan jumlah stok yang tadinya dianggap rusak
        $stok->increment('jumlah', $item->jumlah_rusak);
    }

    $item->delete();
    return back()->with('success', 'Data barang rusak dihapus dan stok telah dikembalikan.');
}
}