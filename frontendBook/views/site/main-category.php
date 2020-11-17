<?php

use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */
/* @var $mainCategoryId int */
/* @var $subcategoryId int */
/* @var $date int */
/* @var $mainCategoryList array */
/* @var $subcategoryList array */
/* @var $dateList array */

$this->title = Yii::t('app', 'Book Gallery');
$this->registerJsFile('@web/js/filter_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<?php echo Select2::widget([
                               'name'          => 'kv-state-200',
                               'data'          => $subcategoryList,
                               'size'          => Select2::SMALL,
                               'options'       => ['placeholder' => 'Select a state ...'],
                               'pluginOptions' => [
                                   'allowClear' => true,
                               ],
                           ]) ?>
<!-- SECTION -->
<div class="section">
    <!-- container -->
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

            <div class="advanced-search col-md-12">
                <?= Html::label(Yii::t('app', 'ترتيب حسب'), null, [
                    'class' => 'col-lg-2',
                ]) ?>

                <?= Html::dropDownList('mainCategory', ['li data-tax="category" data-cat=""'], $mainCategoryList, [
                    'id'       => isset($mainCategoryId) ? $mainCategoryId : '',
                    'class'    => 'col-lg-3 selectMainCategoryElement',
                    'onchange' => 'myFunctionMainCategory()',
                    'prompt'   => Yii::t('app', 'Category'),
                ]) ?>

                <?= Html::dropDownList('subcategory', null, $subcategoryList, [
                    'id'       => isset($subcategoryId) ? $subcategoryId : '',
                    'class'    => 'col-lg-4 selectSubcategoryElement',
                    'onchange' => 'myFunctionSubcategory(' . $mainCategoryId . ')',
                    'prompt'   => Yii::t('app', 'Subcategory'),
                ]) ?>

                <?= Html::dropDownList('date', null, $dateList, [
                    'id'       => isset($date) ? $date : '',
                    'class'    => 'col-lg-3 selectDateElement',
                    'onchange' => 'myFunctionSubcategory(' . $mainCategoryId . ')',
                    'prompt'   => Yii::t('app', 'Date'),
                ]) ?>
            </div>

            <!-- Products tab & slick -->
            <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
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
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->