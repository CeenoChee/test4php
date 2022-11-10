<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Media;

class MediaRepository extends EloquentRepository
{
    public function firstByFilename(string $filename)
    {
        return $this->model->where('file_name', $filename)->first();
    }

    protected function setModel()
    {
        $this->model = new Media();
    }
}
