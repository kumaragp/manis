<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\Peminjaman;
use App\Models\Perawatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

class RiwayatPeminjamanKaryawan extends Component
{
    public $columns = [
        'No',
        'Alat',
        'Jumlah',
        'Status',
        'Tanggal Pinjam',
        'Tanggal Kembali'
    ];

    public $rows = [];
    public $mode = 'table';

    public $selectedPeminjaman = null;
    public $jumlah;
    public $keterangan;
    public $tanggal;

    protected $listeners = [
        'openPelaporan' => 'openPelaporan',
        'openPengembalian' => 'openPengembalian',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->rows = Peminjaman::with('alat')
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
                    'tanggal_pinjam' => Carbon::parse($item->tanggal_pinjam)->format('d/m/Y H:i'),
                    'tanggal_kembali' => $item->tanggal_kembali
                        ? Carbon::parse($item->tanggal_kembali)->format('d/m/Y H:i')
                        : '-',
                ];
            })->toArray();
    }

    public function openPelaporan($id)
    {
        $this->selectedPeminjaman = Peminjaman::with('alat')->findOrFail($id);
        $this->jumlah = $this->selectedPeminjaman->jumlah;
        $this->mode = 'pelaporan';
    }

    public function openPengembalian($id)
    {
        $this->selectedPeminjaman = Peminjaman::with('alat')->findOrFail($id);
        $this->jumlah = $this->selectedPeminjaman->jumlah;
        $this->mode = 'pengembalian';
    }

    public function storePelaporan()
    {
        $this->validate([
            'jumlah' => 'required|integer|min:1|max:' . $this->selectedPeminjaman->jumlah,
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $this->selectedPeminjaman->jumlah -= $this->jumlah;
        $this->selectedPeminjaman->save();

        Perawatan::create([
            'alat_id' => $this->selectedPeminjaman->alat_id,
            'tanggal' => $this->tanggal,
            'jumlah' => $this->jumlah,
            'status' => 'rusak',
            'deskripsi' => $this->keterangan,
            'teknisi' => null,
        ]);

        $message = 'Alat berhasil dilaporkan';

        $this->dispatch(
            'toast',
            type: 'success',
            message: $message
        );

        $this->resetModal();
        $this->loadData();
    }
    public function storePengembalian()
    {
        $this->validate([
            'jumlah' => 'required|integer|min:1|max:' . $this->selectedPeminjaman->jumlah,
        ]);

        $jumlahKembali = $this->jumlah;
        $peminjaman = $this->selectedPeminjaman;

        if ($jumlahKembali >= $peminjaman->jumlah) {
            $peminjaman->status = 'selesai';
            $peminjaman->tanggal_kembali = now();
            $peminjaman->save();
        } else {
            $peminjaman->jumlah -= $jumlahKembali;
            $peminjaman->save();

            Peminjaman::create([
                'alat_id' => $peminjaman->alat_id,
                'karyawan_id' => $peminjaman->karyawan_id,
                'jumlah' => $jumlahKembali,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => now(),
                'status' => 'selesai',
            ]);
        }

        if ($peminjaman->alat) {
            $peminjaman->alat->jumlah_alat += $jumlahKembali;
            $peminjaman->alat->status = 'tersedia';
            $peminjaman->alat->save();
        }

        $message = 'Pengembalian alat berhasil dilakukan';

        $this->dispatch(
            'toast',
            type: 'success',
            message: $message
        );

        $this->resetModal();
        $this->loadData();
    }

    public function resetModal()
    {
        $this->mode = 'table';
        $this->selectedPeminjaman = null;
        $this->jumlah = null;
        $this->keterangan = null;
        $this->tanggal = null;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.karyawan.riwayat-peminjaman-karyawan');
    }
}