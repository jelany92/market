<?php

use common\components\GridView;
use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $subcategory \common\models\Subcategory */
/* @var $subcategories array */
/* @var $subcategoryList array */

$this->title = Yii::t('app', 'Subcategory');
$this->registerJsFile('@web/js/filter_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="container">

    <!-- row -->
    <div class="row">
        <!-- section title -->
        <div class="col-md-12">
            <div class="section-title">
                <h3 class="title"><?= Yii::t('app', 'Book Gallery') ?></h3>
            </div>
        </div>
        <!-- /section title -->

        <?= Html::label(Yii::t('app', 'ترتيب حسب'), null, [
            'class' => 'col-md-6',
        ]) ?>
        <?= Html::dropDownList('subcategory', null, $subcategoryList, [
            'id'       => isset($subcategoryId) ? $subcategoryId : '',
            'class'    => 'col-md-3 selectSubcategoryElement',
            'onchange' => 'myFunctionSubcategory()',
            'prompt'   => Yii::t('app', 'Subcategory'),
        ]) ?>
    </div>
    <br>
    <!-- Products tab & slick -->
    <?php foreach ($subcategories as $subcategory) : ?>
        <?= '<h1>' . $subcategory->subcategory_name . '</h1>' ?>
        <div class="row">
            <div class="products-tabs col-md-12">
                <!-- tab -->
                <div id="tab1" class="tab-pane active">
                    <div class="products-slick" data-nav="#<?= ($subcategory->id) ?>">
                        <!-- product -->
                        <?php $modelDetailGalleryArticle = DetailGalleryArticle::find()->innerJoinWith('gallerySaveCategory')->andWhere(['subcategory_id' => $subcategory->id])->all(); ?>
                        <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
                            <div class="product">
                                <div class="product-img">
                                    <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                                        <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:100%;height: 300px']) ?>
                                    <?php else: ?>
                                        <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                                    <?php endif; ?>
                                    <div class="product-label">
                                        <span class="new">NEW</span>
                                    </div>
                                </div>
                                <div class="product-body">
                                    <p class="product-category"><?= $detailGalleryArticle->mainCategory->category_name ?></p>
                                    <?= Html::a('<h3 class="product-name">' . $detailGalleryArticle->article_name_ar . '</h3>', [
                                        'book-info/book-details',
                                        'detailGalleryArticleId' => $detailGalleryArticle->id,
                                    ]); ?>
                                    <h4 class="product-price">free
                                        <!--                                                <del class="product-old-price">$990.00</del>
                                        -->
                                    </h4>
                                </div>
                                <div class="add-to-cart">
                                    <?= Html::a(Yii::t('app', 'Read'), $detailGalleryArticle->link_to_preview, [
                                        'class'  => 'add-to-cart-btn',
                                        'target' => '_blank',
                                    ]) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- /product -->
                    </div>
                </div>
                <div id="<?= ($subcategory->id) ?>" class="products-slick-nav"></div>
            </div>
            <!-- /tab -->
        </div>
        <!-- Products tab & slick -->
    <?php endforeach; ?>
    <br>
    <br>
</div>
