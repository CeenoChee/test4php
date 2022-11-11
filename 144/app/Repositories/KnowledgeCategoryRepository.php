<?php

namespace App\Repositories;

use App\Models\KnowledgeCategory;

class KnowledgeCategoryRepository
{
    protected KnowledgeCategory $knowledgeCategory;

    public function __construct()
    {
        $this->knowledgeCategory = new KnowledgeCategory();
    }

    public function firstActiveBySlug(string $slug)
    {
        return $this->knowledgeCategory
            ->withAndWhereHas('translation', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->active()
            ->with(['knowledges.videos','descendants'])
            ->first();
    }

    public function getActive()
    {
        return $this->knowledgeCategory
            ->active()
            ->with(['knowledges.videos', 'translation'])
            ->get();
    }

    public function getRoots()
    {
        return $this->knowledgeCategory
            ->active()
            ->with(['knowledges', 'translation'])
            ->whereNull('parent_id')
            ->get();
    }

    public function getActiveChildren(KnowledgeCategory $category)
    {
        return $this->knowledgeCategory
            ->active()
            ->where('parent_id', $category->id)
            ->with(['knowledges.videos', 'translation'])
            ->get();
    }

    public function getActiveByKeyword(string $keyword)
    {
        return $this->knowledgeCategory
            ->active()
            ->with(['knowledges', 'translation'])
            ->keyword($keyword)
            ->get();
    }
}
