<?php

namespace App\Models;

use App\Interfaces\HasTranslation;
use App\Traits\HasMedia;
use App\Traits\Translations\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model implements HasTranslation
{
    use Translatable;
    use HasFactory;
    use HasMedia;

    public function categories()
    {
        return $this->belongsToMany(DownloadCategory::class, 'download_download_category');
    }

    public function getDownload()
    {
        return $this->getMediaByCollection('download')->first();
    }

    public function getIcon()
    {
        return $this->getMediaByCollection('icon')->first();
    }

    public function scopeKeyword($query, $keyword)
    {
        return $query->where('version', 'LIKE', '%' . $keyword . '%');
    }
}
