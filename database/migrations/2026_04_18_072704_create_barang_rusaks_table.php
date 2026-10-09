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
    Schema::create('barang_rusak', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel stok_bahan (batch mana yang rusak)
        $table->foreignId('stok_bahan_id')->constrained('stok_bahan')->onDelete('cascade');
        $table->date('tanggal_lapor');
        $table->decimal('jumlah_rusak', 10, 2);
        $table->string('keterangan'); // Alasan rusak (Contoh: "Pecah saat dipindah")
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_rusak');
    }
};
