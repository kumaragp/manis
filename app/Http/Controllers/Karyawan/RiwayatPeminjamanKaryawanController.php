<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Perawatan;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatPeminjamanKaryawanController extends Controller
{
    // Daftar riwayat peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with('alat')
            ->where('karyawan_id', Auth::id())
            ->orderBy('tanggal_pinjam', 'desc')
            ->get()
            ->map(function ($item, $index) {
                return [
                    'id' => $item->id,
                    'no' => $index + 1,
                    'nama' => $item->alat->nama_alat ?? 'Alat dihapus',
                    'jumlah' => $item->jumlah,
                    'status' => Str::upper(str_replace('_', ' ', $item->status)),
                    'tanggal_pinjam' => $item->tanggal_pinjam->format('d/m/Y H:i'),
                    'tanggal_kembali' => $item->tanggal_kembali
                        ? $item->tanggal_kembali->format('d/m/Y H:i')
                        : '-',
                ];
            });

        return view('layouts.karyawan.riwayatPeminjaman', [
            'columns' => ['No', 'Alat', 'Jumlah', 'Status', 'Tanggal Pinjam', 'Tanggal Kembali'],
            'peminjaman' => $peminjaman,
            'mode' => 'table',
        ]);
    }

    // Form pelaporan alat dari peminjaman
    public function pelaporanAlatPinjam($id)
    {
        $peminjaman = Peminjaman::with('alat')
            ->where('id', $id)
            ->where('karyawan_id', Auth::id())
            ->firstOrFail();

        return view('layouts.karyawan.riwayatPeminjaman', [
            'peminjaman' => $peminjaman,
            'mode' => 'pelaporanAlatPinjam'
        ]);
    }

    // Store pelaporan alat rusak dari peminjaman
    public function pelaporanStore(Request $request, $id)
    {
        // Ambil data peminjaman yang dilaporkan
        $peminjaman = Peminjaman::findOrFail($id);

        // Validasi input
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah_alat' => 'required|integer|min:1|max:' . $peminjaman->jumlah, // pastikan jumlah tidak melebihi peminjaman
        ]);

        $jumlahDilaporkan = $request->jumlah_alat;

        // Kurangi jumlah di tabel peminjaman sesuai laporan
        $peminjaman->jumlah -= $jumlahDilaporkan;
        $peminjaman->save();

        // Catat pelaporan di tabel perawatan
        Perawatan::create([
            'alat_id' => $peminjaman->alat_id,
            'tanggal' => $request->tanggal ?? now(),
            'jumlah' => $jumlahDilaporkan,
            'status' => 'rusak',
            'deskripsi' => $request->keterangan,
            'teknisi' => null,
        ]);

        return redirect()->route('riwayatPeminjamanKaryawan')
            ->with('success', 'Pelaporan alat berhasil dicatat, dan jumlah di peminjaman diperbarui.');
    }


    // Form pengembalian alat
    public function pengembalianAlat($id)
    {
        $peminjaman = Peminjaman::with('alat')
            ->where('id', $id)
            ->where('karyawan_id', Auth::id())
            ->firstOrFail();

        return view('layouts.karyawan.riwayatPeminjaman', [
            'peminjaman' => $peminjaman,
            'mode' => 'pengembalianAlat'
        ]);
    }

    // Store pengembalian alat
    public function storePengembalian(Request $request, $id)
    {
        $request->validate([
            'jumlah_kembali' => 'required|integer|min:1',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $jumlahKembali = $request->jumlah_kembali;

        if ($jumlahKembali >= $peminjaman->jumlah) {
            $peminjaman->status = 'selesai'; // update status
            $peminjaman->tanggal_kembali = Carbon::now();
            $peminjaman->save();
        } else {
            $peminjaman->jumlah -= $jumlahKembali;
            $peminjaman->status = 'sedang_digunakan'; // optional, tetap gunakan jika masih dipakai
            $peminjaman->save();

            Peminjaman::create([
                'alat_id' => $peminjaman->alat_id,
                'karyawan_id' => $peminjaman->karyawan_id,
                'jumlah' => $jumlahKembali,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => Carbon::now(),
                'status' => 'selesai',
            ]);
        }

        $alat = $peminjaman->alat;
        if ($alat) {
            $alat->jumlah_alat += $jumlahKembali;
            $alat->status = 'tersedia';
            $alat->save();
        }

        return redirect()->route('riwayatPeminjamanKaryawan')
            ->with('success', 'Alat berhasil dikembalikan.');
    }
}