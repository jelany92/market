<?php

namespace backend\controllers\quiz;

use backend\models\quiz\Excercise;
use backend\models\quiz\ExerciseForm;
use backend\models\quiz\MainCategoryExercise;
use backend\models\quiz\search\ExcerciseSearch;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param int $mainCategoryExerciseId
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate(int $mainCategoryExerciseId)
    {
        $modelForm         = new ExerciseForm();
        $modelExerciseList = [new Excercise];

        $modelModelMainCategoryExercise = $this->findModelMainCategoryExercise($mainCategoryExerciseId);
        if ($modelForm->load(Yii::$app->request->post()))
        {
            $modelExerciseFormList = ExerciseForm::createMultiple(ExerciseForm::class);
            ExerciseForm::loadMultiple($modelExerciseList, Yii::$app->request->post());
            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(ActiveForm::validateMultiple($modelExerciseList), ActiveForm::validate($modelForm));
            }
            $transaction = \Yii::$app->db->beginTransaction();
            try
            {
                foreach ($modelExerciseFormList as $modelExerciseForm)
                {
                    $modelExercise                            = new Excercise();
                    $modelExercise->main_category_exercise_id = $mainCategoryExerciseId;
                    $modelExercise->question_type             = $modelExerciseForm->question_type;
                    $modelExercise->question                  = $modelExerciseForm->question;
                    $modelExercise->answer_a                  = $modelExerciseForm->answer_a;
                    $modelExercise->answer_b                  = $modelExerciseForm->answer_b;
                    $modelExercise->answer_c                  = $modelExerciseForm->answer_c;
                    $modelExercise->answer_d                  = $modelExerciseForm->answer_d;
                    $modelExercise->correct_answer            = $modelExerciseForm->correct_answer;
                    if (!($modelExercise->save(false)))
                    {
                        $transaction->rollBack();
                        break;
                    }
                }
                $transaction->commit();
                return $this->redirect([
                                           'index',
                                       ]);
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
            }
        }
        return $this->render('create', [
            'model'                          => $modelForm,
            'modelModelMainCategoryExercise' => $modelModelMainCategoryExercise,
            'modelsAddress'                  => (empty($modelExerciseList)) ? [new Excercise()] : $modelExerciseList,
        ]);
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
        $model     = $this->findModel($id);
        $modelForm = new ExerciseForm();
        $modelForm->setValueFromModelToForm($model);
        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->validate())
        {
            dd($modelForm);
            $model->setValueFromFormToModel($modelForm);
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }
        return $this->render('update', [
            'model'                          => $modelForm,
            'modelModelMainCategoryExercise' => $model->mainCategoryExercise,
            'modelsAddress'                  => (empty($model)) ? [new Excercise()] : [$model],
        ]);
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

    public function actionCorrectAnswer()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents']))
        {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null)
            {
                $cat_id = $parents[0];
                return [
                    'output'   => Excercise::getCorrectAnswerOption($cat_id),
                    'selected' => '',
                ];
            }
        }
        return [
            'output'   => '',
            'selected' => '',
        ];
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
            throw new NotFoundHttpException('The requested page does not exist . ');
        }
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
    protected function findModelMainCategoryExercise($mainCategoryExerciseId)
    {
        if (($model = MainCategoryExercise::findOne($mainCategoryExerciseId)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist . ');
        }
    }
}
