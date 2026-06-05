<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\EksporController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TargetHarianController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes — Monifora
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth
Route::get('/masuk',       [AuthController::class, 'showLogin'])->name('login');
Route::post('/masuk',      [AuthController::class, 'login'])->name('login.post');
Route::get('/daftar',      [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar',     [AuthController::class, 'register'])->name('register.post');
Route::post('/keluar',     [AuthController::class, 'logout'])->name('logout');

// Lupa Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Halaman yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi
    Route::get('/transaksi/tambah',   [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/tambah',  [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/riwayat',  [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}/edit',[TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}',     [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}',  [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

    // Ekspor
    Route::get('/ekspor',          [EksporController::class, 'index'])->name('ekspor.index');
    Route::post('/ekspor/pdf',     [EksporController::class, 'exportPdf'])->name('ekspor.pdf');
    Route::post('/ekspor/excel',   [EksporController::class, 'exportExcel'])->name('ekspor.excel');

    // Profil
    Route::get('/profil',              [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil/foto',        [ProfilController::class, 'uploadFoto'])->name('profil.foto');
    Route::delete('/profil/hapus-data',[ProfilController::class, 'hapusSemuaData'])->name('profil.hapusData');

    // Target Harian
    Route::get('/target-harian', [TargetHarianController::class, 'index'])->name('target.index');
    Route::post('/target-harian', [TargetHarianController::class, 'simpan'])->name('target.simpan');
});