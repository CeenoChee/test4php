<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Libs\RielNewsletter;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    protected RielNewsletter $rielNewsletter;

    public function __construct(RielNewsletter $rielNewsletter)
    {
        $this->rielNewsletter = $rielNewsletter;
    }

    public function index()
    {
        return view('pages.newsletters.index', [
            'newsletters' => Newsletter::orderBy('Label')->get(),
            'checked' => $this->rielNewsletter->getTags(app('User')->getUser()),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->handleSubscriptions($request, app('User')->getUser());

        flash()->success('A beállítások el lettek mentve.');

        return redirect()->to(LUrl::route('newsletter.index'));
    }

    public function editSubscriptions($id, $hash)
    {
        $user = User::findOrFail($id);
        $userHash = $this->rielNewsletter->getHash($user);

        if ($userHash !== $hash) {
            abort(404);
        }

        return view('pages.newsletters.edit-subscriptions', [
            'newsletters' => Newsletter::orderBy('Label')->get(),
            'id' => $user->id,
            'hash' => $userHash,
            'checked' => $this->rielNewsletter->getTags($user),
        ]);
    }

    public function updateSubscriptions(Request $request, $id, $hash): RedirectResponse
    {
        $user = User::findOrFail($id);
        $userHash = $this->rielNewsletter->getHash($user);

        if ($userHash !== $hash) {
            abort(404);
        }

        $this->handleSubscriptions($request, $user);

        flash()->success('A beállítások el lettek mentve.');

        return redirect()
            ->route('newsletter.subscriptions.edit', ['id' => $user, 'hash' => $userHash]);
    }

    private function handleSubscriptions(Request $request, $user): void
    {
        if ($request->missing('newsletters')) {
            $this->rielNewsletter->unsubscribeFromAll($user);
        } else {
            $this->rielNewsletter->updateSubscriptions($user, $request->newsletters);
        }

        $this->rielNewsletter->update($user);
    }
}
