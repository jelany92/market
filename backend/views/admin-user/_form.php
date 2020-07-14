<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $formModel common\models\AdminUserForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $roleList array */
/* @var $role string */
?>

<div class="admin-user-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($formModel, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'email')->input('email',['maxlength' => true]) ?>

    <?= $form->field($formModel, 'active_from')->widget(DateTimePicker::class, [
        'pluginOptions' => [
            'language' => 'de',
            'autoclose' => true,
            'startDate' => new \yii\web\JsExpression('new Date()'),
            'endDate' => '+60d',
            'minuteStep' => 15,
            'showMeridian' => true,
            'daysOfWeekDisabled' => '0,6',
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]);?>
    <?= $form->field($formModel, 'active_until')->widget(DateTimePicker::class, [
        'pluginOptions' => [
            'language' => 'de',
            'autoclose' => true,
            'startDate' => new \yii\web\JsExpression('new Date()'),
            'endDate' => '+1y',
            'minuteStep' => 15,
            'showMeridian' => true,
            'daysOfWeekDisabled' => '0,6',
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]);?>


    <?php if($formModel->isNewRecord):?>
        <!--        create mode -->
        <?= $form->field($formModel, 'role')->dropDownList($roleList) ?>
    <?php else:?>
        <!--        update mode -->
        <?= $form->field($formModel, 'role')->dropDownList($roleList, ['options' => [$formModel->role => ['Selected' => true] ]]) ?>
    <?php endif;?>





    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton(Yii::t('app', 'Speichern'), ['class' => 'btn btn-success pull-right']) ?>
            <?= Html::a(Yii::t('app', 'Abbrechen'), ['index'], ['class' => 'btn btn-light pull-right margin-right-10']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>