<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PermintaanController; // PENTING: jangan lupa import ini
// Jika kamu pakai AdminController untuk update profil, import juga di sini:
// use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('register');
});

// ==========================
// AUTH
// ==========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// ==========================
// DASHBOARD
// ==========================
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru');

// ==========================
// GURU MANAGEMENT
// ==========================
Route::get('/admin/guru', [GuruController::class, 'index'])->name('guru.index');
Route::get('/admin/guru/tambah', [GuruController::class, 'create'])->name('guru.create');
Route::post('/admin/guru', [GuruController::class, 'store'])->name('guru.store');
Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');

// ==========================
// BARANG MANAGEMENT
// ==========================
Route::get('/admin/barang/tambah', [BarangController::class, 'create'])->name('barang.create');
Route::post('/admin/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/admin/barang/baru', [BarangController::class, 'barangBaru'])->name('barang.baru');
Route::get('/admin/barang/stok', [BarangController::class, 'allStok'])->name('barang.stok');
Route::delete('/admin/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/admin/barang/export/pdf', [BarangController::class, 'exportPDF'])->name('barang.export.pdf');

// ==========================
// UPDATE PROFIL ADMIN
// ==========================
// ** HANYA SATU ROUTE untuk update profil **
// Pakai DashboardController (sesuaikan jika kamu pakai AdminController)
Route::post('/admin/update-profil', [DashboardController::class, 'updateProfil'])->name('admin.update.profil');

// ==========================
// PERMINTAAN MANAGEMENT
// ==========================
Route::get('/permintaan', [PermintaanController::class, 'index'])->name('permintaan.index');
Route::get('/permintaan/create', [PermintaanController::class, 'create'])->name('permintaan.create');
Route::post('/permintaan', [PermintaanController::class, 'store'])->name('permintaan.store');
Route::get('/permintaan/{id}/status', [PermintaanController::class, 'status'])->name('permintaan.status');

// ==========================
// DEFAULT REDIRECT /admin
// ==========================
Route::redirect('/admin', '/dashboard/admin')->name('dashboard');
