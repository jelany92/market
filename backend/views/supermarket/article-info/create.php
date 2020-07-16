<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleInfo */
/* @var $fileUrls string */

$this->title                   = Yii::t('app', 'Create Article Info');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article Infos'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'    => $model,
        'fileUrls' => $fileUrls,

    ]) ?>

</div>
