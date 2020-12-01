<?php

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use common\widgets\Card;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $exercises \backend\models\quiz\Excercise */

/* @var $modelQuizAnswerForm \backend\models\quiz\QuizAnswerForm */

$this->title                   = Yii::t('app', 'Exercise');
$this->params['breadcrumbs'][] = $this->title;
Card::begin([
                'id'             => 'privacyPolicy',
                'parent'         => 'accordionApplication',
                'title'          => $this->title,
                'collapsed'      => false,
                'icon'           => Icon::show('circle', ['framework' => Icon::FAR]),
                'toggle'         => '',
                'collapseClass'  => 'answerCollapse',
                'containerClass' => 'card-current card-open',
            ]);

$this->registerJsFile('@web/js/quiz_answer.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<?php
$no         = 1;
$isExpanded = true;
foreach ($exercises as $exercise) : ?>
    <?php $form = ActiveForm::begin([
                                        'action'  => Yii::$app->urlManager->createUrl([
                                                                                          'quiz/token/ajax-next-question',
                                                                                          'token' => $token,
                                                                                      ]),
                                        'options' => [
                                            'class' => 'answer-form',
                                        ],
                                    ]); ?>
    <?php
    $answers = [
        'answer_a' => $exercise['answer_a'],
        'answer_b' => $exercise['answer_b'],
        'answer_c' => $exercise['answer_c'],
        'answer_d' => $exercise['answer_d'],
    ];
    Card::begin([
                    'id'             => '_' . $no,
                    'parent'         => 'accordionApplication',
                    'title'          => $exercise['question'],
                    'collapsed'      => $no == 1 ? false : true,
                    'toggle'         => '',
                    'inSubAccordion' => true,
                    'collapseClass'  => 'answerCollapse_' . $no,
                    'containerClass' => 'card-open',
                ]);
    if (0 < count(array_filter($answers)))
    {
        $content = $form->field($modelQuizAnswerForm, 'answer')->radioList(array_filter($answers), [
            'name'      => 'Answers[' . $exercise['id'] . ']',
            'separator' => '<br>',
            'class'     => 'panel-body',
        ])->label(false);
    }
    else
    {
        $content = $form->field($modelQuizAnswerForm, 'answer')->textInput([
                                                                               'maxlength' => true,
                                                                               'name'      => 'Answers[' . $exercise['id'] . ']',
                                                                               'class'     => 'panel-body',
                                                                           ])->label(false);
    }
    ?>
    <?= $content ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Next Question'), [
            'id'      => 'answer',
            'class'   => 'btn btn-primary ajaxButton',
            'onclick' => 'myFunctionNextQuestion(' . $no . ')',
        ]) ?>
    </div>
    <?php
    $no++;
    $isExpanded = false;
    Card::end();
    ActiveForm::end();
endforeach;
?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php Card::end(); ?>


