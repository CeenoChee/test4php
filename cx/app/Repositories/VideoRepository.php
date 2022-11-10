<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Video;

class VideoRepository extends EloquentRepository
{
    public function search(string $keyword)
    {
        return $this->model->where('title', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%')->orderBy('title')->get();
    }

    public function getMostPopular()
    {
        return $this->model->orderBy('views', 'desc')->orderBy('likes', 'desc')->take(5)->get();
    }

    protected function setModel()
    {
        $this->model = new Video();
    }
}
