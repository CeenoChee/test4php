<?php

namespace App\Libs\Sitemap;

class UrlSet extends Sitemap
{
    public function add($url, $priority = null, $lastMod = null, $changefreq = null, $alternate = [])
    {
        $track = $this->xml->addChild('url');
        $track->addChild('loc', $url);

        if ($lastMod === null) {
            $lastMod = $this->lastMod;
        }
        if ($lastMod !== null) {
            $track->addChild('lastmod', $lastMod);
        }
        if ($changefreq !== null) {
            $track->addChild('changefreq', $changefreq);
        }
        $track->addChild('priority', $priority === null ? '0.5' : $priority);

        foreach ($alternate as $lang => $href) {
            $alt = $track->addChild('xhtml:link', null, 'http://www.w3.org/1999/xhtml');
            $alt->addAttribute('rel', 'alternate');
            $alt->addAttribute('hreflang', $lang);
            $alt->addAttribute('href', $href);
        }
    }

    protected function getMainTag(): string
    {
        return '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml"/>';
    }
}
