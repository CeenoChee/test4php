<?php

namespace App\Repositories;

use App\Mail\InviteCustomerEmployee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRepository extends EloquentRepository
{
    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getEmailById(int $id)
    {
        return $this->model->where('id', $id)->value('email');
    }

    public function invite($email, $firstname, $lastname, $position, $phone, $mobile, $fax): ?User
    {
        $adminUserInfo = app('User');

        if (! $adminUserInfo->isCustomerAdmin()) {
            return null;
        }

        $user = $this->getByEmail($email);

        if (! $user) {
            $user = new User();

            $user->email = $email;
            $user->Keresztnev = $firstname;
            $user->Vezeteknev = $lastname;
            $user->Beosztas = $position;
            $user->Telefon = $phone;
            $user->Mobil = $mobile;
            $user->Fax = $fax;

            $user->Orszag_ID = $adminUserInfo->getCurrencyID();
            $user->IrSzam = $adminUserInfo->getPostcode();
            $user->Helyseg = $adminUserInfo->getCity();
            $user->UtcaHSzam = $adminUserInfo->getStreetHouseNumber();

            $user->password = '';
            $user->Cegnev = $adminUserInfo->getCompanyName();

            $user->Adoszam = $adminUserInfo->getCustomer()->Adoszam;
            $user->Cegjegyzekszam = $adminUserInfo->getCustomer()->Cegjegyzekszam;
            $user->token = $this->getToken();
            $user->verified = false;
            $user->newsletter = false;
        }

        $user->invite_customer_id = $adminUserInfo->getCustomerId();
        $user->invited_at = Carbon::now();

        $user->save();

        Mail::send(new InviteCustomerEmployee($user));

        return $user;
    }

    public function confirm(User $user)
    {
        $user->verified = true;
        $user->save();
    }

    public function reInvite(User $user)
    {
        $user->invited_at = Carbon::now();
        $user->token = $this->getToken();
        $user->save();

        Mail::send(new InviteCustomerEmployee($user));
    }

    public function deleteInvitation(User $user)
    {
        $user->invited_at = null;
        $user->token = null;
        $user->save();
    }

    protected function setModel()
    {
        $this->model = new User();
    }

    private function getToken(): string
    {
        do {
            $token = Str::random(60);
        } while (User::where('token', $token)->exists());

        return $token;
    }
}
