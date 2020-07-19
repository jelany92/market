<?php

use common\models\ArticleInfo;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */

/* @var $modelArticleIGain \backend\models\ArticleIGain */

$this->title                   = Yii::t('app', 'احسب مربح القطعة');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($modelArticleIGain, 'articleName', [])->widget(Select2::class, [
        'model'         => $modelArticleIGain,
        'attribute'     => 'articleName',
        'options'       => [
            'placeholder' => 'Bitte auswählen ...',
        ],
        'pluginOptions' => [
            'tags'               => true,
            'allowClear'         => true,
            'maximumInputLength' => false,
        ],
        'size'          => Select2::LARGE,
        'data'          => ArticleInfo::getArticleNameList(),
    ]) ?>

    <?= $form->field($modelArticleIGain, 'articlePrice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelArticleIGain, 'articleCount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelArticleIGain, 'articleGain')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if ($show == true) : ?>
        <div class="row">
            <div class="col-sm-12">
                <h3>
                    <?= Yii::t('app', 'مبلغ مشتريات ') . $modelArticleIGain->articleName ?>
                </h3>
                <h3>
                    <?= Yii::t('app', 'عدد ') . $modelArticleIGain->articleCount ?>
                </h3>
                <h3>
                    <?= Yii::t('app', 'مكسب ')?>
                    <?= $modelArticleIGain->articleCount * $modelArticleIGain->articleGain ?>
                </h3>
            </div>
        </div>
    <?php endif; ?>
</div>


