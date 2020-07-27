<?php

use backend\components\LanguageDropdown;
use yii\bootstrap4\Html;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use common\models\ArticleInfo;
use common\models\MainCategory;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\helpers\Url;

Icon::map($this);
\yidas\yii\fontawesome\FontawesomeAsset::register($this);

$navBarColor      = '#e73918';
$categoryNameList = ArrayHelper::map(MainCategory::find()->andWhere(['company_id' => 1])->all(), 'id', 'category_name');
?>

<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <a href="#">Usd</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">Eur</a></li>
                            <li><a href="#">Usd</a></li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->

                <div class="header-dropdown">
                    <?php
                    $language = [
                        [
                            'label' => LanguageDropdown::label(Yii::$app->language),
                            'items' => LanguageDropdown::widget([]),
                        ],
                    ];
                    echo Nav::widget([
                                         'options' => ['class' => 'navbar-auto ml-auto'],
                                         'items'   => $language,
                                     ]);
                    ?>
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <?= Icon::show('phone-alt', ['style' => 'margin-right: 5px;']) ?>
                            <li><?= Html::a('Call: +0123 456 789', '#') ?></li>
                            <li><?= Html::a(Yii::t('app', 'About Us'), '#') ?></li>
                            <li><?= Html::a(Yii::t('app', 'Contact Us'), '#') ?></li>
                            <?php
                            if (Yii::$app->user->isGuest)
                            {
                                $login[] = [
                                    'label' => Yii::t('app', 'Login'),
                                    'url'   => ['/site/login'],
                                ];
                            }
                            else
                            {
                                $login[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
                            }
                            echo Icon::show('user', ['style' => 'margin-left: 10px;']) . Nav::widget([
                                                                                                         'options' => ['class' => 'navbar-auto ml-auto'],
                                                                                                         'items'   => $login,
                                                                                                     ]);
                            ?>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <li><?= Html::a(Html::img('test', [
                        'options' => [
                            'width'  => '105',
                            'height' => '25',
                        ],
                    ])) ?></li>
            </div>
            <div class="header-right">
                <div class="header-search">
                    <?= Html::submitButton(Icon::show('search'), [
                        'class' => 'search-toggle',
                        'role'  => 'button',
                        'title' => 'Search',
                    ]); ?>
                    <?php ActiveForm::begin([
                                                'id'     => 'navSearchForm',
                                                'method' => 'GET',
                                                'action' => Url::toRoute('/search/global-search'),
                                            ]); ?>
                    <div class="header-search-wrapper">
                        <?= Html::textInput('search', (Yii::$app->controller->id == 'search' && Yii::$app->controller->action->id == 'global-search') ? Yii::$app->request->get('search') : null, [
                            'id'           => 'navSearchString',
                            'autocomplete' => 'off',
                            'type'         => 'search',
                            'class'        => 'form-control',
                            'placeholder'  => Yii::t('app', 'Search to') . '...',
                        ]); ?>
                    </div><!-- End .header-search-wrapper -->
                    <?php ActiveForm::end(); ?>
                </div><!-- End .header-search -->
                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
                        <?= Icon::show('random') ?>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="compare-products">
                            <li class="compare-product">
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                <h4 class="compare-product-title"><a href="product.html">Blue Night Dress</a></h4>
                            </li>
                            <li class="compare-product">
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                <h4 class="compare-product-title"><a href="product.html">White Long Skirt</a></h4>
                            </li>
                        </ul>

                        <div class="compare-actions">
                            <a href="#" class="action-link">Clear All</a>
                            <a href="#" class="btn btn-outline-primary-2"><span>Compare</span><i class="icon-long-arrow-right"></i></a>
                        </div>
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .compare-dropdown -->

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <?= Icon::show('shopping-cart') ?>
                        <span class="cart-count">2</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products">
                            <div class="product">
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="product.html">Beige knitted elastic runner shoes</a>
                                    </h4>

                                    <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x $84.00
                                            </span>
                                </div><!-- End .product-cart-details -->

                                <figure class="product-image-container">
                                    <a href="product.html" class="product-image">
                                        <img src="assets/images/products/cart/product-1.jpg" alt="product">
                                    </a>
                                </figure>
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                            </div><!-- End .product -->

                            <div class="product">
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="product.html">Blue utility pinafore denim dress</a>
                                    </h4>

                                    <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x $76.00
                                            </span>
                                </div><!-- End .product-cart-details -->

                                <figure class="product-image-container">
                                    <a href="product.html" class="product-image">
                                        <img src="assets/images/products/cart/product-2.jpg" alt="product">
                                    </a>
                                </figure>
                                <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                            </div><!-- End .product -->
                        </div><!-- End .cart-product -->

                        <div class="dropdown-cart-total">
                            <span>Total</span>

                            <span class="cart-total-price">$160.00</span>
                        </div><!-- End .dropdown-cart-total -->

                        <div class="dropdown-cart-action">
                            <a href="cart.html" class="btn btn-primary">View Cart</a>
                            <a href="checkout.html" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
                        </div><!-- End .dropdown-cart-total -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
    <div class="sticky-header">
        <div class="container" style="text-align: center">
            <ul class="menu">
                <?php foreach ($categoryNameList as $category) : ?>
                    <li>
                        <?= Html::a($category, ['site/index']) ?>
                        <ul>
                            <li><?= Html::a('test', ['site/index']) ?></li>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul><!-- End .menu -->
        </div>
    </div>
</header><!-- End .header -->
