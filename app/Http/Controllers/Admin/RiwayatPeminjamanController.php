<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $columns = ['No','Waktu', 'Alat', 'Jumlah', 'Status', 'Karyawan'];
        $rows = [
            [1 ,'10:46 AM', 'Telescopic Ladder 3.8', 2, 'DIGUNAKAN', 'Budi'],
            [2 ,'12:17 AM', 'Telescopic Ladder 2.6', 1, 'DIGUNAKAN', 'Setiawan']
        ];

        return view('layouts.admin.riwayatPeminjaman', compact('columns', 'rows'));
    }
}