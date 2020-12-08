<?php

use kartik\form\ActiveForm;
use kartik\password\PasswordInput;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $formModel \backend\models\ResetPasswordForm */

$this->title = Yii::t('common', 'Set a new password');
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('common', 'Please enter a new password.') ?></p>

    <div class="row">
        <div class="col-12">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($formModel, 'password')->widget(PasswordInput::class, [
                'pluginOptions' => [
                    'showMeter'  => true,
                    'toggleMask' => false,
                ],
            ]) ?>
            <?= $form->field($formModel, 'password_repeat')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('common', 'Reset password'), ['class' => 'btn btn-primary btn-block']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
