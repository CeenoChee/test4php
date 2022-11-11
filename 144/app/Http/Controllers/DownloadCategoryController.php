<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Repositories\DownloadCategoryRepository;

class DownloadCategoryController extends Controller
{
    protected DownloadCategoryRepository $downloadCategoryRepo;

    public function __construct(
        DownloadCategoryRepository $downloadCategoryRepo
    ) {
        $this->downloadCategoryRepo = $downloadCategoryRepo;
    }

    public function index()
    {
        return view('pages.downloads.categories.index', ['downloadCategories' => $this->downloadCategoryRepo->getRoots()]);
    }

    public function show(string $downloadCategorySlug)
    {
        $category = $this->downloadCategoryRepo->firstOrFailBySlug($downloadCategorySlug);

        if (! $category) {
            return redirect(LUrl::route('downloads.index'));
        }

        $childCategories = $this->downloadCategoryRepo->getChildren($category);

        if ($category->parent) {
            $siblingCategories = $this->downloadCategoryRepo->getChildren($category->parent);
        } else {
            $siblingCategories = null;
        }

        return view('pages.downloads.categories.show', [
            'rootCategories' => $this->downloadCategoryRepo->getRoots(),
            'category' => $category,
            'childCategories' => $childCategories,
            'siblingCategories' => $siblingCategories,
        ]);
    }
}
