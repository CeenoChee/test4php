<?php

namespace App\Services;

use App\Repositories\KnowledgeRepository;
use App\Repositories\SyncFromWebRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class KnowledgeService
{
    protected KnowledgeRepository $knowledgeRepo;

    public function __construct(KnowledgeRepository $knowledgeRepo)
    {
        $this->knowledgeRepo = $knowledgeRepo;
    }

    public function setViewCookie(string $slug)
    {
        if (! Cookie::has('knowledge_views_' . $slug)) {
            $knowledge = (new KnowledgeRepository())->firstActiveBySlug($slug);

            if ($knowledge) {
                $knowledge->increment('views');

                (new SyncFromWebRepository())->updateKnowledgeViews(['id' => $knowledge->id, 'views' => $knowledge->views]);

                $response = new Response();
                $response->withCookie(cookie('knowledge_views_' . $slug, 'true', $twelveHours = 720));

                return $response;
            }
        }

        return false;
    }
}
