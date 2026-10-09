<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'pesan',
        'detail_bahan',
        'is_read'
    ];

    protected $casts = [
        'detail_bahan' => 'array',
        'is_read' => 'boolean',
    ];
}