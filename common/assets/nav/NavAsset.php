<?php

namespace common\assets\nav;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class NavAsset extends AssetBundle
{
    public $baseUrl  = '@web';
    public $css      = [
        '/css/nav-custom-widget.css',
    ];
    public $js       = [];
    public $depends  = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'resources';
    }
}
