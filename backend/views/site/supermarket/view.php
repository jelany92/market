<?php

use backend\models\Capital;
use backend\models\IncomingRevenue;
use backend\models\MarketExpense;
use backend\models\Purchases;
use backend\models\TaxOffice;
use common\components\GridView;
use common\components\ListeHelper;
use common\components\QueryHelper;
use common\widgets\Table;
use onmotion\apexcharts\ApexchartsWidget;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $showCreate boolean */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $date data */
/* @var $showCreateIncomingRevenue boolean */
/* @var $staticDailyInfoIncomingList array */
/* @var $staticDailyInfoMarketExpenseList array */
/* @var $staticDailyInfoPurchasesList array */
/* @var $resultCash float */
/* @var $dailyResult float */


$this->title                   = $date;
$this->params['breadcrumbs'][] = $this->title;
$year                          = date("Y");
$amountCapital                 = Capital::sumResultCapital();
$taxOffice                     = TaxOffice::sumResultTaxOffice()['result'];
$amountCash                    = IncomingRevenue::sumResultIncomingRevenue()['result'] + $amountCapital + $taxOffice;
$amountPurchases               = Purchases::sumResultPurchases()['result'];
$amountExpense                 = MarketExpense::sumResultMarketExpense()['result'];
$resultCash                    = $amountCash - $amountPurchases - $amountExpense;
$totalIncomeOfTheShop          = IncomingRevenue::sumResultIncomingRevenue()['result'];

$incoming          = [];
$StaticDailyResult = [];
$expense           = [];
$purchases         = [];
foreach ($staticDailyInfoIncomingList as $dailyInfoIncoming)
{
    $incoming[] = [
        $dailyInfoIncoming['date'],
        $dailyInfoIncoming['total'],
    ];

    $StaticDailyResult[] = [
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
        'data' => $StaticDailyResult,
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
?>

<?php
//open Popup
yii\bootstrap4\Modal::begin([
                                'id'    => 'modal',
                                'title' => "<h3>" . Yii::t('app', 'Create Incoming Revenue') . "</h3>",
                            ]);
echo '<div id="modalContent"></div>';

yii\bootstrap4\Modal::end();
?>

<p>
    <?php if ($showCreateIncomingRevenue): ?>
        <?= Html::a(Yii::t('app', 'Incoming Revenue'), ['supermarket/incoming-revenue/create'], [
            'class' => 'btn btn-success',
            'data'  => [
                'method' => 'post',
                'params' => ['date' => $date],
            ],
        ]) ?>
    <?php endif; ?>
    <?= Html::a(Yii::t('app', 'Purchases'), ['supermarket/purchases/create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ['date' => $date],
        ],
    ]) ?>
    <?= Html::a(Yii::t('app', 'Market Expense'), ['supermarket/market-expense/create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ['date' => $date],
        ],
    ]) ?>
    <?= Html::a(Yii::t('app', 'Tax Office'), ['supermarket/tax-office/create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ['date' => $date],
        ],
    ]) ?>
    <?= Html::a(Yii::t('app', 'Returned Goods'), ['supermarket/returned-goods/create'], [
        'class' => 'btn btn-success',
        'data'  => [
            'method' => 'post',
            'params' => ['date' => $date],
        ],
    ]) ?>

    <?= Table::widget([
                          'tableArray' => [
                              [
                                  [
                                      'type' => 'td',
                                      'html' => '<strong>السبب</strong>',
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => '<strong>المبلغ</strong>',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Yii::t('app', 'المجموع الدخل الكلي'),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($amountCash) ? $amountCash : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode(Yii::t('app', 'تاسيس المحل')), Yii::$app->urlManager->createUrl(['/establish-market/index'])),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($establishMarketAmount['amount']) ? $establishMarketAmount['amount'] : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode(Yii::t('app', 'تاسيس المحل المؤسسين')), Yii::$app->urlManager->createUrl(['/capital/index'])),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($amountCapital) ? Html::a($amountCapital, Yii::$app->urlManager->createUrl(['/capital/index'])) : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode(Yii::t('app', 'مجموع الدخل اليومي')), Yii::$app->urlManager->createUrl(['/incoming-revenue/index'])),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($totalIncomeOfTheShop) ? Html::a($totalIncomeOfTheShop, Yii::$app->urlManager->createUrl(['/incoming-revenue/index'])) : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode(Yii::t('app', 'مجموع مسترجعات الدخل')), Yii::$app->urlManager->createUrl(['/tax-office/index'])),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($taxOffice) ? Html::a(Html::encode($taxOffice), Yii::$app->urlManager->createUrl(['/tax-office/index'])) : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode(Yii::t('app', 'مشتريات البضاعة')), Yii::$app->urlManager->createUrl(['/purchases/index'])),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($amountPurchases) ? Html::a(Html::encode($amountPurchases), Yii::$app->urlManager->createUrl(['/purchases/index'])) : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode(Yii::t('app', 'مصاريف المحل')), Yii::$app->urlManager->createUrl(['/market-expense/index'])),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => Html::a(Html::encode($amountExpense), Yii::$app->urlManager->createUrl(['/market-expense/index'])),
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Yii::t('app', 'مدخول اليوم الحالي'),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($dailyResult) ? $dailyResult : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Yii::t('app', 'الباقي سيولة ما عدا اليوم الحالي'),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($resultCash) ? $resultCash - $dailyResult : '',
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => Yii::t('app', 'الباقي سيولة'),
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => isset($resultCash) ? $resultCash : '',
                                  ],
                              ],
                          ],
                      ]); ?>
<h1><?= Html::encode(Yii::t('app', 'Day Information')) ?></h1>

<?= GridView::widget([
                         'dataProvider' => $dataProvider,
                         'columns'      => [
                             ['class' => 'yii\grid\SerialColumn'],
                             [
                                 'attribute' => 'type',
                                 'value'     => function ($model) {
                                     return Html::a($model['type'], [
                                         $model['site'] . '/update',
                                         'id' => $model['id'],
                                     ]);
                                 },
                                 'format'    => 'raw',
                             ],
                             'reason',
                             [
                                 'attribute' => 'result',
                                 'value'     => function ($model) {
                                     return Html::a($model['result'], [
                                         $model['site'] . '/update',
                                         'id' => $model['id'],
                                     ]);
                                 },
                                 'format'    => 'raw',
                             ],
                             [
                                 'class'      => 'common\components\ActionColumn',
                                 'template'   => '{update} {delete}',
                                 'urlCreator' => function ($action, $model) use ($date) {
                                     if ($action === 'update')
                                     {
                                         $url = Yii::$app->urlManager->createUrl([
                                                                                     $model['site'] . '/update',
                                                                                     'id'   => $model['id'],
                                                                                     'data' => [
                                                                                         'method' => 'post',
                                                                                         'params' => [
                                                                                             'date' => $date,
                                                                                         ],
                                                                                     ],
                                                                                 ]);
                                         return $url;
                                     }
                                     if ($action === 'delete')
                                     {
                                         $url = Yii::$app->urlManager->createUrl([
                                                                                     $model['site'] . '/delete',
                                                                                     'id' => $model['id'],
                                                                                 ]);
                                         return $url;
                                     }
                                 },
                             ],
                         ],
                     ]) ?>
<?php

echo '<h1>' . Yii::t('app', 'Statistics for whole month') . ' ' . ListeHelper::monthList($year) . '</h1>';

echo '<h1>' . Yii::t('app', 'Statistics for quarter') . '</h1>';
for ($i = 1; $i <= 4; $i++)
{
    echo Html::a(Yii::t('app', $i), ['arbeitszeit/quartal-ansicht' . '?year=' . $year . '&quartal=' . $i], [
        '',
        'class' => 'btn btn-primary',
    ]);

}

echo '<h1>' . Yii::t('app', 'Statistics for year') . ' ' . ListeHelper::YearList() . '</h1>';

$this->registerJsFile('@web/js/date_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>
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
