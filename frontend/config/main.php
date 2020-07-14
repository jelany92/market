<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'faktencheck-frontend',
    'name' => 'Faktencheck',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'   => 'yii\log\EmailTarget',
                    'enabled' => YII_ENV_PROD,
                    'levels'  => ['error'],
                    'except'  => ['yii\web\HttpException:404'],
                    'message' => [
                        'from'    => ['errors@faktencheck.com'],
                        'to'      => [
                            'max.kirmair@aicovo.com',
                            'jelani.qattan@aicovo.com',
                            'nico.nuernberger@aicovo.com',
                        ],
                        'subject' => 'Fehler aufgetreten im frontend',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
