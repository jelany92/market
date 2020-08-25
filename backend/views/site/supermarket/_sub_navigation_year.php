<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Tabs;
use common\components\ListeHelper;

/* @var $controller string */
/* @var $year integer */
/* @var $month string */
$this->registerJsFile('@web/js/date_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="col-sm-12">
    <h1><?= Html::encode($this->title) . ' ' . ListeHelper::YearList() ?></h1>

    <h1><?= Html::a('zurück', [
            'site/view',
            'date' => Yii::$app->session->get('returnDate'),
        ], [
                        '',
                        'class' => 'btn btn-success',
                    ]) . '</br>'; ?></h1>
</div>
<div class="row">
    <?= Tabs::widget([
                         'options' => ['id' => 'customer_nav'],
                         'items'   => [
                             [
                                 'label'       => Icon::show('list-alt') . ' ' . Yii::t('app', 'معلومات السنة'),
                                 'linkOptions' => ['class' => 'tab-link'],
                                 'active'      => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'year-view',
                                 'url'         => Yii::$app->urlManager->createUrl([
                                                                                       'site/year-view',
                                                                                       'year' => $year,
                                                                                   ]),
                                 'encode'      => false,
                             ],
                             [
                                 'label'       => Icon::show('list-alt') . ' ' . Yii::t('app', 'الدخل'),
                                 'linkOptions' => ['class' => 'tab-link'],
                                 'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'year-income',
                                 'url'         => Yii::$app->urlManager->createUrl([
                                                                                       'statistic/year-income',
                                                                                       'year' => $year,
                                                                                   ]),
                                 'encode'      => false,
                             ],
                             [
                                 'label'       => Icon::show('users') . ' ' . Yii::t('app', 'شراء بضاعة'),
                                 'linkOptions' => ['class' => 'tab-link'],
                                 'url'         => Yii::$app->urlManager->createUrl([
                                                                                       'statistic/year-purchases',
                                                                                       'year' => $year,
                                                                                   ]),
                                 'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'year-purchases',
                                 'encode'      => false,
                             ],
                             [
                                 'label'       => Icon::show('users') . ' ' . Yii::t('app', 'نفقات المحل'),
                                 'linkOptions' => ['class' => 'tab-link'],
                                 'url'         => Yii::$app->urlManager->createUrl([
                                                                                       'statistic/year-market-expense',
                                                                                       'year' => $year,
                                                                                   ]),
                                 'active'      => Yii::$app->controller->id == 'statistic' && Yii::$app->controller->action->id == 'year-market-expense',
                                 'encode'      => false,
                             ],
                         ],
                     ]); ?>
</div>
<br>
