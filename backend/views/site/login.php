<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Bitte die folgenden Felder ausfüllen:'); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Login', [
                    'class' => 'btn btn-primary',
                    'name'  => 'login-button',
                ]) ?>
            </div>

            <?= Html::a(Yii::t('app', 'Passwort vergessen?'), ['forgot-password']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
