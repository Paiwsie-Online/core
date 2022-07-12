<?php

return [
    'adminEmail' => 'admin@smartadmincore.backend.test',
    'senderEmail' => 'payment@paiwise.com',
    'senderName' => 'SmartAdmin Core',
    'default_site_settings' => [
        'site_name' => 'SmartAdmin Core',
        'base_url' => 'https://smartadmincore.backend.test',
        'instance' => 'smartadmin',
        'support_email' => 'smartadmin@paiwise.com',
    ],
    'inputSettings' => [
        'phoneInput' => [
            'preferredCountries' => ['se', 'dk', 'no', 'fi', 'es'],
            'onlyCountries' => []
        ]
    ],
    'SmtpSettings' => [
        'host' => 'host',
        'username' => 'username',
        'password' => 'password',
        'port' => '587',
        'encryption' => 'tls',
        'streamOptions' => [
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]
    ],
    'textLocal' => [
        'apiKey' => "apiKey",
        'default_sms_sender_name' => 'SmartAdmin Core', //max 11 characters
    ],
];