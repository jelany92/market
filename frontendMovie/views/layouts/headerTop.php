<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use kartik\icons\Icon;

$menuItems = [
    [
        'label'       => '',
        'url'         => 'https://www.facebook.com/Shahid4U.Official',
        'linkOptions' => [
            Icon::show('facebook'),
        ],

    ],
    [
        'label'       => '',
        'url'         => 'https://www.facebook.com/Shahid4U.Official',
        'linkOptions' => [
            Icon::show('twitter-square'),
        ],
    ],
    [
        'label'       => '',
        'url'         => 'https://www.facebook.com/Shahid4U.Official',
        'linkOptions' => [
            Icon::show('telegram'),
        ],
    ],
];

NavBar::begin([
                  'brandUrl' => Yii::$app->homeUrl,
                  'options'  => [
                      'class' => 'navbar-expand navbar-fixed-top navbar-dark bg-dark',
                      'style' => 'min-height: 100px;',
                  ],
              ]);
?>
<div class="col-lg-9">
    <?= Html::a(Html::img('https://shahid4u.im/themes/Shahid4u/img/logo.png'), [''], [
        'class' => 'logo',
    ]) ?>
</div>
<div class="col-md-3">
    <?php
    echo Nav::widget([
                         'options' => ['class' => 'nav navbar-nav bg-dark'],
                         'items'   => $menuItems,
                     ]);
    ?>
    <?php
    $form = ActiveForm::begin([
                                  'id'      => 'itemNavFirst',
                                  'method'  => 'GET',
                                  'options' => [
                                      'class' => 'collapse navbar-collapse',
                                      'style' => 'text-align: center;',
                                  ],
                                  'action'  => Url::toRoute('/search/global-search'),
                              ]);

    ?>
    <?php
    echo Html::textInput('search', (Yii::$app->controller->id == 'search' && Yii::$app->controller->action->id == 'global-search') ? Yii::$app->request->get('search') : null, [
        'autocomplete' => 'off',
        'id'           => 'navSearchString',
        'placeholder'  => Yii::t('app', 'الكلمات الدلاليه للبحث') . '...',
        'value'        => 'test',
        'class'        => 'navSearchTextBox control-icon ti-search pull-center',
        'style'        => 'align-items: revert; padding-left: 50px;',
    ]);
    echo Html::submitButton(Icon::show('search'), ['class' => 'btn btn-secondary rounded'])
    ?>
    <?php ActiveForm::end(); ?>
</div>
<?php
NavBar::end();
?>

