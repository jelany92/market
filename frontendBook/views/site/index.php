<?php

use yii\bootstrap4\Html;
use common\models\DetailGalleryArticle;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */
/* @var $mainCategoryList array */

$this->title = 'Book Gallery';

$count = 0;
?>
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- shop -->
            <?php foreach ($mainCategoryList as $mainCategory) : ?>
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <?php if ($mainCategory->category_photo != null) : ?>
                                <?= Html::img($mainCategory::mainCategoryImagePath($mainCategory->category_photo), ['style' => 'width:100%;height: 250px']) ?>
                            <?php else: ?>
                                <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="shop-body">
                            <h3><?= $mainCategory->category_name ?><br>Collection</h3>
                            <?= Html::a(Yii::t('app', 'See More') . ' ' . '<i class="fa fa-arrow-circle-right"></i>', [
                                'site/main-category',
                                'mainCategoryId' => $mainCategory->id,
                            ], [
                                            'class' => 'cta-btn',
                                        ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- /shop -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-sm-12">
                <div class="section-title">
                    <h3 class="title"><?= Yii::t('app', 'New Book') ?></h3>
                    <div class="section-nav">
                        <ul class="section-title section-tab-nav tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1"><?= Yii::t('app', 'New Book') ?></a></li>
                            <?php foreach ($mainCategoryList as $mainCategory) : ?>
                                <?= Html::tag("li", Html::a($mainCategory->category_name, ['main-category', 'mainCategoryId' => $mainCategory->id])) ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="row col-md-12">
                <div class="products-tabs col-md-12">
                    <!-- tab -->
                    <div id="tab1" class="tab-pane active">
                        <div class="products-slick" data-nav="#slick-nav-1">
                            <!-- product -->
                            <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
                                <div class="product">
                                    <div class="product-img">
                                        <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                                            <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), ['style' => 'width:100%;height: 300px']) ?>
                                        <?php else: ?>
                                            <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                                        <?php endif; ?>
                                        <div class="product-label">
                                            <span class="new">NEW</span>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category"><?= $detailGalleryArticle->mainCategory->category_name ?></p>
                                        <h3 class="product-name"><?= Html::a($detailGalleryArticle->article_name_ar, [
                                                'book-info/book-details',
                                                'detailGalleryArticleId' => $detailGalleryArticle->id,
                                            ]) ?></h3>
                                        <h4 class="product-price">free
                                            <!--                                                <del class="product-old-price">$990.00</del>
                                            -->
                                        </h4>
                                    </div>
                                    <div class="add-to-cart">
                                        <?= Html::a(Yii::t('app', 'Read'), $detailGalleryArticle->link_to_preview, [
                                            'class'  => 'add-to-cart-btn',
                                            'target' => '_blank',
                                        ]) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- /product -->
                        </div>
                    </div>
                    <div id="slick-nav-1" class="products-slick-nav"></div>
                </div>
                <!-- /tab -->
            </div>
            <!-- Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <?php foreach ($modelBookAuthorName as $bookAuthorName) : ?>
                <div class="col-md-4 col-xs-6">
                    <div class="section-title">
                        <h4 class="title"> <?= $bookAuthorName->name ?></h4>
                        <div class="section-nav">
                            <div id="<?= $bookAuthorName->id ?>" class="products-slick-nav"></div>
                        </div>
                    </div>

                    <div class="products-widget-slick" data-nav="#<?= $bookAuthorName->id ?>">
                        <div>
                            <!-- product widget -->
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="common/img/product08.png" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Category</p>
                                    <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                    <h4 class="product-price">$980.00
                                        <del class="product-old-price">$990.00</del>
                                    </h4>
                                </div>
                            </div>
                            <!-- /product widget -->

                            <!-- product widget -->
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="common/img/product09.png" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Category</p>
                                    <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                    <h4 class="product-price">$980.00
                                        <del class="product-old-price">$990.00</del>
                                    </h4>
                                </div>
                            </div>
                            <!-- product widget -->
                        </div>

                        <div>
                            <!-- product widget -->
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="common/img/product01.png" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Category</p>
                                    <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                    <h4 class="product-price">$980.00
                                        <del class="product-old-price">$990.00</del>
                                    </h4>
                                </div>
                            </div>
                            <!-- /product widget -->

                            <!-- product widget -->
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="common/img/product02.png" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Category</p>
                                    <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                    <h4 class="product-price">$980.00
                                        <del class="product-old-price">$990.00</del>
                                    </h4>
                                </div>
                            </div>
                            <!-- /product widget -->

                            <!-- product widget -->
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="common/img/product03.png" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">Category</p>
                                    <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                    <h4 class="product-price">$980.00
                                        <del class="product-old-price">$990.00</del>
                                    </h4>
                                </div>
                            </div>
                            <!-- product widget -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>


            <div class="clearfix visible-sm visible-xs"></div>

            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">Top selling</h4>
                    <div class="section-nav">
                        <div id="slick-nav-5" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-5">
                    <?php foreach ($detailGalleryArticleList as $detailGalleryInfo) : ?>
                    <div>
                        <!-- product widget -->
                        <div class="product-widget">
                            <div class="product-img">
                                <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
                                    <?= Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryInfo->bookGalleries->book_photo), ['style' => 'width:35px;height: 50px']) ?>
                                <?php else: ?>
                                    <?= Html::a('test', 'test', ['style' => "padding-top: 245px;"]) ?>
                                <?php endif; ?>
                            </div>
                            <div class="product-body">
                                <p class="product-category"><?= $detailGalleryInfo->mainCategory->category_name ?></p>
                                <h3 class="product-name"><?= Html::a($detailGalleryInfo->article_name_ar, [
                                        'book-info/book-details',
                                        'detailGalleryArticleId' => $detailGalleryArticle->id,
                                    ]) ?></h3>
                            </div>
                        </div>
                        <?php $count++ ?>
                        <?php if ($count == 5) : ?>
                            <?php break; ?>
                        <?php endif; ?>
                        <!-- product widget -->
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- NEWSLETTER -->
<div id="newsletter" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                    <form>
                        <input class="input" type="email" placeholder="Enter Your Email">
                        <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                    </form>
                    <ul class="newsletter-follow">
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /NEWSLETTER -->