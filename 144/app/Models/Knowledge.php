<?php

namespace App\Models;

use App\Traits\WithAndWhereHas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Knowledge extends Model
{
    use HasFactory;
    use WithAndWhereHas;
    use SoftDeletes;

    protected $table = 'knowledges';

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(KnowledgeCategory::class);
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(KnowledgeTranslation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(KnowledgeTranslation::class)->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    public function scopeKeyword($query, $keyword)
    {
        $knowledgeTransTable = (new KnowledgeTranslation())->getTable();

        return $query
            ->join($knowledgeTransTable, self::getTable() . '.id', '=', $knowledgeTransTable . '.knowledge_id')
            ->where($knowledgeTransTable . '.Nyelv_ID', app('Lang')->getLanguageId())
            ->where(function ($query) use ($keyword, $knowledgeTransTable) {
                $query->where("{$knowledgeTransTable}.title", 'LIKE', "%{$keyword}%")
                    ->orWhere("{$knowledgeTransTable}.brief", 'LIKE', "%{$keyword}%")
                    ->orWhere("{$knowledgeTransTable}.body_stripped", 'LIKE', "%{$keyword}%");
            });
    }

    public function scopeActive($query)
    {
        return $query->where([
            ['knowledges.active', 1],
            ['knowledges.published_at', '<=', Carbon::now()],
        ])->with('translation')->has('translation');
    }

    public function isActive()
    {
        return $this->active && $this->published_at <= Carbon::now() && $this->has('translation');
    }
}
