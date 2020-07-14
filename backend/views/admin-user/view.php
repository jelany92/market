<?php

use common\models\AdminUser;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */
/* @var $role string roleName */
/* @var $loginProvider \yii\data\ActiveDataProvider */
/* @var $roleProvider \yii\data\ActiveDataProvider */

$this->title                   = $model->username;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Benutzer'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a(Yii::t('app', 'Bearbeiten'), [
            'update',
            'id' => $model->id,
        ], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->isActive()): ?>
            <?= Html::a(Yii::t('app', 'Passwort anfordern'), [
                'forgot-password',
                'id' => $model->id,
            ], ['class' => 'btn btn-info']) ?>
            <?= Html::a(Yii::t('app', 'Deaktivieren'), [
                'deactivate',
                'id' => $model->id,
            ], ['class' => 'btn btn-warning']) ?>
        <?php else: ?>
            <?= Html::a(Yii::t('app', 'sofort Aktivieren'), [
                'activate',
                'id' => $model->id,
            ], ['class' => 'btn btn-success pull-right']) ?>
        <?php endif; ?>
        <?php if (!AdminUser::isSuperAdmin($model->id)): ?>

            <?= Html::a(Yii::t('app', 'Löschen'), [
                'delete',
                'id' => $model->id,
            ], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => Yii::t('app', 'Wollen Sie diesen Eintrag wirklich löschen?'),
                    'method'  => 'post',
                ],
            ]) ?>

        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'username',
            'first_name',
            'last_name',
            'email:email',
            'active_from:datetime',
            'active_until:datetime',
            [
                'label'     => 'Rolle',
                'attribute' => 'role',
                'value'     => $role,
            ],
        ],
    ]) ?>

    <div class="row">
        <div class="col-sm-6">
            <h3><?= Yii::t('app', 'Die letzten {0} Login-Zeiten', Yii::$app->params['smallPageSize']) ?></h3>
            <?= GridView::widget([
                'dataProvider' => $loginProvider,
                'layout'       => "{items}",
                'columns'      => [
                    'login_at',
                ],
            ]) ?>
        </div>

        <div class="col-sm-6">
            <h3><?= Yii::t('app', 'Die letzten {0} Rollen', Yii::$app->params['smallPageSize']) ?></h3>
            <?= GridView::widget([
                'dataProvider' => $roleProvider,
                'layout'       => "{items}",
                'columns'      => [
                    'role',
                    'modified_at',
                ],
            ]) ?>
        </div>
    </div>

</div>
