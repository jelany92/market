<?php

namespace backend\controllers\quiz;

use Yii;
use backend\models\quiz\Excercise;
use backend\models\quiz\search\ExcerciseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExcerciseController implements the CRUD actions for Excercise model.
 */
class ExcerciseController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Excercise models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ExcerciseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Excercise model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Excercise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $mainCategoryExerciseId
     * @return mixed
     */
    public function actionCreate(int $mainCategoryExerciseId)
    {
        $model = new Excercise();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->main_category_exercise_id = $mainCategoryExerciseId;
            $model->save();
            Yii::$app->session->addFlash('app', 'done');
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Excercise model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Excercise model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'done');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Excercise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Excercise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Excercise::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
