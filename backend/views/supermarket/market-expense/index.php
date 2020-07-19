<?php

use common\components\GridView;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\MarketExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */
/* @var $model  \backend\models\MarketExpense */
/* @var $show bool */

$this->title                   = Yii::t('app', 'Market Expenses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="market-expense-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($show == false) : ?>
        <?php $form = ActiveForm::begin([
                                            'type'   => ActiveForm::TYPE_HORIZONTAL,
                                            'action' => ['index'],
                                            'method' => 'post',
                                        ]); ?>

        <?= $form->field($model, 'reason') ?>
        <?= $form->field($model, 'from')->widget(DatePicker::class, [
            'options'       => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'autoclose'    => true,
                'showMeridian' => false,
                'endDate'      => '+0d',
                'format'       => 'yyyy-mm-dd',
            ],
        ]) ?>
        <?= $form->field($model, 'to')->widget(DatePicker::class, [
            'options'       => ['placeholder' => 'Enter event time ...'],
            'pluginOptions' => [
                'autoclose'    => true,
                'showMeridian' => false,
                'endDate'      => '+0d',
                'format'       => 'yyyy-mm-dd',
            ],
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'بحث'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'الغاء'), ['class' => 'btn btn-outline-secondary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <h1><?= Yii::t('app', 'مجموع ما تم بحث عنه<br> ') . $model->reason . ': ' . $result['result'] ?></h1>
    <?php endif; ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Market Expense'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Market Expense') . ' ' . Yii::t('app', 'export'), [
            'purchases/export',
        ], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Price in Group'), ['index-group'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'expense',
                                 'reason',
                                 'selected_date',
                                 [
                                     'class'    => 'common\components\ActionColumn',
                                     'template' => '{update} {delete}',
                                 ],
                             ],
                         ]); ?>


</div>
