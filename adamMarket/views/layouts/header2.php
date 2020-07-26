<?php

use backend\components\LanguageDropdown;
use yii\bootstrap4\Html;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use common\models\ArticleInfo;

$navBarColor = '#e73918';

?>
<div class="header-top bg-main hidden-xs">
    <div class="container" style="height: 50px">
        <div class="top-bar left">
            <ul class="horizontal-menu">
                <?php NavBar::begin([
                                        'brandLabel' => 'Adam Markt',
                                        'brandUrl'   => Yii::$app->homeUrl,
                                        'options'    => [
                                            'style' => ['background-color' => $navBarColor . ' !important'],
                                        ],
                                    ]); ?>
            </ul>
        </div>
        <div class="top-bar right">
            <ul class="social-list">
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
            </ul>
            <ul class="horizontal-menu">
                <li class="horz-menu-item currency">
                    <?= Html::dropDownList('test', 'currency', ArticleInfo::PRICE_LIST, ['style' => ['background-color' => '#e73918 !']]) ?>
                </li>
                <li class="horz-menu-item lang">
                    <?php
                    $firstMenuItems = [
                        [
                            'label' => LanguageDropdown::label(Yii::$app->language),
                            'items' => LanguageDropdown::widget([
                                                                    'options' => ['style' => ['background-color' => $navBarColor]],
                                                                ]),
                        ],
                    ];
                    if (Yii::$app->user->isGuest)
                    {
                        $firstMenuItems[] = [
                            'label' => Yii::t('app', 'Login'),
                            'url'   => ['/site/login'],
                        ];
                    }
                    else
                    {
                        $firstMenuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
                    }
                    echo Nav::widget([
                                         'options' => ['class' => 'navbar-auto ml-auto'],
                                         'items'   => $firstMenuItems,
                                     ]);
                    ?>
            </ul>
            <?php NavBar::end(); ?>
        </div>
    </div>
</div>
