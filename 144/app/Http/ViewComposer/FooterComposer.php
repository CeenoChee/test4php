<?php

namespace App\Http\ViewComposer;

use App\Models\ProductCategory;
use Illuminate\View\View;

class FooterComposer
{
    protected $productCategories;

    public function __construct()
    {
        if (auth()->user()) {
            $categories = ProductCategory::from('termekfa_level as tl')
                ->whereParent('tl')
                ->whereDoesntHaveBlacklistedProduct('tl')
                ->with('trans')
                ->get();
        } else {
            $categories = ProductCategory::whereParent()->with('trans')->get();
        }

        $this->productCategories = $categories;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $view->with('productCategories', $this->productCategories);
    }
}
