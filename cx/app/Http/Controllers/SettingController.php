<?php

namespace App\Http\Controllers;

use App\Libs\RielNewsletter;
use App\Models\Newsletter;

class SettingController extends Controller
{
    protected RielNewsletter $rielNewsletter;

    public function __construct(RielNewsletter $rielNewsletter)
    {
        $this->rielNewsletter = $rielNewsletter;
    }

    public function index()
    {
        return view('pages.settings.index', [
            'user' => app('User'),
            'newsletters' => Newsletter::orderBy('Label')->get(),
            'checked' => $this->rielNewsletter->getTags(app('User')->getUser()),
        ]);
    }
}
