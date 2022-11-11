<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $maintenanceMode = (new SettingRepository())->getByKey(Setting::MAINTENANCE_MODE);

        if ($maintenanceMode && $maintenanceMode->value === 'true' && ! in_array($request->ip(), ['89.134.90.145', '188.36.122.21'])) {
            throw new MaintenanceModeException(time());
        }

        return $next($request);
    }
}
