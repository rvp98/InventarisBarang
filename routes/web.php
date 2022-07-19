<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\Barang\KategoriBarangController;
use App\Http\Controllers\Peminjam\PeminjamController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Transaksi\PeminjamanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::get('/barang/edit/{id}', [BarangController::class, 'fetchBarang'])->name('barang.edit');
    Route::get('/barang/delete/{id}', [BarangController::class, 'deleteBarang'])->name('barang.delete');
    Route::post('/barang', [BarangController::class, 'storeBarang'])->name('barang.store');

    // Kategori
    Route::get('/kategori_barang', [KategoriBarangController::class, 'index'])->name('kategori_barang');
    Route::get('/kategori_barang/edit/{id}', [KategoriBarangController::class, 'fetchKategori'])->name('kategori_barang.edit');
    Route::get('/kategori_barang/delete/{id}', [KategoriBarangController::class, 'deleteKategori'])->name('kategori_barang.delete');
    Route::post('/kategori_barang', [KategoriBarangController::class, 'storeKategori'])->name('kategori_barang.store');

    // Peminjam
    Route::get('/peminjam', [PeminjamController::class, 'index'])->name('peminjam');
    Route::get('/peminjam/edit/{id}', [PeminjamController::class, 'fetchPeminjam'])->name('peminjam.edit');
    Route::get('/peminjam/delete/{id}', [PeminjamController::class, 'deletePeminjam'])->name('peminjam.delete');
    Route::post('/peminjam', [PeminjamController::class, 'storePeminjam'])->name('peminjam.store');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/add_peminjaman', [PeminjamanController::class, 'addPeminjaman'])->name('add_peminjaman');
    Route::get('/edit_peminjaman/{id}', [PeminjamanController::class, 'editPeminjaman'])->name('edit_peminjaman');
    Route::get('/peminjaman/delete/{id}', [PeminjamanController::class, 'deletePeminjaman'])->name('peminjaman.delete');
    Route::post('/peminjaman', [PeminjamanController::class, 'storePeminjaman'])->name('peminjaman.store');
    Route::post('/peminjaman_edit', [PeminjamanController::class, 'storeEditPeminjaman'])->name('peminjaman.store_edit');

    // Data Admin
    Route::get('/data_admin', [AdminController::class, 'index'])->name('data_admin');
    Route::get('/data_admin/edit/{id}', [AdminController::class, 'fetchAdmin'])->name('data_admin.edit');
    Route::get('/data_admin/delete/{id}', [AdminController::class, 'deleteAdmin'])->name('data_admin.delete');
    Route::post('/data_admin', [AdminController::class, 'storeAdmin'])->name('data_admin.store');
});

// Modul Error
Route::get('error_403', function () {
    return view('error.403');
})->name('403');
Route::get('error_404', function () {
    return view('error.404');
})->name('404');

