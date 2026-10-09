<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index() {
    $sekolah = \App\Models\Sekolah::all();
    return view('sekolah.index', compact('sekolah'));
    }

    public function store(Request $request) {
        $request->validate(['nama_sekolah' => 'required', 'kategori_penerima' => 'required', 'alamat' => 'required', 'jumlah_siswa' => 'required|integer']);
        \App\Models\Sekolah::create($request->all());
        return back()->with('success', 'Sekolah berhasil didaftarkan.');
    }

    public function edit($id) {
        $sekolah = \App\Models\Sekolah::findOrFail($id);
        return view('sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_sekolah' => 'required', 
            'kategori_penerima' => 'required',
            'alamat' => 'required', 
            'jumlah_siswa' => 'required|integer'
        ]);
        \App\Models\Sekolah::findOrFail($id)->update($request->all());
        return redirect()->route('sekolah.index')->with('success', 'Data Sekolah berhasil diperbarui.');
    }

    public function destroy($id) {
        \App\Models\Sekolah::findOrFail($id)->delete();
        return back()->with('success', 'Data Sekolah berhasil dihapus.');
    }
}
