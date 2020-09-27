<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Excercise */

$this->title = $model->mainCategoryExercise->main_category_exercise_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Main Category Exercises'), 'url' => ['quiz/main-category-exercise']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Excercise'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="excercise-crud-view">

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
            'mainCategoryExercise.main_category_exercise_name',
            'question:ntext',
            [
                'attribute' => 'answer_a',
                'value'     => function ($model) {
                    return $model->answer_a;
                },
                'visible' => !empty($model->answer_a),
            ],
            [
                'attribute' => 'answer_b',
                'value'     => function ($model) {
                    return $model->answer_b;
                },
                'visible' => !empty($model->answer_b),
            ],
            [
                'attribute' => 'answer_c',
                'value'     => function ($model) {
                    return $model->answer_c;
                },
                'visible' => !empty($model->answer_c),
            ],
            [
                'attribute' => 'answer_d',
                'value'     => function ($model) {
                    return $model->answer_d;
                },
                'visible' => !empty($model->answer_d),
            ],
            [
                'attribute' => 'correct_answer',
                'value'     => function ($model) {
                    return isset($model[$model->correct_answer]) ? $model[$model->correct_answer] : $model->correct_answer;
                },
            ],
        ],
    ]) ?>

</div>
