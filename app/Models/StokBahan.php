<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Bahan;

class StokBahan extends Model
{
    protected $table = 'stok_bahan';

    protected $fillable = [
        'bahan_id',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'jumlah_awal',
        'jumlah',
        'harga',
        'foto',
    ];

    protected $casts = [
        'jumlah' => 'float',
        'jumlah_awal' => 'float',
    ];

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }
}
