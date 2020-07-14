<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\auth\AuthItem */
/* @var $typeList array*/

$this->title = Yii::t('app', 'Bearbeiten: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rechte & Rollen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->name), 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Bearbeiten');
?>
<div class="auth-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
