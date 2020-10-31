<?php

use backend\components\LanguageDropdown;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

if (Yii::$app->user->isGuest)
{
    $labelEnd[] = [
        'label'       => 'Signup',
        'url'         => ['/site/signup'],
    ];
    $labelEnd[] = [
        'label' => 'Login',
        'url'   => ['/site/login'],
    ];
}
else
{
    $labelEnd[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
}

$labelEnd[] = [
    'label' => LanguageDropdown::label(Yii::$app->language),
    'items' => LanguageDropdown::widget(),

];
$labelFirst = [
    [
        'label' => 'Login',
        'url'   => ['/site/login'],
    ],
    [
        'label' => 'test',
        'url'   => ['/site/login'],
    ],
    [
        'label' => 'test33',
        'url'   => ['/site/login'],
    ],
    [
        'label' => 'test33',
        'url'   => ['/site/login'],
    ],
    [
        'label' => 'test33',
        'url'   => ['/site/login'],
    ],
];

NavBar::begin([
                  'brandUrl' => Yii::$app->homeUrl,
                  'options'  => [
                      'class' => 'navbar navbar-expand navbar-dark bg-dark sticky-top ml-auto',
                  ],
              ]);
?>
<div class="col-md-9">
    <?php
    echo nav::widget([
                         'options' => [
                             'id'    => 'itemNav',
                             'class' => 'navbar-nav ml-auto',
                             'style' => 'display: ruby-base-container',
                         ],
                         'items'   => $labelFirst,
                     ]);
    ?>
</div>
<?= Html::button(Icon::show('bars'), [
    'class'         => 'navbar-toggler',
    'data-toggle'   => 'collapse',
    'data-target'   => '#itemNavFirst',
    'aria-controls' => 'itemNavFirst',
    'aria-expanded' => 'false',
    'aria-label'    => 'Toggle navigation',
]) ?>
<div class="col-md-3" style="display: -webkit-box">
    <?php
    echo nav::widget([
                         'options' => [
                             'id'    => 'itemNavFirst',
                             'class' => 'collapse navbar-collapse navbar-nav ml-auto bts',
                             //'style' => 'align-items: revert;',
                         ],
                         'items'   => $labelEnd,
                     ]);
    ?>
</div>
<?php
NavBar::end(); ?>
