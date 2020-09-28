<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use backend\models\quiz\MainCategoryExercise;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\quiz\Excercise;
use kartik\select2\Select2;
use common\widgets\LocationWidget;

/* @var $this yii\web\View */
/* @var $model Excercise */
/* @var $form ActiveForm */
$this->registerJsFile('@web/js/quiz_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="excercise-crud-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'question_type')->dropDownList(Excercise::getQuestionType(), [
        'id'       => 'question_type_id',
        'onchange' => 'myFunctionAnswerType()',
        'prompt'   => Yii::t('app', 'Choose Answer Type'),
    ]); ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

        <?= Html::dropDownList('answerOption', [
                'id'   => 'answerId',
                'name' => 'answerName',
            ], MainCategoryExercise::getDefaultAnswerList(), [
                'id'       => 'answer',
                'class'    => 'btn btn-primary conditional-field answerOption',
                'onchange' => 'myFunctionAnswer()',
                'prompt'   => Yii::t('app', 'Choose Answer Option'),
                'style'    => 'display:none',
        ]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'answer_a',  [
                     'options' => [
                         'class' => 'form-group conditional-field filter-exercise-tow_choice-field',
                         'style' => 'display:none',
                     ],
                ])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'answer_b', [
                     'options' => [
                         'class' => 'form-group conditional-field filter-exercise-tow_choice-field',
                         'style' => 'display:none',
                     ],
                ])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'answer_c', [
                     'options' => [
                         'class' => 'form-group conditional-field filter-exercise-four_choice-field',
                         'style' => 'display:none',
                     ],
                ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'answer_d', [
                     'options' => [
                         'class' => 'form-group conditional-field filter-exercise-four_choice-field',
                         'style' => 'display:none',
                     ],
                ])->textInput(['maxlength' => true]) ?>
                </div>
            </div>
    <?= $form->field($model, 'correct_answer', ['options' => [
        'class' => 'form-group conditional-field filter-right-answer-type-field',
        'style' => 'display:none',
    ]])->widget(DepDrop::class, [
        'type'           => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'pluginOptions' => [
                'allowClear'         => true,
                'tags'               => true,
                'maximumInputLength' => false,
            ],
            'options'       => [
                'multiple' => true,
            ],
            'size'          => Select2::LARGE,
        ],
        // DepDrop
        'data'           => $model->question_type != null ? Excercise::getCorrectAnswerOptionList($model->question_type) : '',
        'options'        => [
            'id'       => 'correct_answer_id',
            'prompt'   => Yii::t('app', 'please Choose'),
        ],
        'pluginOptions'  => [
            'depends'     => ['question_type_id'],
            'placeholder' => 'Select...',
            'url'         => Url::to(['quiz/excercise/correct-answer']),
        ],
    ]); ?>

    <?= LocationWidget::widget([
                                   'model' => $model,
                                   'form'  => $form,
                               ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
