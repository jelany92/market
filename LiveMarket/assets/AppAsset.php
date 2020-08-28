<?php

namespace LiveMarket\assets;

use yii\web\AssetBundle;

/**
 * Main LiveMarket application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        //'common/css/bootstrap.min.css',
        'common/css/site.css',
        'common/css/main.css',
        //'common/css/blue.css',
        //'common/css/owl.carousel.css',
        //'common/css/owl.transitions.css',
        //'common/css/animate.min.css',
        //'common/css/rateit.css',
        //'common/css/font-awesome.css',
    ];
    public $js       = [
        "common/js/jquery-1.11.1.min.js",
        "common/js/bootstrap.min.js",
        "common/js/bootstrap-hover-dropdown.min.js",
        "common/js/owl.carousel.min.js",
        "common/js/echo.min.js",
        "common/js/jquery.easing-1.3.min.js",
        "common/js/bootstrap-slider.min.js",
        "common/js/jquery.rateit.min.js",
        "common/js/lightbox.min.js",
        "common/js/bootstrap-select.min.js",
        "common/js/wow.min.js",
    ];
    public $depends  = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
