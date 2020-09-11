<?php

use backend\components\LanguageDropdown;
use common\models\MainCategory;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$language = [
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget([]),
    ],
];

$navBarColor      = '#e73918';
$categoryNameList = ArrayHelper::map(MainCategory::find()->andWhere(['company_id' => 1])->all(), 'id', 'category_name');
?>

<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <a href="#">Usd</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">Eur</a></li>
                            <li><a href="#">Usd</a></li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->

                <div class="header-dropdown">
                    <?php
                    echo Nav::widget([
                                         'options' => ['class' => 'navbar-auto ml-auto'],
                                         'items'   => $language,
                                     ]);
                    ?>
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <?= Icon::show('phone-alt', ['style' => 'margin-right: 5px;']) ?>
                            <li><?= Html::a('Call: +0123 456 789', '#') ?></li>
                            <li><?= Html::a(Yii::t('app', 'About Us'), '#') ?></li>
                            <li><?= Html::a(Yii::t('app', 'Contact Us'), '#') ?></li>
                            <?php
                            if (Yii::$app->user->isGuest)
                            {
                                $login[] = [
                                    'label' => Yii::t('app', 'Login'),
                                    'url'   => ['/site/login'],
                                ];
                            }
                            else
                            {
                                $login[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
                            }
                            echo Icon::show('user', ['style' => 'margin-left: 10px;']) . Nav::widget([
                                                                                                         'options' => ['class' => 'navbar-auto ml-auto'],
                                                                                                         'items'   => $login,
                                                                                                     ]);
                            ?>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->
</header><!-- End .header -->
