<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';

    protected $fillable = [
        'alat_id',
        'pembeli',
        'jumlah',
        'harga_jual',
        'tanggal_penjualan',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id')->withTrashed();
    }
}