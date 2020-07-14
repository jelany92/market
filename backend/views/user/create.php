<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Frontend-Benutzer anlegen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Frontend-Benutzer'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
