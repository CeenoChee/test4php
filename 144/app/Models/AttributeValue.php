<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'tulajdonsag_tetel';
    protected $primaryKey = [
        'Tulajdonsag_ID',
        'TulajdonsagTetel_ID',
    ];

    public function __toString()
    {
        $trans = $this->trans;
        if ($trans) {
            return $trans->Nev;
        }

        return $this->Nev;
    }

    public function trans()
    {
        return $this->belongsTo(TulajdonsagTetelForditas::class, 'Tulajdonsag_ID', 'Tulajdonsag_ID')
            ->where('TulajdonsagTetel_ID', $this->TulajdonsagTetel_ID)
            ->where('Nyelv_ID', app('Lang')->getLanguageId());
    }
}
