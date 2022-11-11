<?php

namespace App\Traits\Translations\Languages;

use App\Models\Language;

trait Hungarian
{
    public function transHU()
    {
        return $this->trans(Language::HU)->first();
    }

    public function getNameHuAttribute()
    {
        $trans = $this->transHU();

        return $trans ? $trans->name : null;
    }

    public function getSlugHuAttribute()
    {
        $trans = $this->transHU();

        return $trans ? $trans->slug : null;
    }

    public function getDescriptionHuAttribute()
    {
        $trans = $this->transHU();

        return $trans ? $trans->description : null;
    }
}
