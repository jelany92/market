<?php

/* @var $this yii\web\View */
/* @var $exercises \backend\models\quiz\Excercise */

/* @var $modelQuizAnswerForm \backend\models\quiz\QuizAnswerForm */

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use common\widgets\Card;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use yii\web\JqueryAsset;

$this->title                   = Yii::t('app', 'Exercise');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/application_form.js', ['depends' => [JqueryAsset::class]]);
?>

<div id="time-down-counter-2"></div>
<?php $form = ActiveForm::begin([
                                    'action'  => Yii::$app->urlManager->createUrl([
                                                                                      'quiz/token/ajax-save-single-answer',
                                                                                      'token' => $token,
                                                                                      //'identifierJob'      => $identifierJob,
                                                                                      //'intranet'           => $intranet ? 1 : 0,
                                                                                      //'applicantAccount'   => $applicantAccount,
                                                                                  ]),
                                    'options' => [
                                        'class' => 'question-form',
                                    ],
                                ]); ?>
<?php
$no         = 1;
$isExpanded = true;
Card::begin([
                'id'             => 'privacyPolicy',
                'parent'         => 'accordionApplication',
                'title'          => $this->title,
                'collapsed'      => 1 < $no ? true : false,
                'icon'           => 0 < $no ? Icon::show('check-circle', ['framework' => Icon::FAS]) : Icon::show('circle', ['framework' => Icon::FAR]),
                'toggle'         => '',
                'collapseClass'  => 'applicationFormCollapse',
                'containerClass' => 'card-current card-open',
            ]);
foreach ($exercises as $exercise) : ?>
    <?php
    $answers = [
        'answer_a' => $exercise['answer_a'],
        'answer_b' => $exercise['answer_b'],
        'answer_c' => $exercise['answer_c'],
        'answer_d' => $exercise['answer_d'],
    ];
    Card::begin([
                    'id'             => $exercise['id'],
                    'parent'         => 'accordionApplication',
                    'title'          => $exercise['question'],
                    'collapsed'      => 1 < $no ? true : false,
                    'toggle'         => '',
                    'inSubAccordion' => true,
                    'collapseClass'  => 'applicationFormCollapse',
                    'containerClass' => 'card-open',
                ]);

    if (0 < count(array_filter($answers)))
    {
        $content = $form->field($modelQuizAnswerForm, 'answer')->radioList(array_filter($answers), [
            'name'      => 'Answers[' . $exercise['id'] . ']',
            'separator' => '<br>',
            '<div class="panel-body"></div>',
        ])->label(false);
    }
    else
    {
        $content = $form->field($modelQuizAnswerForm, 'answer')->textInput([
                                                                               'maxlength' => true,
                                                                               'name'      => 'Answers[' . $exercise['id'] . ']',
                                                                           ])->label(false);
    }
    ?>

    <?= $content ?>
    <?php
    $no++;
    $isExpanded = false;
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Apply now') . ' ' . Icon::show('caret-right'), [
            'class' => 'btn btn-primary ajaxButton',
            //'disabled' => true,
        ]) ?>
    </div>
    <?php Card::end();
endforeach;
?>
<?php
Card::end()
?>
<?php ActiveForm::end(); ?>

