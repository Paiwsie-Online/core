<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'default_site_settings' => [
        'site_name' => 'site_name',
        'base_url' => 'base_url',
        'api_url' => 'api_url',
    ],
    'defaults' => [
        'systemTimeZone' => 'Etc/UTC'
    ],
    'systemTimeout' => [
        'authTimeout' => 60*60*12, //Time for automatic logout passed this time (12h),
        'modalShow' => (60*60*12)-60, //Time to wait for modal (1m left)
    ],
];
