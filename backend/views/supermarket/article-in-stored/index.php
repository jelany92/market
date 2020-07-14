<?php

use backend\models\ArticleInStored;
use common\models\ArticleInfo;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $modelArticleInventory backend\models\ArticleInventory */
/* @var $searchModel backend\models\searchModel\ArticleInStoredSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Article In Stored') . ' ' . $modelArticleInventory->inventory_name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article In Inventory'),
    'url'   => ['index-inventory'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-in-stored-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article In Stored'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Article In Stored'), ['enter-manually'], ['class' => 'btn btn-success']) ?>
    </p>

    <h1><?= Yii::t('app', 'Sum') . ' ' . $result ?></h1>

    <?php Pjax::begin(['id' => 'my_pjax']); ?>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'pjax'         => true,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'article_info_id',
                                     'filter'    => Select2::widget([
                                                                        'name'    => 'ArticleInStoredSearch[article_info_id]',
                                                                        'model'   => $searchModel,
                                                                        'value'   => $searchModel->article_info_id,
                                                                        'options' => ['placeholder' => 'Filter'],
                                                                        'data'    => ArrayHelper::map(ArticleInfo::find()->andWhere(['company_id' => Yii::$app->user->id])->all(), 'id', 'article_name_ar'),
                                                                    ]),
                                     'value'     => function ($model) {
                                         if ($model instanceof ArticleInStored)
                                         {
                                             return Html::a($model->articleInfo->article_name_ar, [
                                                 'article-info/view',
                                                 'id' => $model->articleInfo->id,
                                             ]);
                                         }
                                         return $model['article_name_ar'];
                                     },
                                     'format'    => 'raw',
                                 ],
                                 [
                                     'label'  => Yii::t('app', 'Quantity'),
                                     'value'  => function ($model) {
                                         if ($model instanceof ArticleInStored)
                                         {
                                             $quantity = $model->articleInfo->article_quantity . ' ' . $model->articleInfo->article_unit;
                                         }
                                         else
                                         {
                                             $quantity = $model['article_quantity'] . ' ' . $model['article_unit'];
                                         }
                                         return $quantity;
                                     },
                                     'format' => 'raw',
                                 ],
                                 [
                                     'label'  => Yii::t('app', 'Price'),
                                     'value'  => function ($model) {
                                         return $model->articleInfo->getMinPrice();
                                     },
                                     'format' => 'raw',
                                 ],
                                 [
                                     'class'     => 'kartik\grid\EditableColumn',
                                     'attribute' => 'count',
                                 ],

                                 [
                                     'label'  => Yii::t('app', 'Total Price'),
                                     'value'  => function ($model) {
                                         if (isset($model->count))
                                         {
                                             $totalPrice = $model->articleInfo->getMinPrice() * $model->count;
                                             return $totalPrice;
                                         }
                                     },
                                     'format' => 'raw',
                                 ],
                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>
    <?php Pjax::end(); ?>
</div>