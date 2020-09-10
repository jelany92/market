<?php

use common\components\GridView;
use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */

$this->title = Yii::t('app', 'Author');
?>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'options'      => [
                                 'id'    => 'permission_grid',
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'name',
                                     'value'     => function ($model) {
                                         return Html::a($model->name, [
                                             'search/global-search',
                                             'search' => $model->name,
                                         ]);
                                     },
                                     'format'    => 'raw',
                                 ],
                                 [
                                     'label'  => Yii::t('app', 'Book Number'),
                                     'value'  => function ($model) {
                                         return count($model->bookGalleries);
                                     },
                                     'format' => 'raw',
                                 ],
                             ],
                         ]); ?>


</div>
