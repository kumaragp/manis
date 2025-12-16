<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarAlatKaryawanController extends Controller
{
    public function index()
    {
        // Data dummy alat-alat
        $alats = [
            [
                'id' => 1,
                'nama' => 'TANGGA TELESCOPIC 2.6',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png'),
            ],

            [
                'id' => 2,
                'nama' => 'TANGGA TELESCOPIC 3.8',
                'status' => 'DIGUNAKAN',
                'gambar' => asset('images/ladder.png')
            ],
            [
                'id' => 3,
                'nama' => 'TANGGA TELESCOPIC 5.5',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png')
            ],
            [
                'id' => 4,
                'nama' => 'KRISBOW JETSTEAM',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png')
            ],
            [
                'id' => 5,
                'nama' => 'KRISBOW KOMPRESOR',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png')
            ],
            [
                'id' => 6,
                'nama' => 'KRISBOW GENSET PORTABLE',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png')
            ],
            [
                'id' => 7,
                'nama' => 'POMPA SUBMERSIBLE 3 INCH',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png')
            ],
            [
                'id' => 8,
                'nama' => 'TOOL BOX (50X26X24)',
                'status' => 'TERSEDIA',
                'gambar' => asset('images/ladder.png')
            ],
        ];

        return view('layouts.karyawan.daftarAlat', [
            'alats' => $alats
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