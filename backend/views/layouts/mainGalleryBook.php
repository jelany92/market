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

Icon::map($this);
BookGallery::register($this);
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
        <?= $this->render('headerFirstNav') ?>
        <div>
            <div>
                <main class="d-flex">
                    <?php echo $this->render('_sidebar') ?>
                    <div class="container">
                        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                        <?= Alert::widget() ?>
                        <?= $content ?>
                    </div>
                </main>
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