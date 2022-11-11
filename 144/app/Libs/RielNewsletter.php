<?php

namespace App\Libs;

use App\Models\Newsletter;
use App\Models\Subscription;
use App\Models\User;
use App\Repositories\SyncFromWebRepository;
use Illuminate\Support\Facades\DB;
use Spatie\Newsletter\NewsletterFacade;

class RielNewsletter
{
    protected string $newsletterList = 'test';

    public function __construct()
    {
        $this->newsletterList = config('riel.stage') === 'prod' ? 'subscribers' : $this->newsletterList;
    }

    public function update(User $user)
    {
        $userInfo = new UserInfo($user);

        $email = $userInfo->getEmail();

        NewsletterFacade::subscribeOrUpdate($email, [
            'FNAME' => $userInfo->getFirstName(),
            'LNAME' => $userInfo->getLastName(),
            'COMPANY' => $userInfo->getCompanyName(),
            'COUNTRY' => (string) $userInfo->getCountry(),
            'ZIPCODE' => $userInfo->getPostcode(),
            'CITY' => $userInfo->getCity(),
            'URL' => route('newsletter.subscriptions.edit', ['id' => $user->id, 'hash' => $this->getHash($user)]),
            'GROUP' => $this->getGroup($user),
        ], $this->newsletterList);

        $tags = $this->getTags($user);
        $this->updateTags($email, $tags);

        $data = [];
        foreach (Newsletter::all() as $newsletter) {
            $data[$newsletter->name] = in_array($newsletter->name, $tags);
        }

        (new SyncFromWebRepository())->updateNewsletterSubscriptions($user, $data);
    }

    public function updateSubscriptions(User $user, array $newsletterIds)
    {
        Subscription::where('user_id', $user->id)->delete();

        $data = array_map(function ($newsletterId) use ($user) {
            return [
                'user_id' => $user->id,
                'newsletter_id' => $newsletterId,
            ];
        }, $newsletterIds);

        Subscription::insert($data);
    }

    public function unsubscribeFromAll(User $user)
    {
        Subscription::where('user_id', $user->id)->delete();
    }

    public function getTags(User $user): array
    {
        return DB::table('newsletters')
            ->join('subscriptions', 'newsletters.id', '=', 'subscriptions.newsletter_id')
            ->where('subscriptions.user_id', $user->id)
            ->pluck('newsletters.name')
            ->toArray();
    }

    public function getHash(User $user): string
    {
        return md5(serialize([$user->id, $user->email, 'newsletter']));
    }

    public function getGroup(User $user)
    {
        $row = DB::table('csop_fizetesi_feltetel')
            ->join('ugyfel', 'ugyfel.CsopFizetesiFeltetel_ID', '=', 'csop_fizetesi_feltetel.CsopFizetesiFeltetel_ID')
            ->join('ugyfel_dolgozo', 'ugyfel_dolgozo.Ugyfel_ID', '=', 'ugyfel.Ugyfel_ID')
            ->join('users', 'users.email', '=', 'ugyfel_dolgozo.WebLogin')
            ->where('users.id', $user->id)
            ->select('csop_fizetesi_feltetel.Nev')->first();

        if ($row) {
            $nev = explode('-', $row->Nev);
            if ($nev) {
                return trim($nev[0]);
            }

            return $nev;
        }

        return '';
    }

    private function updateTags($email, $newTags)
    {
        $oldTags = [];
        $tagRows = NewsletterFacade::getTags($email);
        foreach ($tagRows['tags'] as $tagRow) {
            $oldTags[] = $tagRow['name'];
        }

        $removeTags = array_diff($oldTags, $newTags);
        if (count($removeTags)) {
            NewsletterFacade::removeTags($removeTags, $email);
        }

        $addTags = array_diff($newTags, $oldTags);
        if (count($addTags)) {
            NewsletterFacade::addTags($addTags, $email);
        }
    }
}
