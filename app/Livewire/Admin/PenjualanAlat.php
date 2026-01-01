<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Alat;
use App\Models\Penjualan;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

class PenjualanAlat extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';
    public $columns = ['No', 'Tanggal', 'Alat', 'Jumlah', 'Harga'];
    public $rows = [];

    public $totalAlat;
    public $totalPenjualan;
    public $rataRataHarga;

    public $isOpen = false;
    public $penjualanId;
    public $tanggal;
    public $alat_id;
    public $customer;
    public $gambar;
    public $jumlah = 1;

    public $stok_tersedia = 0;
    public $harga_satuan = 0;
    public $harga_total = 0;

    public $alatList = [];
    public $alatData = [];

    public $search = '';
    public $sortField = 'tanggal_penjualan';
    public $sortDirection = 'desc';

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    public function mount()
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->loadAlat();
    }

    public function searchData()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadAlat()
    {
        $this->alatData = Alat::all()->keyBy('id')->map(fn($a) => [
            'nama' => $a->nama_alat,
            'stok' => $a->jumlah_alat,
            'harga' => $a->harga,
        ])->toArray();

        $this->alatList = collect($this->alatData)
            ->mapWithKeys(fn($a, $id) => [$id => $a['nama']])
            ->toArray();
    }

    public function loadData()
    {
        $query = Penjualan::with('alat')
            ->when($this->search, function ($q) {
                $q->whereHas(
                    'alat',
                    fn($a) =>
                    $a->where('nama_alat', 'like', '%' . $this->search . '%')
                )->orWhere('customer', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $this->rows = $query->map(function ($item, $index) use ($query) {
            return [
                'id' => $item->id,
                'no' => ($query->currentPage() - 1) * $query->perPage() + $index + 1,
                'tanggal' => Carbon::parse($item->tanggal_penjualan)->format('d/m/Y'),
                'nama_alat' => $item->alat->nama_alat,
                'jumlah' => $item->jumlah,
                'harga' => 'Rp. ' . number_format($item->harga_jual, 0, ',', '.'),
            ];
        });

        $this->totalAlat = Penjualan::sum('jumlah');
        $this->totalPenjualan = Penjualan::sum('harga_jual');
        $this->rataRataHarga = Penjualan::avg('harga_jual');

        return $query;
    }

    public function sortBy($field)
    {
        $this->sortDirection =
            $this->sortField === $field && $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';

        $this->sortField = $field;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetForm()
    {
        $this->penjualanId = null;
        $this->alat_id = null;
        $this->customer = '';
        $this->jumlah = 1;
        $this->stok_tersedia = 0;
        $this->gambar = null;
        $this->harga_satuan = 0;
        $this->harga_total = 0;
    }

    public function updatedAlatId()
    {
        $this->pilihAlat();
    }

    public function updatedJumlah()
    {
        $this->jumlah = max(1, min($this->jumlah, $this->stok_tersedia));
        $this->hitungHarga();
    }

    public function pilihAlat()
    {
        if (!$this->alat_id || !isset($this->alatData[$this->alat_id])) {
            $this->stok_tersedia = 0;
            $this->harga_satuan = 0;
            $this->harga_total = 0;
            return;
        }

        $alat = $this->alatData[$this->alat_id];

        $this->stok_tersedia = $alat['stok'];
        $this->harga_satuan = $alat['harga'];
        $this->jumlah = 1;

        $this->hitungHarga();
    }

    private function hitungHarga()
    {
        $this->harga_total = $this->jumlah * $this->harga_satuan;
    }

    public function save()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'alat_id' => 'required|exists:alat,id',
            'jumlah' => 'required|integer|min:1|max:' . $this->stok_tersedia,
            'customer' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $path = $this->gambar
            ? $this->gambar->store('penjualan', 'public')
            : null;

        $alat = Alat::findOrFail($this->alat_id);

        Penjualan::create([
            'alat_id' => $alat->id,
            'customer' => $this->customer,
            'tanggal_penjualan' => $this->tanggal,
            'jumlah' => $this->jumlah,
            'harga_jual' => $this->harga_total,
            'gambar' => $path,
        ]);

        $alat->decrement('jumlah_alat', $this->jumlah);

        $this->dispatch(
            'toast',
            type: 'success',
            message: 'Log penjualan berhasil ditambahkan'
        );

        $this->closeModal();
        $this->loadAlat();
    }

    public function delete($id)
    {
        Penjualan::findOrFail($id)->delete();

        $this->dispatch(
            'toast',
            type: 'success',
            message: 'Log penjualan berhasil dihapus'
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $pagination = $this->loadData();

        return view('livewire.admin.penjualan-alat', [
            'pagination' => $pagination
        ]);
    }
}