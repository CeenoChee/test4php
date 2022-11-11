<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faq extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'int',
    ];

    /**
     * Forditas relationship.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     * Rendszer nyelvi forditas.
     */
    public function trans(): HasOne
    {
        return $this->hasOne(FaqTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }
}
