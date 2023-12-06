<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class feedbackCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'deskripsi',
        'no_feedback',
        'info_tambahan',
        'progres',
        'user_id',
        'lampiran',
        'excerpt'
    ];

    public function progres_dev_by() : BelongsTo
    {
        return $this->belongsTo(User::class, 'progres_by', 'id');
    }

    public function users_id() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
