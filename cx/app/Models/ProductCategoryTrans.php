<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTrans extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'termekfa_level_forditas';

    protected $primaryKey = [
        'Nyelv_ID',
        'TermekfaLevel_ID',
    ];

    public static function getBySlug($slug)
    {
        return ProductCategoryTrans::where('Nyelv_ID', app('Lang')->getLanguageId())->where('Eleres', $slug)->first();
    }

    public function lang()
    {
        return $this->belongsTo(Language::class, 'Nyelv_ID');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'TermekfaLevel_ID');
    }
}
