<?php

use backend\models\Capital;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Capital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capital-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($model, 'name', [])->widget(Select2::class, [
        'model'         => $model,
        'attribute'     => 'name',
        'options'       => [
            'placeholder' => 'please Choose ...',
            'multiple'    => false,
        ],
        'pluginOptions' => [
            'allowClear'         => true,
            'tags'               => true,
            'maximumInputLength' => false,
        ],
        'size'          => Select2::LARGE,
        'data'          => ArrayHelper::map(Capital::find()->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['name'])->all(), 'id', 'name'),
    ]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'selected_date')->widget(DatePicker::class, [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose'    => true,
            'showMeridian' => false,
            'endDate'      => '+0d',
            'format'       => 'yyyy-mm-dd'
            //'format'       => 'dd.mm.yyyy'
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([
                                                         'Entry'      => 'Entry',
                                                         'Withdrawal' => 'Withdrawal',
                                                     ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
