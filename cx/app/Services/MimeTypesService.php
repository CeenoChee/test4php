<?php

namespace App\Services;

use Illuminate\Support\Collection;

class MimeTypesService
{
    public const UNKNOWN_FILE_TYPE = 'application/octet-stream';

    public static array $mimeTypes = [
        'basic' => [
            'txt' => 'text/plain',
            'csv' => 'text/csv',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            'unknown' => self::UNKNOWN_FILE_TYPE,
        ],
        'images' => [
            // Images
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
        ],
        'archives' => [
            // Archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
        ],
        'audio_video' => [
            // Audio/video
            'mpg' => 'audio/mpeg',
            'mp2' => 'audio/mpeg',
            'mp3' => 'audio/mpeg',
            'mp4' => 'audio/mp4',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'ogg' => 'audio/ogg',
            'oga' => 'audio/ogg',
            'wav' => 'audio/wav',
            'webm' => 'audio/webm',
            'aac' => 'audio/aac',
            'avi' => 'video/avi',
        ],
        'adobe' => [
            // Adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
        ],
        'ms_office' => [
            // MS Office
            'doc' => 'application/msword',
            'dot' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
            'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'xlt' => 'application/vnd.ms-excel',
            'xla' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
            'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pot' => 'application/vnd.ms-powerpoint',
            'pps' => 'application/vnd.ms-powerpoint',
            'ppa' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
            'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
            'mdb' => 'application/vnd.ms-access',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ],
        'more' => [
            'es3' => 'application/vnd.eszigno3+xml',
        ],
    ];

    public static $blackListMimes = [
        'application/x-msdownload',
    ];

    public function get(string $extension): string
    {
        if ($extension === '') {
            return static::UNKNOWN_FILE_TYPE;
        }

        foreach (static::$mimeTypes as $mimeGroup => $mimeTypes) {
            if (array_key_exists($extension, $mimeTypes)) {
                return static::$mimeTypes[$mimeGroup][$extension];
            }
        }

        return static::UNKNOWN_FILE_TYPE;
    }

    public function getWithExtension(string $extension): string
    {
        if ($extension === '') {
            return static::UNKNOWN_FILE_TYPE;
        }

        foreach (static::$mimeTypes as $mimeGroup => $mimeTypes) {
            if (array_key_exists($extension, $mimeTypes)) {
                return static::$mimeTypes[$mimeGroup][$extension] . ",.{$extension}";
            }
        }

        return static::UNKNOWN_FILE_TYPE;
    }

    /**
     * Retrives a concatenation of all mime types.
     */
    public function all(): string
    {
        $allTypes = [];

        foreach (static::$mimeTypes as $mimeTypes) {
            $allTypes = array_merge($allTypes, array_values($mimeTypes));
        }

        return $this->concatenate(array_unique(array_values($allTypes)));
    }

    /**
     * Make concatenate string of mime types.
     */
    public function concatenate(array $rules): string
    {
        if ($rules instanceof Collection) {
            $mimeTypes = $rules->map(fn ($rule) => $this->getWithExtension($rule->pivot->value))->toArray();
        } else {
            $mimeTypes = $rules;
        }

        foreach ($mimeTypes as $key => $mimeType) {
            if (! $this->isMimeTypeAccepted($mimeType)) {
                unset($mimeTypes[$key]);
            }
        }

        return implode(',', $mimeTypes);
    }

    public function isImageByMimeType(string $mimeType): bool
    {
        return in_array($mimeType, static::$mimeTypes['images']);
    }

    /**
     * Retrives a concatenation of all mime types except the given exceptions.
     *
     * @param $exceptions
     */
    public function allTypesExcept($exceptions): string
    {
        $allTypes = [];

        foreach (static::$mimeTypes as $mimeTypes) {
            $filteredMimeTypes = array_values($mimeTypes);
            if (is_array($exceptions)) {
                foreach ($exceptions as $exception) {
                    $matches = [];
                    foreach ($filteredMimeTypes as $key => $mimeType) {
                        if ($mimeType === $exception) {
                            $matches[] = $key;
                        }
                    }

                    foreach ($matches as $match) {
                        unset($filteredMimeTypes[$match]);
                    }
                }
            } else {
                $matches = [];
                foreach ($filteredMimeTypes as $key => $mimeType) {
                    if ($mimeType === $exceptions) {
                        $matches[] = $key;
                    }
                }

                foreach ($matches as $match) {
                    unset($filteredMimeTypes[$match]);
                }
            }

            $allTypes = array_merge($allTypes, $filteredMimeTypes);
        }

        return $this->concatenate(array_unique(array_values($allTypes)));
    }

    /**
     * Removes unknown and blacklisted mime types.
     */
    public function removeUnknownAndBlacklistedMimeTypes(array $extensions): array
    {
        $filteredExtensions = [];
        foreach ($extensions as $extension) {
            foreach (static::$mimeTypes as $mimeTypes) {
                if (array_key_exists($extension, $mimeTypes) && $this->isMimeTypeAccepted($this->get($extension))) {
                    $filteredExtensions[] = $extension;
                }
            }
        }

        return $filteredExtensions;
    }

    public function getExtensionByMimeType($mimeTypes): array
    {
        $extensions = [];

        if (is_array($mimeTypes)) {
            foreach (static::$mimeTypes as $staticMimeTypes) {
                foreach ($mimeTypes as $mimeType) {
                    if ($extension = array_search($mimeType, $staticMimeTypes)) {
                        $extensions[] = $extension;
                    }
                }
            }
        } else {
            foreach (static::$mimeTypes as $staticMimeTypes) {
                if ($extension = array_search($mimeTypes, $staticMimeTypes)) {
                    $extensions[] = $extension;
                }
            }
        }

        return $extensions;
    }

    public function getMimeTypeByExtension($extensions): array
    {
        $mimeTypes = [];

        if (is_array($extensions)) {
            foreach (static::$mimeTypes as $staticMimeTypes) {
                foreach ($extensions as $extension) {
                    if (array_key_exists($extension, $staticMimeTypes)) {
                        $mimeTypes[] = $staticMimeTypes[$extension];
                    }
                }
            }
        } else {
            foreach (static::$mimeTypes as $staticMimeTypes) {
                if (array_key_exists($extensions, $staticMimeTypes)) {
                    $mimeTypes[] = $staticMimeTypes[$extensions];
                }
            }
        }

        return $mimeTypes;
    }

    private function isMimeTypeAccepted(string $mimeType): bool
    {
        return ! in_array($mimeType, static::$blackListMimes);
    }
}
