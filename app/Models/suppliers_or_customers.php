<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliers_or_customers extends Model
{

    use HasFactory;

    protected $fillable = [
        'nama_bisnis',
        'alamat',
        'email',
        'no_hp',
        'jenis_transaksi_id',
        'user_id'
    ];
}
