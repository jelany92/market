<?php

use backend\components\LanguageDropdown;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\Url;

$firstMenuItems = [
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget(),
    ],
];
if (Yii::$app->user->isGuest)
{
    $firstMenuItems[] = [
        'label' => 'Login',
        'url'   => ['/site/login'],
    ];
}
else
{
    $firstMenuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
}

$label = [
    [
        'label'       => Yii::t('app', 'Adam Market'),
        'url'         => ['/site/index'],
        'linkOptions' => [
            'style' => 'text-align: start;'
        ],
    ],
];

?>
<!-- HEADER -->
<!-- TOP HEADER -->
<nav id="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ml-auto">
    <div class="container">
        <div class="row col-md-12" style="display: -webkit-box">
            <div class="col-10 col-md-4" >
                <?php
                echo nav::widget([
                                     'options' => [
                                         'id'    => 'itemNav',
                                         'class' => 'navbar-nav ml-auto',
                                     ],
                                     'items'   => $label,
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
            <div class="col-md-4">
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
                    'placeholder'  => Yii::t('app', 'Search to') . '...',
                    'value'        => 'test',
                    'class'        => 'navSearchTextBox pull-center',
                    'style'        => 'align-items: revert;',
                ]);
                echo Html::submitButton(Icon::show('search'), ['class' => 'btn btn-secondary navSearchSubmit'])
                ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-md-4" style="display: -webkit-box">
                <?php
                echo nav::widget([
                                     'options' => [
                                         'id'    => 'itemNavFirst',
                                         'class' => 'collapse navbar-collapse navbar-nav ml-auto',
                                         'style' => 'align-items: revert;'
                                     ],
                                     'items'   => $firstMenuItems,
                                 ]);
                ?>
            </div>
        </div>
    </div>
</nav>

