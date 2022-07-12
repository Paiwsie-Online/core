<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'skipFiles'  => [
 *             // list of files that should only copied once and skipped if they already exist
 *         ],
 *         'setWritable' => [
 *             // list of directories that should be set writable
 *         ],
 *         'setExecutable' => [
 *             // list of files that should be set executable
 *         ],
 *         'setCookieValidationKey' => [
 *             // list of config files that need to be inserted with automatically generated cookie validation keys
 *         ],
 *         'createSymlink' => [
 *             // list of symlinks to be created. Keys are symlinks, and values are the targets.
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Development' => [
        'path' => 'dev',
        'skipFiles'  => [
            'backend/config/main.php',
            'backend/config/params.php',
            'api/config/main.php',
            'api/config/params.php',
            'common/config/main.php',
            'common/config/params.php',
            'console/config/main.php',
            'console/config/params.php',
        ],
        'setWritable' => [
            'backend/runtime',
            'backend/web/assets',
            'console/runtime',
            'api/runtime',
            'api/web/assets',
        ],
        'setExecutable' => [
            'yii',
            'yii_test',
        ],
        'setCookieValidationKey' => [
            'backend/config/main-local.php',
            'common/config/codeception-local.php',
            'api/config/main-local.php',
        ],
    ],
    'Production' => [
        'path' => 'prod',
        'skipFiles'  => [
            'backend/config/main.php',
            'backend/config/params.php',
            'api/config/main.php',
            'api/config/params.php',
            'common/config/main.php',
            'common/config/params.php',
            'console/config/main.php',
            'console/config/params.php',
        ],
        'setWritable' => [
            'backend/runtime',
            'backend/web/assets',
            'console/runtime',
            'api/runtime',
            'api/web/assets',
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'backend/config/main-local.php',
            'api/config/main-local.php',
        ],
    ],
    'New Project' => [
        'path' => 'new',
        'setWritable' => [
            'backend/runtime',
            'backend/web/assets',
            'console/runtime',
            'api/runtime',
            'api/web/assets',
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'backend/config/main.php',
            'api/config/main.php',
        ],
    ],
];
