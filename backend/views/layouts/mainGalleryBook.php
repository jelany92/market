<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\BookGallery;
use backend\components\LanguageDropdown;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use common\models\Subcategory;
use common\widgets\Alert;
use kartik\icons\Icon;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

BookGallery::register($this);

function items($teams, $view, $param)
{
    $items = [];
    foreach ($teams as $key => $team)
    {
        $items[] = [
            'label' => $team,
            'url'   => [
                $view,
                $param => $key,
            ],
        ];
    }
    return $items;
}

$category = MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->one();

$modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere([
                                                                        'company_id' => Yii::$app->user->id,
                                                                    ])->all();
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

    <div class="wrap">
        <?php
        NavBar::begin([
                          'brandLabel' => 'Adam Markt',
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => ['class' => 'sticky-top navbar-expand-lg navbar-dark bg-blue ml-auto',],
                      ]);
        $menuItems = [
            [
                'label' => Yii::t('app', 'Home'),
                'url'   => ['/site/index'],
            ],
            [
                'label' => LanguageDropdown::label(Yii::$app->language),
                'items' => LanguageDropdown::widget(),
            ],
        ];
        if (Yii::$app->user->isGuest)
        {
            $menuItems[] = [
                'label' => 'Login',
                'url'   => ['/site/login'],
            ];
        }
        else
        {
            $mainCategory = [];
            $menuItems    = [];
            if ($category instanceof MainCategory)
            {
                $mainCategory = MainCategory::getMainCategoryList(Yii::$app->user->id);
            }
            $menuItems   = [
                [
                    'label' => Yii::t('app', 'Categories'),
                    'items' => items($mainCategory, '/main-category/view', 'id'),
                ],
                [
                    'label' => Yii::t('app', 'Book Gallery'),
                    'url'   => ['/detail-gallery-article/index'],
                ],

                [
                    'label' => LanguageDropdown::label(Yii::$app->language),
                    'items' => LanguageDropdown::widget(),
                ],
            ];
            $menuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
        }

        echo Nav::widget([
                             'options' => ['class' => Yii::$app->language == 'ar' ? 'navbar-right ml-auto pull-left' : 'navbar-right ml-auto'],
                             'items'   => $menuItems,
                         ]);
        ?>
        <div class="navSearch">
            <?php
            $form = ActiveForm::begin([
                                          'id'     => 'navSearchForm',
                                          'method' => 'GET',
                                          'action' => Url::toRoute('/search/global-search'),
                                      ]);
            ?>

            <?php
            echo Html::textInput('search', (Yii::$app->controller->id == 'search' && Yii::$app->controller->action->id == 'global-search') ? Yii::$app->request->get('search') : null, [
                'autocomplete' => 'off',
                'class'        => 'navSearchTextBox pull-right',
                'id'           => 'navSearchString',
                'placeholder'  => Yii::t('app', 'Search to') . '...',
                'value'        => 'test',
            ]);
            echo Html::submitButton(Icon::show('search'), ['class' => 'btn btn-secondary navSearchSubmit'])
            ?>
            <?php ActiveForm::end(); ?>
        </div>
        <?php NavBar::end(); ?>
        <div>
            <div>
                <?php
                NavBar::begin([
                                  'options' => ['class' => 'navbar-expand-lg bg-dark',],
                              ]);
                $subMenuItems = [];
                $mainCategory = [];
                $subMenuItems = [];
                $subCategory  = Subcategory::getSubcategoryList();
                $authorName   = array_combine(\common\models\BookGallery::getAuthorNameList(2), \common\models\BookGallery::getAuthorNameList(2));
                if ($category instanceof MainCategory)
                {
                    $mainCategory = MainCategory::getMainCategoryList(Yii::$app->user->id);
                }
                $subMenuItems = [
                    [
                        'label' => Yii::t('app', 'Categories'),
                        'items' => items($mainCategory, '/site/index', 'mainCategory'),
                    ],
                    [
                        'label' => Yii::t('app', 'Subcategories'),
                        'items' => items($subCategory, '/site/index', 'subcategory'),
                    ],
                    [
                        'label' => Yii::t('app', 'Author Name'),
                        'items' => items($authorName, '/site/index', 'author'),
                    ],
                ];
                echo Nav::widget([
                                     'options' => ['style' => 'padding-left: 300px; padding-right: 300px;'],
                                     'items'   => $subMenuItems,
                                 ]);
                ?>
                <?php NavBar::end(); ?>
                <div class="container">
                    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="sidenav">
        <?php
    /*        echo \kartik\sidenav\SideNav::widget([
                                                     'type'    => \kartik\sidenav\SideNav::TYPE_SUCCESS,
                                                     'heading' => Yii::t('app', 'Category'),
                                                     'items'   => [
                                                         [
                                                             'url'   => '#',
                                                             'label' => 'Home',
                                                             'icon'  => 'home',
                                                         ],
                                                         [
                                                             'label' => Yii::t('app', 'Categories'),
                                                             'items' => items($mainCategory, '/site/index'),
                                                             'icon'  => 'home',
                                                             'class' => 'sidenav-info',
                                                         ],
                                                     ],
                                                 ]);
            */ ?>

    </div>-->
    <footer class="footer">
        <div class="container">
            <h4><p class="pull-right">&copy; <?= Html::encode(Yii::t('app', 'مكتبتك')) ?> <?= date('Y') ?></p></h4>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>