<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \backend\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title                   = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-login">
    <div class="row">
        <div class="col-12">
            <h1><?= Html::encode($this->title) ?></h1>

            <p><?= Yii::t('app', 'Please fill out the following fields to login:'); ?></p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Log in'), [
                    'class' => 'btn btn-primary btn-block',
                    'name'  => 'login-button',
                ]) ?>
            </div>
            <?php ActiveForm::end(); ?>

            <p class="text-center mt-3">
                <?= Html::a(Yii::t('app', 'Forgot password'), ['site/forgot-password'], ['class' => 'm3 text-muted']); ?>
            </p>
        </div>
    </div>
</div>