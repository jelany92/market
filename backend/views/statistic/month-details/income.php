<?php

use common\components\QueryHelper;
use yii\bootstrap4\Html;
use common\components\GridView;
use onmotion\apexcharts\ApexchartsWidget;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $modelIncomingRevenue ArrayDataProvider */
/* @var $queryDailyInfo array */

$this->title                   = Yii::$app->params['months'][$month];
$this->params['breadcrumbs'][] = $this->title;
$ein                           = QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue');
$date                          = [];
$price                         = [];


foreach ($queryDailyInfo as $dailyInfo)
{
    $date[] = [
        $dailyInfo['date'],
        $dailyInfo['total'],
    ];
}
$series = [
    [
        'name' => Yii::t('app', 'احصائيات الدخل'),
        'data' => $date,
    ],
];

?>
<?= $this->render('/site/supermarket/_sub_navigation', [
    'controller' => 'statistic/month-income',
    'year'       => $year,
    'month'      => $month,
]) ?>
<?= ApexchartsWidget::widget([
                                 'type'         => 'histogram',
                                 // default area
                                 'height'       => '400',
                                 // default 350
                                 'width'        => '100%',
                                 // default 100%
                                 'chartOptions' => [
                                     'chart'       => [
                                         'toolbar' => [
                                             'show'         => true,
                                             'autoSelected' => 'zoom',
                                         ],
                                     ],
                                     'xaxis'       => [
                                         'type' => 'datetime',
                                         // 'categories' => $categories,
                                     ],
                                     'plotOptions' => [
                                         'bar' => [
                                             'horizontal'  => false,
                                             'endingShape' => 'rounded',
                                         ],
                                     ],
                                     'dataLabels'  => [
                                         'enabled' => false,
                                     ],
                                     'stroke'      => [
                                         'show'   => true,
                                         'colors' => ['transparent'],
                                     ],
                                     'legend'      => [
                                         'verticalAlign'   => 'bottom',
                                         'horizontalAlign' => 'left',
                                     ],
                                 ],
                                 'series'       => $series,
                             ]); ?>
<h1>
    <?= $ein ?>
    <?= Yii::t('app', 'تفاصيل الدخل') ?>
    <?= Html::a(Yii::t('app', 'All Einkommen'), ['incoming-revenue/index'], ['class' => 'btn btn-success']) ?>
</h1>
<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
                                 'dataProvider' => $modelIncomingRevenue,
                                 'columns'      => [
                                     ['class' => 'yii\grid\SerialColumn'],
                                     'date',
                                     'total',
                                 ],
                             ]) ?>
    </div>
</div>


