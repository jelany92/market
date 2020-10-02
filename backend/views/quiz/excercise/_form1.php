<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use backend\models\quiz\MainCategoryExercise;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\quiz\Excercise;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model Excercise */
/* @var $form ActiveForm */

$this->registerJsFile('@web/js/quiz_list.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$number = 0;
?>

<div class="excercise-crud-form">

    <div class="customer-form">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-envelope"></i> Address Book
                <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add address</button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items"><!-- widgetContainer -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-address">Address: <?= ($i + 1) ?></span>
                            <div class="pull-right">
                                <?= Html::button(Icon::show('plus'), ['class' => 'btn btn-success add-item btn-xs']) ?>
                                <?= Html::button(Icon::show('minus'), ['class' => 'btn btn-danger remove-item btn-xs']) ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.

                            if (!$modelAddress->isNewRecord)
                            {
                                echo $form->field($modelAddress, "[{$i}]id")->hiddenInput([
                                                                                              'class' => 'email-limit-type',
                                                                                          ])->label(false);
                            }
                            ?>
                            <?= $form->field($model, "[{$i}]question_type")->dropDownList(Excercise::getQuestionType(), [
                                'class'  => "test",
                                'prompt' => Yii::t('app', 'Choose Answer Type'),
                            ]); ?>

                            <?= $form->field($model, "[{$i}]question")->textarea(['rows' => 6]) ?>

                            <?= Html::dropDownList('answerOption', [
                                'id'   => 'answerId',
                                'name' => 'answerName',
                            ], Excercise::getDefaultAnswerList(), [
                                                       'class'    => 'btn btn-primary conditional-field answerOption',
                                                       'onchange' => 'myFunctionAnswer()',
                                                       'prompt'   => Yii::t('app', 'Choose Answer Option'),
                                                       'style'    => 'display:none',
                                                   ]); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, "[{$i}]answer_a", [
                                        'options' => [
                                            'class' => 'form-group conditional-field filter-exercise-tow_choice-field',
                                            // 'style' => 'display:none',
                                        ],
                                    ])->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, "[{$i}]answer_b", [
                                        'options' => [
                                            'class' => 'form-group conditional-field filter-exercise-tow_choice-field',
                                            'style' => 'display:none',
                                        ],
                                    ])->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, "[{$i}]answer_c", [
                                        'options' => [
                                            'class' => 'form-group conditional-field filter-exercise-four_choice-field',
                                            'style' => 'display:none',
                                        ],
                                    ])->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, "[{$i}]answer_d", [
                                        'options' => [
                                            'class' => 'form-group conditional-field filter-exercise-four_choice-field',
                                            'style' => 'display:none',
                                        ],
                                    ])->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <?= $form->field($model, "[{$i}]correct_answer", [
                                'options' => [
                                    'class' => 'form-group conditional-field filter-right-answer-type-field',
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
                                    'depends'     => [$i],
                                    'placeholder' => 'Select...',
                                    'url'         => Url::to(['quiz/excercise/correct-answer']),
                                ],
                            ]); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <div class="form-group">
            <?= Html::submitButton($modelAddress->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
