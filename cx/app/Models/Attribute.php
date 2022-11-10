<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attribute extends Model
{
    protected $table = 'tulajdonsag';
    protected $primaryKey = 'Tulajdonsag_ID';

    public function __toString()
    {
        $trans = $this->trans;
        if ($trans) {
            return $trans->Cimke;
        }

        return $this->Cimke;
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'Tulajdonsag_ID')->orderBy('Sorrend');
    }

    public function trans(): BelongsTo
    {
        return $this->belongsTo(AttributeTrans::class, 'Tulajdonsag_ID', 'Tulajdonsag_ID')
            ->where('Nyelv_ID', app('Lang')->getLanguageId());
    }
}
