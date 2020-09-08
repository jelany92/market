<?php

/* @var $this yii\web\View */
/* @var $exercises \backend\models\quiz\Excercise */

/* @var $modelQuizAnswerForm \backend\models\quiz\QuizAnswerForm */

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use common\widgets\AccordionWidget;
use common\widgets\Card;
use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use kartik\icons\Icon;

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
?>
<?php $form = ActiveForm::begin(); ?>


<div id="time-down-counter-2"></div>

<?php
$no         = 1;
$isExpanded = true;
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
                    'collapsed'      => false,
                    'toggle'         => '',
                    'inSubAccordion' => true,
                    'collapseClass'  => 'answerCollapse',
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
    Card::end();
endforeach;
?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php Card::end(); ?>


