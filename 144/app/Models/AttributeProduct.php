<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'termek_tulajdonsag';
    protected $primaryKey = [
        'Termek_ID',
        'Tulajdonsag_ID',
        'TulajdonsagTetel_ID',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'Tulajdonsag_ID');
    }
}
