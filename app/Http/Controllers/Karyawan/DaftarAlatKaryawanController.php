<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Perawatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarAlatKaryawanController extends Controller
{
    // Daftar semua alat
    public function index()
    {
        $alat = Alat::all()->map(function ($alat) {
            return [
                'id' => $alat->id,
                'nama' => $alat->nama_alat,
                'status' => Str::upper(str_replace('_', ' ', $alat->status)),
                'stok' => $alat->jumlah_alat,
                'gambar' => $alat->gambar,
            ];
        });

        return view('layouts.karyawan.daftarAlat', [
            'columns' => ['No', 'Alat', 'Jumlah', 'Status'],
            'alat' => $alat,
            'mode' => 'table',
        ]);
    }

    // Form peminjaman alat
    public function peminjamanAlat($id)
    {
        $alat = Alat::findOrFail($id);

        return view('layouts.karyawan.riwayatPeminjaman', [
            'alat' => $alat,
            'mode' => 'peminjamanAlat'
        ]);
    }

    // Simpan peminjaman alat
    public function storePeminjaman(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $alat = Alat::findOrFail($id);

        \DB::table('peminjaman')->insert([
            'alat_id' => $alat->id,
            'karyawan_id' => auth()->id(),
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => now(),
            'status' => 'sedang_digunakan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $alat->jumlah_alat -= $request->jumlah;
        $alat->save();

        return redirect()->route('riwayatPeminjamanKaryawan')
            ->with('success', 'Alat berhasil dipinjam.');
    }

    // Form laporan alat rusak
    public function pelaporanAlat($id)
    {
        $alat = Alat::findOrFail($id);

        return view('layouts.karyawan.riwayatPeminjaman', [
            'alat' => $alat,
            'mode' => 'pelaporanAlat'
        ]);
    }

    // Simpan laporan alat rusak
    public function storePelaporan(Request $request, $alatId)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1'
        ]);

        $alat = Alat::findOrFail($alatId);

        $alat->jumlah_alat = max(0, $alat->jumlah_alat - $request->jumlah);
        $alat->status = 'rusak';
        $alat->save();

        Perawatan::create([
            'alat_id' => $alat->id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'status' => 'rusak',
            'deskripsi' => $request->keterangan,
            'teknisi' => null,
        ]);

        return redirect()->route('riwayatPeminjamanKaryawan')
            ->with('success', 'Alat berhasil dilaporkan.');
    }
}