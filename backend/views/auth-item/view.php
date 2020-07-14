<?php

use common\models\AdminUser;
use common\models\auth\AuthItem;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\auth\AuthItem */
/* @var $dataProviderUser \yii\data\ActiveDataProvider */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Rechte & Rollen'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <h2><?= AuthItem::getTypeList()[$model->type] . ': ' . Html::encode($this->title) ?></h2>

    <div class="row">
        <div class="col-sm-6 ">
            <p>
                <?php if (yii::$app->user->can("auth-item.update")): ?>
                    <?= Html::a(Yii::t('app', $model->getTypeName() . " bearbeiten"), [
                        'update',
                        'id' => $model->name,
                    ], ['class' => 'btn btn-primary pull-left margin-right-10']) ?>
                <?php endif; ?>
                <?php if (yii::$app->user->can("auth-item.delete") && !$model->isAdminRole() && !$model->isSuperPermission()): ?>
                    <?= Html::a(Yii::t('app', 'Löschen'), [
                        'delete',
                        'id' => $model->name,
                    ], [
                        'class' => 'btn btn-danger',
                        'data'  => [
                            'confirm' => Yii::t('app', 'Wollen Sie diesen Eintrag wirklich löschen?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <?= DetailView::widget([

                'model'      => $model,
                'attributes' => [
                    'description:ntext',
                    $model->getTypeColumn(),
                    'name',
                ],

            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <h2><?= Yii::t('app', 'Übergeordnete') ?></h2>
            <?= GridView::widget([

                'dataProvider' => $dataProviderParent,
                'layout'       => "{items}",
                'columns'      => [

                    'name',
                    $model->getTypeColumn(),
                    'description:ntext',
                    [
                        'class'          => 'common\components\ActionColumn',
                        'template'       => '{view} {update}',
                        'visibleButtons' => [
                            'update' => \Yii::$app->user->can('auth-item.update'),
                            'view'   => \Yii::$app->user->can('auth-item.view'),
                        ],
                    ],
                ],

            ]); ?>

            <?php if (0 < $dataProviderUser->count): ?>
                <h2><?= Yii::t('app', 'Benutzer mit dieser Rolle'); ?></h2>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderUser,
                    'layout'       => "{items}",
                    'columns'      => [
                        'username',
                        'first_name',
                        'last_name',
                        'active_until',
                        // action column
                        [
                            'class'          => 'common\components\ActionColumn',
                            'template'       => '{view} {update}',
                            'urlCreator'     => function ($action, AdminUser $adminUserModel, $key, $index) {
                                return Url::to([
                                    'admin-user/' . $action,
                                    'id' => $adminUserModel->id,
                                ]);
                            },
                            'visibleButtons' => [
                                'update' => \Yii::$app->user->can('admin-user.update'),
                                'view'   => \Yii::$app->user->can('admin-user.view'),
                            ],
                        ],
                    ],
                ]); ?>

            <?php endif; ?>
        </div>


        <div class="col-sm-6">
            <?php if ($model->type != AuthItem::TYPE_PERMISSION): ?>
                <h2><?= Yii::t('app', 'Zugeordnete Elemente') ?></h2>
                <?= GridView::widget([

                    'dataProvider' => $dataProviderChild,
                    'layout'       => "{items}",
                    'options' => [
                        'id'    => 'auth_item_grid',
                        'class' => 'grid-view',
                    ],
                    'columns'      => [
                        'name',
                        $model->getTypeColumn(),
                        'description:ntext',
                        [
                            'class'          => 'common\components\ActionColumn',
                            'template'       => ' {view} {update} {unassign}',
                            'buttons'        => [
                                'unassign' => function ($url) {
                                    return Html::a(Icon::show('minus-circle'), $url, [
                                            'title' => Yii::t('app', 'Element entfernen'),
                                            'data'  => [
                                                'confirm' => Yii::t('app', 'Wollen Sie diesen Eintrag wirklich löschen?'),
                                                'method'  => 'post',
                                            ],
                                    ]);
                                },
                            ],
                            'urlCreator'     => function ($action, $child, $key, $index) use ($model) {
                                if ($action == 'unassign')
                                {
                                    return Url::to([
                                        $action,
                                        'child'  => $key,
                                        'parent' => $model->name,
                                    ]);
                                }
                                return Url::to([
                                    $action,
                                    'id' => $key,
                                ]);
                            },
                            'visibleButtons' => [
                                'update'   => \Yii::$app->user->can('auth-item.update'),
                                'view'     => \Yii::$app->user->can('auth-item.view'),
                                'unassign' => function ($model, $key, $index) {
                                    /** @var $model common\models\AuthItem */
                                    return \Yii::$app->user->can('auth-item.unassign') && !$model->isSuperPermission();
                                },
                            ],
                        ],
                    ],

                ]); ?>

            <?php endif; ?>

            <?php if (yii::$app->user->can('auth-item.assign') && (0 < count(AuthItem::getAssignableList($model)))): ?>
                <?= $this->render('_assign_form', ['model' => $model,]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
