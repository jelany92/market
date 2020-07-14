<?php

use dosamigos\tinymce\TinyMce;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(['layout'  => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(TinyMce::class, [
        'options' => ['style' => 'display:none','id' => 'std_editor', 'rows' => 8],
        'language' => Yii::$app->language,
        'clientOptions' => [
            'setup' => new JsExpression("function(editor){
            $('#std_editor').show();
            }"
            ),
            'branding'=> false,
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton(Yii::t('app', 'Speichern'), ['class' => 'btn btn-success pull-right']) ?>
            <?= Html::a(Yii::t('app', 'Abbrechen'), ['index'], ['class' => 'btn btn-light pull-right margin-right-10']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
