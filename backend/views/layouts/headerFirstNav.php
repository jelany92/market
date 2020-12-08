<?php

use backend\components\LanguageDropdown;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use common\widgets\Nav;
use yii\helpers\Url;
use common\models\DetailGalleryArticle;
use evgeniyrru\yii2slick\Slick;

$firstMenuItems = [
    [
        'label' => LanguageDropdown::label(Yii::$app->language),
        'items' => LanguageDropdown::widget(),
    ],
];
if (Yii::$app->user->isGuest)
{
    $firstMenuItems[] = [
        'label' => 'Login',
        'url'   => ['/site/login'],
    ];
}
else
{
    $firstMenuItems[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>';
}

$label = [
    [
        'label'       => Yii::t('app', 'Adam Market'),
        'url'         => ['/site/index'],
        'linkOptions' => [
            'style' => 'text-align: start;',
        ],
    ],
];

?>
<!-- HEADER -->
<!-- TOP HEADER -->
<nav id="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ml-auto">
    <div class="container">
        <div class="row col-md-12" style="display: -webkit-box">
            <div class="col-10 col-md-4">
                <?php
                echo nav::widget([
                                     'options' => [
                                         'id'    => 'itemNav',
                                         'class' => 'navbar-nav ml-auto',
                                     ],
                                     'items'   => $label,
                                 ]);
                ?>
            </div>
            <?= Html::button(Icon::show('bars'), [
                'class'         => 'navbar-toggler',
                'data-toggle'   => 'collapse',
                'data-target'   => '#itemNavFirst',
                'aria-controls' => 'itemNavFirst',
                'aria-expanded' => 'false',
                'aria-label'    => 'Toggle navigation',
            ]) ?>
            <div class="col-md-4">
                <?php
                $form = ActiveForm::begin([
                                              'id'      => 'itemNavFirst',
                                              'method'  => 'GET',
                                              'options' => [
                                                  'class' => 'collapse navbar-collapse',
                                                  'style' => 'text-align: center;',
                                              ],
                                              'action'  => Url::toRoute('/search/global-search'),
                                          ]);

                ?>
                <?php
                echo Html::textInput('search', (Yii::$app->controller->id == 'search' && Yii::$app->controller->action->id == 'global-search') ? Yii::$app->request->get('search') : null, [
                    'autocomplete' => 'off',
                    'id'           => 'navSearchString',
                    'placeholder'  => Yii::t('app', 'Search to') . '...',
                    'value'        => 'test',
                    'class'        => 'navSearchTextBox pull-center',
                    'style'        => 'align-items: revert;',
                ]);
                echo Html::submitButton(Icon::show('search'), ['class' => 'btn btn-secondary navSearchSubmit'])
                ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-md-4" style="display: -webkit-box">
                <?php
                echo nav::widget([
                                     'options' => [
                                         'id'    => 'itemNavFirst',
                                         'class' => 'collapse navbar-collapse navbar-nav ml-auto',
                                         'style' => 'align-items: revert;',
                                     ],
                                     'items'   => $firstMenuItems,
                                 ]);
                ?>
            </div>
        </div>
    </div>
</nav>

<?php if (Yii::$app->controller->action == 'site' && Yii::$app->controller->action->id == 'index'): ?>

    <?php $image               = [];
    $modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere(['company_id' => Yii::$app->user->id])->all();
    ?>

    <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
        <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
            <?php $image[] = Html::a(Html::img(DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo), [
                'style' => 'width:100%;height: 350px',
                'id'    => $detailGalleryArticle->id,
            ]), [
                                         'detail-gallery-article/view',
                                         'id' => $detailGalleryArticle->id,
                                     ]) ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <div style="direction: initial">
        <?= Slick::widget([
                              // Widget configuration. See example above.
                              // settings for js plugin
                              // @see http://kenwheeler.github.io/slick/#settings
                              'clientOptions' => [
                                  // 'dots'           => true,
                                  'speed'          => 300,
                                  'autoplay'       => true,
                                  'infinite'       => true,
                                  'slidesToShow'   => 4,
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
                              'items'         => $image,
                          ]); ?>
    </div>
<?php endif; ?>
