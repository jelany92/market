<?php

use backend\components\LanguageDropdown;
use yii\bootstrap4\Html;

use common\widgets\Nav;
use yii\bootstrap4\NavBar;
use kartik\icons\Icon;

$rightMenuItems = [
    [
        'label' => 'Login',
        'url'   => ['/site/login'],

    ],
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget(),
    ],
];

$leftMenuItems = [
    [
        'label' => Yii::t('app', 'Book Gallery'),
        'url'   => ['/site/index'],
        'class' => 'add-to-cart-btn',
    ],
    [
        'label' => Yii::t('app', '+49 157'),
        'class' => 'fa fa-phone',
        'icon'  => 'cog',
    ],
    [
        'label' => 'jelany.kattan@hotmail.com',
        'class' => 'fa fa-envelope-o',
    ],
    [
        'label' => Yii::t('app', '1734 Germany'),
        'class' => 'fa fa-map-marker',
    ],
]
?>
<div id="top-header">
    <?php NavBar::begin([
                            'options' => [
                                'class' => 'nav navbar-expand-lg navbar-dark ml-auto',
                            ],
                        ]) ?>
    <?= Nav::widget([
                        'options' => [
                            'class' => 'collapse navbar-collapse nav navbar-nav',
                        ],
                        'items'   => $leftMenuItems,

                    ]); ?>
    <?= Nav::widget([
                        'options' => [
                            'class' => 'navbar-expand-lg nav navbar-right',
                        ],
                        'items'   => $rightMenuItems,
                    ]); ?>

    <?php NavBar::end() ?>
</div>


