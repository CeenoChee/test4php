<?php

namespace App\Libs;

use DateTime;

class Fct
{
    public static function price(Price $price = null): string
    {
        if ($price === null) {
            return '';
        }

        return (string) $price->exchange(app('User')->getCurrencyID());
    }

    public static function dateTime($dateTime)
    {
        $timestamp = strtotime($dateTime);

        switch (app('Lang')->getLocale()) {
            case 'hu':
                return date('Y-m-d H:i:s', $timestamp);

            case 'en':
            case 'de':
                return date('d-m-Y H:i:s', $timestamp);

            default:
                return $dateTime;
        }
    }

    public static function date($dateTime)
    {
        $timestamp = strtotime($dateTime);

        switch (app('Lang')->getLocale()) {
            case 'hu':
                return date('Y-m-d', $timestamp);

            case 'en':
            case 'de':
                return date('d-m-Y', $timestamp);

            default:
                return $dateTime;
        }
    }

    public function prepareRoute($parameters = []): string
    {
        $route = \Request::route();
        $currentRouteName = $route->getName();
        $params = array_merge(request()->all(), $route->parameters());

        return route($currentRouteName, array_merge($params, $parameters));
    }

    public static function remove_accent($str)
    {
        $a = ['À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'];
        $b = ['A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'];

        return str_replace($a, $b, $str);
    }

    public static function slugify($str): string
    {
        return strtolower(preg_replace(['/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'], ['', '-', ''], Fct::remove_accent($str)));
    }

    public static function highlight($str, $keyword)
    {
        $length = strlen($keyword);
        $keyword = strtolower($keyword);
        $pos = strpos(strtolower($str), $keyword);
        if ($pos === false) {
            return $str;
        }

        return substr($str, 0, $pos) . '<em>' . substr($str, $pos, $length) . '</em>' . self::highlight(substr($str, $pos + $length), $keyword);
    }

    // Jogosultságok gyors lekérdezése

    public static function isRiel()
    {
        return app('User')->isRiel();
    }

    public static function isRielActive()
    {
        return app('User')->isRielActive();
    }

    public static function isUser()
    {
        return app('User')->isLoggedIn();
    }

    public static function isDev()
    {
        return app('User')->isDev();
    }

    public static function isReseller()
    {
        return app('User')->isReseller();
    }

    public static function installerPrice()
    {
        return app('User')->installerPrice();
    }

    public static function hasPermission($permissions)
    {
        return app('User')->hasPermission($permissions);
    }

    public static function isCanOrder()
    {
        return app('User')->hasPermission('REND');
    }

    public function getLocale(): string
    {
        return app('Lang')->getLocale();
    }

    public static function timeElapsedString($datetime, $full = false, $lang = 'hu'): string
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        if ($lang == 'hu') {
            $string = [
                'y' => 'éve',
                'm' => 'hónapja',
                'w' => 'hete',
                'd' => 'napja',
                'h' => 'órája',
                'i' => 'perce',
                's' => 'másodperce',
            ];
        } else {
            $string = [
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            ];
        }

        foreach ($string as $k => &$v) {
            if ($diff->{$k}) {
                $v = $diff->{$k} . ' ' . $v;
                if ($lang == 'en') {
                    $v = $v . ($diff->{$k} > 1 ? 's' : '');
                }
            } else {
                unset($string[$k]);
            }
        }

        if (! $full) {
            $string = array_slice($string, 0, 1);
        }

        if ($lang == 'hu') {
            return $string ? implode(', ', $string) . '' : 'épp most';
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function formatBytes($bytes): string
    {
        $units = [
            1073741824 => 'GB',
            1048576 => 'MB',
            1024 => 'KB',
        ];

        foreach ($units as $value => $unit) {
            if (($bytes / $value) > 1) {
                return round($bytes / $value, 2) . ' ' . $unit;
            }
        }

        return $bytes . ' B';
    }

    public static function warranty($warranty)
    {
        $lang = app('Lang')->getLocale();
        if ($lang == 'hu') {
            return $warranty;
        }

        switch ($warranty) {
            case 'Fél év':
                return trans('dates.half_year');

            case 'Élettartam':
                return trans('dates.life_long');
        }

        $exp = explode(' ', $warranty);
        if (! $exp or count($exp) <= 1) {
            return $warranty;
        }

        switch ($exp[1]) {
            case 'év':
                $unit = trans('dates.year');

                break;

            case 'hónap':
                $unit = trans('dates.month');

                break;
        }

        return $exp[0] . ' ' . $unit;
    }

    public static function getMediaFileUrl($slug): string
    {
        return config('riel.files_app_url') . '/media/' . $slug;
    }

    public static function getMediaImageUrl($slug, $size = 'thumbnail'): string
    {
        return config('riel.files_app_url') . '/media/' . $size . '/' . $slug;
    }
}
