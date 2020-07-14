<?php

use common\models\Answer;
use common\models\CategoryFunctionAnswer;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\View;

/* @var $modelBaseData \common\models\BaseData */
/* @var $dataKey string */
/* @var $boolean array */
/* @var $salutation array */
/* @var $countryList array */
/* @var $existingAnswers array */
/* @var $firstAnswerPerFunction array */
/* @var $categories \common\models\Category */
$list = Answer::getAnswerAsList();
$checkBoxList = CategoryFunctionAnswer::getCheckBoxList();

Yii::$app->session['renderedFunctions'] = [];
?>
<h1><?= Yii::t('app', 'Gewünschte Funktionen für Projekt auswählen') ?></h1>
<br>

<div class="site-index">
    <?php $form = ActiveForm::begin(['layout' => 'horizontal']) ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php $isExpanded = true; ?>
        <?php foreach ($categories AS $key => $category): ?>
            <?php
            $isComplete = false;
            if (count(@$category->components) == count(@$existingAnswers[$category->id]))
            {
                $isComplete = true;
            }
            ?>

            <div class="panel panel-default <?= $isComplete ? 'panel-success' : '' ?>">
                <div class="panel-heading" role="tab" id="heading<?= $key ?>">
                    <h4 class="panel-title">
                        <a <?= (!$isExpanded) ? 'class="collapsed"' : '' ?> role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key ?>" aria-expanded="<?= ($isExpanded) ? 'true' : 'false' ?>" aria-controls="collapse<?= $key ?>">
                            <?= Html::encode($category->name) ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse<?= $key ?>" class="panel-collapse collapse <?= ($isExpanded) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading<?= $key ?>">
                    <div class="panel-body">
                        <?= $k = $this->render('_functions', [
                            'existingAnswers'         => $existingAnswers,
                            'firstAnswerPerFunction'  => $firstAnswerPerFunction,
                            'dataKey'                 => $dataKey,
                            'key'                     => $key,
                            'category'                => $category,
                            'list'                    => $list,
                            'checkBoxList'            => $checkBoxList,
                            'modelBaseData'           => $modelBaseData,
                        ]); ?>
                    </div>
                </div>
            </div>
            <?php $isExpanded = false; ?>
        <?php endforeach; ?>
    </div>
    <?php ActiveForm::end() ?>
    <?php
    $this->registerJsVar('dataKey', $dataKey, View::POS_HEAD);
    $this->registerJsVar('ajaxUrl', Yii::$app->getUrlManager()->createUrl('site/save-answer'), View::POS_HEAD);
    $this->registerJsFile('js/detailsHandling.js', ['depends' => 'yii\web\JqueryAsset'])
    ?>
</div>