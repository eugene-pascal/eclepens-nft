<?php

return [
    'structure' => [
        [
            'label' => 'Dashboard', 
            'url'   => '/cpanel',
            'options' => [],
            'template' => '<a href="{url}"><i class="icon-home"></i><span class="title">{label}</span></a>',
            'items'    => []
        ],
        [
            'label' => 'Landing pages', 
            'url'   => '/cpanel/lp', 
            'options' => [],
            'template' => '<a href="{url}"><i class="icon-diamond"></i><span class="title">{label}</span><span class="arrow"></span></a>',
            'items'    => [
                [
                    'label' => 'List pages', 
                    'url'   => '/cpanel/lp/list', 
                    'options' => [],
                    'template' => '<a href="{url}"><i class="icon-docs"></i><span class="title">{label}</span></a>',
                    'items' => [
                        [
                            'label' => 'Create a new page', 
                            'url'   => '/cpanel/lp/create',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-rocket"></i><span class="title">{label}</span></a>'
                        ],
                        [
                            'label' => 'Edit the landing page', 
                            'url'   => '/cpanel/lp/edit/{id}',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-pencil"></i><span class="title">{label}</span></a>'
                        ],
                    ]
                ],
                [
                    'label' => 'List page\'s types', 
                    'url'   => '/cpanel/lp/list/types',
                    'options' => [],
                    'template' => '<a href="{url}"><i class="icon-grid"></i><span class="title">{label}</span></a>',
                    'items' => [
                        [
                            'label' => 'Create a new page\'s type', 
                            'url'   => '/cpanel/lp/create/type',
                            'visible' => false,
                            'options' => [],
                            'template' => '<a href="{url}"><i class="icon-plus"></i><span class="title">{label}</span></a>'
                        ],
                        [
                            'label' => 'Edit page\'s type', 
                            'url'   => '/cpanel/lp/edit/type/{id}',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-pencil"></i><span class="title">{label}</span></a>'
                        ],
                    ]
                ],
                
            ]
        ],
        // [
        //     'label' => 'UI Components', 
        //     'url'   => '#', 
        //     'options' => [],
        //     'template' => '<a href="{url}"><i class="icon-puzzle"></i><span class="title">{label}</span><span class="arrow"></span></a>',
        //     'items'    => [
        //         [
        //             'label' => 'List UI components', 
        //             'url'   => '#', 
        //             'options' => [],
        //             'template' => '<a href="{url}"><i class="icon-list"></i><span class="title">{label}</span></a>'
        //         ],
        //         [
        //             'label' => 'Add a new one', 
        //             'url'   => '#', 
        //             'options' => [],
        //             'template' => '<a href="{url}"><i class="icon-picture"></i><span class="title">{label}</span></a>'
        //         ],
        //     ]
        // ],
        [
            'label' => 'Statistics', 
            'url'   => '#', 
            'options' => [],
            'template' => '<a href="{url}"><i class="icon-bar-chart"></i><span class="title">{label}</span><span class="arrow"></span></a>',
            'items'    => [
                [
                    'label' => 'GEO statistic', 
                    'url'   => '#', 
                    'options' => [],
                    'template' => '<a href="{url}"><i class="icon-globe"></i><span class="title">{label}</span></a>'
                ]
            ]
        ],
        [
            'label' => 'Settings', 
            'url'   => '/cpanel/settings', 
            'options' => [],
            'template' => '<a href="{url}"><i class="icon-settings"></i><span class="title">{label}</span><span class="arrow"></span></a>',
            'items'    => [
                [
                    'label' => 'The list of the OneSignal IDs', 
                    'url'   => '/cpanel/settings/onesignal', 
                    'options' => [],
                    'template' => '<a href="{url}"><i class="icon-wrench"></i><span class="title">{label}</span></a>',
                    'items'    => [
                        [
                            'label' => 'Create <u>OneSignal ID</u>', 
                            'url'   => '/cpanel/settings/onesignal/create', 
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-plus"></i><span class="title">{label}</span></a>'
                        ],
                        [
                            'label' => 'Edit OneSignal ID', 
                            'url'   => '/cpanel/settings/onesignal/edit/{id}',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-pencil"></i><span class="title">{label}</span></a>'
                        ],

                    ]
                ],

                [
                    'label' => 'The list of the Adrack IDs', 
                    'url'   => '/cpanel/settings/adrack', 
                    'options' => [],
                    'template' => '<a href="{url}"><i class="icon-settings"></i><span class="title">{label}</span></a>',
                    'items'    => [
                        [
                            'label' => 'Create Adrack ID', 
                            'url'   => '/cpanel/settings/adrack/create', 
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-plus"></i><span class="title">{label}</span></a>'
                        ],
                        [
                            'label' => 'Edit Adrack ID', 
                            'url'   => '/cpanel/settings/adrack/edit/{id}',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-pencil"></i><span class="title">{label}</span></a>'
                        ],

                    ]
                ],
                
                [
                    'label' => 'The list of the Exit Links', 
                    'url'   => '/cpanel/settings/exit_link', 
                    'options' => [],
                    'template' => '<a href="{url}"><i class="fa fa-list-alt"></i><span class="title">{label}</span></a>',
                    'items'    => [
                         [
                            'label' => 'Create <u>Exit Link</u>', 
                            'url'   => '/cpanel/settings/exit_link/create', 
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="fa fa-link"></i><span class="title">{label}</span></a>'
                        ],
                        [
                            'label' => 'Edit Exit_Link', 
                            'url'   => '/cpanel/settings/exit_link/edit/{id}',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-pencil"></i><span class="title">{label}</span></a>'
                        ],
                    ]
                ],

                [
                    'label' => 'The list of the Back Buttons', 
                    'url'   => '/cpanel/settings/back_button', 
                    'options' => [],
                    'template' => '<a href="{url}"><i class="fa fa-list"></i><span class="title">{label}</span></a>',
                    'items'    => [
                        [
                            'label' => 'Create <u>Back Button</u>', 
                            'url'   => '/cpanel/settings/back_button/create', 
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="fa fa-plus"></i><span class="title">{label}</span></a>'
                        ],
                        [
                            'label' => 'Edit Back_Button', 
                            'url'   => '/cpanel/settings/back_button/edit/{id}',
                            'options' => [],
                            'visible' => false,
                            'template' => '<a href="{url}"><i class="icon-pencil"></i><span class="title">{label}</span></a>'
                        ],
                    ]
                ],
            ]
        ]
    ]
];