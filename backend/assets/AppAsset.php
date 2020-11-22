<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'css/site.css',
        'css/admin.css',
        'css/bootstrap.min.css',
    ];
    public $js       = [
        'js/bootstrap_modal.js',
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
