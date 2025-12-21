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

// Karyawan
Route::middleware(['auth', 'role:karyawan'])->group(function () {

    // Riwayat peminjaman alat karyawan
    Route::get('/karyawan/riwayat-peminjaman-karyawan', [RiwayatPeminjamanKaryawanController::class, 'index'])->name('riwayatPeminjamanKaryawan');
    Route::get('/riwayat/report/{id}', [RiwayatPeminjamanKaryawanController::class, 'pelaporanAlatPinjam'])->name('karyawan.report');
    Route::post('/riwayat/report/store/{id}', [RiwayatPeminjamanKaryawanController::class, 'pelaporanStore'])->name('karyawan.report.store');
    Route::get('/riwayat/return/{id}', [RiwayatPeminjamanKaryawanController::class, 'pengembalianAlat'])->name('karyawan.return');
    Route::post('/riwayat/return/store/{id}', [RiwayatPeminjamanKaryawanController::class, 'storePengembalian'])->name('karyawan.return.store');

    // Daftar alat karyawan
    Route::get('/karyawan/daftar-alat', [DaftarAlatKaryawanController::class, 'index'])->name('daftarAlatKaryawan');
    Route::get('/pelaporan-alat/{id}', [DaftarAlatKaryawanController::class, 'pelaporanAlat'])->name('pelaporanAlat');
    Route::post('/pelaporan-alat/{id}/store', [DaftarAlatKaryawanController::class, 'storePelaporan'])->name('pelaporanAlat.store');
    Route::get('/peminjaman-alat/{id}', [DaftarAlatKaryawanController::class, 'peminjamanAlat'])->name('peminjamanAlat');
    Route::post('/peminjaman-alat/{id}/store', [DaftarAlatKaryawanController::class, 'storePeminjaman'])->name('peminjamanAlat.store');
    Route::post('/perawatan/{id}/selesai', [DaftarAlatKaryawanController::class, 'perbaikiAlat'])->name('perbaikiAlat');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index'])->name('riwayatPeminjaman');

    // Tampil daftar alat
    Route::get('/daftar-alat', [DaftarAlatController::class, 'daftarAlat'])->name('daftarAlat');
    Route::get('/tambah-alat', [DaftarAlatController::class, 'tambahAlat'])->name('tambahAlat');
    Route::post('/simpan-alat', [DaftarAlatController::class, 'simpanAlat'])->name('simpanAlat');
    Route::get('/edit-alat/{id}', [DaftarAlatController::class, 'editAlat'])->name('editAlat');
    Route::put('/update-alat/{id}', [DaftarAlatController::class, 'updateAlat'])->name('updateAlat');
    Route::delete('/hapus-alat/{id}', [DaftarAlatController::class, 'hapusAlat'])->name('hapusAlat');

    Route::get('/pengadaan-alat', [PengadaanAlatController::class, 'index'])->name('pengadaanAlat');
    Route::get('/pengadaan-alat/create', [PengadaanAlatController::class, 'pengajuanAlat'])->name('pengajuanAlat');
    Route::post('/pengadaan-alat', [PengadaanAlatController::class, 'store'])->name('pengadaanAlat.store');
    Route::delete('/pengadaan-alat/delete/{id}', [PengadaanAlatController::class, 'destroy'])->name('pengadaanAlat.destroy');

    // Penjualan Alat
    Route::get('/penjualan-alat', [PenjualanAlatController::class, 'index'])->name('penjualanAlat');
    Route::get('/penjualan-alat/create', [PenjualanAlatController::class, 'jualAlat'])->name('jualAlat');
    Route::post('/penjualan-alat', [PenjualanAlatController::class, 'store'])->name('penjualanAlat.store');
    Route::delete('/penjualan-alat/delete/{id}', [PenjualanAlatController::class, 'destroy'])->name('penjualanAlat.destroy');

    // Perawatan Alat
    Route::get('/perawatan-alat', [PerawatanAlatController::class, 'index'])->name('perawatanAlat');
    Route::get('/perawatan-alat/create', [PerawatanAlatController::class, 'tambahPerawatan'])->name('tambahPerawatan');
    Route::post('/perawatan-alat', [PerawatanAlatController::class, 'store'])->name('storePerawatan');
    Route::get('/perawatan-alat/edit/{id}', [PerawatanAlatController::class, 'editPerawatan'])->name('editPerawatan');
    Route::put('/perawatan-alat/update/{id}', [PerawatanAlatController::class, 'update'])->name('updatePerawatan');
    Route::delete('/perawatan-alat/delete/{id}', [PerawatanAlatController::class, 'destroy'])->name('hapusPerawatan');

    // Daftar Karyawan
    Route::get('/daftar-karyawan', [DaftarKaryawanController::class, 'index'])->name('admin.karyawan');
    Route::get('/daftar-karyawan/create', [DaftarKaryawanController::class, 'tambahAkun'])->name('admin.karyawan.tambah');
    Route::post('/daftar-karyawan', [DaftarKaryawanController::class, 'store'])->name('admin.karyawan.store');
    Route::get('/daftar-karyawan/edit/{id}', [DaftarKaryawanController::class, 'edit'])->name('admin.karyawan.edit');
    Route::put('/daftar-karyawan/update/{id}', [DaftarKaryawanController::class, 'update'])->name('admin.karyawan.update');
    Route::delete('/daftar-karyawan/delete/{id}', [DaftarKaryawanController::class, 'destroy'])->name('admin.karyawan.delete');
    Route::post('/daftar-karyawan/reset-token/{id}', [DaftarKaryawanController::class, 'resetPassword'])->name('admin.karyawan.reset');
});

require __DIR__ . '/auth.php';
