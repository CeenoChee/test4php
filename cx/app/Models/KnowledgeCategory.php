<?php

namespace App\Models;

use App\Traits\HasMedia;
use App\Traits\WithAndWhereHas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kalnoy\Nestedset\NodeTrait;

class KnowledgeCategory extends Model
{
    use HasFactory;
    use WithAndWhereHas;
    use NodeTrait;
    use HasMedia;

    protected $table = 'knowledge_categories';

    public function knowledges(): BelongsToMany
    {
        return $this->belongsToMany(Knowledge::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(KnowledgeCategoryTranslation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(KnowledgeCategoryTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->withAndwhereHas('knowledges', function ($query) {
                $query->where([
                    ['knowledges.active', 1],
                    ['knowledges.published_at', '<=', Carbon::now()],
                ])
                    ->with('translation')
                    ->has('translation');
            });
            $q->orWhere(function ($q2) {
                $q2->hasChildren();
            });
        })->has('translation');
    }

    public function scopeKeyword($query, $keyword)
    {
        $categoryTransTable = (new KnowledgeCategoryTranslation())->getTable();

        return $query
            ->join($categoryTransTable, self::getTable() . '.id', '=', $categoryTransTable . '.knowledge_category_id')
            ->where($categoryTransTable . '.Nyelv_ID', app('Lang')->getLanguageId())
            ->where(function ($query) use ($keyword, $categoryTransTable) {
                $query->where("{$categoryTransTable}.name", 'LIKE', "%{$keyword}%")
                    ->orWhere("{$categoryTransTable}.brief", 'LIKE', "%{$keyword}%");
            });
    }
}
