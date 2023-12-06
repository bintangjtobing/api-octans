<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informasiBisnis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bisnis',
        'alamat',
        'no_tax',
        'website',
        'email',
        'logo',
        'no_handphone',
        'jabatan',
        'user_id'
    ];
}
