<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Perawatan;
use App\Models\Alat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

class PerawatanAlat extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['delete-data' => 'delete'];

    public $columns = ['No', 'Tanggal', 'Alat', 'Jumlah', 'Teknisi', 'Status'];
    public $search = '';

    public $isOpen = false;
    public $perawatanId = null;

    public $alat_id;
    public $jumlah = 1;
    public $teknisi = '';
    public $tanggal;
    public $status = 'rusak';
    public $deskripsi = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $stok_tersedia = 0;
    public $alatList = [];

    public function mount()
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->alatList = Alat::pluck('nama_alat', 'id')->toArray();
    }

    public function searchData()
    {
        $this->resetPage();
    }

    public function pilihAlat()
    {
        if (!$this->alat_id) {
            $this->stok_tersedia = 0;
            return;
        }

        $stokAlat = Alat::where('id', $this->alat_id)->value('jumlah_alat') ?? 0;

        $stokDipakai = Perawatan::where('alat_id', $this->alat_id)
            ->where('status', '!=', 'diperbaiki')
            ->when($this->perawatanId, fn($q) => $q->where('id', '!=', $this->perawatanId))
            ->sum('jumlah');

        $stokGudang = $stokAlat - $stokDipakai;

        if ($this->perawatanId) {
            $jumlahPerawatanSaatIni = Perawatan::where('id', $this->perawatanId)
                ->value('jumlah');

            $this->stok_tersedia = $stokGudang + $jumlahPerawatanSaatIni;
        } else {
            $this->stok_tersedia = $stokGudang;
        }

        if ($this->jumlah < 1) {
            $this->jumlah = 1;
        }

        if ($this->jumlah > $this->stok_tersedia) {
            $this->jumlah = $this->stok_tersedia;
        }
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

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id)
            $this->edit($id);
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
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

    public function save()
    {
        $this->validate([
            'alat_id' => 'required|exists:alat,id',
            'jumlah' => 'required|integer|min:1',
            'teknisi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:rusak,dalam_perawatan,diperbaiki',
        ]);

        DB::transaction(function () {

            $perawatan = $this->perawatanId
                ? Perawatan::findOrFail($this->perawatanId)
                : null;


            $stokAlat = Alat::where('id', $this->alat_id)->value('jumlah_alat') ?? 0;

            $stokDipakai = Perawatan::where('alat_id', $this->alat_id)
                ->where('status', '!=', 'diperbaiki')
                ->when($perawatan, fn($q) => $q->where('id', '!=', $perawatan->id))
                ->sum('jumlah');

            $stokTersedia = $stokAlat - $stokDipakai;

            if (!$perawatan) {

                if ($this->status !== 'diperbaiki' && $this->jumlah > $stokTersedia) {
                    $this->dispatch('toast', type: 'error', message: 'Stok tidak mencukupi');
                    return;
                }

                Perawatan::create([
                    'alat_id' => $this->alat_id,
                    'jumlah' => $this->jumlah,
                    'teknisi' => $this->teknisi,
                    'tanggal' => $this->tanggal,
                    'status' => $this->status,
                    'deskripsi' => $this->deskripsi,
                    'editable' => $this->status !== 'diperbaiki',
                ]);

                if ($this->status !== 'diperbaiki') {
                    Alat::where('id', $this->alat_id)
                        ->decrement('jumlah_alat', $this->jumlah);
                }

                return;
            }

            if ($perawatan->status === 'diperbaiki') {
                $this->dispatch('toast', type: 'error', message: 'Perawatan sudah selesai');
                return;
            }

            $jumlahLama = $perawatan->jumlah;
            $jumlahBaru = $this->jumlah;
            $statusLama = $perawatan->status;
            $statusBaru = $this->status;

            if ($statusLama !== 'diperbaiki' && $statusBaru === 'diperbaiki') {

                if ($jumlahBaru > $jumlahLama) {
                    $this->dispatch('toast', type: 'error', message: 'Jumlah tidak boleh melebihi jumlah sebelumnya');
                    return;
                }

                if ($jumlahBaru < $jumlahLama) {

                    $perawatan->update([
                        'jumlah' => $jumlahLama - $jumlahBaru,
                    ]);

                    Perawatan::create([
                        'alat_id' => $perawatan->alat_id,
                        'jumlah' => $jumlahBaru,
                        'teknisi' => $this->teknisi,
                        'tanggal' => $this->tanggal,
                        'status' => 'diperbaiki',
                        'deskripsi' => $this->deskripsi,
                        'editable' => false,
                    ]);
                } else {
                    $perawatan->update([
                        'status' => 'diperbaiki',
                        'teknisi' => $this->teknisi,
                        'tanggal' => $this->tanggal,
                        'deskripsi' => $this->deskripsi,
                        'editable' => false,
                    ]);
                }

                Alat::where('id', $perawatan->alat_id)
                    ->increment('jumlah_alat', $jumlahBaru);

                return;
            }

            $selisih = $jumlahBaru - $jumlahLama;

            if ($selisih > 0 && $selisih > $stokTersedia) {
                $this->dispatch('toast', type: 'error', message: 'Stok tidak mencukupi');
                return;
            }

            if ($selisih > 0) {
                Alat::where('id', $perawatan->alat_id)
                    ->decrement('jumlah_alat', $selisih);
            } elseif ($selisih < 0) {
                Alat::where('id', $perawatan->alat_id)
                    ->increment('jumlah_alat', abs($selisih));
            }

            $perawatan->update([
                'jumlah' => $jumlahBaru,
                'teknisi' => $this->teknisi,
                'tanggal' => $this->tanggal,
                'status' => $statusBaru,
                'deskripsi' => $this->deskripsi,
            ]);
        });

        $this->dispatch('toast', type: 'success', message: 'Data perawatan berhasil disimpan');
        $this->closeModal();
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
    public function edit($id)
    {
        $data = Perawatan::findOrFail($id);

        if ($data->status === 'diperbaiki') {
            $this->dispatch('toast', type: 'warning', message: 'Perawatan sudah selesai');
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
        DB::transaction(function () use ($id) {
            $perawatan = Perawatan::findOrFail($id);

            if ($perawatan->status !== 'diperbaiki') {
                Alat::where('id', $perawatan->alat_id)
                    ->increment('jumlah_alat', $perawatan->jumlah);
            }

            $perawatan->delete();
        });

        $this->dispatch('toast', type: 'success', message: 'Data perawatan berhasil dihapus');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $perawatan = Perawatan::with('alat')
            ->where(function ($q) {
                $q->whereHas(
                    'alat',
                    fn($a) =>
                    $a->where('nama_alat', 'like', "%{$this->search}%")
                )
                    ->orWhere('teknisi', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $rows = $perawatan->through(function ($item, $i) use ($perawatan) {
            $stokAlat = $item->alat->jumlah_alat ?? 0;
            $stokDipakai = Perawatan::where('alat_id', $item->alat_id)
                ->where('status', '!=', 'diperbaiki')
                ->where('id', '!=', $item->id)
                ->sum('jumlah');

            $stokTersedia = $stokAlat - $stokDipakai;

            return [
                'id' => $item->id,
                'no' => $i + 1 + ($perawatan->currentPage() - 1) * $perawatan->perPage(),
                'tanggal' => Carbon::parse($item->tanggal)->format('d/m/Y'),
                'alat' => $item->alat->nama_alat ?? '-',
                'jumlah' => $item->jumlah,
                'teknisi' => $item->teknisi,
                'status' => strtoupper(str_replace('_', ' ', $item->status)),
                'can_edit' => $item->status !== 'diperbaiki',
            ];
        });

        return view('livewire.admin.perawatan-alat', [
            'rows' => $rows,
            'pagination' => $perawatan,
        ]);
    }
}