<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatPeminjamanKaryawanController extends Controller
{
    public function index()
    {
        return view('layouts.karyawan.riwayatPeminjaman', [
            'mode' => 'table',
            'columns' => ['No', 'Waktu', 'Alat', 'Jumlah', 'Status'],
            'rows' => [
                [1, '09:00 AM', 'Telescopic Ladder 3.8', 2, 'Tersedia'],
                [2, '11:00 AM', 'Telescopic Ladder 2.6', 1, 'Digunakan']
            ],
            'actions' => ['report', 'return']
        ]);
    }

    public function pelaporanAlat()
    {
        return view('layouts.karyawan.riwayatPeminjaman', [
            'mode' => 'pelaporanAlat'
        ]);
    }

    public function pengembalianAlat()
    {
        return view('layouts.karyawan.riwayatPeminjaman', [
            'mode' => 'pengembalianAlat'
        ]);
    }
}
