<?php

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Excercise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="excercise-crud-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?php if (($modelModelMainCategoryExercise->question_type == 'tow_choice') || ($modelModelMainCategoryExercise->question_type == 'four_choice')) : ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'answer_a')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'answer_b')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?php if ($modelModelMainCategoryExercise->question_type == 'four_choice') : ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'answer_c')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'answer_d')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        <?php endif ?>
    <?php endif ?>
    <?php if ($modelModelMainCategoryExercise->question_type == 'text') : ?>

        <?= $form->field($model, 'correct_answer')->textInput(['maxlength' => true]) ?>

    <?php else: ?>

        <?= $form->field($model, 'correct_answer')->dropDownList($model->getCorrectAnswers($modelModelMainCategoryExercise->question_type), ['prompt' => 'Please Choose one']) ?>

    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
