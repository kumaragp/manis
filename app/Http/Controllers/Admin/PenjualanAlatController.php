<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenjualanAlatController extends Controller
{
    public function index()
    {
        return view('layouts.admin.penjualanAlat', [
            'mode' => 'table',
            'columns' => ['No', 'Alat', 'Jumlah', 'Harga'],
            'rows' => [
                [1, 'Telescopic Ladder 3.8', 1, 'Rp.2.300.000'],
                [2, 'Telescopic Ladder 2.6', 1, 'Rp.2.100.000']
            ],
            'actions' => ['delete']
        ]);
    }

    public function jualAlat()
    {
        return view('layouts.admin.penjualanAlat', [
            'mode' => 'jualAlat'
        ]);
    }
}
