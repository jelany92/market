<?php

use backend\components\LanguageDropdown;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;


$language = [
    [
        'label'       => Yii::$app->user->isGuest == true ? Yii::t('app', 'My Account') : Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Logout (' . Html::encode(Yii::$app->user->identity->username) . ')', ['class' => 'btn btn-link logout']) . Html::endForm(),
        'url'         => ['/site/login'],
        'linkOptions' => [
            'class' => '<i class="fa fa-user-o"></i>',
        ],
    ],
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget([]),
    ],
];

$label = [
    [
        'label'       => Yii::t('app', 'Book Gallery'),
        'url'         => ['/site/index'],
        'linkOptions' => [
            'class' => 'add-to-cart-btn',
        ],
    ],
    [
        'label'       => Yii::t('app', '+49 157'),
        'linkOptions' => [
            'class' => 'fa fa-phone',
        ],
    ],
    [
        'label'       => 'jelany.kattan@hotmail.com',
        'linkOptions' => [
            'class' => 'fa fa-envelope-o',
        ],
    ],
    [
        'label'       => Yii::t('app', '1734 Germany'),
        'linkOptions' => [
            'class' => 'fa fa-map-marker',
        ],
    ],
];


?>
<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <nav id="top-header" class="header-links">
        <div class="container">
            <div class="row">
                <div class="col-xs-9">
                    <?php
                    echo nav::widget([
                                         'options' => [
                                             'class' => 'nav ml-auto',
                                         ],
                                         'items'   => $label,
                                     ]);
                    ?>
                </div>
                <div class="col-xs-3">
                    <?php
                    echo nav::widget([
                                         'options' => [
                                             'class' => 'nav ml-auto',
                                         ],
                                         'items'   => $language,
                                     ]);
                    ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- /TOP HEADER -->
</header>
