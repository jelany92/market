<?php

use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchModel\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Histories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create History'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel'  => $searchModel,
                             'options'      => [
                                 'style' => 'overflow: auto; word-wrap: break-word;',
                             ],
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 [
                                     'attribute' => 'company_id',
                                     'value'     => function ($model) {
                                         return $model->adminUser->username;
                                     },
                                 ],
                                 [
                                     'attribute' => 'current_admin_user_id',
                                     'value'     => function ($model) {
                                         return $model->adminUser->company_name;
                                     },
                                 ],
                                 'summary',
                                 'note:ntext',
                                 'type:raw',
                                 'edited_date_at',
                                 ['class' => 'common\components\ActionColumn'],
                             ],
                         ]); ?>


</div>
