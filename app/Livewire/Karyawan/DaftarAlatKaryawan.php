<?php

namespace App\Livewire\Karyawan;

use Livewire\Component;
use App\Models\Alat;
use App\Models\Perawatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class DaftarAlatKaryawan extends Component
{
    public $alatList = [];
    public $mode = 'table';
    public $selectedAlat = null;
    public $jumlah;
    public $keterangan;
    public $tanggal;
    public $search = '';

    protected $listeners = [
        'openPeminjaman' => 'openPeminjaman',
        'openPelaporan' => 'openPelaporan',
    ];

    public function mount()
    {
        $this->loadAlat();
    }

    public function loadAlat()
    {
        $query = Alat::query();

        if ($this->search) {
            $query->where('nama_alat', 'like', '%' . $this->search . '%');
        }

        $this->alatList = $query->get()->map(function ($alat) {
            return [
                'id' => $alat->id,
                'nama' => $alat->nama_alat,
                'status' => Str::upper(str_replace('_', ' ', $alat->status)),
                'stok' => $alat->jumlah_alat,
                'gambar' => $alat->gambar,
            ];
        })->toArray();
    }

    public function searchData()
    {
        $this->loadAlat();
    }

    public function updatedSearch()
    {
        $this->loadAlat();
    }

    public function openPeminjaman($id)
    {
        $this->selectedAlat = Alat::findOrFail($id);
        $this->jumlah = $this->selectedAlat->jumlah_alat;
        $this->mode = 'peminjamanAlat';
    }

    public function openPelaporan($id)
    {
        $this->selectedAlat = Alat::findOrFail($id);
        $this->jumlah = $this->selectedAlat->jumlah_alat;
        $this->mode = 'pelaporanAlat';
    }

    public function storePeminjaman()
    {
        $this->validate([
            'jumlah' => 'required|integer|min:1|max:' . $this->selectedAlat->jumlah_alat
        ]);

        \DB::table('peminjaman')->insert([
            'alat_id' => $this->selectedAlat->id,
            'karyawan_id' => Auth::id(),
            'jumlah' => $this->jumlah,
            'tanggal_pinjam' => now(),
            'status' => 'sedang_digunakan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->selectedAlat->jumlah_alat -= $this->jumlah;
        $this->selectedAlat->save();

        $this->dispatch('toast', type: 'success', message: 'Alat berhasil dipinjam');

        $this->resetModal();
        $this->loadAlat();
    }

    public function storePelaporan()
    {
        $this->validate([
            'jumlah' => 'required|integer|min:1|max:' . $this->selectedAlat->jumlah_alat,
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date'
        ]);

        $newJumlah = max(0, $this->selectedAlat->jumlah_alat - $this->jumlah);
        \DB::table('alat')
            ->where('id', $this->selectedAlat->id)
            ->update(['jumlah_alat' => $newJumlah]);

        Perawatan::create([
            'alat_id' => $this->selectedAlat->id,
            'tanggal' => $this->tanggal,
            'jumlah' => $this->jumlah,
            'status' => 'rusak',
            'deskripsi' => $this->keterangan,
            'teknisi' => null,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Alat berhasil dilaporkan');

        $this->resetModal();
        $this->loadAlat();
    }

    public function resetModal()
    {
        $this->mode = 'table';
        $this->selectedAlat = null;
        $this->jumlah = null;
        $this->keterangan = null;
        $this->tanggal = null;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.karyawan.daftar-alat-karyawan', [
            'alatList' => $this->alatList,
        ]);
    }
}