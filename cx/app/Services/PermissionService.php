<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CustomerEmployeeCategory;
use App\Models\CustomerEmployeeCategoryItem;
use App\Repositories\CustomerEmployeeCategoryItemRepository;
use App\Repositories\CustomerEmployeeClassificationRepository;
use App\Repositories\CustomerEmployeeRepository;
use App\Repositories\UserRepository;

class PermissionService
{
    public function getPermissions(): array
    {
        return (new CustomerEmployeeCategoryItemRepository())
            ->getWithoutEs2()
            ->map(fn (CustomerEmployeeCategoryItem $categoryItem) => $this->makePermission($categoryItem))
            ->toArray();
    }

    public function getPermissionsByUserId(int $userId): array
    {
        $userEmail = (new UserRepository())->getEmailById($userId);

        $customerEmployee = (new CustomerEmployeeRepository())->getByWebLogin($userEmail);

        return $this->getPermissionsByCustomerIdAndCustomerEmployeeId((int) $customerEmployee->Ugyfel_ID, (int) $customerEmployee->UgyfelDolgozo_ID);
    }

    public function getPermissionsByCustomerIdAndCustomerEmployeeId(int $customerId, int $customerEmployeeId): array
    {
        $customerPermissions = (new CustomerEmployeeClassificationRepository())
            ->getPermissions($customerId, $customerEmployeeId);

        $permissions = (new CustomerEmployeeCategoryItemRepository())
            ->getWithoutEs2();

        return $permissions->map(fn (CustomerEmployeeCategoryItem $categoryItem) => $this->makePermission($categoryItem, $customerPermissions))
            ->toArray();
    }

    protected function makePermission(CustomerEmployeeCategoryItem $categoryItem, $customerPermissions = null): \stdClass
    {
        $permission = new \stdClass();
        $permission->customerEmployeeCategoryId = $categoryItem->UgyfelDolgozoKategoria_ID;
        $permission->customerEmployeeCategoryItemId = $categoryItem->UgyfelDolgozoKategoriaTetel_ID;
        $permission->code = $categoryItem->Kod;
        $permission->name = $categoryItem->getName();
        $permission->value = $customerPermissions && $customerPermissions
            ->where('UgyfelDolgozoKategoria_ID', $categoryItem->UgyfelDolgozoKategoria_ID)
            ->where('UgyfelDolgozoKategoriaTetel_ID', $categoryItem->UgyfelDolgozoKategoriaTetel_ID)->count() > 0;
        $permission->icon = $this->getIcon($categoryItem);

        return $permission;
    }

    private function getIcon(CustomerEmployeeCategoryItem $categoryItem): string
    {
        switch ($categoryItem->Kod) {
            case 'ADMIN':
                return 'fa-crown';

            case 'PENZ':
                return 'fa-circle-dollar';

            case 'REND':
                return 'fa-cart-shopping';

            case 'SERV':
                return 'fa-screwdriver-wrench';

            case 'FF':
                return 'fa-triangle-exclamation';
        }

        if ($categoryItem->UgyfelDolgozoKategoria_ID == CustomerEmployeeCategory::PERMISSION_TAKE_OVER_CATEGORY_ID
            && $categoryItem->Kod == 'IGEN') {
            return 'fa-hand-holding-box';
        }

        if ($categoryItem->UgyfelDolgozoKategoria_ID == CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID
            && $categoryItem->Kod == 'ES') {
            return 'fa-file-invoice-dollar';
        }

        return '';
    }
}
