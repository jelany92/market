<?php

use common\models\MainCategory;
use kartik\form\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use kartik\icons\Icon;

//var_dump($menuItems[0]['items']);die();
?>
<!-- HEADER -->
<header>
    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="#" class="logo">
                            <img src="./img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->

                <div class="col-md-6">
                    <div class="header-search">
                        <?php $form = ActiveForm::begin([
                                                            'id'     => 'navSearchForm',
                                                            'method' => 'GET',
                                                            'action' => Url::toRoute('/search/global-search'),
                                                        ]);
                        ?>
                        <form>
                            <?= Html::dropDownList('', null, MainCategory::getMainCategoryList(), [
                                'class'  => 'input-select',
                                'prompt' => Yii::t('app', 'All Categories'),
                            ]) ?>
                            <?= Html::textInput('search', '', [
                                'class'       => 'input',
                                'placeholder' => Yii::t('app', 'Search here'),
                            ]) ?>
                            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'search-btn']) ?>
                        </form>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            <a href="#">
                                <?= Icon::show('heart') ?>
                                <br>
                                <span>
                                    <?= Yii::t('app', 'Your Book') ?>
                                </span>
                                <div class="qty">0</div>
                            </a>
                        </div>
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <?= Icon::show('shopping-cart') ?>
                                <br>
                                <span><?= Yii::t('app', 'Your Cart') ?></span>
                                <div class="qty">0</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="./img/product01.png" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                            <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>

                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="./img/product02.png" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                            <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>
                                </div>
                                <div class="cart-summary">
                                    <small>3 Item(s) selected</small>
                                    <h5>SUBTOTAL: $2940.00</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="#">View Cart</a>
                                    <a href="#">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->
