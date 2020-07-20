<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model  \backend\models\MarketExpense */

$this->title                   = $model->reason;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Market Expenses'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="market-expense-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), [
            'update',
            'id' => $model->id,
        ], ['class' => 'btn btn-primary']) ?>
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
    </p>

    <?= DetailView::widget([
                               'model'      => $model,
                               'attributes' => [
                                   'expense',
                                   'reason',
                                   'selected_date',
                               ],
                           ]) ?>

</div>
