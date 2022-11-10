<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BlacklistedManufacturer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'date',
    ];

    public static function getWhitelistIdsByCustomer(int $customerId): Collection
    {
        $bm = new static();

        return $bm->query()
            ->from($bm->getTable() . ' as bm')
            ->leftJoin('gyarto_ugyfel_whitelist as guw', function ($join) use ($customerId) {
                $join->on('bm.id', '=', 'guw.blacklisted_manufacturer_id')->where('guw.Ugyfel_ID', $customerId);
            })
            ->whereNotNull('guw.Ugyfel_ID')
            ->pluck('Gyarto_ID');
    }

    public static function getIdsByCustomer(int $customerId)
    {
        $bm = new static();

        $blacklistedManufacturerIds = $bm->pluck('Gyarto_ID');
        $whitelistedManufacturerIds = $bm->getWhitelistIdsByCustomer($customerId);

        return $blacklistedManufacturerIds->diff($whitelistedManufacturerIds);
    }
}
