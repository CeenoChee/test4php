<?php

namespace App\Interfaces;

interface HasTranslation
{
    public function transes();

    public function trans(int $languageId);
}
