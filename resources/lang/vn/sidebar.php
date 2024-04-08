<?php

use Illuminate\Support\Facades\Route;

return [
    'module' => [
        [
            'title' => "QL Bài viết",
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModel' => [
                [
                    'title' => 'QL Nhóm bài viết',
                    'route' => '/post/catalogue'
                ],
                [
                    'title' => 'QL Bài viết',
                    'route' => '/post'
                ]
            ]
        ],
        [
            'title' => "QL Nhóm thành viên",
            'icon' => 'fa fa-user',
            'name' => ['user', 'permission'],
            'subModel' => [
                [
                    'title' => 'QL Nhóm thành viên',
                    'route' => '/user/catalogue'
                ],
                [
                    'title' => 'QL Thành viên',
                    'route' => '/user'
                ],
                [
                    'title' => 'QL Quyền',
                    'route' => '/permission'
                ]
            ]
        ],
        [
            'title' => "Cấu hình chung",
            'icon' => 'fa fa-user',
            'name' => ['language'],
            'subModel' => [
                [
                    'title' => 'QL ngôn ngữ',
                    'route' => '/language'
                ]
            ]
        ],
    ]
];
