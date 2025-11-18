<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DaftarKaryawanController;
use App\Http\Controllers\Admin\RiwayatPeminjamanController;
use App\Http\Controllers\Admin\DaftarAlatController;
use App\Http\Controllers\Admin\PengadaanAlatController;
use App\Http\Controllers\Admin\PenjualanAlatController;
use App\Http\Controllers\Admin\PerawatanAlatController;
use App\Http\Controllers\Karyawan\RiwayatPeminjamanKaryawanController;
use App\Http\Controllers\Karyawan\DaftarAlatKaryawanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// User
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/riwayat-peminjaman-karyawan', [RiwayatPeminjamanKaryawanController::class, 'index'])->name('riwayatPeminjamanKaryawan');
    Route::get('/karyawan/daftar-alat', [DaftarAlatKaryawanController::class, 'index'])->name('daftarAlatKaryawan');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index'])->name('riwayatPeminjaman');
    
    Route::get('/daftar-alat', [DaftarAlatController::class, 'index'])->name('daftarAlat');
    Route::get('/daftar-alat/tambah-alat', [DaftarAlatController::class, 'tambahAlat'])->name('tambahAlat');
    Route::get('/daftar-alat/edit-alat', [DaftarAlatController::class, 'editAlat'])->name('editAlat');
    
    Route::get('/pengadaan-alat', [PengadaanAlatController::class, 'index'])->name('pengadaanAlat');
    Route::get('/pengadaan-alat/pengajuan-alat', [PengadaanAlatController::class, 'pengajuanAlat'])->name('pengajuanAlat');
    
    Route::get('/penjualan-alat', [PenjualanAlatController::class, 'index'])->name('penjualanAlat');
    Route::get('/penjualan-alat/jual-alat', [PenjualanAlatController::class, 'jualAlat'])->name('jualAlat');
    
    Route::get('/perawatan-alat', [PerawatanAlatController::class, 'index'])->name('perawatanAlat');
    Route::get('/perawatan-alat/tambah-perawatan', [PerawatanAlatController::class, 'tambahPerawatan'])->name('tambahPerawatan');
    Route::get('/perawatan-alat/edit-perawatan', [PerawatanAlatController::class, 'editPerawatan'])->name('editPerawatan');
    
    Route::get('/daftar-karyawan', [DaftarKaryawanController::class, 'index'])->name('admin.daftarKaryawan');
    Route::get('/daftar-karyawan/tambah', [DaftarKaryawanController::class, 'tambahAkun'])->name('admin.karyawan.tambah');
    Route::post('/daftar-karyawan/store', [DaftarKaryawanController::class, 'store'])->name('admin.karyawan.store');
    Route::delete('/daftar-karyawan/delete/{id}', [DaftarKaryawanController::class, 'destroy'])->name('admin.karyawan.delete');
});

require __DIR__.'/auth.php';
