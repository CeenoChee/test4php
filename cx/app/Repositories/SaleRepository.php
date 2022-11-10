<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Libs\Lang;
use App\Models\Sale;
use Carbon\Carbon;

class SaleRepository extends EloquentRepository
{
    public function list(array $with = [])
    {
        return $this->model
            ->with($with)
            ->where('Nyelv_ID', (new Lang())->getLanguageId())
            ->whereDate('DatumTol', '<=', Carbon::now())
            ->whereDate('DatumIg', '>=', Carbon::now())
            ->orderBy('sort')
            ->get();
    }

    protected function setModel()
    {
        $this->model = new Sale();
    }
}
