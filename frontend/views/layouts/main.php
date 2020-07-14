<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use kartik\icons\Icon;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

Icon::map($this);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => ['class' => 'sticky-top navbar-expand-lg navbar-dark bg-dark'],
    ]);
    if (Yii::$app->user->isGuest)
    {
        $menuItems = [];
    }
    else
    {
        $menuItems = [
            '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline']) . Html::submitButton('Logout (' . Html::encode(Yii::$app->user->identity->username) . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>'
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items'   => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="float-left">&copy; aicovo gmbh 2018 - <?= date('Y') ?></p>
        <p class="float-right">
            <?= Html::a(Yii::t('app','Impressum'),['/site/imprint'])?>
            &nbsp;
            <?= Html::a(Yii::t('app','Datenschutzerklärung'),['/site/tos'])?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
