<?php

use common\models\DetailGalleryArticle;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $modelDetailGalleryArticle DetailGalleryArticle */
/* @var $mainCategoryList array */

$this->title = 'My Yii Application';
$image       = DetailGalleryArticle::subcategoryImagePath($modelDetailGalleryArticle->bookGalleries->book_photo);

?>

<div class="media-details">
    <div class="row no-gutter">

        <div class="poster-wraper col-3">
            <?= Html::a('<span class="rate">7.6<i>IMDB</i></span>', [
                'information/view',
                'id' => $modelDetailGalleryArticle->id,
            ], [
                            'class'    => 'poster-image',
                            'data-src' => $image,
                            'style'    => 'background-image: url("' . $image . '")',
                        ]) ?>
            <?= Html::a(Yii::t('app', 'متابعه'), 'javascript:', [
                'class' => 'left-bottom ti-heart btn small success ti-heart btn small success btn-do-subs ti-notifications-bill',
            ]) ?>
            <?= Html::a(Yii::t('app', 'إلغاء الإشتراك'), 'javascript:', [
                'class' => 'left-bottom ti-heart btn small warning btn-do-unsubs ti-notifications-bill',
                'style' => 'display: none;',
            ]) ?>

            <?= Html::a(Yii::t('app', 'حذف من المشاهدة لاحقا'), 'javascript:', [
                'class' => 'btn rounded watch-latter success remove-from-list-btn',
                'style' => 'display: none;left: 5px; right: auto;',
            ]) ?>

            <?= Html::a(Yii::t('app', 'مشاهدة لاحقا'), 'javascript:', [
                'class' => 'btn primary rounded watch-latter add-to-list-btn',
                'style' => 'left: 5px; right: auto',
            ]) ?>
        </div>

        <div class="details col-9">
            <div class="title">
                <?= '<h1>' . $modelDetailGalleryArticle->article_name_ar . '</h1>' ?>
                <ul class="half-tags">
                    <?= Html::tag('li', Html::tag('span class="ti-movie-filter"', Yii::t('app', 'الجودة'))) ?>
                    <?php foreach ($modelDetailGalleryArticle->gallerySaveCategory as $gallerySaveCategory) : ?>
                        <?php $subcategoryList = $gallerySaveCategory->subcategory->subcategory_name;
                        $subcategory           = Html::a($subcategoryList, [
                            'information/subcategory',
                            'subcategoryName' => $subcategoryList,
                        ], ['class' => 'click-all ti-tag']); ?>
                        <?= Html::tag('li', $subcategory); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="btns">
                <?= Html::a('<i class="ti-slow-motion"></i> <span>' . Yii::t('app', 'مشاهدة الأن') . '</span>', $modelDetailGalleryArticle->link_to_preview, [
                    'class'  => 'btns-play watch-btn primary btn',
                    'style'  => 'left: 5px; right: auto',
                    'target' => '_blank',
                ]) ?>
                <?= Html::a('<i class="ti-server-download"></i> <span>' . Yii::t('app', 'تحميل الأن') . '</span>', [''], [
                    'class'  => 'btns-play download-btn success btn',
                    'style'  => 'left: 5px; right: auto',
                    'target' => '_blank',

                ]) ?>
            </div>

            <?= Html::tag('div class="media-p"', Html::tag('p class="Scroll-list" style="height: 80px;"', $modelDetailGalleryArticle->description)) ?>

            <ul class="half-tags">
                <?= Html::tag('li', Html::tag('span class="ti-earth"', Yii::t('app', 'القسم'))) ?>
                <?= Html::tag('li', Html::a($modelDetailGalleryArticle->mainCategory->category_name, [
                    'information/mainCategory',
                    'mainCategoryId' => $modelDetailGalleryArticle->main_category_id,
                ], [
                                                'class' => 'click-all',
                                            ])) ?>
                <?= Html::a(Html::tag('li', Html::tag('span class="release-year"', Yii::t('app', 'السنة')) . '<strong>2020</strong>'), [
                    'information/mainCategory',
                    'mainCategoryId' => $modelDetailGalleryArticle->main_category_id,
                ], [
                                'class' => 'click-all',
                            ]) ?>
            </ul>
            <ul class="half-tags">
                <?= Html::a(Html::tag('li', Html::tag('span class="ti-tagr"', Yii::t('app', 'النوع'))), [
                    'information/subCategory',
                    'subCategoryId' => $modelDetailGalleryArticle->main_category_id,
                ]) ?>

                <?php foreach ($modelDetailGalleryArticle->gallerySaveCategory as $gallerySaveCategory) : ?>
                    <?php
                    $subcategoryList = $gallerySaveCategory->subcategory->subcategory_name;
                    $subcategory     = Html::a($subcategoryList, [
                        'information/subcategory',
                        'subcategoryName' => $subcategoryList,
                    ], ['class' => 'click-all']); ?>
                    <?= Html::tag('li', $subcategory); ?>
                <?php endforeach; ?>
            </ul>
            <div class="row no-gutter col-12">
                <div class="col-l-4 info-lists">
                    <?= Html::tag('ul', Html::tag('li class="title ti-business-manager-rate"', Yii::t('app', 'الممثلين'))); ?>
                    <ul class="margin-top Scroll-list">
                        <?= Html::tag('li class="item"', Html::img('https://shahid4u.im/themes/Shahid4u/img/avatar.png') . Html::a($modelDetailGalleryArticle->bookAuthorName->name, [''])); ?>
                    </ul>
                </div>
                <div class="col-l-4 info-lists">
                    <?= Html::tag('ul', Html::tag('li class="title ti-business-cogs-group-2"', Yii::t('app', 'تأليف'))); ?>

                    <ul class="margin-top Scroll-list">
                        <li class="item">
                            <?= Html::tag('li class="item"', Html::img('https://shahid4u.im/themes/Shahid4u/img/avatar.png') . Html::a($modelDetailGalleryArticle->bookAuthorName->name, [''])); ?>
                        </li>
                    </ul>
                </div>
                <div class="col-l-4 info-lists">
                    <?= Html::tag('ul', Html::tag('li class="title ti-suit"', Yii::t('app', 'إخراج'))); ?>
                    <ul class="margin-top Scroll-list">
                        <li class="item">
                            <?= Html::tag('li class="item"', Html::img('https://shahid4u.im/themes/Shahid4u/img/avatar.png') . Html::a($modelDetailGalleryArticle->bookAuthorName->name, [''])); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="carousel-slider">
    <div class="section-head">
        <h3 class="area-title">مقالات مشابهة</h3>
    </div>
    <div style="direction: initial;">
        <?= \evgeniyrru\yii2slick\Slick::widget([
                              'clientOptions' => [
                                  'dots'           => false,
                                  'speed'          => 300,
                                  'autoplay'       => true,
                                  'infinite'       => true,
                                  'slidesToShow'   => 5,
                                  'slidesToScroll' => 1,
                                  'responsive'     => [
                                      [
                                          'breakpoint' => 1200,
                                          'settings'   => [
                                              'slidesToShow'   => 4,
                                              'slidesToScroll' => 4,
                                              'infinite'       => true,
                                              'autoplay'       => true,
                                              'dots'           => true,
                                          ],

                                      ],
                                      [
                                          'breakpoint' => 992,
                                          'settings'   => [
                                              'slidesToShow'   => 4,
                                              'slidesToScroll' => 4,
                                              'infinite'       => true,
                                              'autoplay'       => true,
                                              'dots'           => true,
                                          ],
                                      ],
                                      [
                                          'breakpoint' => 768,
                                          'settings'   => [
                                              'slidesToShow'   => 2,
                                              'slidesToScroll' => 2,
                                              'infinite'       => true,
                                              'autoplay'       => true,
                                              'dots'           => true,
                                          ],
                                      ],
                                      [
                                          'breakpoint' => 480,
                                          'settings'   => 'unslick',
                                          // Destroy carousel, if screen width less than 480px
                                      ],

                                  ],
                              ],
                              'items'         => $images,
                          ]); ?>
    </div>
</div>
