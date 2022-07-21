<?php

return [
    'default_site_settings' => [
        'site_name' => 'site_name',
        'base_url' => 'base_url',
        'instance' => 'instance',
        'support_email' => 'support_email',
    ],
    'adminEmail' => 'adminEmail',
    'senderEmail' => 'senderEmail',
    'senderName' => 'senderName',
    'loginOptions' => [
        'allowQR' => true,
        'allowEmail' => true,
        'allowPhone' => false,
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
        'pdflogo' => 'img/logo-dark.png',    //same without first '/'
        'themeCss' => 'dark',
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