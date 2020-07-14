<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title                   = Yii::t('app', 'Rollenverwaltung');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Rolle anlegen'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Rollen sortieren', ['sort'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'description',
                'value'     => function ($model) {
                    $text = $model->description;
                    if (100 < strlen($text))
                    {
                        $text = substr($text, 0, 100) . '...';
                    }
                    return $text;
                },
                'format'    => 'raw',
            ],
            'updated_at:datetime',
            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
</div>
