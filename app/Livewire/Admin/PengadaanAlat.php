<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pengadaan;
use App\Models\Alat;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

class PengadaanAlat extends Component
{
    public $columns = ['No', 'Tanggal', 'Alat', 'Vendor', 'Jumlah', 'Harga'];
    public $rows = [];

    public $totalAlat;
    public $totalPenjualan;
    public $rataRataHarga;

    public $isOpen = false;
    public $pengadaanId;
    public $editId;
    public $tanggal;
    public $vendor;
    public $nama_alat;
    public $jumlah;
    public $harga;
    public $tujuan;
    public $alat_id;

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->rows = Pengadaan::with('alat')->get()->map(function ($item, $index) {
            return [
                'id' => $item->id,
                'no' => $index + 1,
                'tanggal' => Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y'),
                'nama_alat' => $item->nama_alat,
                'vendor' => $item->vendor,
                'jumlah' => $item->jumlah,
                'harga' => 'Rp. ' . number_format($item->harga, 0, ',', '.'),
            ];
        })->toArray();

        $this->totalAlat = Alat::sum('jumlah_alat');
        $this->totalPenjualan = Alat::sum('harga');
        $this->rataRataHarga = Alat::avg('harga');
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->vendor = '';
        $this->nama_alat = '';
        $this->jumlah = '';
        $this->harga = '';
        $this->tujuan = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'nama_alat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|integer',
            'vendor' => 'nullable|string',
            'alat_id' => 'nullable|exists:alat,id',
        ]);

        Pengadaan::create([
            'alat_id' => $this->alat_id,
            'nama_alat' => $this->nama_alat,
            'tanggal_pengadaan' => $this->tanggal,
            'vendor' => $this->vendor,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
        ]);

        $this->dispatch(
            'toast',
            type: 'success',
            message: 'Pengadaan alat berhasil dilakukan'
        );

        $this->closeModal();
        $this->loadData();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function delete($id)
    {
        $Pengadaan =Pengadaan::findOrFail($id);

        $Pengadaan->delete();
        $this->loadData();
        $this->dispatch(
            'toast',
            type: 'success',
            message: 'Alat berhasil dihapus'
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.pengadaan-alat');
    }
}