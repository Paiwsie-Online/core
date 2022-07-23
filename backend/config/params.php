<?php

return [
    'default_site_settings' => [
        'site_name' => 'Bjorns Core',
        'base_url' => 'https://back.core.test',
        'instance' => 'instance',
        'support_email' => 'support_email',
        'default_theme' => 'dark',
        'allow_theme_switch' => true
    ],
    'adminEmail' => 'adminEmail',
    'senderEmail' => 'senderEmail',
    'senderName' => 'senderName',
    'loginOptions' => [
        'allowQR' => true,
        'allowEmail' => true,
        'allowPhone' => true,
        'default' => 'email'
    ],
    'tagID_settings' => [
        'neuron' => 'lab.tagroot.io',
        'service_callback_url' => 'https://smartadmin.paiwise.com/api/settagscan',
        'signature_callback_url' => 'https://smartadmin.paiwise.com/api/signaturetagscan',
    ],
    'inputSettings' => [
        'phoneInput' => [
            'preferredCountries' => ['se', 'dk', 'no', 'fi'],
            'onlyCountries' => []
        ]
    ],
    'branding' => [
        'lightLogo' => '/img/logo-light.png',
        'darkLogo' => '/img/logo-dark.png',
        'smallLogo' => '/img/logo-sm.png',
        'favicon' => '/img/favicon.ico',
        'pdflogo' => 'img/logo-dark.png',    //same without first '/'
        'slogan'    =>  'Trust Anchor Group\'s Smart Admin Core',
        'copyright' => 'Trust Anchor Group'
    ],
    'modules' => [
        'all' => [
            'systemAdmin',
            'siteAdmin',
        ],
        'available' => [
            'siteAdmin',
        ],
        'public' => [
        ],
        'defaultOrganization' => [
        ],
        'defaultUser' => [
        ],
    ],
    'allowedExtensions' => [
        'images' => ['jpg', 'jpeg', 'gif', 'png'],
        'text_documents' => ['txt', 'doc', 'docx', 'pdf'],
        'pdf' => ['pdf'],
    ],
    // Above the list of layouts that doesn't belong to the core (ones in views/layouts folder)
    // Put here your customized layout
    'layout' => [
        //'main' => 'main',
        //'authentication' => 'authentication',
        //'systemMessage' => 'system_message',
    ],
    'defaults' => [
        'systemTimeZone' => 'Etc/UTC'
    ],
    'systemTimeout' => [
        'authTimeout' => 60*60*12, //Time for automatic logout passed this time (12h),
        'modalShow' => (60*60*12)-60, //Time to wait for modal (1m left)
    ],
];