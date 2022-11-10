<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Banner extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'int',
        'valid_start' => 'datetime:Y-m-d',
        'valid_end' => 'datetime:Y-m-d',
    ];

    /**
     * Forditas relationship.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(BannerTranslation::class);
    }

    /**
     * Rendszer nyelvi forditas.
     */
    public function trans(): HasOne
    {
        return $this->hasOne(BannerTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }
}
