<?php

namespace App\Libs;

class AttributeProduct
{
    private $belsoNev;
    private $nev;
    private $ertek;

    public function __construct($belsoNev, $nev, $ertek)
    {
        $this->belsoNev = $belsoNev;
        $this->nev = $nev;
        $this->ertek = $ertek;
    }

    public function getInnerName()
    {
        return $this->belsoNev;
    }

    public function getName()
    {
        return $this->nev;
    }

    public function getValue()
    {
        return $this->ertek;
    }
}
