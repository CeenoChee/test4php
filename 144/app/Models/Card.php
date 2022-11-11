<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sort' => 'int',
        'active' => 'int',
        'valid_start' => 'datetime:Y-m-d',
        'valid_end' => 'datetime:Y-m-d',
    ];

    /**
     * Forditas relationship.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CardTranslation::class);
    }

    /**
     * Rendszer nyelvi forditas.
     */
    public function trans(): HasOne
    {
        return $this->hasOne(CardTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }
}
