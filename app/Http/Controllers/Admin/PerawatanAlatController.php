<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perawatan;
use App\Models\Alat;
use Carbon\Carbon;

class PerawatanAlatController extends Controller
{
    public function index()
    {
        $perawatan = Perawatan::with('alat')->get();

        $rows = $perawatan->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'tanggal' => Carbon::parse($item->tanggal)->format('d/m/Y'),
                'nama_alat' => $item->alat?->nama_alat ?? '-',
                'jumlah' => $item->jumlah,
                'teknisi' => $item->teknisi,
                'status' => strtoupper(str_replace('_', ' ', $item->status)),
                'id' => $item->id
            ];
        });

        return view('layouts.admin.perawatanAlat', [
            'mode' => 'table',
            'columns' => ['No', 'Tanggal', 'Alat', 'Jumlah', 'Teknisi', 'Status'],
            'rows' => $rows,
            'actions' => ['edit', 'delete']
        ]);
    }

    public function tambahPerawatan()
    {
        return view('layouts.admin.perawatanAlat', [
            'mode' => 'tambahPerawatan',
            'alatList' => Alat::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaAlat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'teknisi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:rusak,dalam_perawatan,diperbaiki',
            'deskripsi' => 'nullable|string'
        ]);

        $alat = Alat::where('nama_alat', $request->namaAlat)->firstOrFail();

        if ($alat->jumlah_alat < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok alat.']);
        }

        $alat->jumlah_alat -= $request->jumlah;
        $alat->save();

        Perawatan::create([
            'alat_id' => $alat->id,
            'jumlah' => $request->jumlah,
            'teknisi' => $request->teknisi,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('perawatanAlat')->with('success', 'Perawatan berhasil ditambahkan.');
    }

    public function editPerawatan($id)
    {
        $data = Perawatan::findOrFail($id);

        return view('layouts.admin.perawatanAlat', [
            'mode' => 'editPerawatan',
            'data' => $data,
            'alatList' => Alat::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Perawatan::findOrFail($id);

        $request->validate([
            'teknisi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:rusak,dalam_perawatan,diperbaiki',
            'deskripsi' => 'nullable|string'
        ]);

        // Cek perubahan status dari rusak/dalam_perawatan → diperbaiki
        if ($request->status === 'diperbaiki' && $data->status !== 'diperbaiki') {
            $alat = Alat::find($data->alat_id);
            if ($alat) {
                $alat->jumlah_alat += $data->jumlah;
                $alat->status = 'tersedia';
                $alat->save();
            }
        }

        $data->update([
            'teknisi' => $request->teknisi,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('perawatanAlat')
            ->with('success', 'Perawatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Perawatan::findOrFail($id);

        $alat = Alat::find($data->alat_id);
        if ($alat) {
            $alat->jumlah_alat += $data->jumlah;
            $alat->save();
        }

        $data->delete();

        return redirect()->route('perawatanAlat')->with('success', 'Perawatan dihapus & stok dikembalikan.');
    }
}