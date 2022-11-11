<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportSearchRequest;
use App\Libs\LUrl;
use App\Repositories\VideoCategoryRepository;
use App\Repositories\VideoRepository;

class VideoController extends Controller
{
    protected VideoCategoryRepository $videoCategoryRepo;
    protected VideoRepository $videoRepo;

    public function __construct(VideoCategoryRepository $videoCategoryRepo, VideoRepository $videoRepo)
    {
        $this->videoCategoryRepo = $videoCategoryRepo;
        $this->videoRepo = $videoRepo;
    }

    public function index()
    {
        $categories = $this->videoCategoryRepo->list();

        return view('pages.videos.index', compact('categories'));
    }

    public function showCategory(string $slug)
    {
        $category = $this->videoCategoryRepo->firstOrFailBySlug($slug);

        $categories = $this->videoCategoryRepo->list();

        return view('pages.videos.show', compact('category', 'categories'));
    }

    public function search(SupportSearchRequest $request)
    {
        $keyword = $request->keyword;

        if (empty($keyword)) {
            return redirect(LUrl::route('videos.index'));
        }

        $videos = $this->videoRepo->search($keyword);

        return view('pages.videos.results', compact('keyword', 'videos'));
    }
}
