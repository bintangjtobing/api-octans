<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'jumlah',
        'kategori_anggaran_id',
        'kategori_transaksi_id',
        'user_id',
    ];
}
