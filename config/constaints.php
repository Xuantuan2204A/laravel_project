<?php
return [
    'user' => [
        'role' => [
            'admin' => 1,
            'user' => 2,
        ],
        'status' => [
            'active' => 1,
            'inactive' => 0,
        ],
        'account_type' => [
            'trial' => 0,
            'signed_contract' => 1,
        ],
        'project' => [
            'colors' => ['#3f9df3', '#b3a6f2', '#dc95e4', '#ffa09e', '#ffb833', '#aad539', '#37d279', '#66ff99', '#00ccff', '#3366ff', '#ff8533', '#ffb84d', '#993300', '#999966', '#336600'],
        ],
        'elastic_search' => [
            'trial' => [
                'facebook' => 'mo-facebook-trial',
                'ifollow' => 'mo-ifollow-trial',
                'paper' => 'mo-paper-trial',
                'tv' => 'mo-tv-trial',
                'twitter' => 'mo-twitter-trial',
                'tiktok' => 'mo-tiktok-trial',
                'youtube' => 'mo-youtube-trial',
                'app' => 'mo-review-app-trial',
                'instagram' => 'mo-instagram-trial',
            ],
            'final' => [
                'facebook' => 'mo-facebook',
                'ifollow' => 'mo-ifollow',
                'paper' => 'mo-paper',
                'tv' => 'mo-tv',
                'twitter' => 'mo-twitter',
                'tiktok' => 'mo-tiktok',
                'youtube' => 'mo-youtube',
                'app' => 'mo-review-app',
                'instagram' => 'mo-instagram',
            ],
            "channels" => [
                1 => 'facebook',
                2 => 'ifollow',
                3 => 'paper',
                4 => 'tv',
                5 => 'youtube',
                6 => 'twitter',
                7 => 'tiktok',
                8 => 'review-app',
                9 => 'instagram',
            ],
            "state" => [
                0 => 'neutral',
                1 => 'positive',
                2 => 'negative',
            ],
            "type" => [
                0 => 'post',
                1 => 'comment',
                2 => 'image',
            ],
            "name_channel_excels" => [
                1 => 'Social',
                2 => 'News',
                3 => 'Newspaper',
                4 => 'TV',
                5 => 'Youtube',
                6 => 'Twitter',
                7 => 'Tiktok',
                8 => 'Review App',
                9 => 'Instagram',
            ],
        ],
        'sentiment_ids' => [0, 1, 2],
        'channel_ids' => [1, 2, 3, 4, 5, 6, 7, 8, 9]
    ],
];
