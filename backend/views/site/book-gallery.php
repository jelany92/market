<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle \common\models\DetailGalleryArticle */
$this->registerAssetBundle('backend\assets\BookGallery');
?>
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
        <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
            <div class="books-view col-6 col-sm-3">
                <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                    <?= Html::a(Html::img(\common\models\DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), [
                        'style' => 'width:100%;height: 300px',
                        'id' => $detailGalleryArticle->id,
                    ]), ['detail-gallery-article/view', 'id' => $detailGalleryArticle->id,]) ?>
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
