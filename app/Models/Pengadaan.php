<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengadaan extends Model
{
    use HasFactory;
    protected $table = 'pengadaan';

    protected $fillable = [
        'alat_id',
        'nama_alat',
        'jumlah',
        'harga',
        'vendor',
        'tanggal_pengadaan'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}