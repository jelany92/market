<?php

use yii\bootstrap4\Html;
use common\models\DetailGalleryArticle;
use evgeniyrru\yii2slick\Slick;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle \common\models\DetailGalleryArticle */
/* @var $subcategoryList array */
//$this->registerAssetBundle('backend\assets\BookGallery');
$this->registerJsFile('@web/js/filter_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$image = [];
?>
<?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
    <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
        <?php $image[] = Html::a(Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), [
            'style' => 'width:100%;height: 300px',
            'id'    => $detailGalleryArticle->id,
        ]), [
                                     'detail-gallery-article/view',
                                     'id' => $detailGalleryArticle->id,
                                 ]) ?>
    <?php endif; ?>
<?php endforeach; ?>
<div class="body">
    <!--    <?php /*if (Yii::$app->user->id != 3) : */ ?>
        <?php /*if (Yii::$app->user->id != 2) : */ ?>
            <p>
                <? /*= Html::a(Yii::t('app', 'Demo Data'), ['demo-data'], ['class' => 'btn btn-success']) */ ?>
            </p>
            <br>
            <br>
        <?php /*endif; */ ?>
    --><?php /*endif; */ ?>
    <div class="text-xl-center">
        <h1><?= Yii::t('app', 'My Library') ?></h1>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-4">
                <div class="toolbox-left">
                    <?= Html::a(Icon::show('bars', ['style' => 'margin-right: 5px;']) . Yii::t('app', 'Filters'), ['site/index#'], ['class' => 'sidebar-toggler']) ?>
                </div><!-- End .toolbox-left -->

                <div class="col-lg-4">
                    <div class="toolbox-info">
                        <?= Yii::t('app', 'Showing'); ?> <span><?= count($modelDetailGalleryArticle) ?> of <?= count($modelDetailGalleryArticle); ?> </span> <?= Yii::t('app', 'Products'); ?>
                    </div><!-- End .toolbox-info -->
                </div><!-- End .toolbox-center -->

                <div class="col-lg-4">
                    <?= Html::label(Yii::t('app', 'Sort by:'), 'sortby', ['class' => 'toolbox-sort']) ?>
                    <?= Html::dropDownList('option', [
                        'name'  => 'sortby',
                        'id'    => 'sortby',
                        'class' => 'form-control',
                    ], [
                                               'Most Popular',
                                               'Most Rated',
                                               'Date',
                                           ], ['class' => 'select-custom']) ?>
                </div><!-- End .toolbox-right -->
            </div><!-- End .toolbox -->
        </div>
    </div>

    <div class="col-md-12">

        <?= Html::label(Yii::t('app', 'ترتيب حسب'), null, [
            'class' => 'col-lg-2',
        ]) ?>

        <?= Html::dropDownList('subcategory', null, $subcategoryList, [
            'id'       => isset($subcategoryId) ? $subcategoryId : '',
            'class'    => 'col-lg-5 selectSubcategoryElement',
            'onchange' => 'myFunctionSubcategory()',
            'prompt'   => Yii::t('app', 'Subcategory'),
        ]) ?>
    </div>

    <div class="row">
        <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
            <div class="books-view col-6 col-sm-3">
                <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                    <?= Html::a(Html::img(\common\models\DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), [
                        'style' => 'width:100%;height: 300px',
                        'id'    => $detailGalleryArticle->id,
                    ]), [
                                    'detail-gallery-article/view',
                                    'id' => $detailGalleryArticle->id,
                                ]) ?>
                <?php else: ?>
                    <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                <?php endif; ?>

                <div class="photo-title">
                    <h3><?= Html::a($detailGalleryArticle->article_name_ar, [
                            'detail-gallery-article/view',
                            'id' => $detailGalleryArticle->id,
                        ]) ?></h3>
                </div>
                <br>
            </div>
            <br>
        <?php endforeach; ?>
        <div class="center-block">
            <?= \common\components\LinkPager::widget([
                                                         'pagination' => $pages,
                                                     ]); ?>
        </div>
    </div>
</div>
