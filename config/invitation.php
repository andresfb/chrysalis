<?php

return [

    'ranges' => [
        'low' => [
            'prices' => ['min' => 0, 'max' => 999],
            'link' => env('INVITATION_PRICE_LOW_LINK'),
        ],
        'medium' => [
            'prices' => ['min' => 1000, 'max' => 2999],
            'link' => env('INVITATION_PRICE_MEDIUM_LINK'),
        ],
        'right' => [
            'prices' => ['min' => 3000, 'max' => 9999],
            'link' => '',
        ],
        'high' => [
            'prices' => ['min' => 10000, 'max' => 9223372036854775807],
            'link' => env('INVITATION_PRICE_HIGH_LINK'),
        ],
    ],

    'expires_hours' => env('INVITATION_EXPIRES_HOURS', 24),

    'slack_webhook_url' => env('INVITATION_SLACK_WEBHOOK_URL'),
];
