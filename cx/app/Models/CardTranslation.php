<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class CardTranslation extends Model
{
    use HasFactory;

    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_model');
    }
}
