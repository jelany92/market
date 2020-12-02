<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use common\components\GridView;
use backend\models\quiz\Excercise;

/* @var $this yii\web\View */
/* @var $model backend\models\quiz\MainCategoryExercise */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = $model->main_category_exercise_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Main Category Exercises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="main-category-exercise-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'main_category_exercise_name',
            'description:ntext',
        ],
    ]) ?>

    <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Question'), [
            'quiz/excercise/create',
            'mainCategoryExerciseId' => $model->id],
        ['class' => 'btn btn-success']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'      => [
            'style' => 'overflow: auto; word-wrap: break-word;',
        ],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'question',
            [
                'attribute' => 'question_type',
                'value'     => function ($model) {
                    return Excercise::getQuestionType()[$model->question_type];
                },
            ],
            [
                'attribute' => 'correct_answer',
                'value'     => function ($model) {
                    return isset($model[$model->correct_answer]) ? $model[$model->correct_answer] : $model->correct_answer;
                },
            ],
        ],
    ]); ?>
</div>
