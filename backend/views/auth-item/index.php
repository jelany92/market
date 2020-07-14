<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \common\models\auth\AuthItem */

/* @var $searchModel \common\models\auth\search\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderRole yii\data\ActiveDataProvider */
/* @var $dataProviderPermission yii\data\ActiveDataProvider */
/* @var $dataProviderTask yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Rechte & Rollen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('auth-item.create')): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Eintrag erstellen'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>
    <?php
    $icons = ['class'          => 'common\components\ActionColumn',
              'visibleButtons' => ['update' => \Yii::$app->user->can('auth-item.update'),
                                   'view'   => \Yii::$app->user->can('auth-item.view'),
                                   'delete' => function ($model, $key, $index) {
                                       /** @var $model common\models\AuthItem */
                                       return \Yii::$app->user->can('auth-item.delete') && !$model->hasChildren() && !$model->isSuperPermission();
                                   }]];
    ?>

    <div class="col-sm-12">
        <h2><?= Yii::t('app', 'Rollen') ?></h2>
        <?= GridView::widget(['dataProvider' => $dataProviderRole,
                              'columns'      => ['name',
                                  'description:ntext',
                                  $icons,],]); ?>
    </div>

    <div class="col-sm-12">
        <h2><?= Yii::t('app', 'Aufgaben') ?></h2>
        <?= GridView::widget(['dataProvider' => $dataProviderTask,
                              'columns'      => ['name',
                                  'description:ntext',
                                  $icons,],]); ?>
    </div>

    <div class="col-sm-12">
        <h2><?= Yii::t('app', 'Rechte') ?></h2>
        <?= GridView::widget(['dataProvider' => $dataProviderPermission,
                              'columns'      => ['name',
                                  'description:ntext',
                                  $icons,],]); ?>
    </div>

</div>
