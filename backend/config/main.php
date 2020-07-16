<?php

use kartik\mpdf\Pdf;

$params = array_merge(require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php');
return [
    'id'                  => 'admin-backend',
    'name'                => 'Admin-Kattan',
    'language'            => 'en',
    'timeZone'            => 'Europe/Berlin',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [
        'gridview' => [
            'class'          => '\kartik\grid\Module',
            //'downloadAction' => 'export',
            'downloadAction' => 'gridview/export/download',
        ],
        'social'   => [
            // the module class
            'class'    => 'kartik\social\Module',

            // the global settings for the facebook widget
            'facebook' => [
                'appId' => '228100621678999',
            ],
        ],
    ],
    'components'          => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user'    => [
            'identityClass'   => 'common\models\AdminUser',
            'class'           => 'backend\components\WebUser',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-backend',
                'httpOnly' => true,
            ],
        ],

        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'admin',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => true,
            'rules'           => [],
            'class'           => 'codemix\localeurls\UrlManager',
            'languages'       => [
                'en',
                'de',
                'ar',
            ],
        ],

        'pdf' => [
            'class'       => Pdf::class,
            'format'      => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        'log' => [
            'flushInterVal' => 1,
            'traceLevel'    => YII_DEBUG ? 3 : 0,
            'targets'       => [
                [
                    'class'          => 'yii\log\FileTarget',
                    'levels'         => [
                        'error',
                        'warning',
                    ],
                    'exportInterval' => 1,
                ],
                [
                    'class'   => 'yii\log\EmailTarget',
                    'enabled' => YII_ENV_PROD,
                    'levels'  => ['error'],
                    'except'  => ['yii\web\HttpException:404'],
                    'message' => [
                        'from'    => ['errors@kattan.com'],
                        'to'      => [
                            'j_robben92@hotmai.com',
                        ],
                        'subject' => 'Fehler aufgetreten im backend',
                    ],
                ],
            ],
        ],
    ],
    'params'              => $params,
];

