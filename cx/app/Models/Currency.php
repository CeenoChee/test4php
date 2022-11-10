<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public const CREATED_AT = 'FelvDatum';
    public const UPDATED_AT = 'ModDatum';

    public $incrementing = false;

    protected $table = 'deviza';
    protected $primaryKey = 'Deviza_ID';

    public function __toString()
    {
        return $this->Nev;
    }
}
