<?php

return [
    'member' => [
        'signup' => [
            'title' => 'Email address verification at :site',
            'hello' => 'Hello :name !',
            'welcome' => 'Welcome to :site',
            'message1' => 'Please click on the link below to verify your email address. This is required to confirm ownership of the email address.',
            'verify_email' => 'Verify your email address',
            'verify_email_url' => 'Or, if you\'re having trouble, try copying and pasting the following URL into your browser: :link',
            'partner' => [
                'intro' => 'You are registered as a partner.',
                'message1' => 'Please click on the link below to verify your email address. This is required to confirm ownership of the email address.',
            ]
        ],
        'forgot' => [
            'title_reset' => 'A new password for login at :site',
            'hello' => 'Hello :name !',
            'message1' => 'We generated a new password by your request. You can see it in box below.',
            'message2' => 'Visit login page and use a new new password with your email as login at :link',
        ]
    ],
    'admin' => [
        'signup' => [
            'hello' => 'Hello Admin !',
            'message1' => 'A new registration with E-mail ":email" has been just completed as a :type_account',
        ],
        'partner' => [
            'added_member' => [
                'title' => 'Partner added a new client at :site',
                'message1' => 'Dear admin, partner :partnerName has just added a new client :memberName'
            ],
            'remove_member' => [
                'title' => 'Admin removed your client from your list',
                'message1' => 'Dear :partnerName, Admin removed your client :memberName from your list'
            ],
            'approved_member' => [
                'title' => 'Admin approved a new client to your list',
                'message1' => 'Dear :partnerName, Admin approved a new client :memberName to your list'
            ],
            'declined_member' => [
                'title' => 'Admin unapproved some client from your list',
                'message1' => 'Dear :partnerName, Admin unapproved your client :memberName from your list'
            ]
        ]
    ]
];
