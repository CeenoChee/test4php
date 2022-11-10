<?php

namespace App\Libs\Sitemap;

abstract class Sitemap
{
    protected $xml;
    protected $lastMod;

    public function __construct()
    {
        $this->xml = new \SimpleXMLElement($this->getMainTag());
    }

    public function setLastmod($lastmod)
    {
        $this->lastMod = $lastmod;
    }

    public function download()
    {
        header('Content-type: text/xml');
        echo $this->xml->asXML();

        exit;
    }

    abstract protected function getMainTag();
}
