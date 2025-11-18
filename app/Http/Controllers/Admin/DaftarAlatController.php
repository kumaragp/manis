<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarAlatController extends Controller
{
    public function index()
    {
        return view('layouts.admin.daftarAlat', [
            'mode' => 'table',
            'columns' => ['No', 'Alat', 'Jumlah', 'Status'],
            'rows' => [
                [1, 'Telescopic Ladder 3.8', 2, 'TERSEDIA'],
                [2, 'Telescopic Ladder 2.6', 1, 'RUSAK']
            ],
            'actions' => ['delete']
        ]);
    }

    public function tambahAlat()
    {
        return view('layouts.admin.daftarAlat', [
            'mode' => 'tambahAlat'
        ]);
    }

    public function editAlat()
    {
        return view('layouts.admin.daftarAlat', [
            'mode' => 'editAlat'
        ]);
    }
}

