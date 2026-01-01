<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Peminjaman;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class RiwayatPeminjaman extends Component
{
    use WithPagination;

    public $columns = ['No', 'Waktu Peminjaman', 'Alat', 'Jumlah', 'Karyawan', 'Status'];

    public $search = '';
    public $sortField = 'tanggal_pinjam';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchData()
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

    #[Layout('layouts.app')]
    public function render()
    {
        $peminjaman = Peminjaman::with(['alat', 'karyawan'])
            ->whereHas('alat', function ($query) {
                $query->where('nama_alat', 'like', "%{$this->search}%");
            })
            ->orWhereHas('karyawan', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orWhere('status', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $rows = $peminjaman->through(function ($item, $index) use ($peminjaman) {
            return [
                'no' => $index + 1 + ($peminjaman->currentPage() - 1) * $peminjaman->perPage(),
                'waktu_peminjaman' => $item->tanggal_pinjam->format('d/m/Y H:i'),
                'alat' => $item->alat->nama_alat ?? '-',
                'jumlah' => $item->jumlah,
                'karyawan' => $item->karyawan->name ?? '-',
                'status' => Str::upper(str_replace('_', ' ', $item->status)),
            ];
        });

        return view('livewire.admin.riwayat-peminjaman', [
            'rows' => $rows,
            'pagination' => $peminjaman,
        ]);
    }
}