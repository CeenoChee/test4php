<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Download;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DownloadRepository extends EloquentRepository
{
    public function search(string $keyword): LengthAwarePaginator
    {
        return $this->model
            ->with('transes')
            ->whereHas('transes', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
                $q->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->orWhere('version', $keyword)
            ->paginate()
            ->withQueryString();
    }

    protected function setModel()
    {
        $this->model = new Download();
    }
}
