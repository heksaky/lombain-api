<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LombaRequest extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
        'kategori',
        'penyelenggara',
        'deadline',
        'link_daftar',
        'target',
        'gratis',
        'persyaratan',
        'timeline',
        'foto_poster',
        'catatan',
        'status',
        'alasan_tolak',
    ];

    protected $casts = [
        'gratis'   => 'boolean',
        'deadline' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}