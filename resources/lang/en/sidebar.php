<?php

use Illuminate\Support\Facades\Route;

return [
    'module' => [
        [
            'title' => "Article Management",
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModel' => [
                [
                    'title' => 'Article Group',
                    'route' => '/post/catalogue'
                ],
                [
                    'title' => 'Article',
                    'route' => '/post'
                ]
            ]
        ],
        [
            'title' => "User Management",
            'icon' => 'fa fa-user',
            'name' => ['user'],
            'subModel' => [
                [
                    'title' => 'User Group',
                    'route' => '/user/catalogue'
                ],
                [
                    'title' => 'User',
                    'route' => '/user'
                ],
                [
                    'title' => 'Permission',
                    'route' => '/permission'
                ]
            ]
        ],
        [
            'title' => "General Configuration",
            'icon' => 'fa fa-user',
            'name' => ['language'],
            'subModel' => [
                [
                    'title' => 'Language',
                    'route' => '/language'
                ]
            ]
        ],
    ]
];
