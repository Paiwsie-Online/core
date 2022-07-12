<?php

return [
    'adminEmail' => 'adminEmail',
    'senderEmail' => 'senderEmail',
    'senderName' => 'senderName',
    'default_site_settings' => [
        'site_name' => 'site_name',
        'base_url' => 'base_url',
        'instance' => 'instance',
        'support_email' => 'support_email',
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
        'default_sms_sender_name' => 'default_sms_sender_name', //max 11 characters
    ],
];