<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Excercise */
/* @var $modelModelMainCategoryExercise \backend\models\quiz\MainCategoryExercise */

$this->title                   = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Excercise',
    ]) . $model->question;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Excercise'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $modelModelMainCategoryExercise->main_category_exercise_name,
    'url'   => ['quiz/main-category-exercise'],
];


$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="excercise-crud-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'                          => $model,
        'modelModelMainCategoryExercise' => $modelModelMainCategoryExercise,
        'modelsAddress'                  => $modelsAddress,
    ]) ?>

</div>
