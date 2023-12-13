<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => 'dashboard',
            'new-tab' => false,
        ],

        // Users
        [
            'section' => 'Users',
            'permissions' => ['admin']
        ],
        [
            'title' => 'Members',
            'icon' => 'media/svg/icons/Communication/Add-user.svg',
            'bullet' => 'dot',
            'root' => true,
            'permissions' => ['admin'],
            'submenu' => [
                [
                    'title' => ' List of members',
                    'bullet' => 'dot',
                    'page' => 'members.list',
                ],
            ]
        ],

        // Pages
        [
            'section' => 'Layout',
            'permissions' => ['admin']
        ],
        [
            'title' => 'Pages',
            'icon' => 'media/svg/icons/Shopping/Barcode-read.svg',
            'bullet' => 'dot',
            'root' => true,
            'permissions' => ['admin'],
            'submenu' => [
                [
                    'title' => 'List pages',
                    'bullet' => 'dot',
                    'page' => 'pages.list',
                    'permissions' => ['admin'],
                ],
                [
                    'title' => 'Add a new page',
                    'bullet' => 'dot',
                    'page' => 'page.add',
                    'permissions' => ['admin'],
                ],
            ]
        ],

        // Contents
        [
            'section' => 'Content',
            'permissions' => ['admin']
        ],
        [
            'title' => 'Articles',
            'desc' => '',
            'icon' => 'media/svg/icons/Code/Compiling.svg',
            'bullet' => 'dot',
            'root' => true,
            'permissions' => ['admin'],
            'submenu' => [
                [
                    'title' => 'List of articles',
                    'bullet' => 'dot',
                    'page' => 'content.articles.list',
                    'permissions' => ['admin'],
                ],
                [
                    'title' => 'Categories of articles',
                    'bullet' => 'dot',
                    'page' => 'content.articles.categories.list',
                    'permissions' => ['admin'],
                ]
            ]
        ],

        [
            'title' => 'NFT',
            'desc' => '',
            'icon' => 'media/svg/icons/Food/Wine.svg',
            'bullet' => 'dot',
            'page' => 'content.nft.list',
            'root' => true,
            'permissions' => ['admin'],
        ],

        [
            'section' => 'Config',
            'permissions' => ['admin']
        ],
        [
            'title' => 'Settings',
            'icon' => 'media/svg/icons/Shopping/Settings.svg',
            'bullet' => 'dot',
            'root' => true,
            'permissions' => ['admin'],
            'submenu' => [
                [
                    'title' => 'Languages',
                    'bullet' => 'dot',
                    'page' => 'settings.languages',
                    'permissions' => ['admin'],
                ],
                [
                    'title' => 'Sites',
                    'bullet' => 'dot',
                    'page' => 'settings.sites',
                    'permissions' => ['admin'],
                ],
            ],
        ],
        [
            'title' => 'Accounts',
            'icon' => 'media/svg/icons/Files/User-folder.svg',
            'bullet' => 'dot',
            'root' => true,
            'permissions' => ['admin'],
            'submenu' => [
                [
                    'title' => 'Administrators',
                    'bullet' => 'dot',
                    'page' => 'employees.list',
                    'permissions' => ['admin'],
                ],

            ]
        ]
    ]
];
