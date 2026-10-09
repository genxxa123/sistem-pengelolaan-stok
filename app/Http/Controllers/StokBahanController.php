<?php

namespace App\Http\Controllers;

use App\Models\StokBahan;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StokBahanController extends Controller
{
    public function index()
    {
        $stok = StokBahan::with('bahan')
            ->orderBy('tanggal_kadaluarsa', 'asc')
            ->get();

        return view('stok.index', compact('stok'));
    }

    public function create()
    {
        $bahan = Bahan::all();
        return view('stok.create', compact('bahan'));
    }

    public function edit(StokBahan $stok)
    {
        $bahan = Bahan::all();
        return view('stok.edit', compact('stok', 'bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date',
            'jumlah' => 'required|numeric|min:0.1',
            'harga_satuan' => 'required|numeric|min:0', // <-- Ganti 'harga' menjadi 'harga_satuan'
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        $data['jumlah_awal'] = $request->jumlah; // Simpan jumlah awal saat pertama kali masuk
        // HITUNG TOTAL HARGA OTOMATIS: Jumlah x Harga Satuan
        $data['harga'] = $request->jumlah * $request->harga_satuan; 

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('stok_foto', 'public');
        }

        StokBahan::create($data);

        return redirect()->route('stok.index')->with('success', 'Stok bahan berhasil ditambahkan');
    }

    public function update(Request $request, StokBahan $stok)
    {
        $request->validate([
            'bahan_id' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'harga_satuan' => 'required|numeric|min:0', // <-- Ganti 'harga' menjadi 'harga_satuan'
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Pastikan hanya mengambil data yang diperlukan, JANGAN ambil 'harga_satuan' ke database
        $data = $request->only(['bahan_id', 'tanggal_masuk', 'tanggal_kadaluarsa', 'jumlah']);
        
        $data['jumlah_awal'] = $request->jumlah; // Update jumlah awal jika jumlah diubah
        // HITUNG TOTAL HARGA OTOMATIS: Jumlah x Harga Satuan
        $data['harga'] = $request->jumlah * $request->harga_satuan;

        if ($request->hasFile('foto')) {
            if ($stok->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($stok->foto);
            }
            $data['foto'] = $request->file('foto')->store('stok_foto', 'public');
        }

        $stok->update($data);

        return redirect()->route('stok.index')->with('success', 'Stok bahan berhasil diperbarui');
    }

    public function destroy(StokBahan $stok)
    {
        // LOGIKA KEAMANAN: Cek apakah bahan sudah dipakai masak
        // Jika jumlah saat ini lebih kecil dari jumlah awal, berarti sudah dipakai dapur
        if ($stok->jumlah < $stok->jumlah_awal) {
            return redirect()->route('stok.index')->with('error', 'Gagal! Data stok tidak bisa dihapus karena bahan tersebut sudah sebagian digunakan oleh dapur.');
        }

        // Hapus file foto jika ada di penyimpanan
        if ($stok->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($stok->foto);
        }

        $stok->delete();

        return redirect()->route('stok.index')->with('success', 'Stok bahan masuk berhasil dihapus.');
    }
}
