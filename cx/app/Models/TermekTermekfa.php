<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class TermekTermekfa extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'termek_termekfa';
    protected $primaryKey = [
        'TermekfaLevel_ID',
        'Tulajdonsag_ID',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Termek_ID');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'TermekfaLevel_ID');
    }
}
