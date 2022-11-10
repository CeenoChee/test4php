<?php

namespace App\Repositories;

use App\Models\CustomerPremise;

class CustomerPremiseRepository extends EloquentRepository
{
    public function getMaxCustomerPremiseIdByCustomerId(int $customerId): int
    {
        return (int) $this->model->where('Ugyfel_ID', $customerId)->max('UgyfelTelephely_ID');
    }

    public function getMaxCode(int $customerId): int
    {
        return intval(
            $this->model
                ->query()
                ->selectRaw('MAX(CAST(Kod AS UNSIGNED)) as Kod')
                ->where('Ugyfel_ID', $customerId)
                ->whereRaw("Kod REGEXP '^[0-9]{0,999}$'")
                ->value('Kod')
        );
    }

    public function findByCompositeKeys(int $customerId, int $customerPremiseId, array $select = ['*'])
    {
        return $this->model
            ->select($select)
            ->where([
                ['Ugyfel_ID', $customerId],
                ['UgyfelTelephely_ID', $customerPremiseId],
            ])
            ->firstOrFail();
    }

    public function getByCustomerId(int $customerId, array $with = [])
    {
        return $this->model->where('Ugyfel_ID', $customerId)->with($with)->get();
    }

    public function getEnabledByCustomerId(int $customerId, array $with = [])
    {
        return $this->model
            ->where([
                ['Ugyfel_ID', $customerId],
                ['Hasznalhato', 1],
            ])
            ->with($with)
            ->get();
    }

    public function isSyncronized(int $id): bool
    {
        return $this->model->where([
            ['id', $id],
            ['UgyfelTelephely_ID', '!=', null],
        ])->count();
    }

    protected function setModel()
    {
        $this->model = new CustomerPremise();
    }
}
