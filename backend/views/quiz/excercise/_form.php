<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use backend\models\quiz\MainCategoryExercise;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\quiz\Excercise;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model Excercise */
/* @var $form ActiveForm */
$this->registerJsFile('@web/js/quiz_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="excercise-crud-form">

    <div class="customer-form">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

        <div class="panel panel-default">
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                                                   'widgetContainer' => 'dynamicform_wrapper',
                                                   // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                                   'widgetBody'      => '.container-items',
                                                   // required: css class selector
                                                   'widgetItem'      => '.item',
                                                   // required: css class
                                                   'limit'           => 4,
                                                   // the maximum times, an element can be cloned (default 999)
                                                   'min'             => 1,
                                                   // 0 or 1 (default 1)
                                                   'insertButton'    => '.add-item',
                                                   // css class
                                                   'deleteButton'    => '.remove-item',
                                                   // css class
                                                   'model'           => $modelsAddress[0],
                                                   'formId'          => 'dynamic-form',
                                                   'formFields'      => [
                                                       'question_type',
                                                       'question',
                                                       'answer_a',
                                                       'answer_b',
                                                       'answer_c',
                                                       'answer_d',
                                                       'correct_answer',
                                                   ],
                                               ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <?php var_dump($i); ?>

                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Address</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (!$modelAddress->isNewRecord)
                                {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                                ?>
                                <?= $form->field($model, "[{$i}]question_type")->dropDownList(Excercise::getQuestionType(), [
                                    'id'       => 'question_type_id_' . $i,
                                    'onchange' => 'myFunctionAnswerType(' . $i . ')',
                                    'prompt'   => Yii::t('app', 'Choose Answer Type'),
                                ]); ?>

                                <?= $form->field($model, "[{$i}]question")->textarea(['rows' => 6]) ?>

                                <?= Html::dropDownList('answerOption_' . $i, [
                                    'id'   => 'answerId',
                                    'name' => 'answerName',
                                ], MainCategoryExercise::getDefaultAnswerList(), [
                                                           'id'       => 'answer_' . $i,
                                                           'class'    => 'btn btn-primary conditional-field answerOption',
                                                           'onchange' => 'myFunctionAnswer(' . $i . ')',
                                                           'prompt'   => Yii::t('app', 'Choose Answer Option'),
                                                           'style'    => 'display:none',
                                                       ]); ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, "[{$i}]answer_a", [
                                            'options' => [
                                                'class' => 'form-group conditional-field filter-exercise-tow_choice-field_' . $i,
                                                'style' => 'display:none',
                                            ],
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, "[{$i}]answer_b", [
                                            'options' => [
                                                'class' => 'form-group conditional-field filter-exercise-tow_choice-field_' . $i,
                                                'style' => 'display:none',
                                            ],
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, "[{$i}]answer_c", [
                                            'options' => [
                                                'class' => 'form-group conditional-field filter-exercise-four_choice-field_' . $i,
                                                'style' => 'display:none',
                                            ],
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, "[{$i}]answer_d", [
                                            'options' => [
                                                'class' => 'form-group conditional-field filter-exercise-four_choice-field_' . $i,
                                                'style' => 'display:none',
                                            ],
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                                <?= $form->field($model, "[{$i}]correct_answer", [
                                    'options' => [
                                        'class' => 'form-group conditional-field filter-right-answer-type-field_' . $i,
                                        'style' => 'display:none',
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
                                        'id'     => 'correct_answer_id_' . $i,
                                        'prompt' => Yii::t('app', 'please Choose'),
                                    ],
                                    'pluginOptions'  => [
                                        'depends'     => ['question_type_id_' . $i],
                                        'placeholder' => 'Select...',
                                        'url'         => Url::to(['quiz/excercise/correct-answer']),
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($modelAddress->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
