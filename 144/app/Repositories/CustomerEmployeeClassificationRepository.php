<?php

namespace App\Repositories;

use App\Models\CustomerEmployeeCategory;
use App\Models\CustomerEmployeeCategoryItem;
use App\Models\CustomerEmployeeClassification;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CustomerEmployeeClassificationRepository
{
    private CustomerEmployeeClassification $customerEmployeeClassification;

    public function __construct()
    {
        $this->customerEmployeeClassification = new CustomerEmployeeClassification();
    }

    public function setValue(int $customerId, int $customerEmployeeId, int $customerEmployeeCategoryId, int $customerEmployeeCategoryItemId, bool $hasPermission)
    {
        $customerEmployeeClassification = $this->customerEmployeeClassification->where([
            'Ugyfel_ID' => $customerId,
            'UgyfelDolgozo_ID' => $customerEmployeeId,
            'UgyfelDolgozoKategoria_ID' => $customerEmployeeCategoryId,
            'UgyfelDolgozoKategoriaTetel_ID' => $customerEmployeeCategoryItemId,
        ])->first();

        if ($hasPermission && ! $customerEmployeeClassification) {
            $now = Carbon::now();

            $this->customerEmployeeClassification->insert([
                'Ugyfel_ID' => $customerId,
                'UgyfelDolgozo_ID' => $customerEmployeeId,
                'UgyfelDolgozoKategoria_ID' => $customerEmployeeCategoryId,
                'UgyfelDolgozoKategoriaTetel_ID' => $customerEmployeeCategoryItemId,
                'FelvDatum' => $now,
                'ModDatum' => $now,
            ]);
        }

        if (! $hasPermission && $customerEmployeeClassification) {
            $customerEmployeeClassification->delete();
        }
    }

    public function getPermissions(int $customerId, int $customerEmployeeId): Collection
    {
        $customerEmployeeClassificationTable = $this->customerEmployeeClassification->getTable();

        return $this->customerEmployeeClassification
            ->where("{$customerEmployeeClassificationTable}.Ugyfel_ID", $customerId)
            ->where("{$customerEmployeeClassificationTable}.UgyfelDolgozo_ID", $customerEmployeeId)
            ->whereIn("{$customerEmployeeClassificationTable}.UgyfelDolgozoKategoria_ID", [
                CustomerEmployeeCategory::PERMISSION_TAKE_OVER_CATEGORY_ID,
                CustomerEmployeeCategory::PERMISSION_WEB_CATEGORY_ID,
                CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID,
            ])
            ->join((new CustomerEmployeeCategoryItem())->getTable() . ' as ceci', function ($join) use ($customerEmployeeClassificationTable) {
                $join->on("{$customerEmployeeClassificationTable}.UgyfelDolgozoKategoria_ID", '=', 'ceci.UgyfelDolgozoKategoria_ID')
                    ->whereColumn("{$customerEmployeeClassificationTable}.UgyfelDolgozoKategoriaTetel_ID", 'ceci.UgyfelDolgozoKategoriaTetel_ID')
                    ->where('Kod', '!=', 'ES2');
            })
            ->get();
    }
}
