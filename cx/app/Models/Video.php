<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public function scopeKeyword($query, $keyword)
    {
        return $query->where('title', 'LIKE', '%' . $keyword . '%');
    }
}
