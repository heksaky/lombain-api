<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'judul', 'ringkasan', 'konten', 'foto', 'kategori', 'penulis'
        'judul',
        'ringkasan',
        'konten',
        'kategori',
        'penulis',
        'foto'
    ];
}