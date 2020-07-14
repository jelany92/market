<?php

use sjaakp\sortable\SortableGridView;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Länder sortieren');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Länder'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Yii::t('app','Die Themenbereiche sind mit Drag&Drop sortierbar und werden direkt nach dem loslassen in der Datenbank neu sortiert. Ein Speichern ist also nicht notwendig!')?></p>
    <p>
        <?= Html::a(Yii::t('app', 'Zurück zur Übersicht'), ['index'], ['class' => 'btn btn-warning ']) ?>
    </p>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'orderUrl'     => ['order'],
        'columns'      => [
          'name'
        ],
    ]); ?>
</div>
