<?php

use common\models\Subcategory;
use common\models\MainCategory;
use common\models\BookGallery;
use common\models\DetailGalleryArticle;
use kartik\icons\Icon;

$category = MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->one();

$modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere([
                                                                        'company_id' => Yii::$app->user->id,
                                                                    ])->all();
$subMenuItems              = [];
$mainCategory              = [];
$subMenuItems              = [];
$subCategory               = Subcategory::getSubcategoryList();
$authorName                = array_combine(BookGallery::getAuthorNameList(2), \common\models\BookGallery::getAuthorNameList(2));
if ($category instanceof MainCategory)
{
    $mainCategory = MainCategory::getMainCategoryList(Yii::$app->user->id);
}
$subMenuItems = [
    [
        'label' => Yii::t('app', 'Book Gallery'),
        'url'   => ['/detail-gallery-article/index'],
    ],
    [
        'label' => Yii::t('app', 'Categories'),
        'items' => items($mainCategory, '/site/index', 'mainCategory'),
    ],
    [
        'label' => Yii::t('app', 'Subcategory'),
        'items' => items($subCategory, '/site/index', 'subcategory'),
    ],
    [
        'label' => Yii::t('app', 'Author Name'),
        'items' => items($authorName, '/site/index', 'author'),
    ],
];

?>
<aside class="shadow">
    <?= \yii\bootstrap4\Html::label('<h3>' . Yii::t('app', 'Book Information') . '</h3>') ?>
    <?= \yii\bootstrap4\Html::button(Icon::show('bars'), [
        'class'         => 'navbar-toggler float-right',
        'data-toggle'   => 'collapse',
        'data-target'   => '#sidebar',
        'aria-controls' => 'sidebar',
        'aria-expanded' => 'false',
        'aria-label'    => 'Toggle navigation',
    ]) ?>
    <?php echo \yii\bootstrap4\Nav::widget([
                                               'options' => [
                                                   'id'    => 'sidebar',
                                                   'class' => 'collapse navbar-collapse flex-container flex-column nav-pills ml-auto',
                                                   'style' => 'min-width: 200px; align-items: revert;',
                                               ],
                                               'items'   => $subMenuItems,
                                           ]) ?>
</aside>
