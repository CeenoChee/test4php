<?php

declare(strict_types=1);

namespace App\Classes;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class I18n
{
    public function getTranslations(): Collection
    {
        $files = File::files(resource_path('lang/' . App::getLocale()));
        $generals = collect($files)->flatMap(fn ($file) => [
            $file->getBasename('.php') => trans($file->getBasename('.php')),
        ]);

        $files = File::files(resource_path('lang/' . App::getLocale() . '/pages'));
        $pages = collect($files)->flatMap(fn ($file) => [
            $file->getBasename('.php') => trans('pages/' . $file->getBasename('.php')),
        ]);

        return $generals->mergeRecursive(['pages' => $pages]);
    }
}
