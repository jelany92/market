<?php

use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View*/

?>
<h1><?= Yii::t('app', 'Projekt auswählen') ?></h1>
<br>

<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
]) ?>

<?= $form->field($model, 'project_code')->textInput(['maxlength' => true]) ?>

<div class="row">
    <p>
    <div class="col-sm-6 col-sm-offset-3">
        <?= Html::submitButton(Yii::t('app', 'Auswählen & Weiter'), ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>

<br><br><br>
<h1><?= Yii::t('app', 'Neues Projekt starten') ?></h1>
<?= Html::a(Yii::t('app', 'Projekt erfassen'), ['/project/index'], ['class'=>'btn btn-success']) ?>
