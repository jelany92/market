<?php

use yii\bootstrap4\Html;
use common\components\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\quiz\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-crud-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Students'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete Students'), ['delete-not-completed-student'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'options'      => [
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'token',
                                 [
                                     'attribute' => 'name',
                                     'label'     => 'Name',
                                     'format'    => 'html',
                                     'value'     => function ($model) {
                                         return Html::a($model->name, [
                                             '/quiz/token/quiz-result',
                                             'studentId' => $model->id,
                                         ]);
                                     },
                                 ],
                                 'correct_answer',
                                 'wrong_answer',
                                 'score',
                                 [
                                     'attribute' => 'is_complete',
                                     'value'     => function ($model) {
                                         return Html::a($model->is_complete ? 'Completed' : 'Pending', [
                                             '/quiz/token/start-exercise-without-token',
                                             'mainCategoryExerciseId' => $model->id,
                                         ]);
                                     },
                                     'format'    => 'raw',
                                 ],
                                 [
                                     'class'    => 'common\components\ActionColumn',
                                     'template' => '{update} {delete}',
                                 ],                             ],
                         ]); ?>
    <?php Pjax::end(); ?>
</div>
