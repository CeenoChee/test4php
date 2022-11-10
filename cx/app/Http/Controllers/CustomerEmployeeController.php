<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerEmployeeSettingsRequest;
use App\Http\Requests\InviteCustomerEmployee;
use App\Http\Requests\InviteUser;
use App\Libs\LUrl;
use App\Libs\UserInfo;
use App\Mail\InviteCustomerEmployeeAdminConfirm;
use App\Mail\InviteCustomerEmployeeConfirm;
use App\Models\CustomerEmployeeCategory;
use App\Models\CustomerEmployeeClassification;
use App\Models\User;
use App\Repositories\CustomerEmployeeCategoryItemRepository;
use App\Repositories\CustomerEmployeeRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\SyncFromWebRepository;
use App\Repositories\UserRepository;
use App\Services\PermissionService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomerEmployeeController extends Controller
{
    protected CustomerEmployeeRepository $customerEmployeeRepository;

    public function __construct(CustomerEmployeeRepository $customerEmployeeRepository)
    {
        $this->customerEmployeeRepository = $customerEmployeeRepository;
    }

    public function index(CustomerRepository $customerRepository)
    {
        $user = app('User');

        $customerId = $user->getCustomerId();

        if (is_null($customerId)) {
            abort(403);
        }

        $employees = $customerRepository->getEmployees($customerId);

        return view(
            'pages.customer-employees.permissions',
            [
                'user' => $user,
                'employees' => $employees,
            ]
        );
    }

    public function show($customerId, $customerEmployeeId)
    {
        if (app('User')->getCustomerId() != $customerId) {
            abort(403);
        }

        $customerEmployee = $this->customerEmployeeRepository->getCustomerEmployee(
            (int) $customerId,
            (int) $customerEmployeeId
        );
        if (! $customerEmployee) {
            abort(404);
        }

        return view(
            'pages.customer-employees.show',
            compact('customerEmployee')
        );
    }

    public function settings($userId)
    {
        $user = User::findOrFail($userId);
        $userInfo = new UserInfo($user);

        if ($userInfo->getCustomerId() === null || app('User')->getCustomerId() !== $userInfo->getCustomerId()) {
            abort(404);
        }

        $employee = $userInfo->getCustomerEmployee();
        $active = $employee ? $employee->Hasznalhato : false;

        return view(
            'pages.customer-employees.settings',
            [
                'isMySettings' => (app('User')->getUserId() == $userId),
                'userInfo' => $userInfo,
                'customerEmployee' => $user->customerEmployee,
                'permissions' => $userInfo->getPermissionFields(),
                'active' => $active,
            ]
        );
    }

    public function settingsSave(CustomerEmployeeSettingsRequest $request, $locale, $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        $userInfo = new UserInfo($user);

        if ($userInfo->getCustomerId() === null || app('User')->getCustomerId() !== $userInfo->getCustomerId()) {
            abort(404);
        }

        $userInfo->setPosition($request->position);
        $userInfo->setPhone($request->telephone);
        $userInfo->setMobile($request->mobile);
        $userInfo->setFax($request->fax);
        $userInfo->save();

        $permissions = collect($this->getPermissionsByRequest($request));

        if (app('User')->getUserId() == $userId) {
            $permissions->push('ADMIN');
        }

        $customerEmployee = $user->customerEmployee;
        $customer = $customerEmployee ? $customerEmployee->customer : null;

        if ($customer && ! $this->customerHasOtherEmployeesWithDemandForPayment($customer->getKey(), $customerEmployee->UgyfelDolgozo_ID)) {
            $permissions->push('FF');
        }

        // Ha nincs most ennel a mentesnel bekapcsolva az eszamla es az ugyfelnel be van kapcsolva es nincs masik ugyfel dolgozo
        if (! $permissions->contains('ES')
            && $customer
            && $customer->ESzamlazas
            && ! $this->customerHasOtherEmployeesWithEInvoice($customer->getKey(), $customerEmployee->UgyfelDolgozo_ID)
        ) {
            $permissions->push('ES');
        }

        $userInfo->setPermissions($permissions->unique()->values()->toArray());

        if ($request->has('resend_invitation') && ! $userInfo->isRielActive()) {
            (new UserRepository())->reInvite($user);
            $message = trans('pages/account.employee_invitation_sent');
        } else {
            $message = trans('pages/account.the_settings_was_saved');
        }

        (new SyncFromWebRepository())->updateCustomerEmployeeProfile($userInfo);

        flash()->success($message);

        return redirect()->to(LUrl::route('employee.settings', ['userId' => $user->id], false, $locale));
    }

    public function inviteUserForm()
    {
        return view(
            'pages.customer-employees.invites.user',
            [
                'permissions' => (new PermissionService())->getPermissions(),
            ]
        );
    }

    public function inviteUser(InviteUser $request): RedirectResponse
    {
        $user = (new UserRepository())->invite(
            $request->email,
            $request->firstname,
            $request->lastname,
            $request->position,
            $request->phone,
            $request->mobile,
            $request->fax
        );

        $permissions = $this->getPermissionsByRequest($request);

        $userInfo = new UserInfo($user);
        $userInfo->setPermissions($permissions);

        (new SyncFromWebRepository())->updateCustomerEmployeeProfileWithPermissions($userInfo, $permissions);

        flash()->success(trans('pages/account.employee_invitation_sent'));

        return redirect()->to(LUrl::route('employees.index', ['userId' => $user->id]));
    }

    public function reInviteUser($locale, User $user, UserRepository $userRepository): RedirectResponse
    {
        $adminUser = app('User');
        $userInfo = new UserInfo($user);

        if ($adminUser->isCustomerAdmin() && $adminUser->getCustomerId() != $userInfo->getCustomerId()) {
            abort(404);
        }

        $userRepository->reInvite($user);

        flash()->success(trans('pages/account.employee_invitation_sent'));

        return redirect()->route(LUrl::name('employee.settings'), ['userId' => $user->id]);
    }

    public function deleteInvitation($locale, User $user, UserRepository $userRepository): RedirectResponse
    {
        $adminUser = app('User');
        $userInfo = new UserInfo($user);

        if ($adminUser->isCustomerAdmin() && $adminUser->getCustomerId() != $userInfo->getCustomerId()) {
            abort(404);
        }

        $userRepository->deleteInvitation($user);

        flash()->success(trans('pages/account.the_invitation_deleted'));

        return redirect()->route(LUrl::name('employee.settings'), ['userId' => $user->id]);
    }

    /**
     * Létező ügyfél dolgozó nem létező felhasználó.
     *
     * @param $customerId
     * @param $customerEmployeeId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inviteEmployeeForm($customerId, $customerEmployeeId)
    {
        if (app('User')->getCustomerId() != $customerId) {
            abort(403);
        }

        $customerEmployee = $this->customerEmployeeRepository->getCustomerEmployee(
            (int) $customerId,
            (int) $customerEmployeeId
        );

        if (! $customerEmployee) {
            abort(404);
        }

        return view(
            'pages.customer-employees.invites.employee',
            [
                'customerEmployee' => $customerEmployee,
                'permissions' => (new PermissionService())->getPermissions(),
                'active' => $customerEmployee->Hasznalhato,
            ]
        );
    }

    public function inviteEmployee($locale, $customerId, $customerEmployeeId, InviteCustomerEmployee $request): RedirectResponse
    {
        if (app('User')->getCustomerId() != $customerId) {
            abort(403);
        }

        $customerEmployee = $this->customerEmployeeRepository->getCustomerEmployee(
            (int) $customerId,
            (int) $customerEmployeeId
        );

        if (! $customerEmployee || $customerEmployee->WebLogin) {
            abort(404);
        }

        $customerEmployee->WebLogin = $request->email;
        $customerEmployee->Beosztas = $request->position;
        $customerEmployee->Telefon = $request->phone;
        $customerEmployee->Mobil = $request->mobile;
        $customerEmployee->Fax = $request->fax;
        $customerEmployee->save();

        $user = (new UserRepository())->invite(
            $request->email,
            $customerEmployee->getFirstName(),
            $customerEmployee->getLastName(),
            $request->position,
            $request->phone,
            $request->mobile,
            $request->fax
        );

        $userInfo = new UserInfo($user);
        $userInfo->setPermissions($this->getPermissionsByRequest($request));

        (new SyncFromWebRepository())->updateCustomerEmployeeProfile($userInfo);

        flash()->success(trans('pages/account.employee_invitation_sent'));

        return redirect()->route(LUrl::name('employees.index'));
    }

    public function confirmation($locale, $token, UserRepository $userRepository): RedirectResponse
    {
        $user = User::where('token', $token)->whereNotNull('invite_customer_id')->first();

        if ($user) {
            $userInfo = new UserInfo($user);

            if (! $userInfo->getInvitationValidity()) {
                flash()->error(trans('pages/auth.not_valid_link'));

                return redirect()->route(LUrl::name('login'));
            }

            if (! $user->verified) {
                foreach ((new CustomerRepository())->getAdminUsers($userInfo->getCustomer()) as $adminUser) {
                    Mail::send(new InviteCustomerEmployeeAdminConfirm($adminUser, $userInfo));
                }

                Mail::send(new InviteCustomerEmployeeConfirm($userInfo));
            }

            $userRepository->confirm($user);

            (new SyncFromWebRepository())->updateCustomerEmployeeProfile($userInfo);

            Auth::login($user);

            if (empty($user->password)) {
                flash()->success(trans('emails.successful_activation'));

                return redirect()->route(LUrl::name('password.update'));
            }

            $userRepository->deleteInvitation($user);

            flash()->success(trans('emails.successful_activation'));

            return redirect()->route(LUrl::name('login'));
        }

        flash()->error(trans('pages/auth.not_valid_link'));

        return redirect()->route(LUrl::name('login'));
    }

    protected function customerHasOtherEmployeesWithDemandForPayment(int $customerId, int $customerEmployeeId): bool
    {
        return (bool) CustomerEmployeeClassification::where('Ugyfel_ID', $customerId)
            ->where('UgyfelDolgozo_ID', '<>', $customerEmployeeId)
            ->leftJoin('ugyfel_dolgozo_kategoria_tetel', 'ugyfel_dolgozo_besorolas.UgyfelDolgozoKategoriaTetel_ID', '=', 'ugyfel_dolgozo_kategoria_tetel.UgyfelDolgozoKategoriaTetel_ID')
            ->where('ugyfel_dolgozo_besorolas.UgyfelDolgozoKategoria_ID', CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID)
            ->where('ugyfel_dolgozo_kategoria_tetel.Kod', 'FF')
            ->count();
    }

    protected function customerHasOtherEmployeesWithEInvoice(int $customerId, int $customerEmployeeId): bool
    {
        return (bool) CustomerEmployeeClassification::where('Ugyfel_ID', $customerId)
            ->leftJoin('ugyfel_dolgozo_kategoria_tetel', 'ugyfel_dolgozo_besorolas.UgyfelDolgozoKategoriaTetel_ID', '=', 'ugyfel_dolgozo_kategoria_tetel.UgyfelDolgozoKategoriaTetel_ID')
            ->where('UgyfelDolgozo_ID', '<>', $customerEmployeeId)
            ->where('ugyfel_dolgozo_kategoria_tetel.UgyfelDolgozoKategoria_ID', CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID)
            ->where('ugyfel_dolgozo_kategoria_tetel.Kod', 'ES')
            ->count();
    }

    private function getPermissionsByRequest(FormRequest $request): array
    {
        $permissions = [];
        $permissionCategoryItems = (new CustomerEmployeeCategoryItemRepository())->getWithoutEs2();

        foreach ($permissionCategoryItems as $permissionCategoryItem) {
            if ($request->get('permission_' . $permissionCategoryItem->Kod) == 'true') {
                $permissions[] = $permissionCategoryItem->Kod;
            }
        }

        if (in_array('PENZ', $permissions)) {
            $permissions[] = 'FF';
        }

        if ($request->permission_active == 'true') {
            $permissions[] = 'active';
        }

        return $permissions;
    }
}
