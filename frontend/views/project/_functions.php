<?php

use yii\bootstrap4\Html;
use \common\models\queries\CategoryFunctionAnswerQuery;
use \backend\models\PdfDownloadSelectedAdditionalContent;
/* @var $dataKey string */
/* @var $dataKey int */
/* @var $list array */
/* @var $category \common\models\Category */
/* @var $existingCategoryFunctionAnswers array */
/* @var $firstAnswerPerFunction \common\models\CategoryFunctionAnswer[] */
/* @var $model \common\models\BaseData */

$count = 1;
?>
<div id="category_<?= $category->id ?>">
    <?php foreach ($category->getRestrictedComponents($model->baseData)->all() AS $questionKey => $component): ?>

        <?php if (0 < $questionKey): ?>
            <hr class="function-hr">
        <?php endif; ?>
        <?php
        $errorCategoryNameHtml = '<span class="already-answered-category-name">%s</span>';
        $alreadyAnswered       = false;
        $checkboxDisableTestCriteria       = true;
        $checkboxDisableExplain        = true;
        if (isset($existingAnswers[$category->id][$component->id])){
            $checkboxDisableExplain = false;
            if ($existingAnswers[$category->id][$component->id] == 3 || $existingAnswers[$category->id][$component->id] == 4)
            {
                $checkboxDisableTestCriteria = false;
            }

        }
        if (array_key_exists($component->id, $firstAnswerPerFunction) && $firstAnswerPerFunction[$component->id]->category_id != $category->id)
        {
            $alreadyAnswered = true;
        }
        ?>

        <div class="function <?= ($alreadyAnswered || isset($existingAnswers[$category->id][$component->id])) ? 'alert alert-success' : 'alert' ?>">
            <h4 class="function-title">
                <?= $count++ ?>. <?= Html::encode($component->name) ?>
                <?php if (0 < $component->getFunctionImages()->count()): ?>
                    <?= Html::a('<div class="btn-presentation"></div>', '#', [
                        'class'            => 'btn-presentation',
                        'data-toggle'      => 'modal',
                        'data-target'      => '#presentation-modal',
                        'data-function-id' => $component->id,
                    ]); ?>
                <?php endif; ?>
            </h4>

            <p><?= $component->description_short ?></p>

            <div style="display: none" class="alert alert-danger no-value-error">
                <?= Yii::t('app', 'Bitte geben Sie für diese Funktion einen Wert an.'); ?>
            </div>

            <div style="<?= $alreadyAnswered ? '' : 'display: none' ?>" class="alert alert-danger already-answered-error">
                <?= Yii::t('app', 'Diese Funktion wurde bereits unter "{categoryName}" bewertet.', [
                    'categoryName' => sprintf($errorCategoryNameHtml, $alreadyAnswered ? $firstAnswerPerFunction[$component->id]->category->name : ''),
                ]); ?>
            </div>

            <?= Html::radioList($component->id . '-' . $category->id, @$existingAnswers[$category->id][$component->id], $list, [
                'itemOptions' => [
                    'data-functionid'                  => $component->id,
                    'data-categoryid'                  => $category->id,
                    'data-categoryname'                => $category->name,
                    $alreadyAnswered ? 'disabled' : '' => '',
                ],
                'class'       => 'radio-list-max mt-4',
                'function'    => 1,
            ]); ?>

            <div>
                <?= Html::checkbox('test-criteria', CategoryFunctionAnswerQuery::isTestCriteriaChecked($model->id, $component->id), [
                    'data-functionid' => $component->id,
                    'data-categoryid' => $category->id,
                    'label'           => PdfDownloadSelectedAdditionalContent::getTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_TEST_CRITERIA],
                    'class'           => 'checkbox',
                    'disabled'        => $checkboxDisableTestCriteria,
                ]); ?>
            </div>
            <div>
                <?= Html::checkbox('requires-explanation', CategoryFunctionAnswerQuery::isExplainChecked($model->id, $component->id), [
                    'data-functionid' => $component->id,
                    'data-categoryid' => $category->id,
                    'label'           => PdfDownloadSelectedAdditionalContent::getTypeList()[PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN],
                    'class'           => 'checkbox',
                    'disabled'        => $checkboxDisableExplain,
                ]); ?>
            </div>
        </div>

    <?php endforeach; ?>
    <br/>
    <br/>
    <br/>
    <div>
        <?= Html::a('Speichern & Weiter', '#', [
            'class'           => 'btn btn-success save-category',
            'data-categoryid' => $category->id,
            'data-panelid'    => $key,
        ]); ?>
    </div>
</div>
