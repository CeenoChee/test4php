<?php

return [
    'dev_users' => [
        'bednarik.daniel@riel.hu',
        'molnar.david@riel.hu',
        'marton.szilard@riel.hu',
        'mfox0901@gmail.com',
        'latyakmail@gmail.com',
    ],
    'emails' => [
        'register' => [
            'email' => 'regisztracio@riel.hu',
            'name' => 'RIEL Regisztráció',
        ],
        'contact' => [
            'email' => 'ajanlat@riel.hu',
            'name' => 'RIEL Kapcsolat',
        ],
        'ticket' => [
            'email' => 'support@riel.hu',
            'name' => 'RIEL Hibajegy',
        ],
        'order' => [
            'email' => 'rendeles@riel.hu',
            'name' => 'RIEL Rendelés',
        ],
        'dev' => [
            'email' => 'dev@riel.hu',
            'name' => 'Fejlesztőknek',
        ],
    ],
    'warehouse' => [
        'default' => 'KHR',

        // Saját raktárak amiket az ügyfél készletként összesítve lát.
        'inner' => [
            'KPR',
            'KHR',
        ],
        // Külső raktárak
        'external' => [
            'TE-HIKEU',
        ],
    ],
    'tax' => 27,
    'api' => [
        'host' => env('API_HOST'),
    ],
    'simplepay' => [
        // HUF merchant account ID and secret key
        'HUF_MERCHANT' => 'S443901',
        'HUF_SECRET_KEY' => 'BZespIT0WdOobdjJqwgTBwXBXFyVIi0WDxa6tZzFwIU=',
        // EUR merchant account ID and secret key
        'EUR_MERCHANT' => 'S443902',
        'EUR_SECRET_KEY' => 'ywUWzuYU+u2SRQko1GtNQxjOWnLx5N7lRUTP5XIycwQ=',
        // USD merchant account ID and secret key
        'USD_MERCHANT' => 'S443903',
        'USD_SECRET_KEY' => '3g0rqXwytLUo0QzJnaHhP7DwAY1htz2OQhaxZRc9hX0=',
        // Sandbox mode
        'SANDBOX' => env('SIMPLE_SANDBOX', true),
        // Time out
        'TIMEOUT' => 600,
    ],
    'titan_app_url' => env('TITAN_APP_URL', 'localhost'),
    'files_app_url' => env('FILES_APP_URL', 'http://files.riel.hu'),
    'youtube' => [
        'key' => 'AIzaSyCOD4LhmgXOMyd-hRF8u9ttZaj5OqcV73I',
    ],
    'stage' => env('APP_STAGE'),

    'nav_user_data' => [
        'login' => 'cvfhmjmk836jfqr',
        'password' => 'Riel20220817',
        'taxNumber' => '12172171',
        'signKey' => '33-a177-eed373635d413VJ8BMOVDFXU',
        'exchangeKey' => '9a5a3VJ8BMOVFXPY',
    ],

    'nav_software_data' => [
        'softwareId' => 'HU10788110SERPA003',
        'softwareName' => 'sERPa',
        'softwareOperation' => 'LOCAL_SOFTWARE',
        'softwareMainVersion' => '4.0',
        'softwareDevName' => 'ProgEn',
        'softwareDevContact' => 'serpasupport@progen.hu',
        'softwareDevCountryCode' => 'HU',
    ],
];
