<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bahan extends Model
{
    protected $table = 'bahan';

    protected $fillable = [
        'nama_bahan',
        'satuan',
        'kategori',
    ];

    public function stokBahan(): HasMany
    {
        return $this->hasMany(StokBahan::class);
    }

    public function menuDetail(): HasMany
    {
        return $this->hasMany(MenuDetail::class);
    }
}
