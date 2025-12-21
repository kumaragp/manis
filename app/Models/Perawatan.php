<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    protected $table = 'perawatan';

    protected $fillable = [
        'alat_id',
        'tanggal',
        'jumlah',
        'status',
        'teknisi',
        'deskripsi',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id')->withTrashed();
    }
}