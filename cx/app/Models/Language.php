<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public const HU = 0;
    public const DE = 1;
    public const EN = 2;

    protected $table = 'nyelv';
    protected $primaryKey = 'Nyelv_ID';

    public function __toString()
    {
        return $this->Nev;
    }
}
