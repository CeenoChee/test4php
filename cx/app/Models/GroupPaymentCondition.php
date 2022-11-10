<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPaymentCondition extends Model
{
    use HasFactory;

    protected $table = 'csop_fizetesi_feltetel';
	protected $primaryKey = 'CsopFizetesiFeltetel_ID';

    public $incrementing = false;

    const CREATED_AT = 'FelvDatum';
    const UPDATED_AT = 'ModDatum';
}
