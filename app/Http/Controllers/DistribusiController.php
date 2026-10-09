<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    public function index() {
    $distribusi = \App\Models\Distribusi::with(['menu', 'sekolah'])->orderBy('waktu_kirim', 'desc')->get();
    return view('distribusi.index', compact('distribusi'));
    }

    public function create() {
        $menus = \App\Models\Menu::orderBy('tanggal_menu', 'desc')->take(10)->get();
        $sekolahs = \App\Models\Sekolah::all();
        return view('distribusi.create', compact('menus', 'sekolahs'));
    }

    public function store(Request $request) {
        $request->validate([
            'menu_id' => 'required',
            'sekolah_id' => 'required',
            'jumlah_porsi' => 'required|integer',
            'waktu_kirim' => 'required'
        ]);

        \App\Models\Distribusi::create($request->all());
        return redirect()->route('distribusi.index')->with('success', 'Pengiriman sedang diproses!');
    }

    public function edit($id) {
        $distribusi = \App\Models\Distribusi::findOrFail($id);
        $menus = \App\Models\Menu::orderBy('tanggal_menu', 'desc')->take(10)->get();
        $sekolahs = \App\Models\Sekolah::all();
        return view('distribusi.edit', compact('distribusi', 'menus', 'sekolahs'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'menu_id' => 'required',
            'sekolah_id' => 'required',
            'jumlah_porsi' => 'required|integer',
            'waktu_kirim' => 'required'
        ]);

        \App\Models\Distribusi::findOrFail($id)->update($request->all());
        return redirect()->route('distribusi.index')->with('success', 'Data Pengiriman berhasil diperbarui!');
    }

    public function destroy($id) {
        \App\Models\Distribusi::findOrFail($id)->delete();
        return back()->with('success', 'Data Pengiriman berhasil dibatalkan/dihapus.');
    }
}
