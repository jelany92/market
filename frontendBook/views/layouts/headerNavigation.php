<?php

use backend\components\LanguageDropdown;
use common\models\MainCategory;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<!-- /NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="<?= (Yii::$app->controller->route == 'site/index') ? 'active' : '' ?>"><?= Html::a(Yii::t('app', 'Home'), ['site/index']) ?></li>
                <li class="<?= (Yii::$app->controller->route == 'site/main-category') ? 'active' : '' ?>"><?= Html::a(Yii::t('app', 'My Books'), ['site/index']) ?></li>
                <li class="<?= (Yii::$app->controller->route == 'book-info/main-category') ? 'active' : '' ?>"><?= Html::a(Yii::t('app', 'Categories'), ['book-info/main-category']) ?></li>
                <li class="<?= (Yii::$app->controller->route == 'book-info/subcategories') ? 'active' : '' ?>"><?= Html::a(Yii::t('app', 'Subcategories'), ['book-info/subcategories']) ?></li>
                <li class="<?= (Yii::$app->controller->route == 'book-info/author') ? 'active' : '' ?>"><?= Html::a(Yii::t('app', 'Author'), ['book-info/author']) ?></li>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->
