<?php

use backend\models\quiz\Excercise;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Excercise */

$this->title                   = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Excercise',
    ]) . $model->question;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Excercise'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->mainCategoryExercise->main_category_exercise_name,
    'url'   => ['quiz/main-category-exercise'],
];


$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="excercise-crud-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, "question_type")->dropDownList(Excercise::getQuestionType(), [
        'id'     => "question_type",
        'prompt' => Yii::t('app', 'Choose Answer Type'),
    ]); ?>

    <?= $form->field($model, "question")->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, "answer_a", [
                'options' => [
                    'class' => 'form-group conditional-field filter-exercise-tow_choice-field',
                ],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, "answer_b", [
                'options' => [
                    'class' => 'form-group conditional-field filter-exercise-tow_choice-field',
                ],
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, "answer_c", [
                'options' => [
                    'class' => 'form-group conditional-field filter-exercise-four_choice-field',
                ],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, "answer_d", [
                'options' => [
                    'class' => 'form-group conditional-field filter-exercise-four_choice-field',
                ],
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, "correct_answer", [
        'options' => [
            'class' => 'form-group conditional-field filter-right-answer-type-field',
        ],
    ])->widget(DepDrop::class, [
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
            'id'     => 'correct_answer_id_',
            'prompt' => Yii::t('app', 'please Choose'),
        ],
        'pluginOptions'  => [
            'depends'     => ['question_type'],
            'placeholder' => 'Select...',
            'url'         => Url::to(['quiz/excercise/correct-answer']),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
