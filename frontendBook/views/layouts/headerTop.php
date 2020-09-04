<?php

use common\components\LanguageDropdown;
use yii\bootstrap4\Html;


$menuItems = [
    [
        'label' => Yii::$app->language,
        'items' => LanguageDropdown::widget(),
    ],
];

$this->registerJsFile('@web/common/js/language_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);

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
                <?= Html::dropDownList('language', [
                    'id'   => 'languageId',
                    'name' => 'languageName',
                ], Yii::$app->urlManager->languages, [
                                           'class'    => 'btn btn-info',
                                           'onchange' => 'myFunctionLanguage()',
                                           //'prompt'   => Yii::$app->urlManager->languages[Yii::$app->language],
                                       ]) ?>
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

