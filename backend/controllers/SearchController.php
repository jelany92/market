<?php

namespace backend\controllers;

use common\controller\BaseController;
use common\models\ArticleInfo;
use common\models\DetailGalleryArticle;
use yii\data\ActiveDataProvider;

class SearchController extends BaseController
{
    /**
     * @param string $search
     *
     * @return string
     */
    public function actionGlobalSearch(string $search)
    {
        $articleInfo = ArticleInfo::find()->andWhere([
                                                         'and',
                                                         [
                                                             'like',
                                                             'article_name_ar',
                                                             $search,
                                                         ],
                                                         ['company_id' => \Yii::$app->user->id],
                                                     ]);
        if ($articleInfo instanceof ArticleInfo)
        {
            $dataProvider = new ActiveDataProvider([
                                                       'query' => $articleInfo,
                                                   ]);

            return $this->render('global-search-market', ['dataProvider' => $dataProvider,]);
        }

        $articleInfo  = DetailGalleryArticle::find()->innerJoinWith('bookAuthorName')->andWhere([
                                                                                                    'or',
                                                                                                    [
                                                                                                        'like',
                                                                                                        'name',
                                                                                                        $search,
                                                                                                    ],
                                                                                                    [
                                                                                                        'and',
                                                                                                        [
                                                                                                            'like',
                                                                                                            'article_name_ar',
                                                                                                            $search,
                                                                                                        ],
                                                                                                        ['detail_gallery_article.company_id' => \Yii::$app->user->id],
                                                                                                    ],
                                                                                                ]);
        $dataProvider = new ActiveDataProvider([
                                                   'query' => $articleInfo,
                                               ]);
        return $this->render('global-search-book', ['dataProvider' => $dataProvider,]);
    }

}
