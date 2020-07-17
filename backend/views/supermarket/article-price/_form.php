<?php

use common\models\ArticleInfo;
use common\models\ArticlePrice;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-price-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]); ?>
    <?= $form->field($model, 'article_info_id', [])->widget(Select2::class, [
        'model'         => $model,
        'attribute'     => 'name',
        'options'       => [
            'placeholder' => 'Bitte auswählen ...',
        ],
        'pluginOptions' => [
            'allowClear'         => true,
            'maximumInputLength' => false,
        ],
        'size'          => Select2::LARGE,
        'data'          => ArticleInfo::getArticleNameList(),
    ]) ?>
    <?= $form->field($model, 'article_total_prise')->textInput() ?>

    <?= $form->field($model, 'article_count')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(ArticlePrice::STATUS) ?>

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
