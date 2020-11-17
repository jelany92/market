<?php

namespace frontendBook\controllers;

use common\models\AdminUser;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use common\models\searchModel\BookAuthorNameSearch;
use common\models\Subcategory;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class BookInfoController extends Controller
{
    /**
     * Displays Author.
     *
     * @return mixed
     */
    public function actionAuthor()
    {
        $searchModel  = new BookAuthorNameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('author', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays Main Category.
     *
     * @param null $mainCategoryId
     *
     * @return string
     */
    public function actionSubcategories($mainCategoryId = null)
    {
        if (isset($mainCategoryId))
        {
            $subcategories = Subcategory::find()->andWhere(['main_category_id' => $mainCategoryId])->orderBy(['subcategory_name' => SORT_ASC])->all();
        }
        else
        {
            $subcategories = Subcategory::find()->orderBy(['subcategory_name' => SORT_ASC])->all();
        }
        $subcategoryList = Subcategory::getSubcategoryList($mainCategoryId, AdminUser::JELANY_BOOK_CATEGORY);
        return $this->render('subcategories', [
            'subcategories'   => $subcategories,
            'subcategoryList' => $subcategoryList,
        ]);
    }

    /**
     * Displays Main Category.
     *
     * @param int $subcategoryId
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionSubcategory(int $subcategoryId)
    {
        $subcategories   = Subcategory::find()->andWhere(['id' => $subcategoryId])->all();
        $subcategoryList = Subcategory::getSubcategoryList(null, AdminUser::JELANY_BOOK_CATEGORY);
        return $this->render('subcategory', [
            'subcategories'   => $subcategories,
            'subcategoryList' => $subcategoryList,
            'subcategoryId'   => $subcategoryId,
        ]);
    }

    /**
     * Displays Main Category.
     *
     * @return mixed
     */
    public function actionMainCategory()
    {
        $mainCategories = MainCategory::find()->andWhere(['company_id' => 2])->all();

        return $this->render('main-category', [
            'mainCategories' => $mainCategories,
        ]);
    }

    /**
     * Displays Book Details.
     *
     * @param int $detailGalleryArticleId
     *
     * @return mixed
     */
    public function actionBookDetails(int $detailGalleryArticleId)
    {
        $detailGalleryArticle = DetailGalleryArticle::find()->andWhere(['id' => $detailGalleryArticleId])->one();

        return $this->render('book-details', [
            'detailGalleryArticle' => $detailGalleryArticle,
        ]);
    }

}
