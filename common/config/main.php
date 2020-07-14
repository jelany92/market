<?php

// common/config/main.php
return [
    'id' => 'common-main',
    'language' => 'de',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning' ],
                ],
            ],
        ],
        'formatter' => [
            'class'             => 'yii\i18n\Formatter',
            'defaultTimeZone'   => 'Europe/Berlin',
            'dateFormat'        => 'dd.MM.yyyy',
            'decimalSeparator'  => ',',
            'thousandSeparator' => '.',
            'currencyCode'      => 'EUR',
        ],
        'backup' => [
            'class' => 'demi\backup\Component',
            // The directory for storing backups files
            'backupsFolder' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'backups', // <project-root>/backups
            // Directories that will be added to backup
            'directories' => [
                // format: <inner backup filename> => <path/to/dir>
                'frontent_uploads' => '@frontend/web/uploads',
                'frontend_config'  => '@frontend/config',
                'backend_config'   => '@backend/config',
                'common_config'    => '@common/config',
                'console_config'   => '@console/config',
            ],
            'db' => 'db_backup'
        ],
    ],
];
