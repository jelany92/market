<?php

use common\components\QueryHelper;
use onmotion\apexcharts\ApexchartsWidget;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use backend\components\FullCalenderEvent;

/* @var $this yii\web\View */
/* @var $staticDailyInfoIncomingList array */
/* @var $staticDailyInfoMarketExpenseList array */
/* @var $staticDailyInfoPurchasesList array */

$monthName = Yii::$app->params['months'];

$incoming    = [];
$dailyResult = [];
$expense     = [];
$purchases   = [];
// daily incoming

foreach ($staticDailyInfoIncomingList as $dailyInfoIncoming)
{
    $incoming[] = [
        $dailyInfoIncoming['date'],
        $dailyInfoIncoming['total'],
    ];

    $dailyResult[] = [
        $dailyInfoIncoming['date'],
        round(QueryHelper::getDailySum(new DateTime($dailyInfoIncoming['date']))),
    ];
}

// market expo
foreach ($staticDailyInfoMarketExpenseList as $dailyInfoMarketExpense)
{
    $expense[] = [
        $dailyInfoMarketExpense['date'],
        $dailyInfoMarketExpense['total'],
    ];
}

// purchases
foreach ($staticDailyInfoPurchasesList as $dailyInfoPurchases)
{
    $purchases[] = [
        $dailyInfoPurchases['date'],
        $dailyInfoPurchases['total'],
    ];
}

$series = [
    [
        'name' => Yii::t('app', 'احصائيات الدخل'),
        'data' => $incoming,
    ],
    [
        'name' => Yii::t('app', 'الرصيد اليومي'),
        'data' => $dailyResult,
    ],
    [
        'name' => Yii::t('app', 'احصائيات مشتريات المحل'),
        'data' => $purchases,
    ],
    [
        'name' => Yii::t('app', 'احصائيات نفقات المحل'),
        'data' => $expense,
    ],
];

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php if (!Yii::$app->user->can('main-category.*')) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Demo Data'), ['demo-data'], ['class' => 'btn btn-success']) ?>
        </p>
        <br>
        <br>
    <?php endif; ?>
    <h1><?= Yii::t('app', 'Total income for the month') . ' ' . $monthName[date('n')] . ': ' . QueryHelper::getMonthData(date('Y'), date('m'), 'incoming_revenue', 'daily_incoming_revenue') ?></h1>
    <br>

    <?= yii2fullcalendar\yii2fullcalendar::widget([
                                                      'options'       => [
                                                          'lang' => Yii::$app->language == 'ar' ? 'en' : Yii::$app->language,
                                                          //... more options to be defined here!
                                                      ],
                                                      'themeSystem'   => 'bootstrap4',
                                                      'clientOptions' => [
                                                          //'hiddenDays'         => [0],
                                                          // alle Tage auser Samstag un Sontag
                                                          //'weekends' => false,                // oder so kann man auch ohne samstag und sonntag
                                                          'weekNumbers'        => true,
                                                          // in welche klendarwoceh steht
                                                          //'weekNumbersWithinDays'=> true,   // merge mit erste tag in ansicht
                                                          //'eventTextColor'=> 'black',       // fur textein farbe
                                                          'eventStartEditable' => true,
                                                          //'editable'           => true,
                                                          'eventClick'         => new \yii\web\JsExpression(FullCalenderEvent::eventClick()),
                                                          'dayClick'           => new \yii\web\JsExpression('// wenn ein auswälleen
                                                                                    function(date, jsEvent, view) {
                                                                                    window.location.href = "' . Url::toRoute([
                                                                                                  '/site/view/',
                                                                                                  'date' => '',
                                                                                                   ]) . '" + date.format("YYYY-MM-DD");}
                                                                                    '),
                                                          //  'dayClick'           => new \yii\web\JsExpression(FullCalenderEvent::addEvent()),
                                                      ],
                                                      'ajaxEvents'    => Url::to(['/site/get-events']),
                                                  ]); ?>
    <?php
    //open Popup
    yii\bootstrap4\Modal::begin([
                                    'id'    => 'eventModal',
                                    'title' => "<h3>" . Yii::t('app', 'Add Event') . "</h3>",
                                ]);

    yii\bootstrap4\Modal::end();
    ?>
    <br>
    <?= ApexchartsWidget::widget([
                                     'type'         => 'bar',
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
                                                 'endingShape' => 'flat',
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
</div>
