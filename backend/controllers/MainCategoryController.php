<?php

namespace backend\controllers;

use backend\models\searchModel\ArticleSearch;
use backend\models\searchModel\CategorySearch;
use backend\models\searchModel\MainCategorySearch;
use common\components\FileUpload;
use common\models\Article;
use common\models\ArticleInfo;
use common\models\MainCategory;
use common\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class MainCategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new MainCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->id);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelCategory = MainCategory::find()->andWhere([
                                                            'id'         => $id,
                                                            'company_id' => Yii::$app->user->id,
                                                        ])->one();
        if (!$modelCategory instanceof MainCategory)
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        }
        $modelArticle = new ActiveDataProvider([
                                                   'query' => ArticleInfo::find()->andWhere(['category_id' => $id]),
                                               ]);

        $modelSubcategory = new ActiveDataProvider([
                                                       'query' => Subcategory::find()->andWhere(['main_category_id' => $id]),
                                                   ]);
        return $this->render('view', [
            'dataProviderArticle'     => $modelArticle,
            'dataProviderSubcategory' => $modelSubcategory,
            'model'                   => $modelCategory,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model    = new MainCategory();
        $fileUrls = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }

        return $this->render('create', [
            'model'    => $model,
            'fileUrls' => $fileUrls,

        ]);
    }

    /**
     * Updates an existing Category model.
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
        if ($model->category_photo != null)
        {
            $fileUrls = FileUpload::getFileUrl(Yii::$app->params['uploadDirectoryArticle'], $model->category_photo);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $fileUpload = new FileUpload();
            $fileUpload->getFileUpload($model, 'file', 'category_photo', Yii::$app->params['uploadDirectoryCategory']);
            $model->save();
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }

        return $this->render('update', [
            'model'    => $model,
            'fileUrls' => $fileUrls,

        ]);
    }

    /**
     * Deletes an existing Category model.
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

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return MainCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MainCategory::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
