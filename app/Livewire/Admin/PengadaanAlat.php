<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengadaan;
use App\Models\Alat;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use App\Livewire\Services\Export\PengadaanExcel;

class PengadaanAlat extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $columns = ['No', 'Tanggal', 'Alat', 'Vendor', 'Jumlah', 'Harga'];
    public $rows = [];

    public $exportMode = 'preset';
    public $periode = 'tahun';
    public $tahun;
    public $bulan;
    public $minggu;

    public $tanggalMulai;
    public $tanggalSelesai;

    public $totalAlat;
    public $totalNilaiAlat;
    public $rataRataHarga;

    public $isOpen = false;
    public $pengadaanId;
    public $tanggal;
    public $vendor;
    public $nama_alat;
    public $jumlah;
    public $harga;
    public $alat_id;

    public $search = '';
    public $sortField = 'tanggal_pengadaan';
    public $sortDirection = 'desc';

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    public function mount()
    {
        $this->tahun = now()->year;
        $this->bulan = now()->month;
        $this->minggu = 1;
        $this->tanggalMulai = now()->startOfMonth()->toDateString();
        $this->tanggalSelesai = now()->toDateString();
        $this->tanggal = now()->format('Y-m-d');
    }
    public function exportExcel()
    {
        $excel = new PengadaanExcel();

        if ($this->exportMode === 'custom') {
            return $excel->exportByDateRange(
                $this->tanggalMulai,
                $this->tanggalSelesai
            );
        }

        return $excel->exportPengadaan(
            $this->periode,
            $this->tahun,
            $this->bulan,
            $this->minggu
        );
    }

    public function searchData()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadData()
    {
        $query = Pengadaan::query()
            ->when($this->search, function ($q) {
                $q->where('nama_alat', 'like', '%' . $this->search . '%')
                    ->orWhere('vendor', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $this->rows = $query->map(function ($item, $index) use ($query) {
            return [
                'id' => $item->id,
                'no' => ($query->currentPage() - 1) * $query->perPage() + $index + 1,
                'tanggal' => Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y'),
                'nama_alat' => $item->nama_alat,
                'vendor' => $item->vendor,
                'jumlah' => $item->jumlah,
                'harga' => 'Rp. ' . number_format($item->harga, 0, ',', '.'),
            ];
        });

        $this->totalAlat = Alat::sum('jumlah_alat');
        $this->totalNilaiAlat = Alat::get()->sum(function ($alat) {
            return $alat->jumlah_alat * $alat->harga;
        });
        $this->rataRataHarga = Alat::avg('harga');

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

    public function resetForm()
    {
        $this->pengadaanId = null;
        $this->tanggal = now()->format('Y-m-d');
        $this->vendor = '';
        $this->nama_alat = '';
        $this->jumlah = '';
        $this->harga = '';
    }

    public function save()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'nama_alat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|integer',
            'vendor' => 'nullable|string',
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
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function delete($id)
    {
        Pengadaan::findOrFail($id)->delete();

        $this->dispatch(
            'toast',
            type: 'success',
            message: 'Data Pengadaan alat berhasil dihapus'
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $pagination = $this->loadData();

        return view('livewire.admin.pengadaan-alat', [
            'pagination' => $pagination
        ]);
    }
}
