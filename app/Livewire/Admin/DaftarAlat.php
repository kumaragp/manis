<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Alat;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Validator;

class DaftarAlat extends Component
{
    use WithFileUploads, WithPagination;

    public $columns = ['No', 'Alat', 'Jumlah', 'Harga Satuan', 'Status'];
    public $isOpen = false;
    public $alatId;
    public $nama_alat;
    public $jumlah_alat;
    public $harga;
    public $gambar;
    public $isEdit = false;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    protected $paginationTheme = 'tailwind';

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
        $this->isEdit = false;

        if ($id) {
            $alat = Alat::find($id);
            if ($alat) {
                $this->alatId = $alat->id;
                $this->nama_alat = $alat->nama_alat;
                $this->jumlah_alat = $alat->jumlah_alat;
                $this->harga = $alat->harga;
                $this->isEdit = true;
            }
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetForm()
    {
        $this->alatId = null;
        $this->nama_alat = '';
        $this->jumlah_alat = '';
        $this->harga = '';
        $this->gambar = null;
    }

    public function save()
    {
        // Validasi awal dengan toast
        $validator = Validator::make([
            'nama_alat' => $this->nama_alat,
            'jumlah_alat' => $this->jumlah_alat,
            'harga' => $this->harga,
            'gambar' => $this->gambar,
        ], [
            'nama_alat' => 'required|string|unique:alat,nama_alat' . ($this->isEdit ? ',' . $this->alatId : ''),
            'jumlah_alat' => 'required|integer|min:0',
            'harga' => 'nullable|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->dispatch('toast', type: 'error', message: $error);
            }
            return;
        }

        $data = [
            'nama_alat' => $this->nama_alat,
            'jumlah_alat' => $this->jumlah_alat,
            'harga' => $this->harga,
        ];

        if ($this->gambar) {
            if ($this->isEdit && $this->alatId) {
                $alat = Alat::findOrFail($this->alatId);
                if ($alat->gambar && Storage::disk('public')->exists($alat->gambar)) {
                    Storage::disk('public')->delete($alat->gambar);
                }
            }
            $data['gambar'] = $this->gambar->store('alat', 'public');
        }

        if ($this->isEdit && $this->alatId) {
            Alat::findOrFail($this->alatId)->update($data);
            $message = 'Alat berhasil diperbarui';
        } else {
            Alat::create($data);
            $message = 'Alat berhasil ditambahkan';
        }

        $this->dispatch('toast', type: 'success', message: $message);
        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        $alat = Alat::find($id);

        if ($alat) {
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }

            $alat->delete();
            $this->dispatch(
                'toast',
                type: 'success',
                message: 'Alat berhasil dihapus'
            );
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $rows = Alat::query()
            ->where('nama_alat', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        // Transform data untuk tabel
        $tableRows = $rows->through(function ($item, $index) use ($rows) {
            return [
                'id' => $item->id,
                'no' => $index + 1 + ($rows->currentPage() - 1) * $rows->perPage(),
                'nama_alat' => $item->nama_alat,
                'jumlah_alat' => $item->jumlah_alat == 0 ? 'STOK HABIS' : $item->jumlah_alat,
                'harga' => 'Rp.' . number_format($item->harga, 0, ',', '.'),
                'status' => Str::upper(str_replace('_', ' ', $item->status)),
                'gambar' => $item->gambar,
            ];
        });

        return view('livewire.admin.daftar-alat', [
            'rows' => $tableRows,
            'pagination' => $rows,
        ]);
    }
}