<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Länder');;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Land anlegen', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Länder sortieren', ['sort'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'options' => ['id'=>'country_grid','class' => 'grid-view'],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'updated_at:datetime',
            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
</div>
