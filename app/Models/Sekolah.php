<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = ['nama_sekolah', 'kategori_penerima', 'alamat', 'jumlah_siswa'];

    public function distribusis() {
        return $this->hasMany(Distribusi::class);
    }
}
