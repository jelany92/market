<?php

use common\models\auth\AuthItem;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\auth\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $typeList array */

?>

<div class="auth-item-form">

    <h2><?= Yii::t('app', 'Weitere Elemente hinzufügen') ?></h2>
    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'action' => Yii::$app->urlManager->createUrl(['auth-item/assign', 'id' => $model->name])]); ?>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
            <?= Html::dropDownList('item', null, AuthItem::getAssignableList($model), ['class' => "form-control"]) ?>
                </div>
                <div class="col-sm-6">
                    <?= Html::submitButton(Yii::t('app', 'Zuweisen'), ['class' => 'form-control pull-left btn btn-success margin-right-15']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
