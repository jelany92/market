<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Role */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rollenverwaltung'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Bearbeiten'), [
            'update',
            'id' => $model->id,
        ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Löschen'), [
            'delete',
            'id' => $model->id,
        ], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Wollen Sie diesen Eintrag wirklich löschen?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'name',
            'description:raw',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
