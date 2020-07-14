<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\ForgotPasswordForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Passwort vergessen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'forgot-password-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>


                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Passwort anfordern'), ['class' => 'btn btn-primary', 'name' => 'forgot-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
