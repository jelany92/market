<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap4\Html;
use kartik\icons\Icon;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container page-content">

    <div class="login-block row no-gutter">
        <div class="col-m-6">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput([
                                                                'autofocus'   => true,
                                                                'placeholder' => Yii::t('app', 'اسم المستخدم'),
                                                            ]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <form method="POST" action="https://shahid4u.im/login" accept-charset="UTF-8" class="form-ui login-form"><input name="_token" type="hidden" value="tjZ9GTXIkJfQNtuSMSdzu7evCHvWCjUonZTrYwSv">

                <label class="checkbox">
                    <?= $form->field($model, 'rememberMe')->checkbox()->label(false) ?>
                    <?= Html::tag('span', Yii::t('app', 'حفظ بيانات الحساب')) ?>
                </label>
                <?= Html::submitButton('Login', [
                    'class' => 'btn primary',
                    'name'  => 'login-button',
                ]) ?>
            </form>
            <div class="social-login">
                <?= Html::tag('p', Yii::t('app', 'تسجيل الدخول من خلال السوشال ميديا')) ?>
                <?= Html::a(Icon::show('facebook-square'), ['https://shahid4u.im/auth/facebook']) ?>
                <?= Html::a(Icon::show('google-plus-g'), ['https://shahid4u.im/auth/facebook']) ?>
            </div>
        </div>
        <div class="col-m-6">
            <div class="flex">
                <div class="content signup-cta">
                    <?= Html::tag('h2', Yii::t('app', 'الا تملك حساب على متجرنا يمكنك تسجيل حساب جديد الان')) ?>
                    <?= Html::a(Icon::show('facebook-square'), ['https://shahid4u.im/auth/facebook']) ?>
                    <?= Html::a(Icon::show('google-plus-g'), ['https://shahid4u.im/auth/facebook']) ?>
                    <?= Html::a(Yii::t('app', 'انشاء حساب جديد'), ['site/signup'], ['class' => 'btn primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
