<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DaftarKaryawanController extends Controller
{
    public function index()
    {
        $karyawan = User::where('role', 'karyawan')->get();

        $rows = $karyawan->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'name' => $item->name,
                'divisi' => $item->divisi ?? '-',
                'token' => $item->token ?? '-',
                'id' => $item->id,
            ];
        });

        return view('layouts.admin.daftarKaryawan', [
            'mode' => 'table',
            'columns' => ['No','Nama','Divisi','Token'],
            'rows' => $rows,
            'actions' => ['edit','reset','delete'],
            'idField' => 'id'
        ]);
    }

    public function tambahAkun()
    {
        return view('layouts.admin.daftarKaryawan', [
            'mode' => 'tambah'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'divisi' => 'required',
            'email' => 'required|email|unique:users,email'
        ]);

        $token = strtoupper(Str::random(8));

        User::create([
            'name' => $request->name,
            'divisi' => $request->divisi,
            'email' => $request->email,
            'role' => 'karyawan',
            'token' => $token,
            'password' => Hash::make($token),
        ]);

        return redirect()->route('admin.karyawan')
            ->with('success', "Karyawan berhasil ditambahkan");
    }

    public function edit($id)
    {
        return view('layouts.admin.daftarKaryawan', [
            'mode' => 'edit',
            'data' => User::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $k = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'divisi' => 'required',
            'email' => 'required|email|unique:users,email,' . $k->id
        ]);

        $k->update([
            'name' => $request->name,
            'divisi' => $request->divisi,
            'email' => $request->email
        ]);

        return redirect()->route('admin.karyawan')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $k = User::findOrFail($id);

        $newToken = Str::upper(Str::random(8));

        $k->update([
            'token' => $newToken,
            'password' => Hash::make($newToken)
        ]);

        return redirect()->back()->with('success', "Token sudah berhasil di reset");
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil dihapus.');
    }
}