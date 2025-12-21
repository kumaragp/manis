<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';

    protected $fillable = [
        'alat_id',
        'karyawan_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];
    
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
    
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];
}