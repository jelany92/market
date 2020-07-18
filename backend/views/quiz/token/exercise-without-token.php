<?php

/* @var $this yii\web\View */
/* @var $exercises \backend\models\quiz\Excercise */

/* @var $modelQuizAnswerForm \backend\models\quiz\QuizAnswerForm */

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Accordion;
use yii\bootstrap\Collapse;

$this->title                   = Yii::t('app', 'Exercise');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>

<?php
$no         = 1;
$isExpanded = true;

foreach ($exercises as $exercise) : ?>
    <?php $answers = [
        'answer_a' => $exercise['answer_a'],
        'answer_b' => $exercise['answer_b'],
        'answer_c' => $exercise['answer_c'],
        'answer_d' => $exercise['answer_d'],
    ] ?>

    <?= Accordion::widget([
                              'items'             => [
                                  [
                                      'label'    => $exercise['question'],
                                      'content'  => $form->field($modelQuizAnswerForm, 'answer')->radioList($answers, [
                                          'name'      => 'Answers[' . $exercise['id'] . ']',
                                          'separator' => '<br>',
                                      ])->label(false),
                                      'collapse' => '',
                                  ],
                              ],
                              'itemToggleOptions' => [
                                  'aria-expanded' => false,
                                  'data-toggle'   => 'collapse',
                              ],
                          ]) ?>
    <br>
    <?php
    $no++;
    $isExpanded = false;
endforeach;
?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

