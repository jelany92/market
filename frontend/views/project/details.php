<?php

use common\models\Answer;
use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\web\View;

/* @var $model \common\models\BaseDataForm */
/* @var $dataKey string */
/* @var $answerList array */
/* @var $firstAnswerPerFunction array */
/* @var $categoryList \common\models\Category[] */

$this->registerCssFile(Yii::$app->urlManager->createUrl('/css/questionnaire.css'));

$list = Answer::getNameList();

Yii::$app->session['renderedFunctions'] = [];
?>
<h1><?= Yii::t('app', 'Gewünschte Funktionen für Projekt auswählen') ?></h1>
<br>

<div class="site-index">
    <div class="col-sm-12" id="accordion">

        <?= $this->render('_base-data', [
            'model' => $model,
            'key'   => 'p1',
        ]); ?>
        <?php $form = ActiveForm::begin(['layout' => 'horizontal']) ?>

        <?php $isExpanded = true; ?>
        <?php foreach ($categoryList AS $key => $category): ?>
            <?php
            $isComplete = false;
            if (count(@$category->components) == count(@$existingAnswers[$category->id]))
            {
                $isComplete = true;
            }
            ?>
            <?php if (0 < $category->getRestrictedComponents($model->baseData)->count()): ?>
                <div class="card mb-2">
                    <h5 class="card-header <?= $isComplete ? 'alert-success' : '' ?>">
                        <a data-toggle="collapse" href="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>" id="heading<?= $key ?>" class="d-block">
                            <?= Html::encode($category->name) ?>
                        </a>
                    </h5>
                    <div id="collapse<?= $key ?>" class="collapse <?= ($isExpanded) ? 'in show' : '' ?>" aria-labelledby="heading<?= $key ?>" data-parent="#accordion">
                        <div class="card-body">
                            <?= $this->render('_functions', [
                                'existingAnswers'        => $answerList,
                                'firstAnswerPerFunction' => $firstAnswerPerFunction,
                                'dataKey'                => $dataKey,
                                'key'                    => $key,
                                'category'               => $category,
                                'list'                   => $list,
                                'model'                  => $model,
                            ]); ?>
                        </div>
                    </div>
                </div>
                <?php $isExpanded = false; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php ActiveForm::end() ?>

        <?= $this->render('_base-data', [
            'model' => $model,
            'key'   => 'p2',
        ]); ?>
    </div>
    <?php
    $this->registerJsVar('dataKey', $dataKey, View::POS_HEAD);
    $this->registerJsVar('ajaxUrl', Yii::$app->getUrlManager()->createUrl('/project/save-answer'), View::POS_HEAD);
    $this->registerJsVar('ajaxCheckboxTypeUrl', Yii::$app->getUrlManager()->createUrl('/project/save-checkbox-type'), View::POS_HEAD);
    $this->registerJsFile('js/detailsHandling.js', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerJsVar('ajaxLoadPresentationUrl', Yii::$app->getUrlManager()->createUrl('/project/load-image-carousel'), View::POS_HEAD);
    $this->registerJsFile('js/presentationHandling.js', ['depends' => ['yii\web\JqueryAsset', 'yii\bootstrap4\BootstrapAsset']]);
    ?>
</div>

<?php Modal::begin([
    'options' => ['id' => 'presentation-modal'],
    'size' => 'modal-fullscreen',
]);?>
    <div class="modal-contained-div" id="modal-spinner-div">
        <div class="modal-spinner-container">
            <div class="alert alert-danger" role="alert" style="display:none;">
                <?= Yii::t('app', 'Es ist ein Fehler beim Laden der Bilder aufgetreten.')?>
            </div>
            <?= Icon::show('spinner', ['class' => 'fa-pulse fa-7x modal-loading-spinner']) ?>
        </div>
    </div>
<?php Modal::end(); ?>

