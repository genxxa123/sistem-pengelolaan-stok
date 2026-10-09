<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangRusak extends Model
{
    protected $table = 'barang_rusak';
    protected $guarded = [];

    // Relasi kembali ke stok bahan
    public function stokBahan()
    {
        return $this->belongsTo(StokBahan::class, 'stok_bahan_id');
    }
}