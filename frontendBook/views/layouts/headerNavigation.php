<?php

use yii\bootstrap4\Nav;

$label = [
    [
        'label'       => Yii::t('app', 'Home'),
        'url'         => ['/site/index'],
        'linkOptions' => [
            'class' => 'nav-link',
        ],
    ],
    [
        'label'       => Yii::t('app', 'My Books'),
        'url'         => ['/site/index'],
        'linkOptions' => [
            'class' => 'nav-link',
        ],
    ],
    [
        'label'       => Yii::t('app', 'Categories'),
        'url'         => ['/book-info/main-category'],
        'linkOptions' => [
            'class' => 'nav-link',

        ],
    ],
    [
        'label'       => Yii::t('app', 'Subcategories'),
        'url'         => ['/book-info/subcategories'],
        'linkOptions' => [
            'class' => 'nav-link',
        ],
    ],
    [
        'label'       => Yii::t('app', 'Author'),
        'url'         => ['/book-info/author'],
        'linkOptions' => [
            'class' => 'nav-link',
        ],
    ],
];
?>

<!-- /NAVIGATION -->
<nav id="navigation" class="navbar-expand-lg ml-auto">
    <!-- container -->
    <div class="container" style="text-align: start">
            <?php
            echo Nav::widget([
                                 'options' => [
                                     'id'    => 'responsive-nav',
                                     'class' => 'navbar-nav main-nav ml-auto',
                                 ],
                                 'items'   => $label,
                             ]); ?>
            <!-- /container -->
    </div>
</nav>
<!-- /NAVIGATION -->