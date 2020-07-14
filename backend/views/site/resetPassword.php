<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \frontend\models\ResetPasswordForm */

use kartik\password\PasswordInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title                   = Yii::t('app', 'Passwort setzen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Lege ein neues Passwort fest') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->widget(PasswordInput::class, [
                         'pluginOptions' => [
                             'showMeter'  => true,
                             'toggleMask' => false,
                         ],
                         'options' => [
                             'autofocus'  => true,
                         ]
                     ]) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Speichern'), ['class' => 'btn btn-primary pull-right']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
