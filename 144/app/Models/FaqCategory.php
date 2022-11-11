<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FaqCategory extends Model
{
    use HasFactory;

    /**
     * Faq.
     */
    public function faqs(): BelongsToMany
    {
        return $this->belongsToMany(Faq::class)->orderByPivot('sort');
    }

    /**
     * Forditas relationship.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(FaqCategoryTranslation::class);
    }

    /**
     * Rendszer nyelvi forditas.
     */
    public function trans(): HasOne
    {
        return $this->hasOne(FaqCategoryTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }
}
