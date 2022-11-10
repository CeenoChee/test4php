<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\VideoCategory;

class VideoCategoryRepository extends EloquentRepository
{
    public function list()
    {
        return $this->model->with('videos')->orderBy('name')->get();
    }

    public function firstOrFailBySlug(string $slug)
    {
        return $this->model->with('videos')->where('slug', $slug)->firstOrFail();
    }

    protected function setModel()
    {
        $this->model = new VideoCategory();
    }
}
