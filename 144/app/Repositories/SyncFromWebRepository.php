<?php

namespace App\Repositories;

use App\Libs\UserInfo;
use App\Models\SyncFromWeb;
use App\Models\User;
use Carbon\Carbon;

class SyncFromWebRepository
{
    private SyncFromWeb $syncFromWeb;

    public function __construct()
    {
        $this->syncFromWeb = new SyncFromWeb();
    }

    public function updateCustomerEmployeeProfileWithPermissions(UserInfo $userInfo, $premissions)
    {
        $validRequest = true;

        if (is_null($userInfo->getCustomerEmployeeId())) {
            foreach (SyncFromWeb::all() as $sync) {
                if ($sync->method == 'update_customer_employee_profile') {
                    $data = json_decode($sync->data, true);
                    if ($userInfo->getCustomerId() == $data['customerId'] && $userInfo->getEmail() == $data['email'] && $data['customerEmployeeId'] == null) {
                        $validRequest = false;

                        break;
                    }
                }
            }
        }

        if ($validRequest) {
            $this->create('customer', 'update_customer_employee_profile', [
                'userId' => $userInfo->getUserId(),
                'customerId' => $userInfo->getCustomerId(),
                'customerEmployeeId' => $userInfo->getCustomerEmployeeId(),
                'name' => $userInfo->getName(),
                'email' => $userInfo->getEmail(),
                'position' => $userInfo->getPosition(),
                'mobile' => $userInfo->getMobile(),
                'telephone' => $userInfo->getPhone(),
                'fax' => $userInfo->getFax(),
                'active' => 1,
                'permissions' => $premissions,
            ]);
        }
    }

    public function updateCustomerEmployeeProfile(UserInfo $userInfo, $forceActive = false)
    {
        $validRequest = true;

        if (is_null($userInfo->getCustomerEmployeeId())) {
            foreach (SyncFromWeb::all() as $sync) {
                if ($sync->method == 'update_customer_employee_profile') {
                    $data = json_decode($sync->data, true);
                    if ($userInfo->getCustomerId() == $data['customerId'] && $userInfo->getEmail() == $data['email'] && $data['customerEmployeeId'] == null) {
                        $validRequest = false;

                        break;
                    }
                }
            }
        }

        if ($validRequest) {
            $this->create('customer', 'update_customer_employee_profile', [
                'userId' => $userInfo->getUserId(),
                'customerId' => $userInfo->getCustomerId(),
                'customerEmployeeId' => $userInfo->getCustomerEmployeeId(),
                'name' => $userInfo->getName(),
                'email' => $userInfo->getEmail(),
                'position' => $userInfo->getPosition(),
                'mobile' => $userInfo->getMobile(),
                'telephone' => $userInfo->getPhone(),
                'fax' => $userInfo->getFax(),
                'active' => $forceActive ?: $userInfo->isUsable(),
                'permissions' => $userInfo->getPermissions(),
            ]);
        }
    }

    public function updateNewsletterSubscriptions(User $user, $tags)
    {
        $this->create('customer', 'newsletter_subscriptions', [
            'email' => $user->email,
            'tags' => $tags,
        ]);
    }

    public function createShippingAddress(array $data)
    {
        $this->create('customer', 'create_shipping_address', $data);
    }

    public function updateShippingAddress(array $data)
    {
        $this->create('customer', 'update_shipping_address', $data);
    }

    public function updateKnowledgeViews(array $data)
    {
        $this->create('knowledge', 'update_knowledge_views', $data);
    }

    protected function create(string $processSlug, string $method, array $data)
    {
        $this->syncFromWeb->insert([
            'sync_process_slug' => $processSlug,
            'method' => $method,
            'data' => json_encode($data),
            'created_at' => Carbon::now(),
        ]);
    }
}
