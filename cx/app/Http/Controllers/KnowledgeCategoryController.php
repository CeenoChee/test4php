<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Repositories\KnowledgeCategoryRepository;

class KnowledgeCategoryController extends Controller
{
    public function show(string $slug)
    {
        $knowledgeCategoryRepo = new KnowledgeCategoryRepository();

        $category = $knowledgeCategoryRepo->firstActiveBySlug($slug);

        if (! $category) {
            return redirect(LUrl::route('knowledge.index'));
        }

        $childCategories = $knowledgeCategoryRepo->getActiveChildren($category);

        $videos = [];
        if ($category->parent) {
            $siblingCategories = $knowledgeCategoryRepo->getActiveChildren($category->parent);
        } else {
            $siblingCategories = null;

            foreach ($category->knowledges as $knowledge) {
                if ($knowledge->videos->count() > 0) {
                    $videos[$category->id] = $knowledge->videos;
                }
            }

            foreach ($childCategories as $childCategory) {
                foreach ($childCategory->knowledges as $knowledge) {
                    if ($knowledge->videos->count() > 0) {
                        if (! isset($videos[$childCategory->id])) {
                            $videos[$childCategory->id] = $knowledge->videos;
                        } else {
                            $videos[$childCategory->id] = $videos[$childCategory->id]->merge($knowledge->videos);
                        }
                    }
                }
            }
        }

        return view('pages.knowledges.categories.show', [
            'rootCategories' => $knowledgeCategoryRepo->getRoots(),
            'category' => $category,
            'videos' => $videos,
            'childCategories' => $childCategories,
            'siblingCategories' => $siblingCategories,
        ]);
    }
}
