<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stok_bahan', function (Blueprint $table) {
            // Menyimpan modal kuantitas awal yang tidak akan pernah dipotong oleh Dapur
            $table->decimal('jumlah_awal', 15, 2)->default(0)->after('tanggal_kadaluarsa');
        });

        // Menyamakan jumlah awal dengan jumlah saat ini untuk data lama
        \Illuminate\Support\Facades\DB::statement('UPDATE stok_bahan SET jumlah_awal = jumlah');
    }

    public function down(): void
    {
        Schema::table('stok_bahan', function (Blueprint $table) {
            $table->dropColumn('jumlah_awal');
        });
    }
};
