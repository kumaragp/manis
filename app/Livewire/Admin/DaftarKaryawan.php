<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class DaftarKaryawan extends Component
{
    use WithPagination;

    public $mode = 'table';
    public $data = null;

    public $columns = ['No', 'Nama', 'Divisi', 'Token'];
    public $rows = [];

    // Form fields
    public $email;
    public $name;
    public $divisi;
    public $token;
    public $editId = null;

    // Search & Sorting
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    public function searchData()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $query = User::where('role', 'karyawan')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy($this->sortField, $this->sortDirection);

        $karyawan = $query->paginate($this->perPage);

        $this->rows = $karyawan->map(function ($item, $index) use ($karyawan) {
            return [
                'no' => $karyawan->firstItem() + $index,
                'name' => $item->name,
                'divisi' => $item->divisi ?? '-',
                'token' => $item->token ?? '-',
                'id' => $item->id
            ];
        })->toArray();

        return $karyawan; // untuk pagination links di Blade
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function showTambah()
    {
        $this->resetForm();
        $this->mode = 'tambah';
    }

    public function openModal($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $id;
        $this->email = $user->email;
        $this->name = $user->name;
        $this->divisi = $user->divisi;
        $this->token = $user->token;

        $this->mode = 'edit';
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->email = '';
        $this->name = '';
        $this->divisi = '';
        $this->token = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'divisi' => 'required',
            'email' => 'required|email|unique:users,email'
        ]);

        $token = strtoupper(Str::random(8));

        User::create([
            'name' => $this->name,
            'divisi' => $this->divisi,
            'email' => $this->email,
            'role' => 'karyawan',
            'token' => $token,
            'password' => Hash::make($token),
        ]);

        $this->dispatch(
            event: 'toast',
            type: 'success',
            message: 'Karyawan berhasil ditambahkan'
        );

        $this->mode = 'table';
        $this->resetForm();
        $this->resetPage();
    }

    public function update()
    {
        $user = User::findOrFail($this->editId);

        $this->validate([
            'name' => 'required',
            'divisi' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->update([
            'name' => $this->name,
            'divisi' => $this->divisi,
            'email' => $this->email
        ]);

        $this->dispatch(
            event: 'toast',
            type: 'success',
            message: 'Karyawan berhasil diperbarui'
        );

        $this->mode = 'table';
        $this->resetForm();
        $this->resetPage();
    }

    public function resetToken($id)
    {
        $user = User::findOrFail($id);
        $newToken = Str::upper(Str::random(8));

        $user->update([
            'token' => $newToken,
            'password' => Hash::make($newToken)
        ]);

        $this->dispatch(
            event: 'toast',
            type: 'success',
            message: 'Token sudah berhasil di reset'
        );

        $this->resetPage();
    }

    public function delete($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        $this->dispatch(
            event: 'toast',
            type: 'success',
            message: 'Karyawan berhasil dihapus'
        );

        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $karyawanPagination = $this->loadData(); // ambil data paginasi
        return view('livewire.admin.daftar-karyawan', [
            'karyawanPagination' => $karyawanPagination
        ]);
    }
}