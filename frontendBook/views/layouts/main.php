<?php

/* @var $this \yii\web\View */

/* @var $content string */

use frontendBook\assets\AppAsset;
use kartik\icons\Icon;
use yii\bootstrap\Html;

//Icon::map($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html <?= yii::$app->language == 'ar' ? 'dir="rtl" ' . "lang=" . yii::$app->language : "lang=" . yii::$app->language ?>>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('headerTop') ?>
    <?= $this->render('headerMain') ?>
    <?= $this->render('headerNavigation') ?>
    <?= $content ?>
    <?= $this->render('footer') ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
