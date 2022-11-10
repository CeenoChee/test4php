<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\ShippingAddress;

class ShippingAddressRepository
{
    protected ShippingAddress $shippingAddress;

    public function __construct()
    {
        $this->shippingAddress = new ShippingAddress();
    }

    public function all()
    {
        return $this->shippingAddress->all();
    }

    public function find(array $ids)
    {
        return $this->shippingAddress->find($ids);
    }

    public function findByParameters($parameters)
    {
        return $this->shippingAddress->where($parameters)->first();
    }

    public function getMaxShippingAddressIdByCustomerId(int $customerId): int
    {
        return (int) $this->shippingAddress->where('Ugyfel_ID', $customerId)->max('UgyfelCim_ID');
    }

    public function getByCustomer(Customer $customer)
    {
        return $customer->shippingAddresses()
            ->with(['country', 'agent', 'customer'])
            ->where('Hasznalhato', 1)
            ->orderByDesc('AlapCim')
            ->orderByRaw('ISNULL(UgyfelTelephely_ID), UgyfelTelephely_ID ASC')
            ->orderBy('UgyfelCim_ID')
            ->get();
    }

    public function getPremisesByCustomer(Customer $customer)
    {
        return $customer->shippingAddresses()
            ->with(['country', 'agent', 'customer'])
            ->where(function ($q) {
                $q->orWhereNotNull('UgyfelTelephely_ID');
                $q->orWhere('AlapCim', 1);
            })
            ->orderByDesc('AlapCim')
            ->orderByRaw('ISNULL(UgyfelTelephely_ID), UgyfelTelephely_ID ASC')
            ->orderBy('UgyfelCim_ID')
            ->get();
    }
}
