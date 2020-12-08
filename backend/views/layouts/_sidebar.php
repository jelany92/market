<?php

use backend\components\DropdownSide;
use common\models\BookGallery;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use common\models\Subcategory;
use common\widgets\AccordionWidget;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use common\widgets\Nav;

function items($teams, $view, $param)
{
    $items = [];
    foreach ($teams as $key => $team)
    {
        $items[] = [
            'label' => $team,
            'url'   => [
                $view,
                $param => $key,
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
                                                                                                  'items' => items($mainCategory, '/site/index', 'mainCategoryId'),
                                                                                              ]),
                                                            //  'expanded' => true,
                                                        ],
                                                        [
                                                            'label'   => Html::tag('div class="card-header"', Yii::t('app', 'Subcategory')),
                                                            'content' => DropdownSide::widget([
                                                                                                  'items' => items($subCategory, '/site/index', 'subcategoryId'),
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
                                                        'id'    => 'sidebar',
                                                        'class' => 'collapse navbar-collapse show',
                                                        'style' => 'text-align: start; width: 265px;',
                                                    ],
                                                ]) ?>
<div class="sidebar-filter-overlay"></div>
<aside class="sidebar-shop sidebar-filter">
    <aside class="shadow collapsible collapsible-accordion">
        <?= Html::label('<h3>' . Yii::t('app', 'Book Information') . '</h3>', '', [
            'id'    => 'sidebar',
            'class' => 'collapse navbar-collapse show',
        ]) ?>
        <?= Html::button(Icon::show('bars'), [
            'class'         => 'navbar-toggler',
            'data-toggle'   => 'collapse',
            'data-target'   => '#sidebar',
            'aria-controls' => 'sidebar',
            'aria-expanded' => true,
            'aria-label'    => 'Toggle navigation',
            'style'         => 'float: right',
        ]) ?>

        <?= Nav::widget([
                            'options' => [
                                'id'    => 'sidebar',
                                'class' => 'collapse navbar-collapse show collapsible-header flex-container flex-column nav-pills ml-auto',
                                'style' => 'align-items: start;',
                            ],
                            'items'   => $subMenuItems,
                        ]) ?>

    </aside>
</aside>
