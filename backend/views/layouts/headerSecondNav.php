<?php

use common\widgets\Nav;
use yii\bootstrap4\Html;
use kartik\icons\Icon;

$menuItems = [
    [
        'label'   => Yii::t('app', 'Merchandise'),
        'items'   => [
            [
                'label'   => Yii::t('app', 'Article'),
                'url'     => ['/article-info/index'],
                'visible' => Yii::$app->user->can('article-info.*'),
            ],
            [
                'label'   => Yii::t('app', 'Article Price'),
                'url'     => ['/article-price/index'],
                'visible' => Yii::$app->user->can('article-price.*'),
            ],
            [
                'label'   => Yii::t('app', 'Article In Inventory'),
                'url'     => ['/article-in-stored/index-inventory'],
                'visible' => Yii::$app->user->can('article-in-stored.*'),
            ],
            [
                'label'   => Yii::t('app', 'Article Gain'),
                'url'     => ['/article-info/article-gain'],
                'visible' => Yii::$app->user->can('adam-market.*'),
            ],
            [
                'label'   => Yii::t('app', 'Article Returned Goods'),
                'url'     => ['/returned-goods'],
                'visible' => Yii::$app->user->can('adam-market.*'),
            ],
        ],
        'visible' => Yii::$app->user->can('article-info.*'),
    ],
    [
        'label'   => Yii::t('app', 'Market Information'),
        'items'   => [
            [
                'label'   => Yii::t('app', 'Incoming Revenues'),
                'url'     => ['supermarket/incoming-revenue/index'],
                'visible' => Yii::$app->user->can('supermarket/incoming-revenue.*'),
            ],
            [
                'label'   => Yii::t('app', 'Purchases'),
                'url'     => ['supermarket/purchases/index'],
                'visible' => Yii::$app->user->can('supermarket/purchases.*'),
            ],
            [
                'label'   => Yii::t('app', 'Market Expense'),
                'url'     => ['supermarket/market-expense/index'],
                'visible' => Yii::$app->user->can('supermarket/market-expense.*'),
            ],
            [
                'label'   => Yii::t('app', 'Tax Office'),
                'url'     => ['supermarket/tax-office/index'],
                'visible' => Yii::$app->user->can('supermarket/tax-office.*'),
            ],
            [
                'label'   => Yii::t('app', 'Purchase Invoices'),
                'url'     => ['supermarket/purchase-invoices/index'],
                'visible' => Yii::$app->user->can('supermarket/purchase-invoices.*'),
            ],
            [
                'label'   => Yii::t('app', 'Capital'),
                'url'     => ['supermarket/capital/index'],
                'visible' => Yii::$app->user->can('supermarket/capital.*'),
            ],
            [
                'label'   => Yii::t('app', 'Establish Markets'),
                'url'     => ['supermarket/establish-market/index'],
                'visible' => Yii::$app->user->can('supermarket/establish-market.*'),
            ],
            [
                'label'   => Yii::t('app', 'History'),
                'url'     => ['/history/index'],
                'visible' => Yii::$app->user->can('history.*'),
            ],
        ],
        'visible' => Yii::$app->user->can('supermarket/incoming-revenue.*'),
    ],
    [
        'label'   => Yii::t('app', 'Customer Info'),
        'items'   => [
            [
                'label'   => Yii::t('app', 'Employer'),
                'url'     => ['/customer-employer/index'],
                'visible' => Yii::$app->user->can('customer-employer.*'),
            ],
            [
                'label'   => Yii::t('app', 'Company'),
                'url'     => ['/user-model/index'],
                'visible' => Yii::$app->user->can('user-model.*'),
            ],
            [
                'label'   => Yii::t('app', 'Admin User'),
                'url'     => ['/admin-user/index'],
                'visible' => Yii::$app->user->can('admin-user.*'),
            ],
            [
                'label'   => Yii::t('app', 'Permission'),
                'url'     => ['/auth-item/index'],
                'visible' => Yii::$app->user->can('auth-item.*'),
            ],
        ],
        'visible' => Yii::$app->user->can('*.*'),
    ],

    [
        'label'   => Yii::t('app', 'Book Gallery'),
        'url'     => ['/detail-gallery-article/index'],
        'visible' => Yii::$app->user->can('detail-gallery-article.*'),
    ],

    [
        'label'   => Yii::t('app', 'Quiz'),
        'items'   => [
            [
                'label' => Yii::t('app', 'Main Category Excercise'),
                'url'   => ['/quiz/main-category-exercise/index'],
            ],
            [
                'label' => Yii::t('app', 'Excercise'),
                'url'   => ['/quiz/excercise/index'],
            ],
            [
                'label' => Yii::t('app', 'Students'),
                'url'   => ['quiz/students/index'],
            ],
            [
                'label' => Yii::t('app', 'Token'),
                'url'   => ['quiz/token/index'],
            ],
            [
                'label' => Yii::t('app', 'Answers'),
                'url'   => ['quiz/student-answers'],
            ],
            [
                'label' => Yii::t('app', 'Summarize'),
                'url'   => ['quiz/token/summary'],
            ],
        ],
        'visible' => Yii::$app->user->can('*.*'),
    ],
];

$label = [
    [
        'label'       => Yii::t('app', 'Option'),
        'url'         => ['/site/index'],
        'linkOptions' => [

        ],
    ],
];

?>
<!-- HEADER -->
<!-- TOP HEADER -->
<?php if (!Yii::$app->user->isGuest) : ?>
    <nav id="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark ml-auto">
        <div class="container">
            <div class="row col-md-12" style="display: -webkit-box">
                <div class="col-10 col-md-5">
                    <?php
                    echo nav::widget([
                                         'options' => [
                                             'class' => 'navbar-nav ml-auto',
                                         ],
                                         'items'   => $label,
                                     ]);
                    ?>
                </div>
                <?= Html::button(Icon::show('bars'), [
                    'class'         => 'navbar-toggler',
                    'data-toggle'   => 'collapse',
                    'data-target'   => '#itemNavSecond',
                    'aria-controls' => 'itemNavSecond',
                    'aria-expanded' => 'false',
                    'aria-label'    => 'Toggle navigation',
                ]) ?>
                <div class="col-md-7" style="display: -webkit-box">
                    <?php
                    echo nav::widget([
                                         'options' => [
                                             'id'    => 'itemNavSecond',
                                             'class' => 'collapse navbar-collapse navbar-nav ml-auto',
                                             'style' => 'align-items: revert;',
                                         ],
                                         'items'   => $menuItems,
                                     ]);
                    ?>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>
