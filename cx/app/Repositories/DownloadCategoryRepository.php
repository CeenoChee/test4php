<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DownloadCategory;

class DownloadCategoryRepository extends EloquentRepository
{
    public function list()
    {
        return $this->model->with(['translation', 'downloads'])->get();
    }

    public function firstOrFailBySlug(string $slug)
    {
        return $this->model->with(['translation', 'downloads'])->whereHas('translation', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->firstOrFail();
    }

    public function getRoots()
    {
        return $this->model
            ->with(['downloads', 'translation'])
            ->whereNull('parent_id')
            ->get();
    }

    public function getChildren(DownloadCategory $category)
    {
        return $this->model
            ->where('parent_id', $category->id)
            ->with(['downloads', 'translation'])
            ->get();
    }

    protected function setModel()
    {
        $this->model = new DownloadCategory();
    }
}
