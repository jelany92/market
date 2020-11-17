<?php

use common\models\DetailGalleryArticle;
use common\widgets\Table;
use yii\bootstrap4\Html;
use kartik\social\FacebookPlugin;
use common\models\Subcategory;
use common\models\MainCategory;
use common\models\BookAuthorName;

/* @var $this yii\web\View */
/* @var $detailGalleryArticle \common\models\DetailGalleryArticle */

$this->title = $detailGalleryArticle->article_name_ar;
$subcategory = [];
foreach ($detailGalleryArticle->gallerySaveCategory as $gallerySaveCategory)
{
    $subcategory[$gallerySaveCategory->subcategory->id] = $gallerySaveCategory->subcategory->subcategory_name;
}
$tableContent = [
    'tableArray' => [
        [

            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Book Name') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => $this->title,
            ],
        ],
        [
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Section') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => MainCategory::getMainCategoryLink($detailGalleryArticle->mainCategory),
            ],
        ],
        [
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Subcategory') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => Subcategory::getSubcategoryLink($subcategory),
            ],
        ],
        [
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'The owner of the book') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => BookAuthorName::getBookAuthorNameLink($detailGalleryArticle->bookGalleries->bookAuthorName->name),
            ],
        ],
        [
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Date added') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => isset($detailGalleryArticle->selected_date) ? $detailGalleryArticle->selected_date : '',
            ],
        ],
        [
            [
                'type' => 'td',
                'html' => '<strong>' . Yii::t('app', 'Read') . '</strong>',
            ],
            [
                'type' => 'td',
                'html' => Html::a(Yii::t('app', 'Read Online'), $detailGalleryArticle->link_to_preview, [
                    'class'  => 'add-to-cart-btn',
                    'target' => '_blank',
                ]),
            ],
        ],

    ],
];
?>
<div class="container">
    <h3><?= Yii::t('app', 'If you like the content, don`t forget Like and share it for the benefit') ?></h3>
    <?= FacebookPlugin::widget([
                                   'type'     => FacebookPlugin::LIKE,
                                   'settings' => [
                                       'size'          => 'large',
                                       'layout'        => 'button_count',
                                       'mobile_iframe' => 'false',
                                   ],
                               ]); ?>
    <br>
    <br>
    <?= FacebookPlugin::widget([
                                   'type'     => FacebookPlugin::SHARE,
                                   'settings' => [
                                       'size'          => 'large',
                                       'layout'        => 'button_count',
                                       'mobile_iframe' => 'false',
                                   ],
                               ]); ?>
    <?= '<h1>' . Yii::t('app', 'Comment') . '</h1>' ?>

    <?= FacebookPlugin::widget([
                                   'type'     => FacebookPlugin::COMMENT,
                                   'settings' => [
                                       'data-width'    => 1000,
                                       'data-numposts' => 5,
                                   ],
                               ]); ?>
    <br>
    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <div class="col-md-3">
        <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:100%;height: 350px;margin-bottom: 50px;']) ?>
    </div>
    <br>

    <div class="row col-md-9">
        <?= Table::widget($tableContent); ?>
    </div>
</div>
