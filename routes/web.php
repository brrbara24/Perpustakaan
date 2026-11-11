<?php

use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [SiswaAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [SiswaAuthController::class, 'login']);
        Route::get('/daftar', [SiswaAuthController::class, 'showRegister'])->name('daftar');
        Route::post('/daftar', [SiswaAuthController::class, 'register']);
    });

    Route::middleware(['auth', 'siswa'])->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/peminjaman', [SiswaController::class, 'peminjaman'])->name('peminjaman');
        Route::post('/peminjaman', [siswaController::class, 'pinjam'])->name('pinjam');
        Route::get('/pengambilan', [siswaController::class, 'pengembalian'])->name('pengembalian');
        Route::post('/pengembalian/{loan}', [SiswaController::class, 'kembalikan'])->name('kembalikan');
        Route::post('/logout', [SiswaAuthController::class, 'logout'])->name('logout');
    });
});
