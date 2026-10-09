<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MasterMenuController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\StokBahanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DistribusiController;

// ==========================================
// RUTE AUTENTIKASI (Bisa diakses tanpa login)
// ==========================================
Route::get('/', function () {
    return view('welcome'); // Menampilkan halaman landing page MBG
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// RUTE SISTEM (HANYA BISA DIAKSES JIKA SUDAH LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // GRUP ADMIN: Hanya Admin Gudang yang bisa akses
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('bahan', BahanController::class);
        Route::resource('stok', StokBahanController::class);
        Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::resource('barang_rusak', \App\Http\Controllers\BarangRusakController::class);
        Route::get('/laporan/distribusi', [\App\Http\Controllers\LaporanController::class, 'distribusi'])->name('laporan.distribusi');
        Route::resource('sekolah', SekolahController::class);
        Route::resource('distribusi', DistribusiController::class);
    });

    // GRUP BERSAMA: Chef bisa akses
    Route::middleware(['role:chef'])->group(function () {
        Route::post('/menu/check-stock', [MenuController::class, 'checkStock'])->name('menu.checkStock');
        Route::post('/menu/lapor-stok', [App\Http\Controllers\MenuController::class, 'laporStok'])->name('menu.laporStok');
        Route::post('/menu/tandai-dibaca', [App\Http\Controllers\MenuController::class, 'tandaiDibaca'])->name('menu.tandaiDibaca');
        Route::resource('master_menu', MasterMenuController::class);
        Route::resource('menu', MenuController::class);
    });
});