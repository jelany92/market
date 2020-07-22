<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \common\models\AdminUser */

use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

$this->title                   = Yii::t('app', 'Create') . ' ' . Yii::t('app', 'New Customer');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create-company">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Please fill in the following fields') . ':'; ?></p>

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'company_name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), [
            'class' => 'btn btn-primary',
            'name'  => 'login-button',
        ]) ?>
        <?= Html::a(Yii::t('app', 'Abbrechen'), ['login'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
