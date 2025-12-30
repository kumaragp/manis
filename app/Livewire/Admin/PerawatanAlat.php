<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Perawatan;
use App\Models\Alat;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class PerawatanAlat extends Component
{
    use WithPagination;

    public $columns = ['No', 'Tanggal', 'Alat', 'Jumlah', 'Teknisi', 'Status'];
    public $search = '';
    public $sortField = 'tanggal';
    public $sortDirection = 'desc';

    public $isOpen = false;
    public $perawatanId = null;
    public $alat_id;
    public $jumlah = 1;
    public $teknisi = '';
    public $tanggal;
    public $status = 'rusak';
    public $deskripsi = '';

    public $stok_tersedia = 0;

    public $alatList = [];
    public $alatData = [];

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
        ])->toArray();

        $this->alatList = collect($this->alatData)
            ->mapWithKeys(fn($a, $id) => [$id => $a['nama']])
            ->toArray();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id)
            $this->edit($id);
        $this->isOpen = true;
    }

    private function resetForm()
    {
        $this->perawatanId = null;
        $this->alat_id = null;
        $this->jumlah = 1;
        $this->stok_tersedia = 0;
        $this->teknisi = '';
        $this->tanggal = now()->format('Y-m-d');
        $this->status = 'rusak';
        $this->deskripsi = '';
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
    }

    public function pilihAlat()
    {
        if (!$this->alat_id || !isset($this->alatData[$this->alat_id])) {
            $this->stok_tersedia = 0;
            return;
        }

        $this->stok_tersedia = $this->alatData[$this->alat_id]['stok'];
        if (!$this->perawatanId)
            $this->jumlah = 1;
    }

    public function save()
    {
        $this->pilihAlat();

        $this->validate([
            'alat_id' => 'required|exists:alat,id',
            'jumlah' => 'required|integer|min:1|max:' . $this->stok_tersedia,
            'teknisi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:rusak,dalam_perawatan,diperbaiki',
            'deskripsi' => 'nullable|string',
        ]);

        if ($this->perawatanId) {
            Perawatan::where('id', $this->perawatanId)->update([
                'teknisi' => $this->teknisi,
                'tanggal' => $this->tanggal,
                'status' => $this->status,
                'deskripsi' => $this->deskripsi,
            ]);
        } else {
            $alat = Alat::findOrFail($this->alat_id);
            $alat->decrement('jumlah_alat', $this->jumlah);

            Perawatan::create([
                'alat_id' => $this->alat_id,
                'jumlah' => $this->jumlah,
                'teknisi' => $this->teknisi,
                'tanggal' => $this->tanggal,
                'status' => $this->status,
                'deskripsi' => $this->deskripsi,
            ]);
        }

        $this->dispatch('alat-updated');
        $this->closeModal();
    }

    public function edit($id)
    {
        $data = Perawatan::findOrFail($id);

        if ($data->status === 'diperbaiki') {
            $this->dispatch('toast', type: 'warning', message: 'Perawatan sudah diperbaiki tidak dapat di edit');
            return;
        }

        $this->perawatanId = $data->id;
        $this->alat_id = $data->alat_id;
        $this->jumlah = $data->jumlah;
        $this->teknisi = $data->teknisi;
        $this->tanggal = $data->tanggal;
        $this->status = $data->status;
        $this->deskripsi = $data->deskripsi;

        $this->pilihAlat();
    }

    public function delete($id)
    {
        $perawatan = Perawatan::findOrFail($id);
        $perawatan->delete();

        $this->dispatch('toast', type: 'success', message: 'Perawatan alat berhasil dihapus');
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $perawatan = Perawatan::with('alat')
            ->whereHas('alat', fn($q) => $q->where('nama_alat', 'like', "%{$this->search}%"))
            ->orWhere('teknisi', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $tableRows = $perawatan->through(function ($item, $index) use ($perawatan) {
            return [
                'id' => $item->id,
                'no' => $index + 1 + ($perawatan->currentPage() - 1) * $perawatan->perPage(),
                'tanggal' => Carbon::parse($item->tanggal)->format('d/m/Y'),
                'alat' => $item->alat?->nama_alat ?? '-',
                'jumlah' => $item->jumlah,
                'teknisi' => $item->teknisi,
                'status' => strtoupper(str_replace('_', ' ', $item->status)),
                'can_edit' => $item->status !== 'diperbaiki',
            ];
        });

        return view('livewire.admin.perawatan-alat', [
            'rows' => $tableRows,
            'pagination' => $perawatan,
        ]);
    }
}