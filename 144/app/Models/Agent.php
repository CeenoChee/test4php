<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public const CREATED_AT = 'FelvDatum';
    public const UPDATED_AT = 'ModDatum';

    public $incrementing = false;

    protected $table = 'ugynok';
    protected $primaryKey = 'Ugynok_ID';
}
