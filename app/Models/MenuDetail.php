<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Menu;;
use App\Models\Bahan;

class MenuDetail extends Model
{
    protected $table = 'menu_detail';

    protected $fillable = [
        'menu_id',
        'bahan_id',
        'jumlah_digunakan',
    ];

    // TAMBAHKAN BLOK KODE INI
    protected $casts = [
        'jumlah_digunakan' => 'float',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }
}
