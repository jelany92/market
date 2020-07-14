<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \backend\models\quiz\Excercise */

$this->title = Yii::t('app', 'Create Excercise');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Main Category Exercises'), 'url' => ['quiz/main-category-exercise/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Excercise'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="excercise-crud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
