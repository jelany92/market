<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;
use kartik\select2\Select2;
use common\models\ArticleInfo;

/* @var $this yii\web\View */
/* @var $model backend\models\ReturnedGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="returned-goods-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($model, 'name', [])->widget(Select2::class, [
        'model'         => $model,
        'attribute'     => 'name',
        'options'       => [
            'placeholder' => 'Bitte auswählen ...',
        ],
        'pluginOptions' => [
            'tags'               => true,
            'maximumInputLength' => false,
        ],
        'size'          => Select2::LARGE,
        'data'          => ArticleInfo::getArticleNameList(),
    ]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'selected_date')->widget(DatePicker::class, [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose'    => true,
            'showMeridian' => false,
            'endDate'      => '+0d',
            'format'       => 'yyyy-mm-dd'
            //'format'       => 'dd.mm.yyyy'
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
