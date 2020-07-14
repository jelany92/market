<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin([
        'layout'  => 'horizontal',
    ]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton(Yii::t('app', 'Speichern'), ['class' => 'btn btn-success pull-right']) ?>
            <?= Html::a(Yii::t('app', 'Abbrechen'), ['index'], ['class' => 'btn btn-light pull-right margin-right-10']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
