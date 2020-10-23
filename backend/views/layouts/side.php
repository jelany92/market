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

$category = MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->one();

$modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere([
                                                                        'company_id' => Yii::$app->user->id,
                                                                    ])->all();
$subMenuItems              = [];
$mainCategory              = [];
$subMenuItems              = [];
$subCategory               = Subcategory::getSubcategoryList();
$authorName                = array_combine(BookGallery::getAuthorNameList(2), \common\models\BookGallery::getAuthorNameList(2));
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
                                                        ],
                                                        [
                                                            'label'   => Html::tag('div class="card-header"', Yii::t('app', 'Author Name')),
                                                            'content' => DropdownSide::widget([
                                                                                                  'items' => items($authorName, '/site/index', 'author'),
                                                                                                  //'view'          => $this->getView(),
                                                                                              ]),
                                                            'options' => ['style' => 'width: 200px;'],
                                                        ],
                                                    ],
                                                    'options' => [
                                                        'class' => 'navbar-nav',
                                                        'style' => 'text-align: start; width: 220px;',
                                                    ],
                                                ]) ?>

<div class="row">
    <div class="col-sm-2 col-xs-12 bg-dark" style="position: absolute; height: 100%">
        <?php
        NavBar::begin([
                          'brandLabel' => Yii::t('app', 'Option'),
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => [
                              'class' => 'navbar navbar-default navbar-dark',
                          ],
                      ]);
        echo Nav::widget([
                             'options' => ['class' => 'nav navbar-nav list'],
                             'items'   => $subMenuItems,
                         ]);
        ?>
        <?php
        NavBar::end();
        ?>
    </div>
</div>

