<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'singkatan',
        'warna',
        'teks_warna',
        'gratis',
        'penyelenggara',
        'deadline',
        'link_daftar',
        'target',
    ];

    protected $casts = [
        'gratis' => 'boolean',
        'deadline' => 'date',
    ];
}