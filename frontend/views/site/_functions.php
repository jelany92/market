<?php

use yii\bootstrap\Html;

/* @var $dataKey string */
/* @var $dataKey int */
/* @var $list array */
/* @var $checkBoxList array */
/* @var $category \common\models\Category */
/* @var $existingCategoryFunctionAnswers array */
/* @var $firstAnswerPerFunction \common\models\CategoryFunctionAnswer[] */
/* @var $modelBaseData \common\models\BaseData */

$count = 1;
?>
<div id="tender_document_category_<?= $category->id ?>">
    <?php foreach ($category->getRestrictedComponents($modelBaseData)->all() AS $questionKey => $component): ?>
        <?php if (0 < $questionKey): ?>
            <br>
            <hr class="tender-hr">
        <?php endif; ?>
        <?php
        $errorCategoryNameHtml = '<span class="already-answered-category-name">%s</span>';
        $alreadyAnswered       = false;
        if (array_key_exists($component->id, $firstAnswerPerFunction) && $firstAnswerPerFunction[$component->id]->category_id != $category->id)
        {
            $alreadyAnswered = true;
        }
        ?>

        <div class="tender_document_function">
            <h4><?= $count++ ?>. <?= Html::encode($component->name) ?></h4>
            <p><?= $component->description_short ?></p>

            <div style="display: none" class="alert alert-danger no-value-error">
                <?= Yii::t('app', 'Bitte geben Sie für diese Funktion einen Wert an.'); ?>
            </div>

            <div class="alert alert-danger already-answered-error" style="<?= $alreadyAnswered ? '' : 'display: none' ?>">
                <?= Yii::t('app', 'Diese Funktion wurde bereits unter "{categoryName}" bewertet.', [
                    'categoryName' => sprintf($errorCategoryNameHtml, $alreadyAnswered ? $firstAnswerPerFunction[$component->id]->category->name : ''),
                ]); ?>
            </div>

            <p><?= Html::radioList($component->id . '-' . $category->id, @$existingAnswers[$category->id][$component->id], $list, [
                    'itemOptions' => [
                        'data-functionid'                  => $component->id,
                        'data-categoryid'                  => $category->id,
                        'data-categoryname'                => $category->name,
                        $alreadyAnswered ? 'disabled' : '' => '',
                    ],
                    'class'       => 'radio-list-max',
                    'function'    => 1,
                ]); ?>
                <br/>
            </p>
            <p>
                <?= Html::checkboxList('', [], $checkBoxList, [
                    'class'       => 'radio-list-max',
                ]) ?>
            </p>
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
