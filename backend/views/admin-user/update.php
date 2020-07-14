<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $formModel common\models\AdminUserForm */
/* @var $roleList array */
/* @var $id integer ID from DB */

$this->title = Yii::t('app', 'Benutzer bearbeiten: ' . $formModel->username, [
    'nameAttribute' => '' . $formModel->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Benutzer'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Bearbeiten');
?>
<div class="admin-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'formModel' => $formModel,
        'roleList' => $roleList,
    ]) ?>

</div>
