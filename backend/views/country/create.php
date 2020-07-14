<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Country */

$this->title = Yii::t('app', 'Land anlegen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Länder'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
