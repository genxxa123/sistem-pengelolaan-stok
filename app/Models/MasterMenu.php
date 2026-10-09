<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterMenu extends Model {
    protected $guarded = [];
    public function reseps() { return $this->hasMany(Resep::class); }
}