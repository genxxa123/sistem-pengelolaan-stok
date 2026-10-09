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
        $table->string('foto')->nullable()->after('jumlah'); // Nullable karena mungkin admin belum sempat foto
    });
}
public function down(): void
{
    Schema::table('stok_bahan', function (Blueprint $table) {
        $table->dropColumn('foto');
    });
}
};
