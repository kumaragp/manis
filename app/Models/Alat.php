<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    protected $fillable = [
        'nama_alat',
        'jumlah_alat',
        'gambar',
        'status',
        'tanggal_event',
        'harga',
        'vendor',
        'tujuan',
    ];

    protected $casts = [
        'tanggal_event' => 'date',
        'harga' => 'integer',
        'jumlah_alat' => 'integer',
    ];
}
