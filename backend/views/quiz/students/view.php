<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Students */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students Cruds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-crud-view">

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
            'token',
            'name',
            'correct_answer',
            'wrong_answer',
            'score',
            [
                'attribute' => 'is_complete',
                'label' => 'Is Completed',
                'value' => function($model){
                    return $model->is_complete ? 'Completed' : 'Pending';
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
