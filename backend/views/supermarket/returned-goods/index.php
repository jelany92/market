<?php

use common\models\ArticleInfo;
use yii\bootstrap4\Dropdown;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\ReturnedGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Returned Goods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returned-goods-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Returned Goods'), ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::dropDownList('pdf', [
            'id'   => 'pdfId',
            'name' => 'pdfName',
        ], (Yii::$app->params['months']), [
                                   'class'    => 'btn btn-info',
                                   'onchange' => 'myFunction()',
                                   'prompt'   => Yii::t('app', 'Print PDF'),
                               ]) ?>
        <?php
        $var = "document . getElementsByName('pdf')[0] . value";
        $this->registerJs("function myFunction() {
        if (" . $var . "!= '')
        {
            window . location . href = 'pdf?month=' + " . $var . ";
        }
    }", \yii\web\View::POS_HEAD);
        ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'name',
                                     'value'     => function ($model) {
                                         if (isset(ArticleInfo::getArticleNameList()[$model->name]))
                                         {
                                             return ArticleInfo::getArticleNameList()[$model->name];
                                         }
                                         return $model->name;
                                     },
                                     'format'    => 'raw',
                                 ],
                                 'count',
                                 'price',
                                 [
                                     'label'  => Yii::t('app', 'Total'),
                                     'value'  => function ($model) {
                                         return $model->count * $model->price;
                                     },
                                     'format' => 'raw',
                                 ],
                                 'selected_date',
                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>

    <?php Pjax::end(); ?>
</div>
