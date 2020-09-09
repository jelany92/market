<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DetailGalleryArticle */

$this->title = $model->article_name_ar;
if (Yii::$app->user->can('detail-gallery-article.view') && Yii::$app->user->id == $model->company_id)
{
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Detail Gallery Articles'),
        'url'   => ['index'],
    ];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$filesPath    = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPhoto'] . DIRECTORY_SEPARATOR . $model->bookGalleries->book_photo;
$filesPdfPath = DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPdf'] . DIRECTORY_SEPARATOR . $model->bookGalleries->book_pdf;
?>
<div class="detail-gallery-article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('detail-gallery-article.update') && Yii::$app->user->id == $model->company_id) : ?>
            <?= Html::a(Yii::t('app', 'Update'), [
                'update',
                'id' => $model->id,
            ], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('detail-gallery-article.delete') && Yii::$app->user->id == $model->company_id) : ?>
            <?= Html::a(Yii::t('app', 'Delete'), [
                'delete',
                'id' => $model->id,
            ], [
                            'class' => 'btn btn-danger',
                            'data'  => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method'  => 'post',
                            ],
                        ]) ?>
        <?php endif; ?>
    </p>

    <div class="row">
        <div class="text col-md-9">
            <?= DetailView::widget([
                                       'model'      => $model,
                                       'attributes' => [
                                           'article_name_ar',
                                           'article_name_en',
                                           'bookGalleries.bookAuthorName.name',
                                           [
                                               'attribute' => 'bookGalleries.book_pdf',
                                               'value'     => function ($model) {
                                                   if (isset($model->bookGalleries->book_pdf))
                                                   {
                                                       return Html::a(Yii::t('app', 'Download'), [
                                                           'detail-gallery-article/download',
                                                           'id' => $model->id,
                                                       ]);
                                                   }
                                               },
                                               'format'    => 'raw',
                                           ],
                                           'description:raw',
                                           'selected_date',
                                       ],
                                   ]) ?>
        </div>
        <div class="col-md-3">
            <?= Html::img($filesPath, ['class' => 'view-info']) ?>
        </div>
    </div>
</div>
<div>
    <h1><?= Yii::t('app', 'قراءة الكتاب') ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Read'), $model->link_to_preview, [
            'class'  => 'btn btn-primary',
            'target' => '_blank',
        ]) ?>
    </p>
</div>