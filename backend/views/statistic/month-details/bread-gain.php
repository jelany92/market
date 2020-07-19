<?php

use backend\models\Purchases;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $breadCount array */

$this->title                   = Yii::t('app', 'te');
$this->params['breadcrumbs'][] = $this->title;

$this->title                   = Yii::$app->params['months'][$month];
$countBread = intval($breadCount['result'] / Purchases::BRED_PRICE);
$breadGain  = $countBread * Purchases::BRED_GAIN;
?>

<?= $this->render('/site/supermarket/_sub_navigation', [
    'year'  => $year,
    'month' => $month,
]) ?>
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1>
                <?= Yii::t('app', 'مبلغ مشتريات الخبز الشهري') ?>
                <?= $breadCount['result'] ?>
            </h1>
            <h1>
                <?= Yii::t('app', 'عدد ربطات الخبز الشهرية') ?>
                <?= $countBread ?>
            </h1>
            <h1>
                <?= Yii::t('app', 'مكسب ربطات الخبز الشهرية') ?>
                <?= $breadGain ?>
            </h1>
        </div>
    </div>
</div>


