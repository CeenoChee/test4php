<?php

namespace App\Libs;

use App\Models\Currency;
use App\Models\User;
use App\Repositories\CustomerEmployeeCategoryItemRepository;
use App\Repositories\CustomerEmployeeClassificationRepository;
use App\Services\PermissionService;
use Carbon\Carbon;

class UserInfo
{
    private $user;
    private $customerEmployee = false;
    private $customer = false;
    private $groupPaymentConditionID = false;
    private $currency = false;
    private array $permissions = [];

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Visszaadja a bejelentkezett User-t.
     *
     * @return null|\App\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getInvitationValidity(): ?Carbon
    {
        if ($this->user->invited_at) {
            $validity = new Carbon($this->user->invited_at);
            $validity->addDays(7);
            if ($validity->isFuture()) {
                return $validity;
            }
        }

        return null;
    }

    /**
     * Visszaadja a felhasználóhoz kapcsolt Ugyfél dolgozót, ha van.
     *
     * @return null|UgyfelDolgozo
     */
    public function getCustomerEmployee()
    {
        if ($this->customerEmployee === false) {
            $user = $this->getUser();

            if ($user) {
                $user->load('customerEmployee');
            }

            $this->customerEmployee = $user ? $user->customerEmployee : null;
        }

        return $this->customerEmployee;
    }

    public function getUserId()
    {
        $user = $this->getUser();

        if ($user) {
            return $user->id;
        }

        return null;
    }

    public function getCustomerId(): ?int
    {
        $customer = $this->getCustomer();

        if ($customer) {
            return (int) $customer->Ugyfel_ID;
        }

        return null;
    }

    public function getCustomerEmployeeId(): ?int
    {
        $customerEmployee = $this->getCustomerEmployee();

        if ($customerEmployee) {
            return (int) $customerEmployee->UgyfelDolgozo_ID;
        }

        return null;
    }

    public function isVerified(): bool
    {
        $user = $this->getUser();

        return $user && $user->verified;
    }

    /**
     * A felhasználó RIEL munkatárs.
     */
    public function isRiel(): bool
    {
        $customerEmployee = $this->getCustomerEmployee();

        return $customerEmployee && $customerEmployee->Ugyfel_ID == 1074;
    }

    public function isCompetitor(): bool
    {
        return $this->customer->Konkurencia === '1';
    }

    public function isPending(): bool
    {
        if (! $this->isVerified()) {
            return false;
        }

        return $this->user->invite_customer_id && ! $this->getCustomerEmployee();
    }

    /**
     * A bejelentkezett felhasználó össze van kapcsolva a sERPa-val.
     */
    public function isRielActive(): bool
    {
        if (! $this->isVerified()) {
            return false;
        }

        if ($this->getCustomerEmployee()) {
            return true;
        }

        return false;
    }

    /**
     * Össze van kötve de nem használható.
     *
     * @return bool
     */
    public function isUsable(): ?bool
    {
        $customerEmployee = $this->getCustomerEmployee();

        if ($customerEmployee) {
            return (bool) $customerEmployee->Hasznalhato;
        }

        return null;
    }

    public function isBanned(): ?bool
    {
        $user = $this->getUser();

        if (! $user) {
            return null;
        }

        if ($user->banned_at == '0000-00-00 00:00:00') {
            return false;
        }

        if ($user->banned_at !== null || $this->isUsable() === false) {
            return true;
        }

        return false;
    }

    /**
     * A bejelentkezett felhasználó telepítő.
     */
    public function isReseller(): bool
    {
        if ($this->isRiel()) {
            return true;
        }
        $customer = $this->getCustomer();

        return $customer && $customer->Viszontelado;
    }

    public function installerPrice(): bool
    {
        return $this->isReseller() && $this->getUser()->TelepitoiAr;
    }

    /**
     * A bejelentkezett felhasználó fejlesztő.
     *
     * @return bool
     */
    public function isDev()
    {
        $user = $this->getUser();

        return $user && in_array($user->email, config('riel.dev_users', []));
    }

    /**
     * Visszaadja a felhasználóhoz kapcsolt Ugyfellet ha van.
     *
     * @return null|Ugyfel
     */
    public function getCustomer()
    {
        if ($this->customer === false) {
            $customerEmployee = $this->getCustomerEmployee();
            if ($customerEmployee) {
                $this->customer = $customerEmployee->customer;
            } elseif ($this->user && $this->user->inviteCustomer) {
                $this->customer = $this->user->inviteCustomer;
            } else {
                $this->customer = null;
            }
        }

        return $this->customer;
    }

    /**
     * Visszaadja a CsopFizetesiFeltetel_ID-t.
     *
     * @return null|bool
     */
    public function getGroupPaymentConditionID()
    {
        if ($this->groupPaymentConditionID === false) {
            $customer = $this->getCustomer();
            if ($customer) {
                $this->groupPaymentConditionID = $customer->CsopFizetesiFeltetel_ID;
            } else {
                $this->groupPaymentConditionID = null;
            }
        }

        return $this->groupPaymentConditionID;
    }

    /**
     * Visszaadja a felhasználó teljes nevét.
     *
     * @return string
     */
    public function getName()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomerEmployee()->Nev;
        }

        return $user->Vezeteknev . ' ' . $user->Keresztnev;
    }

    public function getLastName()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }

        return $user->Vezeteknev;
    }

    public function getFirstName()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }

        return $user->Keresztnev;
    }

    /**
     * Visszaadja a felhasználó mail címét.
     *
     * @return string
     */
    public function getEmail()
    {
        $user = $this->getUser();

        return $user ? $user->email : '';
    }

    /**
     * Visszaadja cégnevet.
     *
     * @return string
     */
    public function getCompanyName()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomer()->Nev;
        }

        return $user->Cegnev;
    }

    /**
     * Visszaadja a felhasználó címét.
     *
     * @return string
     */
    public function getAddress()
    {
        $user = $this->getUser();

        if ($user === null) {
            return null;
        }

        if ($this->isRielActive()) {
            return $this->getCustomer()->getAddress();
        }

        return $user->getAddress();
    }

    public function getPhone()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomerEmployee()->Telefon;
        }

        return $user->Telefon;
    }

    public function getMobile()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomerEmployee()->Mobil;
        }

        return $user->Mobil;
    }

    public function getFax()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomerEmployee()->Fax;
        }

        return $user->Fax;
    }

    public function getPosition()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomerEmployee()->Beosztas;
        }

        return $user->Beosztas;
    }

    public function save()
    {
        $customerEmployee = $this->getCustomerEmployee();
        if ($customerEmployee) {
            $customerEmployee->save();
        }
        $user = $this->getUser();
        if ($user) {
            $user->save();
        }

        return $this;
    }

    public function getCountry()
    {
        $user = $this->getUser();
        if ($user === null) {
            return null;
        }
        if ($this->isRielActive()) {
            return $this->getCustomer()->country;
        }

        return $user->country;
    }

    public function getPostcode()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomer()->IrSzam;
        }

        return $user->IrSzam;
    }

    public function setPosition($position)
    {
        return $this->setValue('Beosztas', (string) $position);
    }

    public function setPhone($phone)
    {
        return $this->setValue('Telefon', (string) $phone);
    }

    public function setMobile($mobile)
    {
        return $this->setValue('Mobil', (string) $mobile);
    }

    public function setFax($fax)
    {
        return $this->setValue('Fax', (string) $fax);
    }

    public function getCity()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomer()->Helyseg;
        }

        return $user->Helyseg;
    }

    public function getStreetHouseNumber()
    {
        $user = $this->getUser();
        if ($user === null) {
            return '';
        }
        if ($this->isRielActive()) {
            return $this->getCustomer()->UtcaHSzam;
        }

        return $user->UtcaHSzam;
    }

    /**
     * Felhasználó currency ID-ja.
     */
    public function getCurrencyID(): int
    {
        $customer = $this->getCustomer();
        if ($customer) {
            return $customer->Deviza_ID;
        }

        return 0;
    }

    public function getCurrency(): bool
    {
        $currencyID = $this->getCurrencyID();
        if ($this->currency === false || $this->currency->Deviza_ID != $currencyID) {
            $this->currency = Currency::where('Deviza_ID', $currencyID)->first();
        }

        return $this->currency;
    }

    public function canTransfer(): bool
    {
        $customer = $this->getCustomer();
        if ($customer) {
            return $customer->FizetesiMod_ID == 0;
        }

        return false;
    }

    public function canUseCreditCard(): bool
    {
        return in_array($this->getCurrencyID(), [0, 2, 5]);
    }

    public function isForeigner(): ?bool
    {
        $country = $this->getCountry();
        if ($country) {
            return $country->Orszag_ID != 0;
        }

        return null;
    }

    public function getAfa()
    {
        if ($this->isForeigner()) {
            return 0;
        }

        return config('riel.tax', 27);
    }

    public function isCustomerAdmin(): bool
    {
        return $this->hasPermission('ADMIN');
    }

    public function hasOrderPermission(): bool
    {
        return $this->hasPermission('REND');
    }

    public function hasFinancePermission(): bool
    {
        return $this->hasPermission('PENZ');
    }

    public function hasServicePermission(): bool
    {
        return $this->hasPermission('SERV');
    }

    public function getPermissionFields(): array
    {
        if ($this->isRielActive()) {
            $customerEmployee = $this->getCustomerEmployee();

            return (new PermissionService())->getPermissionsByCustomerIdAndCustomerEmployeeId(
                $customerEmployee->Ugyfel_ID,
                $customerEmployee->UgyfelDolgozo_ID
            );
        }

        return (new PermissionService())->getPermissions();
    }

    public function getPermissions(): array
    {
        if (empty($this->permissions)) {
            foreach ($this->getPermissionFields() as $permission) {
                if ($permission->value) {
                    $this->permissions[] = $permission->code;
                }
            }
        }

        return $this->permissions;
    }

    public function hasPermission($permissions): bool
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if ($this->hasPermission($permission)) {
                    return true;
                }
            }

            return false;
        }

        return in_array($permissions, $this->getPermissions());
    }

    public function setPermissions($permissions): UserInfo
    {
        $permissionCategoryItems = (new CustomerEmployeeCategoryItemRepository())->getWithoutEs2();

        $customerEmployee = $this->getCustomerEmployee();

        if ($customerEmployee) {
            $customerEmployeeClassificationRepository = new CustomerEmployeeClassificationRepository();

            foreach ($permissionCategoryItems as $permissionCategoryItem) {
                $customerEmployeeClassificationRepository->setValue(
                    $customerEmployee->Ugyfel_ID,
                    $customerEmployee->UgyfelDolgozo_ID,
                    $permissionCategoryItem->UgyfelDolgozoKategoria_ID,
                    $permissionCategoryItem->UgyfelDolgozoKategoriaTetel_ID,
                    in_array($permissionCategoryItem->Kod, $permissions),
                );
            }

            $active = in_array('active', $permissions) ? 1 : 0;

            $customerEmployee->Hasznalhato = $active;
            $customerEmployee->save();
        }

        return $this;
    }

    private function setValue($fieldName, $value)
    {
        $customerEmployee = $this->getCustomerEmployee();

        if ($customerEmployee) {
            $customerEmployee->{$fieldName} = $value;
        }

        $user = $this->getUser();

        if ($user) {
            $user->{$fieldName} = $value;
        }

        return $this;
    }
}
