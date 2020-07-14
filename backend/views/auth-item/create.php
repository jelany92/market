<?php

use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model common\models\auth\AuthItem */
/* @var $typeList array*/

$this->title = Yii::t('app', 'Eintrag erstellen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rechte & Rollen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'typeList' => $typeList,
    ]) ?>

</div>
