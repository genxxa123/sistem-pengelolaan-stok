<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'tanggal_menu',
        'nama_menu',
        'foto',
    ];

    public function detail(): HasMany
    {
        return $this->hasMany(MenuDetail::class);
    }
}
