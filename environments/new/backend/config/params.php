<?php

return [
    'default_site_settings' => [
        'site_name' => 'SmartAdmin',
        'base_url' => 'https://smartadmin.paiwise.com',
        'instance' => 'smartadmin',
        'support_email' => 'smartadmin@paiwise.com',
    ],
    'adminEmail' => 'admin@smartadmin.paiwise.com',
    'senderEmail' => 'payment@paiwise.com',
    'senderName' => 'SmartAdmin Core',
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
        'lightLogo' => '/branding/paiwise/img/Paiwise_yellow_black.png',
        //'emailHeader' => '/branding/paiwise/img/emailheader.png',
        'roundedLogo' => '/branding/paiwise/img/Paiwise_yellow_black.png',
        'darkLogo' => '/branding/paiwise/img/Paiwise_yellow_black.png',
        'pdflogo' => 'branding/paiwise/img/Paiwise_yellow_black.png',    //same without first '/'
        'backgroundImage' => '/branding/paiwise/img/Paiwise_background.jpg',
        'cardImage' => '/branding/paiwise/img/Paiwise_card.png',
        'themeCss' => 'dark'
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