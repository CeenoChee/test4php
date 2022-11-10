<?php

namespace App\Models;

use App\Libs\UserInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;

class Manufacturer extends Model
{
    use HasFactory;

    public const CREATED_AT = 'FelvDatum';
    public const UPDATED_AT = 'ModDatum';

    protected $table = 'manufacturers';
    protected $primaryKey = 'Gyarto_ID';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sort' => 'int',
        'active' => 'int',
        'warranty_active' => 'int',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'Gyarto_ID');
    }

    public function scopeWithoutBlacklisted($query)
    {
        return $query->whereNotIn('manufacturers.Gyarto_ID', $this->getBlacklistedIds());
    }

    public function scopeProductCategory($query, ProductCategory $productCategory = null)
    {
        $query = $query->join('termek', 'termek.Gyarto_ID', '=', 'manufacturers.Gyarto_ID')
            ->where('termek.Aktiv', 1)
            ->where('termek.Lathato', 1)
            ->groupBy('manufacturers.Gyarto_ID')
            ->orderBy('manufacturers.Nev')
            ->select('manufacturers.*');

        if ($productCategory !== null) {
            $query = $query->join('termek_termekfa', 'termek_termekfa.Termek_ID', '=', 'termek.Termek_ID')
                ->join('termekfa_level', 'termekfa_level.TermekfaLevel_ID', '=', 'termek_termekfa.TermekfaLevel_ID')
                ->where('termekfa_level.Bal', '>=', $productCategory->Bal)
                ->where('termekfa_level.Jobb', '<=', $productCategory->Jobb);
        }

        return $query->addSelect(DB::raw('count(termek.Termek_ID) as count'));
    }

    /**
     * Forditas relationship.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ManufacturerTranslation::class, 'Gyarto_ID', 'Gyarto_ID');
    }

    /**
     * Rendszer nyelvi forditas.
     */
    public function trans(): HasOne
    {
        return $this->hasOne(ManufacturerTranslation::class, 'Gyarto_ID', 'Gyarto_ID')->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_model');
    }

    public function getBlacklistedIds($customerId = null)
    {
        if (auth()->check() && (new UserInfo(auth()->user()))->isRielActive()) {
            $customerId = auth()->user()->getCustomerId();
        }

        if (! is_null($customerId)) {
            return BlacklistedManufacturer::getIdsByCustomer($customerId);
        }

        return BlacklistedManufacturer::pluck('Gyarto_ID');
    }
}
