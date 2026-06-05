<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumRequest extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'no_hp',
        'bukti_bayar',
        'status',
        'alasan_tolak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}