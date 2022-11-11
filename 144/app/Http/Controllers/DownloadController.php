<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportSearchRequest;
use App\Models\Download;
use App\Repositories\DownloadRepository;

class DownloadController extends Controller
{
    protected DownloadRepository $downloadRepo;

    public function __construct(
        DownloadRepository $downloadRepo
    ) {
        $this->downloadRepo = $downloadRepo;
    }

    public function show(Download $download)
    {
        return view('pages.downloads.show', compact('download'));
    }

    public function results(SupportSearchRequest $request)
    {
        return view('pages.downloads.results', [
            'keyword' => $request->keyword,
            'downloads' => $this->downloadRepo->search($request->keyword),
        ]);
    }
}
