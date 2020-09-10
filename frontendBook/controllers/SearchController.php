<?php

namespace frontendBook\controllers;

use common\models\DetailGalleryArticle;
use common\models\UserModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SearchController extends Controller
{
    /**
     * @param string $search
     *
     * @return string
     */
    public function actionGlobalSearch(string $search)
    {
        $articleInfo  = DetailGalleryArticle::find()->innerJoinWith('bookAuthorName')->andWhere([
                                                                                                    'or',
                                                                                                    [
                                                                                                        'like',
                                                                                                        'name',
                                                                                                        $search,
                                                                                                    ],
                                                                                                    ['and',
                                                                                                    [
                                                                                                        'like',
                                                                                                        'article_name_ar',
                                                                                                        $search,
                                                                                                    ],
                                                                                                    ['detail_gallery_article.company_id' => UserModel::JELANY_BOOK_CATEGORY],
                                                                                                ]]);
        $dataProvider = new ActiveDataProvider([
                                                   'query' => $articleInfo,
                                               ]);
        return $this->render('global-search', ['dataProvider' => $dataProvider,]);
    }

}
