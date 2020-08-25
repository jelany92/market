<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\ArticleInfo;

/* @var $this yii\web\View */
/* @var $model backend\models\ReturnedGoods */

$this->title = isset(ArticleInfo::getArticleNameList()[$model->name]) == true ? ArticleInfo::getArticleNameList()[$model->name] : $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Returned Goods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="returned-goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                'label' => Yii::t('app', 'Total'),
                'value'     => function ($model) {
                    return  $model->count * $model->price;
                },
                'format'    => 'raw',
            ],
            'selected_date',
        ],
    ]) ?>

</div>
