<?php

namespace App\Repositories;

use App\Models\CustomerEmployeeCategory;
use App\Models\CustomerEmployeeCategoryItem;
use Illuminate\Support\Collection;

class CustomerEmployeeCategoryItemRepository extends EloquentRepository
{
    public function getWithoutEs2(): Collection
    {
        return $this->model
            ->whereIn('UgyfelDolgozoKategoria_ID', [
                CustomerEmployeeCategory::PERMISSION_TAKE_OVER_CATEGORY_ID,
                CustomerEmployeeCategory::PERMISSION_WEB_CATEGORY_ID,
                CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID,
            ])
            ->where('Kod', '!=', 'ES2')
            ->orderByRaw("FIELD(Nev , 'Ügyfél adminisztrátor', 'Rendelhet', 'Igen', 'Pénzügy', 'E-számla elsődleges', 'Fizetési felszólítást kap', 'Szerviz') ASC")
            ->get();
    }

    protected function setModel()
    {
        $this->model = new CustomerEmployeeCategoryItem();
    }
}
