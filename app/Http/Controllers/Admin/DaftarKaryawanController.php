<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // pastikan modelnya benar

class DaftarKaryawanController extends Controller
{
    public function index()
    {
        $karyawan = User::where('role', 'karyawan')->get();

        $rows = $karyawan->map(function ($item, $index) {
            return [
                $index + 1,
                $item->name,
                $item->divisi ?? '-',
                $item->created_at->format('d/m/Y H:i'),
                $item->id, // penting untuk edit/delete
            ];
        });

        return view('layouts.admin.daftarKaryawan', [
            'mode' => 'table',
            'columns' => ['No', 'Nama', 'Divisi', 'Waktu Terdaftar'],
            'rows' => $rows,
            'actions' => ['delete']
        ]);
    }

    public function tambahAkun()
    {
        return view('layouts.admin.daftarKaryawan', [
            'mode' => 'tambahAkun'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'divisi' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
        ]);

        $karyawan = User::create([
            'name' => $request->name,
            'divisi' => $request->divisi,
            'email' => $request->email,
            'role' => 'karyawan',
            'password' => bcrypt($request->password),
        ]);

        $waktuDaftar = $karyawan->created_at->format('d/m/Y H:i');

        return redirect()->route('admin.daftarKaryawan')
            ->with('success', "Karyawan berhasil ditambahkan pada $waktuDaftar.");
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('admin.daftarKaryawan')->with('success', 'Karyawan berhasil dihapus.');
    }
}