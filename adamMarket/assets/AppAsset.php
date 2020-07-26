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
        'assets/css/bootstrap.min.css',
        'assets/css/style.css',
        'assets/css/plugins/owl-carousel/owl.carousel.css',
        'assets/css/plugins/magnific-popup/magnific-popup.css',
        'assets/css/plugins/nouislider/nouislider.css',
    ];
    public $js       = [
        "assets/js/main.js",
        "assets/js/jquery.min.js",
        "assets/js/bootstrap.bundle.min.js",
        "assets/js/jquery.hoverIntent.min.js",
        "assets/js/jquery.waypoints.min.js",
        "assets/js/superfish.min.js",
        "assets/js/owl.carousel.min.js",
        "assets/js/wNumb.js",
        "assets/js/bootstrap-input-spinner.js",
        "assets/js/jquery.magnific-popup.min.js",
        "assets/js/nouislider.min.js",
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
