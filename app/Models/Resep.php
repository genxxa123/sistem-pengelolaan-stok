<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model {
    protected $guarded = [];
    public function bahan() { return $this->belongsTo(Bahan::class); }
    public function masterMenu() { return $this->belongsTo(MasterMenu::class); }

    // TAMBAHKAN BLOK KODE INI
    protected $casts = [
        'takaran' => 'float',
    ];
}