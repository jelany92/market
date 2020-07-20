<?php

use backend\models\Purchases;
use common\widgets\Table;

/* @var $this yii\web\View */
/* @var $month integer */
/* @var $year integer */
/* @var $breadCount array */

$this->title                   = Yii::t('app', 'Bread Gain');
$this->params['breadcrumbs'][] = $this->title;

$this->title = Yii::$app->params['months'][$month];
$countBread  = intval($breadCount['result'] / Purchases::BRED_PRICE);
$breadGain   = $countBread * Purchases::BRED_GAIN;
?>

<?= $this->render('/site/supermarket/_sub_navigation', [
    'year'  => $year,
    'month' => $month,
]) ?>
<div class="row">
    <?= Table::widget([
                          'tableArray' => [
                              [
                                  [
                                      'type' => 'td',
                                      'html' => '<strong>' . Yii::t('app', 'مبلغ مشتريات الخبز الشهري') . '</strong>',
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => $breadCount['result'],
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => '<strong>' . Yii::t('app', 'عدد ربطات الخبز الشهرية') . '</strong>',
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => $countBread,
                                  ],
                              ],
                              [
                                  [
                                      'type' => 'td',
                                      'html' => '<strong>' . Yii::t('app', 'مكسب ربطات الخبز الشهرية') . '</strong>',
                                  ],
                                  [
                                      'type' => 'td',
                                      'html' => $breadGain,
                                  ],
                              ],
                          ],
                      ]); ?>

</div>


