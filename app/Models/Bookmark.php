<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id', 'lomba_id'];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}