<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pengadaan;
use App\Models\Alat;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class PengadaanAlat extends Component
{
    use WithPagination;

    public $columns = ['No', 'Tanggal', 'Alat', 'Vendor', 'Jumlah', 'Harga'];
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

    public $search = '';
    public $sortField = 'tanggal_pengadaan';
    public $sortDirection = 'desc';

    public $totalAlat;
    public $totalPenjualan;
    public $rataRataHarga;

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
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

    public function openModal($id = null)
    {
        $this->resetForm();
        $this->isOpen = true;

        if ($id) {
            $pengadaan = Pengadaan::find($id);
            if ($pengadaan) {
                $this->pengadaanId = $pengadaan->id;
                $this->tanggal = $pengadaan->tanggal_pengadaan->format('Y-m-d');
                $this->vendor = $pengadaan->vendor;
                $this->nama_alat = $pengadaan->nama_alat;
                $this->jumlah = $pengadaan->jumlah;
                $this->harga = $pengadaan->harga;
                $this->alat_id = $pengadaan->alat_id;
            }
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetForm()
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->vendor = '';
        $this->nama_alat = '';
        $this->jumlah = '';
        $this->harga = '';
        $this->tujuan = '';
        $this->alat_id = null;
        $this->pengadaanId = null;
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

        if ($this->pengadaanId) {
            // Update existing
            $pengadaan = Pengadaan::findOrFail($this->pengadaanId);
            $pengadaan->update([
                'alat_id' => $this->alat_id,
                'nama_alat' => $this->nama_alat,
                'tanggal_pengadaan' => $this->tanggal,
                'vendor' => $this->vendor,
                'jumlah' => $this->jumlah,
                'harga' => $this->harga,
            ]);
            $message = 'Pengadaan alat berhasil diperbarui';
        } else {
            // Create new
            Pengadaan::create([
                'alat_id' => $this->alat_id,
                'nama_alat' => $this->nama_alat,
                'tanggal_pengadaan' => $this->tanggal,
                'vendor' => $this->vendor,
                'jumlah' => $this->jumlah,
                'harga' => $this->harga,
            ]);
            $message = 'Pengadaan alat berhasil ditambahkan';
        }

        $this->dispatch('toast', type: 'success', message: $message);
        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->delete();

        $this->dispatch('toast', type: 'success', message: 'Pengadaan alat berhasil dihapus');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $pengadaan = Pengadaan::with('alat')
            ->where('nama_alat', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $this->totalAlat = Alat::sum('jumlah_alat');
        $this->totalPenjualan = Alat::sum('harga');
        $this->rataRataHarga = Alat::avg('harga');

        // Transform data untuk tabel
        $tableRows = $pengadaan->through(function ($item, $index) use ($pengadaan) {
            return [
                'id' => $item->id,
                'no' => $index + 1 + ($pengadaan->currentPage() - 1) * $pengadaan->perPage(),
                'tanggal' => Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y'),
                'nama_alat' => $item->nama_alat,
                'vendor' => $item->vendor,
                'jumlah' => $item->jumlah,
                'harga' => 'Rp. ' . number_format($item->harga, 0, ',', '.'),
            ];
        });

        return view('livewire.admin.pengadaan-alat', [
            'rows' => $tableRows,
            'pagination' => $pengadaan,
        ]);
    }
}