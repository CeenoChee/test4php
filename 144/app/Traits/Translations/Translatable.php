<?php

namespace App\Traits\Translations;

use App\Models\Language;
use App\Models\Translation;
use App\Traits\Translations\Languages\English;
use App\Traits\Translations\Languages\Hungarian;

trait Translatable
{
    use Hungarian;
    use English;

    public function trans(int $languageId = null)
    {
        $languageId = is_null($languageId) ? app('Lang')->getLanguageId() : $languageId;

        $trans = $this->transes()->where('language_id', $languageId)->first();

        if ($trans) {
            return $trans;
        }

        return $this->transes()->where('language_id', Language::HU)->first();
    }

    public function transes()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
}
