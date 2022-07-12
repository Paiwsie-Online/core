<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'default_site_settings' => [
        'site_name' => 'SmartAdmin Core',
        'base_url' => 'https://smartadmincore.backend.test',
        'api_url' => 'https://smartadmincore.api.test',
        'instance' => 'smartadmincore',
        'apiInstance' => 'smartadmincore.app',
        'frontendInstance' => 'smartadmincore.frontend',
        'support_email' => 'smartadmin@paiwise.com',
    ],
    'allowedExtensions' => [
        'images' => ['jpg', 'jpeg', 'gif', 'png'],
        'text_documents' => ['txt', 'doc', 'docx', 'pdf'],
        'pdf' => ['pdf'],
    ],
    'defaults' => [
        'systemTimeZone' => 'Etc/UTC'
    ],
    'systemTimeout' => [
        'authTimeout' => 60*60*12, //Time for automatic logout passed this time (12h),
        'modalShow' => (60*60*12)-60, //Time to wait for modal (1m left)
    ],
];