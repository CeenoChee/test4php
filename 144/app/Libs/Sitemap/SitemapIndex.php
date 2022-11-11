<?php

namespace App\Libs\Sitemap;

class SitemapIndex extends Sitemap
{
    public function addSitemap($url, $lastMod = null)
    {
        $track = $this->xml->addChild('sitemap');
        $track->addChild('loc', $url);
        if ($lastMod === null) {
            $lastMod = $this->lastMod;
        }
        if ($lastMod !== null) {
            $track->addChild('lastmod', $lastMod);
        }
    }

    protected function getMainTag()
    {
        return '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>';
    }
}
