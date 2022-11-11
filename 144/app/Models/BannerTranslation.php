<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class BannerTranslation extends Model
{
    use HasFactory;

    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_model')->withPivot('collection_name');
    }

    public function getLogoMedia()
    {
        $this->loadMissing('media');

        return $this->media->firstWhere('pivot.collection_name', 'logo');
    }

    public function getImageMedia()
    {
        $this->loadMissing('media');

        return $this->media->firstWhere('pivot.collection_name', 'image');
    }
}
