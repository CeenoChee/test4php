<?php

namespace App\Traits;

use App\Models\Media;

trait HasMedia
{
    public function media()
    {
        return $this->morphToMany(Media::class, 'model', 'media_model');
    }

    public function getMediaByCollection(string $collectionName)
    {
        return $this->media()->where('media.collection_name', $collectionName);
    }
}
