<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use backend\components\DropdownSide;
use common\models\BookGallery;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use common\models\Subcategory;
use common\widgets\AccordionWidget;
use kartik\icons\Icon;
use yii\bootstrap4\Html;

function items($teams, $view)
{
    $items = [];

    foreach ($teams as $key => $team)
    {
        $items[] = [
            'label' => $team,
            'url'   => [
                $view,
                'id' => $key,
            ],
        ];
    }
    return $items;
}

$category = MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->one();

$modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere([
                                                                        'company_id' => Yii::$app->user->id,
                                                                    ])->all();
$subMenuItems              = [];
$mainCategory              = [];
$subMenuItems              = [];
$subCategory               = Subcategory::getSubcategoryList();
$authorName                = array_combine(BookGallery::getAuthorNameList(Yii::$app->user->id), BookGallery::getAuthorNameList(Yii::$app->user->id));
if ($category instanceof MainCategory)
{
    $mainCategory = MainCategory::getMainCategoryList(Yii::$app->user->id);
}
$subMenuItems[] = Html::tag("div class='card-header' style='text-align: start;width: -moz-available;'", Html::a(Yii::t('app', 'Book Gallery'), ['/detail-gallery-article/index'], [
    'options' => [],
]), [

                            ]);

?>
<?php $subMenuItems[] = AccordionWidget::widget([
                                                    'items'   => [
                                                        [
                                                            'label'   => Html::tag('div class="card-header"', Yii::t('app', 'Categories') . Html::tag('span class="sub-icon"', Icon::show('arrow-circle-down', [
                                                                                                                'style' => 'position: revert; float: right',
                                                                                                            ]))),
                                                            'content' => DropdownSide::widget([
                                                                                                  'items' => items($mainCategory, '/site/index', 'mainCategory'),
                                                                                              ]),

                                                            //  'expanded' => true,
                                                        ],
                                                        [
                                                            'label'   => Html::tag('div class="card-header"', Yii::t('app', 'Subcategory')),
                                                            'content' => DropdownSide::widget([
                                                                                                  'items' => items($subCategory, '/site/index', 'subcategory'),
                                                                                              ]),
                                                            'hide'    => true,
                                                        ],
                                                        [
                                                            'label'   => Html::tag('div class="card-header"', Yii::t('app', 'Author Name')),
                                                            'content' => DropdownSide::widget([
                                                                                                  'items' => items($authorName, '/site/index', 'author'),
                                                                                                  //'view'          => $this->getView(),
                                                                                              ]),
                                                        ],
                                                        [
                                                            'label'   => Html::tag('div class="card-header"', Yii::t('app', 'Quiz')),
                                                            'content' => DropdownSide::widget([
                                                                                                  'items' => [
                                                                                                      [
                                                                                                          'label' => Yii::t('app', 'Main Category Excercise'),
                                                                                                          'url'   => ['/quiz/main-category-exercise/index'],

                                                                                                      ],
                                                                                                      [
                                                                                                          'label' => Yii::t('app', 'Excercise'),
                                                                                                          'url'   => ['/quiz/excercise/index'],
                                                                                                      ],
                                                                                                      [
                                                                                                          'label' => Yii::t('app', 'Students'),
                                                                                                          'url'   => ['quiz/students/index'],
                                                                                                      ],
                                                                                                      [
                                                                                                          'label' => Yii::t('app', 'Token'),
                                                                                                          'url'   => ['quiz/token/index'],
                                                                                                      ],
                                                                                                      [
                                                                                                          'label' => Yii::t('app', 'Answers'),
                                                                                                          'url'   => ['quiz/student-answers'],
                                                                                                      ],
                                                                                                      [
                                                                                                          'label' => Yii::t('app', 'Summarize'),
                                                                                                          'url'   => ['quiz/token/summary'],
                                                                                                      ],
                                                                                                  ],
                                                                                              ]),
                                                            'visible' => Yii::$app->user->can('*.*'),
                                                        ],


                                                    ],
                                                    'options' => [
                                                        'style' => 'text-align: start; width: 220px; color:antiquewhite',
                                                    ],
                                                ]) ?>

<?php


?>


<div class="row">
    <div class="col-sm-2 col-xs-12 bg-dark" style="position: fixed; height: 100%; top: 0px">
        <?php
        NavBar::begin([
                          'brandLabel' => Yii::t('app', 'Option'),
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => [
                              'class' => 'navbar navbar-default navbar-dark',
                          ],
                      ]);
        echo Nav::widget([
                             'items'   => $subMenuItems,
                             'options' => [
                                 'class' => 'nav navbar-nav list',
                                 'style' => 'margin-top: 60px;',
                             ],
                         ]);
        ?>
        <?php
        NavBar::end();
        ?>
    </div>
</div>
