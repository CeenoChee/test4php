<?php

namespace App\Repositories;

use App\Libs\Fct;
use App\Libs\UserInfo;
use App\Models\Customer;
use App\Services\PermissionService;

class CustomerRepository extends EloquentRepository
{
    public function getEmployees($customerId): array
    {
        $customer = $this->model->where('Ugyfel_ID', $customerId)->first();

        if (! $customer) {
            return [];
        }

        $employees = [];

        foreach ($customer->invitedUsers as $user) {
            $employee = new \stdClass();
            $employee->userId = $user->id;
            $employee->customerId = null;
            $employee->customerEmployeeId = null;
            $employee->name = $user->getName();
            $employee->mail = $user->email;
            $employee->position = $user->Beosztas;
            $employee->invited = (bool) $user->invited_at;
            $employees[$user->email] = $employee;
            $employee->active = $user->Hasznalhato;
        }

        foreach ($customer->customerEmployees()->with('user')->get() as $customerEmployees) {
            $employee = new \stdClass();
            $employee->userId = ($customerEmployees->user ? $customerEmployees->user->id : null);
            $employee->customerId = $customerEmployees->Ugyfel_ID;
            $employee->customerEmployeeId = $customerEmployees->UgyfelDolgozo_ID;
            $employee->name = $customerEmployees->Nev;
            $employee->mail = $customerEmployees->WebLogin;
            $employee->position = $customerEmployees->Beosztas;
            $employee->invited = ($customerEmployees->user && $customerEmployees->user->invited_at);
            $employee->active = $customerEmployees->Hasznalhato;
            $employee->permissions = $employee->userId ? (new PermissionService())->getPermissionsByUserId($employee->userId) : (new PermissionService())->getPermissions();

            if ($customerEmployees->WebLogin) {
                $employees[$customerEmployees->WebLogin] = $employee;
            } else {
                $employees[] = $employee;
            }
        }

        usort($employees, [$this, 'cmpEmployees']);

        return $employees;
    }

    public function getAdminUsers(Customer $customer): array
    {
        $users = [];
        $customerEmployees = $customer->customerEmployees()->with('user')->get();
        foreach ($customerEmployees as $customerEmployee) {
            $userInfo = new UserInfo($customerEmployee->user);
            if ($userInfo->isCustomerAdmin()) {
                $users[] = $userInfo;
            }
        }

        return $users;
    }

    public function getPaymentMethodIdById($id)
    {
        return $this->model->where('Ugyfel_ID', $id)->value('FizetesiMod_ID');
    }

    public function isCompetitor(int $id): bool
    {
        return $this->model->where('Ugyfel_ID', $id)->value('Konkurencia');
    }

    protected function setModel()
    {
        $this->model = new Customer();
    }

    private function cmpEmployees($a, $b): int
    {
        return strcmp(Fct::slugify($a->name), Fct::slugify($b->name));
    }
}
