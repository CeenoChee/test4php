<?php

namespace App\Models;

use App\Traits\HasMedia;
use App\Traits\WithAndWhereHas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kalnoy\Nestedset\NodeTrait;

class DownloadCategory extends Model
{
    use HasFactory;
    use NodeTrait;
    use HasMedia;
    use WithAndWhereHas;

    protected $guarded = [];

    /**
     * Forditas relationship.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(DownloadCategoryTranslation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(DownloadCategoryTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    /**
     * Rendszer nyelvi forditas.
     */
    public function trans(): HasOne
    {
        return $this->hasOne(DownloadCategoryTranslation::class)->where('Nyelv_ID', Language::HU);
    }

    public function downloads()
    {
        return $this->belongsToMany(Download::class, 'download_download_category');
    }
}
