<?php
// ========================================
// FILE: routes/web.php
// FUNGSI: Mendefinisikan URL routes aplikasi
// ========================================

use Illuminate\Support\Facades\Route;

// Route default (sudah ada)
Route::get('/', function () {
    return view('welcome');
});

// ================================================
// TUGAS: Tambahkan route baru di bawah ini
// ================================================

Route::get('/tentang', function () {
    // ================================================
    // Route::get() = Tangani HTTP GET request
    // '/tentang'   = URL yang akan dihandle
    // function     = Kode yang dijalankan saat URL diakses
    // ================================================

    return view('tentang');
    // ↑ return view('tentang') = Tampilkan file tentang.blade.php
    // ↑ Laravel akan mencari di: resources/views/tentang.blade.php
});
Route::get('/sapa/{semua?}', function ($nama = "semua") {
    // ↑ '/sapa/{nama}' = URL pattern
    // ↑ {nama}         = Parameter dinamis, nilainya dari URL
    // ↑ function($nama) = Parameter diterima di function

    return "Halo, $nama! Selamat datang di Toko Online.";
    // ↑ "$nama" = Variable interpolation (masukkan nilai $nama ke string)
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
