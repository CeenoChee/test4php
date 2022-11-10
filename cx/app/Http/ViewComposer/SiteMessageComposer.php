<?php

namespace App\Http\ViewComposer;

use App\Libs\LUrl;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class SiteMessageComposer
{
    public function compose(View $view)
    {
        if ($this->getSiteMessageVisibility() && (! Cookie::has('closed-site-message') || LUrl::routeIs('home'))) {
            $lang = app('Lang');
            $siteMessage = (new SettingRepository())->getValueByKey(Setting::SITE_MESSAGE . '_' . $lang->getLocale());

            $view->with('siteMessage', $siteMessage);
        } else {
            $view->with('siteMessage', null);
        }
    }

    private function getSiteMessageVisibility(): bool
    {
        $now = Carbon::now();

        $siteMessageStart = (new SettingRepository())->getValueByKey(Setting::SITE_MESSAGE_START);
        $siteMessageEnd = (new SettingRepository())->getValueByKey(Setting::SITE_MESSAGE_END);

        $isSiteMessageVisible = false;

        if (is_null($siteMessageStart) && $now <= $siteMessageEnd) {
            $isSiteMessageVisible = true;
        } elseif (is_null($siteMessageEnd) && $now >= $siteMessageStart) {
            $isSiteMessageVisible = true;
        } elseif (is_null($siteMessageStart) && is_null($siteMessageEnd)) {
            $isSiteMessageVisible = true;
        } elseif ($now >= $siteMessageStart && $now <= $siteMessageEnd) {
            $isSiteMessageVisible = true;
        }

        return $isSiteMessageVisible;
    }
}
