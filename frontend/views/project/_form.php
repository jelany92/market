<?php

use common\models\Condition;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BaseDataForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $booleanList array */
/* @var $salutationList array */
/* @var $countryList array */
/* @var $companyTypeList array */
?>

<div class="base-data-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
        'options' => ['novalidate' => 'novalidate']
    ]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'companyName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'companyTypeId')->dropDownList($companyTypeList) ?>

    <div class="row">
        <?= Html::activeLabel($model, 'street', [
            'label' => $model->attributeLabels()['street'] . ', ' .
            $model->attributeLabels()['houseNumber'],
            'class' => 'col-md-3 col-form-label',
        ]); ?>
        <div class="col-md-5">
            <?= $form->field($model, 'street', ['showLabels' => false])->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['street']]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'houseNumber', ['showLabels' => false])->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['houseNumber']]) ?>
        </div>
    </div>

    <div class="row">
        <?= Html::activeLabel($model, 'countryId', [
            'label' => $model->attributeLabels()['countryId'] . ', ' .
            $model->attributeLabels()['zipCode'] . ', ' .
            $model->attributeLabels()['city'],
            'class' => 'col-md-3 col-form-label',
        ]); ?>
        <div class="col-md-2">
            <?= $form->field($model, 'countryId', ['showLabels' => false])->dropDownList($countryList, ['prompt' => Yii::t('app', 'Bitte wählen')]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'zipCode', ['showLabels' => false])->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['zipCode']]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'city', ['showLabels' => false])->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['city']]) ?>
        </div>
    </div>

    <div class="row">
        <?= Html::activeLabel($model, 'salutation', [
            'label' => $model->attributeLabels()['salutation'] . ', ' .
            $model->attributeLabels()['firstName'] . ', ' .
            $model->attributeLabels()['lastName'],
            'class' => 'col-md-3 col-form-label',
        ]); ?>
        <div class="col-md-2">
            <?= $form->field($model, 'salutation', ['showLabels' => false])->dropDownList($salutationList) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'firstName', ['showLabels' => false])->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['firstName']]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'lastName', ['showLabels' => false])->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['lastName']]) ?>
        </div>
    </div>


    <?= $form->field($model, 'baseDate')->widget(DatePicker::class, [
        'pluginOptions' => [
            'language' => 'de',
            'autoclose' => true,
            'startDate' => new \yii\web\JsExpression('new Date()'),
            'endDate' => '+1y',
            'showMeridian' => true,
            'daysOfWeekDisabled' => '0,6',
        ],
    ]); ?>


    <?= $form->field($model, 'employeeCount')->input('number', ['min' => 0]) ?>

    <?= $form->field($model, 'locationCount')->input('number', ['min' => 0]) ?>

    <?= $form->field($model, 'locationNames')->textInput(['maxlength' => true])->label(Yii::t('app', 'Bezeichnung der Standorte')) ?>

    <?= $form->field($model, 'companyCountSelection')->radioList($booleanList, ['id' => 'radioDiv', 'inline' => true]) ?>

    <?= $form->field($model, 'companyCount')->input('number',
        [
            'id' => 'companyCount',
            'style' => 'display: none;',
            'disabled' => 'true',
            'min' => 2,
            'placeholder' => $model->getAttributeLabel('companyCount'),
        ])->label('') ?>

    <?= $form->field($model, 'conditionList', [])->checkboxList(Condition::getNameList()) ?>

    <br>
    <h4><?= Yii::t('app', 'Anzahl der Bewerbungen pro Jahr') ?></h4>
    <br>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'applicationTraineeCount', ['label' => Yii::t('app', 'Azubis'), 'class' => 'col-md-5 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'applicationTraineeCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'applicationDualStudentsCount', ['label' => Yii::t('app', 'Duale Studenten'), 'class' => 'col-md-6 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'applicationDualStudentsCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'applicationAssistantsCount', ['label' => Yii::t('app', 'Hilfskräfte'), 'class' => 'col-md-5 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'applicationAssistantsCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'applicationExecutivesCount', ['label' => Yii::t('app', 'Fach- und Führungskräfte'), 'class' => 'col-md-6 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'applicationExecutivesCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
    </div>

    <br>
    <h4><?= Yii::t('app', 'Anzahl der Stellenausschreibungen pro Jahr') ?></h4>
    <br>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'vacancyTraineeCount', ['label' => Yii::t('app', 'Azubis'), 'class' => 'col-md-5 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'vacancyTraineeCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'vacancyDualStudentsCount', ['label' => Yii::t('app', 'Duale Studenten'), 'class' => 'col-md-6 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'vacancyDualStudentsCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'vacancyAssistantsCount', ['label' => Yii::t('app', 'Hilfskräfte'), 'class' => 'col-md-5 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'vacancyAssistantsCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'vacancyExecutivesCount', ['label' => Yii::t('app', 'Fach- und Führungskräfte'), 'class' => 'col-md-6 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'vacancyExecutivesCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
    </div>

    <br>

    <h4><?= Yii::t('app', 'Nutzer-Accounts') ?></h4>
    <br>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'adminCount', ['label' => Yii::t('app', 'Fachadministratoren'), 'class' => 'col-md-5 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'adminCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'personResponsibleCount', ['label' => Yii::t('app', 'Personalsachbearbeiter'), 'class' => 'col-md-6 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'personResponsibleCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'evaluatorCount', ['label' => Yii::t('app', 'Gremien'), 'class' => 'col-md-5 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'evaluatorCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <?= Html::activeLabel($model, 'executivesCount', ['label' => Yii::t('app', 'Fach- und Führungskräfte'), 'class' => 'col-md-6 control-label']); ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'executivesCount', ['showLabels' => false])->input('number', ['min' => 0]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton(Yii::t('app', 'Speichern'), ['class' => 'btn btn-success pull-right']) ?>
            <?= Html::a(Yii::t('app', 'Abbrechen'), ['index'], ['class' => 'btn btn-light pull-right margin-right-10']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
/**
 * make field companyCount hidden or visible
 */
$this->registerJs('
$(document).ready(function(){
    var fieldToHide = $("#companyCount");
    var radioDisable = $("#radioDiv input[type=\'radio\'][value=\'1\']");
    if(radioDisable.prop(\'checked\'))
    {
        fieldToHide.prop(\'disabled\', false);
        fieldToHide.show();
    }

    $("#radioDiv input[type=\'radio\']").click(function(){
        if(this.value == 1)
        {
        	fieldToHide.prop(\'disabled\', false);
        	fieldToHide.show();
        }
        else
        {
        	fieldToHide.prop(\'disabled\', true);
        	fieldToHide.hide();
        }
    });
});', \yii\web\View::POS_READY);
?>



