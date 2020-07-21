<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use backend\components\LanguageDropdown;
use common\models\MainCategory;
use common\widgets\Alert;
use kartik\icons\Icon;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

Icon::map($this);
AppAsset::register($this);

function items($teams, $view)
{
    $items = [];

    foreach ($teams as $key => $team)
    {
        $items[] = [
            'label' => $team,
            'url'   => [
                $view,
                'id' => $key,
            ],
        ];
    }
    return $items;
}

$category = MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->one();

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html <?= yii::$app->language == 'ar' ? 'dir="rtl" ' . "lang=" . yii::$app->language : "lang=" . yii::$app->language ?>>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div>
        <?php
        NavBar::begin([
                          'brandLabel' => 'Adam Markt',
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => ['class' => 'sticky-top navbar-expand-lg navbar-dark bg-dark ml-auto',],
                      ]);
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
        echo Nav::widget([
                             'options' => ['class' => Yii::$app->language == 'ar' ? 'navbar-right ml-auto pull-right' : 'navbar-right ml-auto'],
                             'items'   => $firstMenuItems,
                         ]);
        ?>
        <?php
        $form = ActiveForm::begin([
                                      'id'      => 'navSearchForm',
                                      'method'  => 'GET',
                                      'options' => [
                                          'style' => 'text-align: center;',
                                      ],
                                      'action'  => Url::toRoute('/search/global-search'),
                                  ]);

        ?>
        <?php ActiveForm::end(); ?>

        <?php NavBar::end(); ?>
    </div>


    <div class="wrap">
        <?php if (!Yii::$app->user->isGuest) : ?>

            <?php
            NavBar::begin([
                              'brandLabel' => 'Option Main',
                              'options'    => [
                                  'class' => 'navbar-expand-lg navbar-dark bg-dark ml-auto',
                                  'style' => 'margin-top: -10px;',
                              ],
                          ]);

            $teams     = [];
            $menuItems = [];
            if ($category instanceof MainCategory)
            {
                $teams = MainCategory::getMainCategoryList(Yii::$app->user->id);
            }
            $menuItems = [
                [
                    'label'   => Yii::t('app', 'Categories'),
                    'items'   => items($teams, '/main-category/view'),
                    'visible' => Yii::$app->user->can('main-category.*'),
                ],
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
                            'visible' => Yii::$app->user->can('article-info.*'),
                        ],
                    ],
                    'visible' => Yii::$app->user->can('article-info.*'),
                ],
                [
                    'label'   => Yii::t('app', 'Market Information'),
                    'items'   => [
                        [
                            'label'   => Yii::t('app', 'Incoming Revenues'),
                            'url'     => ['/incoming-revenue/index'],
                            'visible' => Yii::$app->user->can('incoming-revenue.*'),
                        ],
                        [
                            'label'   => Yii::t('app', 'Purchases'),
                            'url'     => ['/purchases/index'],
                            'visible' => Yii::$app->user->can('purchases.*'),
                        ],
                        [
                            'label'   => Yii::t('app', 'Market Expense'),
                            'url'     => ['/market-expense/index'],
                            'visible' => Yii::$app->user->can('market-expense.*'),
                        ],
                        [
                            'label'   => Yii::t('app', 'Tax Office'),
                            'url'     => ['/tax-office/index'],
                            'visible' => Yii::$app->user->can('tax-office.*'),
                        ],
                        [
                            'label'   => Yii::t('app', 'Purchase Invoices'),
                            'url'     => ['/purchase-invoices/index'],
                            'visible' => Yii::$app->user->can('purchase-invoices.*'),
                        ],
                        [
                            'label'   => Yii::t('app', 'Capital'),
                            'url'     => ['/capital/index'],
                            'visible' => Yii::$app->user->can('capital.*'),
                        ],
                        [
                            'label'   => Yii::t('app', 'Establish Markets'),
                            'url'     => ['/establish-market/index'],
                            'visible' => Yii::$app->user->can('establish-market.*'),
                        ],
                        [
                            'label' => Yii::t('app', 'History'),
                            'url'   => ['/history/index'],
                            //'visible' => Yii::$app->user->can('history.*'),
                        ],
                    ],
                    'visible' => Yii::$app->user->can('incoming-revenue.*'),
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
            echo Nav::widget([
                                 'options' => [
                                     'class' => 'navbar-nav ml-auto',
                                 ],
                                 'items'   => $menuItems,
                             ]);
            ?>
            <?php NavBar::end(); ?>
        <?php endif; ?>

        <div class="container">
            <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>