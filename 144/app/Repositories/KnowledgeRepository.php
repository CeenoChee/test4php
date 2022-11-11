<?php

namespace App\Repositories;

use App\Models\Knowledge;
use Carbon\Carbon;

class KnowledgeRepository
{
    protected Knowledge $knowledge;

    public function __construct()
    {
        $this->knowledge = new Knowledge();
    }

    public function getActive()
    {
        return $this->knowledge
            ->has('translation')
            ->where([
                ['active', 1],
                ['published_at', '<=', Carbon::now()],
            ])
            ->get();
    }

    public function firstActiveBySlug(string $slug)
    {
        return $this->knowledge
            ->withAndWhereHas('translation', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->has('translation')
            ->where([
                ['active', 1],
                ['published_at', '<=', Carbon::now()],
            ])
            ->first();
    }

    public function getActiveByKeyword(string $keyword)
    {
        return $this->knowledge
            ->active()
            ->with('translation', 'categories')
            ->has('translation')
            ->has('categories')
            ->keyword($keyword)
            ->get();
    }
}
