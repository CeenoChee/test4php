<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Sale extends Model
{
    public function images(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_model')
            ->where('custom_properties->public', 'true');
    }
}
