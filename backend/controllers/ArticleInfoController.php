<?php

namespace backend\controllers;

use backend\models\ArticleIGain;
use common\components\FileUpload;
use common\controller\BaseController;
use common\models\ArticleInfo;
use common\models\MainCategory;
use common\models\searchModel\ArticleInfoSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ArticleInfoController implements the CRUD actions for ArticleInfo model.
 */
class ArticleInfoController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * All ArticleInfo.
     *
     * @return mixed
     */
    public function actionArticleView()
    {
        $articleInfo = ArticleInfo::find()->andWhere(['company_id' => Yii::$app->user->id]);
        $pages       = new Pagination(['totalCount' => $articleInfo->count()]);
        $articleInfo->offset($pages->offset)->limit($pages->limit);
        return $this->render('/supermarket/article-info/article-view', [
            'articleInfo' => $articleInfo->all(),
            'pages'       => $pages,

        ]);
    }

    /**
     * Lists all ArticleInfo models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ArticleInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/article-info/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticleInfo model.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $model                    = $this->findModel($id);
        $modelIncomingRevenue     = $model->articlePrices;
        $dataProviderArticlePrice = new ArrayDataProvider([
                                                              'allModels'  => $modelIncomingRevenue,
                                                              'pagination' => false,
                                                          ]);
        return $this->render('/supermarket/article-info/view', [
            'model'                    => $this->findModel($id),
            'dataProviderArticlePrice' => $dataProviderArticlePrice,
        ]);
    }

    /**
     * Creates a new ArticleInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleInfo();

        $searchModel  = new ArticleInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fileUrls     = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            $model               = new ArticleInfo();
            $model->category_id  = 7;
            $model->article_unit = 'K';
            return $this->render('/supermarket/article-info/create', [
                'model'    => $model,
                'fileUrls' => $fileUrls,
            ]);
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }

        $articleList = ArrayHelper::map(MainCategory::find()->andWhere(['company_id' => Yii::$app->user->id])->all(), 'id', 'category_name');
        return $this->render('/supermarket/article-info/create', [
            'model'       => $model,
            'articleList' => $articleList,
            'fileUrls'    => $fileUrls,

        ]);
    }

    /**
     * Updates an existing ArticleInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model    = $this->findModel($id);
        $fileUrls = '';
        if ($model->article_photo != null)
        {
            $fileUrls = FileUpload::getFileUrl(Yii::$app->params['uploadDirectoryArticle'], $model->article_photo);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $fileUpload = new FileUpload();
            $fileUpload->getFileUpload($model, 'file', 'article_photo', Yii::$app->params['uploadDirectoryArticle']);
            $model->save();
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }

        $articleList = MainCategory::getMainCategoryList(Yii::$app->user->id);
        return $this->render('/supermarket/article-info/update', [
            'model'       => $model,
            'articleList' => $articleList,
            'fileUrls'    => $fileUrls,
        ]);
    }

    /**
     * Deletes an existing ArticleInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/supermarket/article-info/index']);
    }


    public function actionArticleGain()
    {
        $modelArticleIGain = new ArticleIGain();
        if ($modelArticleIGain->load(Yii::$app->request->post()) && $modelArticleIGain->validate())
        {
            return $this->render('/supermarket/article-info/article-gain', [
                'modelArticleIGain' => $modelArticleIGain,
                'show'              => true,
            ]);
        }

        return $this->render('/supermarket/article-info/article-gain', [
            'modelArticleIGain' => $modelArticleIGain,
            'show'              => false,
        ]);
    }


    /**
     * Finds the ArticleInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ArticleInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleInfo::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
