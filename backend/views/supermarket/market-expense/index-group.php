<?php

use common\components\GridView;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */
/* @var $show bool */

$this->title                   = Yii::t('app', 'Market Expenses In Group');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Market Expenses'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="market-expense-index">


    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 'reason',
                                 [
                                     'attribute' => 'company_id',
                                     'value'     => function ($model) {
                                         return $model['result'];
                                     },
                                 ],
                                 'selected_date',
                             ],
                         ]); ?>
</div>
