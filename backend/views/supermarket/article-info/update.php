<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $articleList array */
/* @var $fileUrls string */

$this->title                   = Yii::t('app', 'Update Article Info: {name}', [
    'name' => $model->article_name_ar,
]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article Infos'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="article-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'fileUrls'    => $fileUrls,

    ]) ?>

</div>
