<?php

use common\components\QueryHelper;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $dataProviderResult \yii\data\ArrayDataProvider */

$this->title                   = Yii::$app->params['months'][$month];
$this->params['breadcrumbs'][] = $this->title;

$ein       = QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue');
$aus       = QueryHelper::getMonthData($year, $month, 'purchases', 'purchases');
$ausMarket = QueryHelper::getMonthData($year, $month, 'market_expense', 'expense');
$result    = $ein - $aus - $ausMarket;
?>

<?= $this->render('/site/supermarket/_sub_navigation', [
    'controller' => 'statistic/month-daily-result',
    'year'  => $year,
    'month' => $month,
]) ?>
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1>
                <?= Yii::t('app', 'الرصيد اليومي') ?>
                <?= $result ?>
            </h1>
            <?= GridView::widget([
                                     'dataProvider' => $dataProviderDailyCash,
                                     'columns'      => [
                                         ['class' => 'yii\grid\SerialColumn'],
                                         [
                                             'label' => Yii::t('app', 'Total'),
                                             'value' => function ($model) {
                                                 return $model[0];
                                             },
                                         ],
                                         [
                                             'label' => Yii::t('app', 'Selected Date'),
                                             'value' => function ($model) {
                                                 return $model[1];
                                             },
                                         ],
                                     ],
                                 ]) ?>
        </div>
    </div>
</div>


