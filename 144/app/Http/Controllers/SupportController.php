<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportSearchRequest;
use App\Repositories\DownloadCategoryRepository;
use App\Repositories\DownloadRepository;
use App\Repositories\KnowledgeCategoryRepository;
use App\Repositories\KnowledgeRepository;
use App\Repositories\VideoRepository;

class SupportController extends Controller
{
    public function index()
    {
        $knowledgeCategories = (new KnowledgeCategoryRepository())->getActive()->take(4);
        $downloadCategories = (new DownloadCategoryRepository())->list()->take(4);
        $videos = (new VideoRepository())->getMostPopular();

        return view('pages.support.index', compact('knowledgeCategories', 'downloadCategories', 'videos'));
    }

    public function results(SupportSearchRequest $request)
    {
        return view('pages.support.results', [
            'keyword' => $request->keyword,
            'downloads' => (new DownloadRepository())->search($request->keyword),
            'knowledges' => (new KnowledgeRepository())->getActiveByKeyword($request->keyword),
            'knowledgeCategories' => (new KnowledgeCategoryRepository())->getActiveByKeyword($request->keyword),
            'videos' => (new VideoRepository())->search($request->keyword),
        ]);
    }
}
