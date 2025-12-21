<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Str;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['alat', 'karyawan'])->latest()->get();

        $rows = $peminjaman->map(function($item, $index) {
            return [
                'no' => $index + 1,
                'waktu_peminjaman' => $item->tanggal_pinjam->format('d/m/Y H:i'),
                'alat' => $item->alat->nama_alat ?? '-',
                'jumlah' => $item->jumlah,
                'karyawan' => $item->karyawan->name ?? '-',
                'status' => Str::upper(str_replace('_', ' ', $item->status)),
            ];
        });

        $columns = ['No', 'Waktu Peminjaman', 'Alat', 'Jumlah', 'Karyawan', 'Status'];

        return view('layouts.admin.riwayatPeminjaman', compact('columns', 'rows'));
    }
}