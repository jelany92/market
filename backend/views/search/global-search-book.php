<?php

use common\components\GridView;
use common\models\BookAuthorName;
use yii\bootstrap4\Html;
use common\models\Subcategory;

/* @var $this yii\web\View */
/* @var $searchModels array */
/* @var $dataProviders array */
/* @var $tabItems array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
$this->title                   = Yii::t('app', 'Global search');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (0 < $dataProvider->totalCount)
    {
        echo GridView::widget([
                                  'dataProvider' => $dataProvider,
                                  'id'           => 'grid_admin_search',
                                  'columns'      => [
                                      ['class' => 'yii\grid\SerialColumn'],
                                      [
                                          'attribute' => 'article_name_ar',
                                          'value'     => function ($model) {
                                              return Html::a($model->article_name_ar, [
                                                  'detail-gallery-article/view',
                                                  'id' => $model->id,
                                              ]);
                                          },
                                          'format'    => 'raw',
                                      ],
                                      'article_name_en',
                                      [
                                          'label'  => Yii::t('app', 'Book Number'),
                                          'value'  => function ($model) {
                                              return BookAuthorName::getBookAuthorNameLink($model->bookAuthorName->name);
                                          },
                                          'format' => 'raw',
                                      ],
                                      [
                                          'label'  => Yii::t('app', 'Subcategory'),
                                          'value'  => function ($model) {
                                              $subcategoryList = [];
                                              foreach ($model->gallerySaveCategory as $gallerySaveCategory)
                                              {
                                                  $subcategoryList[$gallerySaveCategory->subcategory->id] = $gallerySaveCategory->subcategory->subcategory_name;
                                              }
                                              $subcategory = [];
                                              foreach ($subcategoryList as $key => $subcategoryName)
                                              {
                                                  $subcategory[] = Html::a($subcategoryName, [
                                                      'detail-gallery-article/index',
                                                      'mainCategoryName' => $model->mainCategory->category_name,
                                                      'subcategoryId'    => $key,
                                                  ]);
                                              }
                                              return implode(', ', $subcategory);
                                          },
                                          'format' => 'raw',
                                      ],
                                  ],
                              ]);
    }
    else
    {
        echo Html::tag('h3', Yii::t('app', 'No Results Found'));
    }
    ?>

</div>
