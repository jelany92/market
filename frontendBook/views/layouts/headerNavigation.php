<?php

use yii\bootstrap4\Nav;

$label = [
    [
        'label' => Yii::t('app', 'Home'),
        'url'   => ['/site/index'],
    ],
    [
        'label' => Yii::t('app', 'My Books'),
        'url'   => ['/site/index'],
    ],
    [
        'label' => Yii::t('app', 'Categories'),
        'url'   => ['/book-info/main-category'],
    ],
    [
        'label' => Yii::t('app', 'Subcategories'),
        'url'   => ['/book-info/subcategories'],
    ],
    [
        'label' => Yii::t('app', 'Author'),
        'url'   => ['/book-info/author'],
    ],
];
?>

<!-- /NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">

        <?php
        echo Nav::widget([
                             'options' => [
                                 'class' => 'main-nav',
                                 'id'    => 'responsive-nav',
                             ],
                             'items'   => $label,
                         ]); ?>
        <!-- /container -->
</nav>
<!-- /NAVIGATION -->