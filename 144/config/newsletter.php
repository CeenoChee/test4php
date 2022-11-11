<?php

return [
    /*
     * The driver to use to interact with MailChimp API.
     * You may use "log" or "null" to prevent calling the
     * API directly from your environment.
     */
    'driver' => env('MAILCHIMP_DRIVER', 'api'),

    /*
     * The API key of a MailChimp account. You can find yours at
     * https://us10.admin.mailchimp.com/account/api-key-popup/.
     */
    'apiKey' => '8ee914a276dc3b323ec2891a52c4dcce-us9',

    // The listName to use when no listName has been specified in a method.
    'defaultListName' => env('DEFAULT_NEWSLETTER_LIST_NAME', 'test'),

    // Here you can define properties of the lists.
    'lists' => [
        /*
         * This key is used to identify this list. It can be used
         * as the listName parameter provided in the various methods.
         *
         * You can set it to any string you want and you can add
         * as many lists as you want.
         */
        'subscribers' => [
            /*
             * A MailChimp list id. Check the MailChimp docs if you don't know
             * how to get this value:
             * http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id.
             */
            'id' => '091a7902b7',
        ],
        'test' => [
            'id' => '8586782653',
        ],
    ],

    // If you're having trouble with https connections, set this to false.
    'ssl' => true,
];
