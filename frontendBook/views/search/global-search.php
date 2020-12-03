<?php

use common\components\GridView;
use common\models\BookAuthorName;
use common\models\DetailGalleryArticle;
use common\models\Subcategory;
use kartik\icons\Icon;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $searchModels array */
/* @var $dataProviders array */
/* @var $tabItems array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
$this->title                   = Yii::t('app', 'Global search');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/view_list_or_grid.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (0 < $dataProvider->totalCount) : ?>
        <div class="col-md-4">
            <div class="btn-group hidden-xs">
                <?= Html::button(Icon::show('th-list'), [
                    'type'                => 'button',
                    'id'                  => 'list-view',
                    'class'               => 'btn btn-default btn-sm',
                    'data-toggle'         => 'tooltip',
                    'data-original-title' => 'List',
                    'onclick'             => 'functionList()',
                ]); ?>
                <?= Html::button(Icon::show('th'), [
                    'type'                => 'button',
                    'id'                  => 'grid-view',
                    'class'               => 'btn btn-default btn-sm',
                    'data-toggle'         => 'tooltip',
                    'data-original-title' => 'Grid',
                    'onclick'             => 'functionGrid()',
                ]); ?>
            </div>
        </div>
        <div id="gridView" class="row col-md-12">
            <!-- Products tab & slick -->
            <?php foreach ($dataProvider->models as $detailGalleryArticle) : ?>
                <div class="col-md-3 col-xs-6" style="padding-bottom: 50px;">
                    <!-- product -->
                    <div class="product">
                        <div class="product-img">
                            <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                                <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:100%;height: 350px']) ?>
                            <?php else: ?>
                                <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                            <?php endif; ?>
                            <div class="product-label">
                                <span class="new">NEW</span>
                            </div>
                        </div>
                        <div class="product-body">
                            <p class="product-category"><?= $detailGalleryArticle->mainCategory->category_name ?></p>
                            <h3 class="product-name"><?= Html::a($detailGalleryArticle->article_name_ar, [
                                    'book-info/book-details',
                                    'detailGalleryArticleId' => $detailGalleryArticle->id,
                                ]); ?></a></h3>
                        </div>
                        <div class="add-to-cart">
                            <?= Html::a(Yii::t('app', 'Read'), $detailGalleryArticle->link_to_preview, [
                                'class'  => 'add-to-cart-btn',
                                'target' => '_blank',
                            ]) ?>
                        </div>
                        <!-- /product -->
                    </div>
                </div>
                <!-- Products tab & slick -->
            <?php endforeach; ?>
        </div>
        <div id="listView" class="col-md-12" style="display: none">
            <?= GridView::widget([
                                     'dataProvider' => $dataProvider,
                                     'id'           => 'grid_admin_search',
                                     'columns'      => [
                                         ['class' => 'yii\grid\SerialColumn'],
                                         [
                                             'attribute' => 'article_name_ar',
                                             'value'     => function ($model) {
                                                 return Html::a($model->article_name_ar, [
                                                     'book-info/book-details',
                                                     'detailGalleryArticleId' => $model->id,
                                                 ]);
                                             },
                                             'format'    => 'raw',
                                         ],
                                         'article_name_en',
                                         [
                                             'label'  => Yii::t('app', 'Book Number'),
                                             'value'  => function ($model) {
                                                 return BookAuthorName::getBookAuthorNameLink($model->bookAuthorName->name);
                                             },
                                             'format' => 'raw',
                                         ],
                                         [
                                             'label'  => Yii::t('app', 'Subcategory'),
                                             'value'  => function ($model) {
                                                 $subcategory = [];
                                                 foreach ($model->gallerySaveCategory as $gallerySaveCategory)
                                                 {
                                                     $subcategory[$gallerySaveCategory->subcategory->id] = $gallerySaveCategory->subcategory->subcategory_name;
                                                 }
                                                 return Subcategory::getSubcategoryLink($subcategory);
                                             },
                                             'format' => 'raw',
                                         ],
                                     ],
                                 ]); ?>
        </div>
    <?php else : ?>
        <?= Html::tag('h3', Yii::t('app', 'No Results Found')); ?>
    <?php endif; ?>

</div>
