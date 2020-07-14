<?php

use common\models\auth\AuthItem;
use yii\bootstrap4\Html;
use common\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AdminUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Benutzer');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Neuen Benutzer erstellen'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget(['dataProvider' => $dataProvider,
                          'filterModel'  => $searchModel,
                          'options'      => [
                              'id'    => 'admin_user_grid',
                              'class' => 'grid-view',
                          ],
                          'columns'      => [

                              [ // column for username as url
                                  'attribute' => 'username',
                                  'value'     => function ($model) {
                                      return Html::a(Html::encode($model->username), Yii::$app->urlManager->createUrl(['admin-user/view', 'id' => $model->id]));
                                  },
                                  'format'    => 'raw',],
                              'first_name',
                              'last_name',
                              ['filter'    => Html::activeDropDownList($searchModel, 'role', AuthItem::getRoleList(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'alle Rollen')]),
                               'label'     => Yii::t('app', 'Rolle'),
                               'attribute' => 'role',
                               'value'     => function ($model) {
                                   return Html::encode($model->getRole());
                               },
                               'format'    => 'raw',],
                              'active_from:datetime',
                              'active_until:datetime',

                              ['class'          => 'common\components\ActionColumn',
                               'visibleButtons' => ['update' => \Yii::$app->user->can('admin-user.update'),
                                                    'view'   => \Yii::$app->user->can('admin-user.view'),]],],]); ?>
</div>
