<?php

use yii\bootstrap4\Html;
use common\components\QueryHelper;
use yii\grid\GridView;
use common\components\ListeHelper;
use yii\bootstrap4\Tabs;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $dataProvider \yii\data\ArrayDataProvider */

$this->title                   = Yii::t('app', 'Year');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="Monat Ansicht-index">

    <?= $this->render('/site/supermarket/_sub_navigation_year', [
        'controller' => 'site/year-view',
        'year'       => $year,
    ]) ?>

    <h1><?=  Yii::t('app', 'اجمالي دخل المحل') . ' : ' . QueryHelper::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue') ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 '0',
                                 // key for month
                             ],
                         ]) ?>
</div>
