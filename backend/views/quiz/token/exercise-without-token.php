<?php

/* @var $this yii\web\View */
/* @var $exercises \backend\models\quiz\Excercise */

/* @var $modelQuizAnswerForm \backend\models\quiz\QuizAnswerForm */

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use common\widgets\AccordionWidget;
use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;

$this->title                   = Yii::t('app', 'Exercise');
$this->params['breadcrumbs'][] = $this->title;
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
    <?= AccordionWidget::widget([
                                    'items' => [
                                        [
                                            'label'   => '<div class="card-header">' . $exercise['question'] . '</div>',
                                            'content' => $content,
                                        ],
                                    ],
                                ]) ?>
    <?php
    $no++;
    $isExpanded = false;
endforeach;
?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

