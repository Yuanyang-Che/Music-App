<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }


    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
