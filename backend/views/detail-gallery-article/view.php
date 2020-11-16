<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

/* @var $model common\models\DetailGalleryArticle */

use common\models\BookAuthorName;
use common\models\Subcategory;
use common\models\DetailGalleryArticle;

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
                                           [
                                               'attribute' => 'bookGalleries.bookAuthorName.name',
                                               'value'     => function ($model) {
                                                   return BookAuthorName::getBookAuthorNameLink($model->bookAuthorName->name);
                                               },
                                               'format'    => 'raw',
                                           ],
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
                                           [
                                               'label'  => Yii::t('app', 'Subcategory'),
                                               'value'  => function ($model) {
                                                   $subcategoryList = [];
                                                   foreach ($model->gallerySaveCategory as $gallerySaveCategory)
                                                   {
                                                       $subcategoryList[$gallerySaveCategory->subcategory->id] = $gallerySaveCategory->subcategory->subcategory_name;
                                                   }
                                                   $subcategory = [];
                                                   foreach ($subcategoryList as $key => $subcategoryName)
                                                   {
                                                       $subcategory[] = Html::a($subcategoryName, [
                                                           'detail-gallery-article/index',
                                                           'mainCategoryName' => $model->mainCategory->category_name,
                                                           'subcategoryId'    => $key,
                                                       ]);
                                                   }
                                                   return implode(', ', $subcategory);
                                               },
                                               'format' => 'raw',
                                           ],
                                       ],
                                   ]) ?>
        </div>
        <div class="col-md-3">
            <?= Html::a(Html::img(DetailGalleryArticle::subcategoryImagePath($model->bookGalleries->book_photo), [
                'class' => 'view-info',
            ]), DetailGalleryArticle::subcategoryImagePath($model->bookGalleries->book_photo), ['rel' => 'fancybox']); ?>        </div>
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

<?php
echo newerton\fancybox\FancyBox::widget([
                                            'target'  => 'a[rel=fancybox]',
                                            'helpers' => true,
                                            'mouse'   => true,
                                            'config'  => [
                                                'maxWidth'    => '90%',
                                                'maxHeight'   => '90%',
                                                'playSpeed'   => 7000,
                                                'padding'     => 0,
                                                'fitToView'   => false,
                                                'width'       => '70%',
                                                'height'      => '70%',
                                                'autoSize'    => false,
                                                'closeClick'  => false,
                                                'openEffect'  => 'elastic',
                                                'closeEffect' => 'elastic',
                                                'prevEffect'  => 'elastic',
                                                'nextEffect'  => 'elastic',
                                                'closeBtn'    => false,
                                                'openOpacity' => true,
                                                'helpers'     => [
                                                    'title'   => ['type' => 'float'],
                                                    'buttons' => [],
                                                    'thumbs'  => [
                                                        'width'  => 68,
                                                        'height' => 50,
                                                    ],
                                                    'overlay' => [
                                                        'css' => [
                                                            'background' => 'rgba(0, 0, 0, 0.8)',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ]);

?>

