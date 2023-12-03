<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_transaksi_id',
        'kategori_anggaran_id',
        'user_id',
    ];
}
