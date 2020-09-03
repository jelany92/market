<?php

use common\components\LanguageDropdown;
use yii\bootstrap4\Html;

$menuItems = [
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget(),
    ],
];

//var_dump($menuItems[0]['items']);die();
?>
<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li>
                    <?= Html::a(Yii::t('app', 'Book Gallery'), ['/site/index'], [
                        'class' => 'add-to-cart-btn',
                    ]) ?>
                </li>
                <li><a href="#"><i class="fa fa-phone"></i> +49 157</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> jelany.kattan@hotmail.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Germany</a></li>
            </ul>

            <ul class="header-links pull-right">

                <?= Html::dropDownList(Html::a(Yii::$app->urlManager->languages[Yii::$app->language], ['test']), null, Yii::$app->urlManager->languages, []) ?>
                <?php if (Yii::$app->user->isGuest) : ?>
                    <li>
                        <?= '<i class="fa fa-user-o"></i>' . Html::a(Yii::t('app', 'My Account'), ['/site/login'], ['class' => 'add-to-cart-btn',]) ?>
                    </li>
                <?php else : ?>
                    <li>
                        <?= Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Logout (' . Html::encode(Yii::$app->user->identity->username) . ')', ['class' => 'btn btn-link logout']) . Html::endForm() ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->
</header>

