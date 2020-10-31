<?php

use common\models\DetailGalleryArticle;
use evgeniyrru\yii2slick\Slick;
use yii\bootstrap\Html;

/* @var $images array */

$modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere(['company_id' => 2])->all();
$images                    = [];
foreach ($modelDetailGalleryArticle as $detailGalleryArticle)
{
    if ($detailGalleryArticle->bookGalleries->book_photo != null)
    {
        $images[] = \yii\bootstrap4\Html::a(Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), [
            'style' => 'width:100%;height: 350px',
            'id'    => $detailGalleryArticle->id,
        ]), [
                                                'detail-gallery-article/view',
                                                'id' => $detailGalleryArticle->id,
                                            ]);
    }
}
?>
<div style="direction: initial;">
    <?= Slick::widget([
                          // Widget configuration. See example above.
                          // settings for js plugin
                          // @see http://kenwheeler.github.io/slick/#settings
                          'clientOptions' => [
                              'dots'           => false,
                              'speed'          => 300,
                              'autoplay'       => true,
                              'infinite'       => true,
                              'slidesToShow'   => 6,
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