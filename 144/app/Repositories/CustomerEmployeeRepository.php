<?php

namespace App\Repositories;

use App\Models\CustomerEmployee;

class CustomerEmployeeRepository
{
    protected CustomerEmployee $customerEmployee;

    public function __construct()
    {
        $this->customerEmployee = new CustomerEmployee();
    }

    public function getCustomerEmployees(int $customerId)
    {
        return $this->customerEmployee->where('Ugyfel_ID', $customerId)->orderBy('Nev')->with('user')->get();
    }

    public function getCustomerEmployee(int $customerId, int $customerEmployeeId)
    {
        return $this->customerEmployee->where('Ugyfel_ID', $customerId)->where('UgyfelDolgozo_ID', $customerEmployeeId)->first();
    }

    public function getByWebLogin($webLogin)
    {
        return $this->customerEmployee->where('WebLogin', $webLogin)->first();
    }

    public function getBySecondaryEmail($email)
    {
        return $this->customerEmployee->where('MasodlagosEmail', $email)->first();
    }
}
