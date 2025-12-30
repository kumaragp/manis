<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Alat;
use App\Models\Penjualan;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

class PenjualanAlat extends Component
{
    use WithFileUploads, WithPagination;

    public $columns = ['No', 'Tanggal', 'Alat', 'Jumlah', 'Harga'];
    public $search = '';
    public $sortField = 'tanggal_penjualan';
    public $sortDirection = 'desc';

    // Modal
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

    // Stats
    public $totalAlat;
    public $totalPenjualan;
    public $rataRataHarga;

    protected $listeners = ['delete-data' => 'delete'];
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->loadAlat();
        $this->tanggal = now()->format('Y-m-d');
    }

    public function searchData()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
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
        $this->jumlah = 1;
        $this->stok_tersedia = 0;
        $this->gambar = null;
        $this->harga_satuan = 0;
        $this->harga_total = 0;
        $this->customer = '';
    }

    public function updatedAlatId()
    {
        $this->pilihAlat();
    }

    public function updatedJumlah()
    {
        if ($this->jumlah < 1)
            $this->jumlah = 1;
        if ($this->jumlah > $this->stok_tersedia)
            $this->jumlah = $this->stok_tersedia;
        $this->hitungHarga();
    }

    public function pilihAlat()
    {
        if (!$this->alat_id || !isset($this->alatData[$this->alat_id])) {
            $this->stok_tersedia = 0;
            $this->harga_satuan = 0;
            $this->jumlah = 1;
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
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $alat = Alat::findOrFail($this->alat_id);

        Penjualan::create([
            'alat_id' => $alat->id,
            'customer' => $this->customer,
            'tanggal_penjualan' => $this->tanggal,
            'jumlah' => $this->jumlah,
            'harga_jual' => $this->harga_total,
            'gambar' => $this->gambar,
        ]);

        $alat->decrement('jumlah_alat', $this->jumlah);

        $this->dispatch('toast', type: 'success', message: 'Log penjualan berhasil ditambahkan');
        $this->closeModal();
        $this->loadAlat();
    }

    public function delete($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();
        $this->dispatch('toast', type: 'success', message: 'Log penjualan berhasil dihapus');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $penjualan = Penjualan::with('alat')
            ->whereHas('alat', fn($q) => $q->where('nama_alat', 'like', "%{$this->search}%"))
            ->orWhere('customer', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        // Transform data untuk tabel
        $tableRows = $penjualan->through(function ($item, $index) use ($penjualan) {
            return [
                'id' => $item->id,
                'no' => $index + 1 + ($penjualan->currentPage() - 1) * $penjualan->perPage(),
                'tanggal' => Carbon::parse($item->tanggal_penjualan)->format('d/m/Y'),
                'nama_alat' => $item->alat->nama_alat,
                'jumlah' => $item->jumlah,
                'harga' => 'Rp. ' . number_format($item->harga_jual, 0, ',', '.'),
            ];
        });

        $this->totalAlat = Penjualan::sum('jumlah');
        $this->totalPenjualan = Penjualan::sum('harga_jual');
        $this->rataRataHarga = Penjualan::avg('harga_jual');

        return view('livewire.admin.penjualan-alat', [
            'rows' => $tableRows,
            'pagination' => $penjualan,
        ]);
    }
}