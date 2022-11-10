<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class CustomerEmployee extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;

    public $timestamps = false;

    protected $table = 'ugyfel_dolgozo';
    protected $primaryKey = [
        'Ugyfel_ID',
        'UgyfelDolgozo_ID',
    ];
    protected $fillable = [
        'WebLogin',
        'Nev',
        'Beosztas',
        'Telefon',
        'Mobil',
        'Fax',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Ugyfel_ID')->where('Ugyfel_ID', $this->Ugyfel_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'WebLogin', 'email');
    }

    public function scopeUsable($query)
    {
        return $query->where('Hasznalhato', 1);
    }

    public function getLastName()
    {
        $explodedName = explode(' ', (string) $this->Nev);

        return isset($explodedName[0]) ? $explodedName[0] : '';
    }

    public function getFirstName()
    {
        $explodedName = explode(' ', (string) $this->Nev);

        return isset($explodedName[1]) ? implode(' ', array_slice($explodedName, 1)) : '';
    }
}
