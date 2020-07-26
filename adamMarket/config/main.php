<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-adamMarket',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'adamMarket\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-testBig',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-adamMarket', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the adamMarket
            'name' => 'advanced-testBig',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
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
    ],
    'params' => $params,
];
