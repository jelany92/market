<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\auth\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $typeList array */

?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal','id'=>'auth-item-form']); ?>
<!-- if name empty  we are in 'create view'  -->
    <?php if($model->isNewRecord):?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->dropDownList($typeList) ?>
    <?php else:?>

    <p>
        <h4>Name: <?= Html::encode($model->name)?></h4>
    </p>
    <?php endif;?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>


    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton(Yii::t('app', 'Speichern'), ['class' => 'btn btn-success pull-right']) ?>
            <?= Html::a(Yii::t('app', 'Abbrechen'), ['index'], ['class' => 'btn btn-light pull-right margin-right-10']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
