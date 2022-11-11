<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Manufacturer;
use Illuminate\Support\Collection;

class ManufacturerRepository extends EloquentRepository
{
    public function homePageManufacturers(): Collection
    {
        return $this->model->query()
            ->whereActive(1)
            ->whereNotIn('Gyarto_ID', $this->model->getBlacklistedIds())
            ->with('trans')
            ->orderBy('sort')
            ->get();
    }

    public function warrantyPageManufacturers(): Collection
    {
        return $this->model->query()
            ->whereWarrantyActive(1)
            ->whereNotIn('Gyarto_ID', $this->model->getBlacklistedIds())
            ->with('trans')
            ->orderBy('sort')
            ->get();
    }

    protected function setModel()
    {
        $this->model = new Manufacturer();
    }
}
