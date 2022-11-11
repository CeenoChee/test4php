<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportSearchRequest;
use App\Libs\LUrl;
use App\Repositories\KnowledgeCategoryRepository;
use App\Repositories\KnowledgeRepository;
use App\Services\KnowledgeService;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index()
    {
        return view('pages.knowledges.categories.index', [
            'categories' => (new KnowledgeCategoryRepository())->getRoots(),
        ]);
    }

    public function show(string $categorySlug, string $slug)
    {
        $knowledge = (new KnowledgeRepository())->firstActiveBySlug($slug);

        if (! $knowledge) {
            return redirect(LUrl::route('knowledge.index'));
        }

        return view('pages.knowledges.show', [
            'categories' => (new KnowledgeCategoryRepository())->getActive(),
            'category' => (new KnowledgeCategoryRepository())->firstActiveBySlug($categorySlug),
            'knowledge' => $knowledge,
        ]);
    }

    public function results(SupportSearchRequest $request)
    {
        return view('pages.knowledges.results', [
            'keyword' => $request->keyword,
            'knowledges' => (new KnowledgeRepository())->getActiveByKeyword($request->keyword),
            'categories' => (new KnowledgeCategoryRepository())->getActiveByKeyword($request->keyword),
        ]);
    }

    public function compatibility_intercom()
    {
        return view('pages.knowledges.compatibility-intercom');
    }

    public function ajaxIncreaseViews(Request $request)
    {
        return resolve(KnowledgeService::class)->setViewCookie($request->slug);
    }
}
