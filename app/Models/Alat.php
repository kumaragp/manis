<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'alat';

    protected $fillable = [
        'nama_alat',
        'jumlah_alat',
        'harga',
        'status',
        'gambar',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'alat_id');
    }

    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class, 'alat_id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'alat_id');
    }

    public function perawatan()
    {
        return $this->hasMany(Perawatan::class, 'alat_id');
    }

}