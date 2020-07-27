<?php

namespace adamMarket\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'common/css/bootstrap.min.css',
        'common/css/style.css',
        'common/css/plugins/owl-carousel/owl.carousel.css',
        'common/css/plugins/magnific-popup/magnific-popup.css',
        'common/css/plugins/nouislider/nouislider.css',
        'href="https://use.fontawesome.com/releases/v5.13.0/css/all.css',
        'common/css/font-awesome.min.css',
    ];
    public $js       = [
        "common/js/main.js",
        "common/js/jquery.min.js",
        "common/js/bootstrap.bundle.min.js",
        "common/js/jquery.hoverIntent.min.js",
        "common/js/jquery.waypoints.min.js",
        "common/js/superfish.min.js",
        "common/js/owl.carousel.min.js",
        "common/js/wNumb.js",
        "common/js/bootstrap-input-spinner.js",
        "common/js/jquery.magnific-popup.min.js",
        "common/js/nouislider.min.js",
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        'yidas\yii\fontawesome\FontawesomeAsset',
    ];
}
