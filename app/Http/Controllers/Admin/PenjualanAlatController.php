<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Alat;
use App\Models\Penjualan;

class PenjualanAlatController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('alat')->latest()->get();

        $rows = $penjualan->map(function($item, $key) {
            return [
                $key + 1,
                Carbon::parse($item->tanggal_penjualan)->format('d/m/Y'),
                $item->alat->nama_alat,
                $item->jumlah,
                'Rp. '.number_format($item->harga_jual,0,',','.')
            ];
        })->toArray();

        $totalAlat = Penjualan::sum('jumlah');
        $totalPenjualan = Penjualan::sum('harga_jual');
        $rataRataHarga = Penjualan::avg('harga_jual');

        return view('layouts.admin.penjualanAlat', [
            'mode' => 'table',
            'columns' => ['No','Tanggal Penjualan', 'Alat', 'Jumlah', 'Harga'],
            'rows' => $rows,
            'totalAlat' => $totalAlat,
            'totalPenjualan' => $totalPenjualan,
            'rataRataHarga' => $rataRataHarga,
        ]);
    }

    public function jualAlat()
    {
        $alatList = Alat::where('jumlah_alat', '>', 0)->get();
        return view('layouts.admin.penjualanAlat', [
            'mode' => 'jualAlat',
            'alatList' => $alatList
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'namaAlat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|integer'
        ]);

        $alat = Alat::where('nama_alat', $request->namaAlat)->firstOrFail();

        if($request->jumlah > $alat->jumlah_alat){
            return redirect()->back()->withErrors(['jumlah' => 'Jumlah melebihi stok alat.']);
        }

        Penjualan::create([
            'alat_id' => $alat->id,
            'pembeli' => $request->nama,
            'tanggal_penjualan' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'harga_jual' => $request->harga
        ]);

        $alat->decrement('jumlah_alat', $request->jumlah);

        return redirect()->route('penjualanAlat')->with('success', 'Alat berhasil dijual.');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $alat = $penjualan->alat;

        $alat->increment('jumlah_alat', $penjualan->jumlah);
        $penjualan->delete();

        return redirect()->route('penjualanAlat')->with('success', 'Data penjualan berhasil dihapus.');
    }
}