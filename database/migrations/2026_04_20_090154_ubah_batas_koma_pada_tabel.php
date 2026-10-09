<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Melebarkan kapasitas koma menjadi 4 angka di belakang koma
        Schema::table('reseps', function (Blueprint $table) {
            $table->decimal('takaran', 10, 4)->change();
        });

        Schema::table('stok_bahan', function (Blueprint $table) {
            $table->decimal('jumlah', 15, 4)->change();
            $table->decimal('jumlah_awal', 15, 4)->change();
        });

        Schema::table('menu_detail', function (Blueprint $table) {
            $table->decimal('jumlah_digunakan', 15, 4)->change();
        });
    }

    public function down(): void
    {
        // Kosongkan saja untuk amannya
    }
};