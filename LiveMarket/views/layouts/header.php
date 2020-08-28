<?php

use backend\components\LanguageDropdown;
use common\models\MainCategory;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

Icon::map($this);
$navBarColor      = '#e73918';
$categoryNameList = ArrayHelper::map(MainCategory::find()->andWhere(['company_id' => 1])->all(), 'id', 'category_name');
$language         = [
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget([]),
    ],
];
?>
<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                        <li class="myaccount"><?= Html::a('<span>' . Yii::t('app', 'My Account') . '</span>', ['']) ?></li>
                        <li class="wishlist"><?= Html::a('<span>' . Yii::t('app', 'Wishlist') . '</span>', ['']) ?></li>
                        <li class="header_cart hidden-xs"><?= Html::a('<span>' . Yii::t('app', 'My Cart') . '</span>', ['']) ?></li>
                        <li class="check"><?= Html::a('<span>' . Yii::t('app', 'Checkout') . '</span>', ['']) ?></li>
                        <li class="login"><?= Html::a('<span>' . Yii::t('app', 'Login') . '</span>', ['']) ?></li>
                    </ul>
                </div>
                <!-- /.cnt-account -->

                <div class="cnt-block">
                    <ul class="list-unstyled list-inline">
                        <li class="dropdown dropdown-small"><a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span class="value">USD </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">INR</a></li>
                                <li><a href="#">GBP</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-small lang"><a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span class="value">English </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                            </ul>
                        </li>
                        <!-- End .header-dropdown -->
                    </ul>
                    <!-- /.list-unstyled -->
                </div>
                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div>
            <!-- /.header-top-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.header-top -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo"><a href="home.html"> <img src="/images/logo.png" alt="logo"> </a></div>
                    <!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= --> </div>
                <!-- /.logo-holder -->

                <div class="col-lg-7 col-md-6 col-sm-8 col-xs-12 top-search-holder">
                    <!-- /.contact-row -->
                    <!-- ============================================================= SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <form>
                            <div class="control-group">
                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="category.html">Categories <b class="caret"></b></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class="menu-header">Computer</li>
                                            <li role="presentation"><?= Html::a('- ' . Yii::t('app', 'Clothing'), [''], ['role' => "menuitem"]) ?></li>
                                            <li role="presentation"><?= Html::a('- ' . Yii::t('app', 'Electronics'), [''], ['role' => "menuitem"]) ?></li>
                                            <li role="presentation"><?= Html::a('- ' . Yii::t('app', 'Shoes'), [''], ['role' => "menuitem"]) ?></li>
                                            <li role="presentation"><?= Html::a('- ' . Yii::t('app', 'Watches'), [''], ['role' => "menuitem"]) ?></li>
                                        </ul>
                                    </li>
                                </ul>
                                <?= Html::input('', '', '', [
                                    'class'       => 'search-field',
                                    'placeholder' => 'Search here...',
                                ]) ?>
                                <?= Html::a(Icon::show('search'), [''], ['class' => 'search-button']) ?>
                            </div>
                        </form>
                    </div>
                    <!-- /.search-area -->
                    <!-- ============================================================= SEARCH AREA : END ============================================================= --> </div>
                <!-- /.top-search-holder -->

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 animate-dropdown top-cart-row">
                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

                    <div class="dropdown dropdown-cart"><a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="basket">
                                    <div class="basket-item-count"><span class="count">2</span></div>
                                    <div class="total-price-basket"><span class="lbl">Shopping Cart</span> <span class="value">$4580</span></div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="cart-item product-summary">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="image">
                                                <?= Html::a(Html::img('', ['alt' => '']), ['']) ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <h3 class="name"><?= Html::a(Yii::t('app', 'Simple Product'), ['']) ?></h3>
                                            <div class="price"><?= '500' ?></div>
                                        </div>
                                        <div class="col-xs-1 action">
                                            <?= Html::a(Icon::show('trash'), ['']) ?>
                                            </a></div>
                                    </div>
                                </div>
                                <!-- /.cart-item -->
                                <div class="clearfix"></div>
                                <hr>
                                <div class="clearfix cart-total">
                                    <div class="pull-right"><span class="text">Sub Total :</span><span class='price'>$600.00</span></div>
                                    <div class="clearfix"></div>
                                    <a href="checkout.html" class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a></div>
                                <!-- /.cart-total-->

                            </li>
                        </ul>
                        <!-- /.dropdown-menu-->
                    </div>
                    <!-- /.dropdown-cart -->

                    <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= --> </div>
                <!-- /.top-cart-row -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- ============================================== TOP MENU : END ============================================== -->

    <!-- /.main-header -->

    <!-- ============================================== NAVBAR ============================================== -->
</header>

<!-- ============================================== HEADER : END ============================================== -->