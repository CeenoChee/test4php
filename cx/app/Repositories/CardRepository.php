<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Card;
use Illuminate\Support\Collection;

class CardRepository extends EloquentRepository
{
    /**
     * Fooldali kartyak.
     */
    public function homePageCards(): Collection
    {
        return $this->model->query()->whereActive(1)
            ->with('trans.media')
            ->where(function ($query) {
                $query->whereDate('valid_start', '<=', today())
                    ->orWhereNull('valid_start');
            })
            ->where(function ($query) {
                $query->whereDate('valid_end', '>=', today())
                    ->orWhereNull('valid_end');
            })
            ->orderBy('sort')
            ->get()
        ;
    }

    protected function setModel()
    {
        $this->model = new Card();
    }
}
