<?php

namespace App\Http\ViewComposer;

use App\Models\ProductCategory;
use App\Repositories\DownloadCategoryRepository;
use App\Repositories\KnowledgeCategoryRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MainMenuComposer
{
    public function compose(View $view)
    {
        $view->with('parentCategories', Cache::remember('main_menu_categories_' . app('Lang')->getLocale(), 3600, function () {
            return ProductCategory::from('termekfa_level as tl')
                ->whereParent('tl')
                ->whereDoesntHaveBlacklistedProduct('tl')
                ->orderBy('Sorrend')
                ->with(['children', 'trans'])
                ->get();
        }));

        $view->with('mainMenuDownloadCategories', resolve(DownloadCategoryRepository::class)->list()->take(10));

        $view->with('knowledgeCategories', (new KnowledgeCategoryRepository())->getRoots());
    }
}
