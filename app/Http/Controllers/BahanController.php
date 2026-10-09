<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index()
    {
        $bahan = Bahan::all();
        return view('bahan.index', compact('bahan'));
    }

    public function create()
    {
        return view('bahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'satuan' => 'required',
            'kategori' => 'nullable|string', // Tambahan untuk kategori
        ]);

        Bahan::create($request->all());

        return redirect()->route('bahan.index')
            ->with('success', 'Data bahan berhasil ditambahkan');
    }
}