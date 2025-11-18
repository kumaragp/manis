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
            'columns' => ['No', 'Alat', 'Jumlah', 'Status'],
            'rows' => [
                [1, 'Telescopic Ladder 3.8', 2, 'TERSEDIA'],
                [2, 'Telescopic Ladder 2.6', 1, 'RUSAK']
            ],
            'actions' => ['delete']
        ]);
    }

    public function tambahPerawatan()
    {
        return view('layouts.karyawan.riwayatPeminjamanKaryawan', [
            'mode' => 'tambahPerawatan'
        ]);
    }

    public function editPerawatan()
    {
        return view('layouts.karyawan.riwayatPeminjaman', [
            'mode' => 'editPerawatan'
        ]);
    }
}
