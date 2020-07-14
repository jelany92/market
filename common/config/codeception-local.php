<?php

// see https://github.com/yiisoft/yii2-app-advanced/issues/346
return yii\helpers\ArrayHelper::merge(require __DIR__ . '/test-local.php', [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'test',
        ],
    ],
]);
