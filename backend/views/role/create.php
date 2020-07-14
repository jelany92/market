<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Role */

$this->title = Yii::t('app', 'Rolle anlegen');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rollenverwaltung'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
