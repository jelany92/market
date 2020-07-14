<?php

use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdminUserForm */
/* @var $roleList array */

$this->title = Yii::t('app', 'Neuen Benutzer erstellen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Benutzer'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
        'roleList' => $roleList,
    ]) ?>

</div>
