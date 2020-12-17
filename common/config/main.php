<?php

// common/config/main.php
return [
    'id' => 'common-main',
    'language' => 'de',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'             => [
        'social'   => [
            // the module class
            'class'    => 'kartik\social\Module',

            // the global settings for the facebook widget
            'facebook' => [
                'appId' => '228100621678999',
            ],
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'bundles' => [
                'yidas\yii\fontawesome\FontawesomeAsset' => [
                    'cdn' => true,
                    'cdnCSS' => ['//maxcdn.bootstrapcdn.com/font-awesome/5.11.0/css/font-awesome.min.css'],
                ],
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
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
        'i18n'        => [
            'translations' => [
                '*' => [
                    'class'          => 'yii\i18n\GettextMessageSource',
                    'basePath'       => realpath(Yii::getAlias('@common') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'translation/translations'),
                    'useMoFile'      => false,
                    'sourceLanguage' => 'en-US',
                ],
            ],
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
