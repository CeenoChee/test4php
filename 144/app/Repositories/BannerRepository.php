<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Banner;

class BannerRepository extends EloquentRepository
{
    /**
     * Fooldali banner.
     */
    public function homePageBanner(): ?Banner
    {
        $today = today();

        return $this->model->query()->whereActive(1)
            ->with('trans.media')
            ->inRandomOrder()
            ->where(function ($query) use ($today) {
                $query->whereDate('valid_start', '<=', $today)
                    ->orWhereNull('valid_start');
            })
            ->where(function ($query) use ($today) {
                $query->whereDate('valid_end', '>=', $today)
                    ->orWhereNull('valid_end');
            })
            ->first()
        ;
    }

    protected function setModel()
    {
        $this->model = new Banner();
    }
}
