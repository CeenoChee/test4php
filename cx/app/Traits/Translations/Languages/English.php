<?php

namespace App\Traits\Translations\Languages;

use App\Models\Language;

trait English
{
    public function transEN()
    {
        return $this->trans(Language::EN)->first();
    }

    public function getNameEnAttribute()
    {
        $trans = $this->transEN();

        return $trans ? $trans->name : null;
    }

    public function getSlugEnAttribute()
    {
        $trans = $this->transEN();

        return $trans ? $trans->slug : null;
    }

    public function getDescriptionEnAttribute()
    {
        $trans = $this->transEN();

        return $trans ? $trans->description : null;
    }
}
