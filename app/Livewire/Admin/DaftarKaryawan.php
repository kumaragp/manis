<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Validator;

class DaftarKaryawan extends Component
{
    public $mode = 'table'; // table, tambah, edit
    public $data = null;

    public $columns = ['No', 'Nama', 'Divisi', 'Token'];
    public $rows = [];

    // Form fields
    public $email;
    public $name;
    public $divisi;
    public $token;

    public $editId = null;

    protected $listeners = [
        'delete-data' => 'delete'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $karyawan = User::where('role', 'karyawan')->get();

        $this->rows = $karyawan->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'name' => $item->name,
                'divisi' => $item->divisi ?? '-',
                'token' => $item->token ?? '-',
                'id' => $item->id
            ];
        })->toArray();
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
        // Generate token terlebih dahulu untuk validasi uniqueness
        $token = strtoupper(Str::random(8));

        $validator = Validator::make([
            'name' => $this->name,
            'divisi' => $this->divisi,
            'email' => $this->email,
            'token' => $token,
        ], [
            'name' => 'required|string|unique:users,name',
            'divisi' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'token' => 'unique:users,token',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('email')) {
                $this->dispatch('toast', type: 'error', message: 'Email sudah terdaftar');
            } elseif ($validator->errors()->has('name')) {
                $this->dispatch('toast', type: 'error', message: 'Nama sudah terdaftar');
            } elseif ($validator->errors()->has('token')) {
                $this->dispatch('toast', type: 'error', message: 'Terjadi duplikasi token, coba lagi');
            } else {
                $this->dispatch('toast', type: 'error', message: 'Terjadi kesalahan validasi');
            }
            return;
        }

        User::create([
            'name' => $this->name,
            'divisi' => $this->divisi,
            'email' => $this->email,
            'role' => 'karyawan',
            'token' => $token,
            'password' => Hash::make($token),
        ]);

        $this->dispatch('toast', type: 'success', message: 'Karyawan berhasil ditambahkan');
        $this->mode = 'table';
        $this->loadData();
        $this->resetForm();
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
        $this->loadData();
        $this->resetForm();
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

        $this->loadData();
    }

    public function delete($id)
    {
        $Karyawan = User::findOrFail($id);

        $Karyawan->delete();
        $this->loadData();
        $this->dispatch(
            event: 'toast',
            type: 'success',
            message: 'Karyawan berhasil dihapus'
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.daftar-karyawan');
    }
}