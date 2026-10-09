<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    protected $fillable = ['menu_id', 'sekolah_id', 'jumlah_porsi', 'waktu_kirim', 'status', 'penerima'];

    public function menu() {
        return $this->belongsTo(Menu::class);
    }

    public function sekolah() {
        return $this->belongsTo(Sekolah::class);
    }
}
