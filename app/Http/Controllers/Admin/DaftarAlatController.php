<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Alat;
use Illuminate\Support\Str;

class DaftarAlatController extends Controller
{
    public function daftarAlat()
    {
        $alat = Alat::all();

        $rows = $alat->map(function ($item, $index) {
            return [
                'id' => $item->id,
                'no' => $index + 1,
                'nama_alat' => $item->nama_alat,
                $item->jumlah_alat == 0 ? 'STOK HABIS' : $item->jumlah_alat,
                'Rp.' . number_format($item->harga, 0, ',', '.'),
                Str::upper(str_replace('_', ' ', $item->status)),
                'gambar' => $item->gambar
            ];
        });

        return view('layouts.admin.daftarAlat', [
            'mode' => 'table',
            'columns' => ['No', 'Alat', 'Jumlah', 'Harga Satuan', 'Status'],
            'rows' => $rows,
            'actions' => ['delete', 'edit']
        ]);
    }

    public function tambahAlat()
    {
        return view('layouts.admin.daftarAlat', [
            'mode' => 'tambahAlat'
        ]);
    }

    public function simpanAlat(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string',
            'jumlah_alat' => 'required|integer|min:0',
            'harga' => 'nullable|integer',
            'status' => 'nullable|in:tersedia,sedang_digunakan,dalam_perawatan,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('alat', 'public');
        }

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'jumlah_alat' => $request->jumlah_alat,
            'harga' => $request->harga,
            'status' => $request->status ?? 'tersedia',
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('daftarAlat')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function editAlat($id)
    {
        $alat = Alat::findOrFail($id);

        return view('layouts.admin.daftarAlat', [
            'mode' => 'editAlat',
            'alat' => $alat
        ]);
    }

    public function updateAlat(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat' => 'required|string',
            'jumlah_alat' => 'required|integer|min:0',
            'harga' => 'nullable|integer',
            'status' => 'nullable|in:tersedia,sedang_digunakan,dalam_perawatan,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }

            $alat->gambar = $request->file('gambar')->store('alat', 'public');
        }

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'jumlah_alat' => $request->jumlah_alat,
            'harga' => $request->harga,
            'status' => $request->status ?? 'tersedia',
        ]);

        return redirect()->route('daftarAlat')
            ->with('success', 'Data alat berhasil diperbarui.');
    }

    public function hapusAlat($id)
    {
        $alat = Alat::findOrFail($id);

        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('daftarAlat')
            ->with('success', 'Alat berhasil dihapus.');
    }

}