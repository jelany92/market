<?php

use common\components\GridView;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */
/* @var $show bool */

$this->title                   = Yii::t('app', 'Price Purchase in Group');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Purchases'),
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
                                 'purchases',
                             ],
                         ]); ?>
</div>
