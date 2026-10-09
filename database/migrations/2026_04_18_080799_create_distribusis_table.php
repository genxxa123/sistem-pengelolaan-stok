<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('distribusis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('menu_id')->constrained('menu')->onDelete('cascade');
        $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
        $table->integer('jumlah_porsi');
        $table->timestamp('waktu_kirim');
        $table->string('status')->default('Dalam Perjalanan'); // Dalam Perjalanan, Terkirim
        $table->string('penerima')->nullable(); // Nama guru/petugas di sekolah
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
