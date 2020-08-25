<?php

use yii\bootstrap4\Html;
use common\components\QueryHelper;
use yii\grid\GridView;
use common\components\ListeHelper;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $dataProvider \yii\data\ArrayDataProvider */
$this->registerJsFile('@web/js/date_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->title                   = Yii::t('app', 'Jahr');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="Monat Ansicht-index">
    <h1><?= Html::a('zurück', [
            'site/view',
            'date' => Yii::$app->session->get('returnDate'),
        ], [
                        '',
                        'class' => 'btn btn-success',
                    ]) . '</br>'; ?></h1>
    <h1><?= Html::encode($this->title) . ' ' . ListeHelper::YearList() ?></h1>
    <h1><?= 'Total Einkommen : ' . QueryHelper::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue') ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 '0',
                                 // key for month
                             ],
                         ]) ?>
</div>
