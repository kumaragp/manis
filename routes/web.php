<?php

use App\Livewire\Admin\DaftarAlat;
use App\Livewire\Admin\PengadaanAlat;
use App\Livewire\Admin\PenjualanAlat;
use App\Livewire\Admin\PerawatanAlat;
use App\Livewire\Admin\DaftarKaryawan;

use App\Livewire\Admin\RiwayatPeminjaman;
use App\Livewire\Karyawan\DaftarAlatKaryawan;
use App\Livewire\Karyawan\RiwayatPeminjamanKaryawan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Karyawan
Route::middleware(['auth', 'role:karyawan'])->group(function () {

    Route::get('/karyawan/daftar-alat', DaftarAlatKaryawan::class)->name('daftarAlatKaryawan');
    Route::get('/karyawan/riwayat-peminjaman', RiwayatPeminjamanKaryawan::class)->name('riwayatPeminjamanKaryawan');
});


// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/riwayat-peminjaman', RiwayatPeminjaman::class)->name('riwayatPeminjaman');
    Route::get('/admin/daftar-alat', DaftarAlat::class)->name('daftarAlat');
    Route::get('/admin/pengadaan-alat', PengadaanAlat::class)->name('pengadaanAlat');
    Route::get('/admin/penjualan-alat', PenjualanAlat::class)->name('penjualanAlat');
    Route::get('/admin/perawatan-alat', PerawatanAlat::class)->name('perawatanAlat');
    Route::get('/admin/daftar-karyawan', DaftarKaryawan::class)->name('daftarKaryawan');
});

require __DIR__ . '/auth.php';
