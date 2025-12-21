<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\Alat;

class PengadaanAlatController extends Controller
{
    public function index()
    {
        $rows = Pengadaan::with('alat')->get()->map(function ($item, $index) {
            return [
                'id' => $item->id,
                $index + 1,
                Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y'),
                $item->nama_alat,
                $item->vendor,
                $item->jumlah,
                'Rp.' . number_format($item->harga, 0, ',', '.')
            ];
        })->toArray();

        $totalAlat = Alat::sum('jumlah_alat');
        $totalPenjualan = Alat::sum('harga');
        $rataRataHarga = Alat::avg('harga');

        return view('layouts.admin.pengadaanAlat', [
            'mode' => 'table',
            'columns' => ['No', 'Tanggal Pengadaan', 'Vendor', 'Alat', 'Jumlah', 'Harga'],
            'rows' => $rows,
            'actions' => ['delete'],
            'totalAlat' => $totalAlat,
            'totalPenjualan' => $totalPenjualan,
            'rataRataHarga' => $rataRataHarga,
        ]);
    }

    public function pengajuanAlat()
    {
        return view('layouts.admin.pengadaanAlat', [
            'mode' => 'pengajuanAlat'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'vendor' => 'nullable|string',
            'nama_alat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|integer',
            'tujuan' => 'nullable|string'
        ]);

        $alat = Alat::firstOrCreate(
            ['nama_alat' => $request->nama_alat],
            ['jumlah_alat' => 0, 'status' => 'tersedia']
        );

        Pengadaan::create([
            'alat_id' => $alat->id,
            'nama_alat' => $request->nama_alat,
            'tanggal_pengadaan' => $request->tanggal,
            'vendor' => $request->vendor,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);

        return redirect()->route('pengadaanAlat')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->delete();

        return redirect()->route('pengadaanAlat')->with('success', 'Pengadaan berhasil dihapus.');

    }
}