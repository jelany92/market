<?php

use common\components\GridView;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $correctAnswer integer */
/* @var $searchModel \backend\models\quiz\search\ExcerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Your Answer');
$percentage  = number_format(($correctAnswer / $dataProvider->count) * 100, 2) . '%';
?>
<div class="excercise-crud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Yii::t('app', 'You have') . ' ' . $correctAnswer . ' ' . Yii::t('app', 'right answer from') . ' ' . $dataProvider->count ?></h1>
    <h1><?= Yii::t('app', 'Percentage') . ' ' . $percentage ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'options'      => [
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'rowOptions'   => function ($model) {
                                 if (!empty($model->student_answer))
                                 {
                                     if ($model->student_answer == $model->excercise->correct_answer)
                                     {
                                         return ['style' => 'background-color:#4FFFB0'];
                                     }
                                     else
                                     {
                                         return ['style' => 'background-color:#F88379'];
                                     }
                                 }
                                 else
                                 {
                                     return ['style' => 'background-color:#F88379'];
                                 }

                             },
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 [
                                     'attribute' => 'excercise_id',
                                     'value'     => 'excercise.question',
                                 ],
                                 [
                                     'attribute' => 'student_id',
                                     'value'     => 'student.name',
                                 ],
                                 [
                                     'attribute' => 'student_answer',
                                     'value'     => function ($model) {
                                         if (!empty($model->student_answer))
                                         {
                                             return $model->excercise[$model->student_answer];
                                         }
                                     },
                                 ],
                                 [
                                     'label' => Yii::t('app', 'Correct Answer'),
                                     'value' => function ($model) {
                                         return isset($model->excercise[$model->excercise->correct_answer]) ? $model->excercise[$model->excercise->correct_answer] : $model->excercise->correct_answer;
                                     },
                                 ],
                             ],
                         ]); ?>
</div>
