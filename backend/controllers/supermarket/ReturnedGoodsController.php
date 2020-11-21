<?php

namespace backend\controllers\supermarket;

use backend\components\ComponentsPDF;
use backend\models\ReturnedGoods;
use backend\models\searchModel\ReturnedGoodsSearch;
use kartik\mpdf\Pdf;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReturnedGoodsController implements the CRUD actions for ReturnedGoods model.
 */
class ReturnedGoodsController extends Controller
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
     * Lists all ReturnedGoods models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ReturnedGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/returned-goods/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReturnedGoods model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/supermarket/returned-goods/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     *
     * Creates a new ReturnedGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $date                 = Yii::$app->request->post('date');
        $model                = new ReturnedGoods();
        $model->selected_date = $date;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id            = Yii::$app->user->id;
            $model->current_admin_user_id = Yii::$app->user->id;
            $model->save();
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }

        return $this->render('/supermarket/returned-goods/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReturnedGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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

        return $this->render('/supermarket/returned-goods/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReturnedGoods model.
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
     * @param int $month
     *
     * @return mixed|string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPdf(int $month = null)
    {
        // erster und letzter Tag im Monat
        $date     = new \DateTime();
        $firstDay = $date->format('Y' . '-' . $month . '-01');
        $lastDay  = $date->format('Y' . '-' . $month . '-t');

        $modelReturnedGoods = ReturnedGoods::find()->andWhere([
                                                                  'AND',
                                                                  ['company_id' => \Yii::$app->user->id],
                                                                  [
                                                                      'between',
                                                                      'selected_date',
                                                                      new Expression("'" . $firstDay . "'"),
                                                                      new Expression("'" . $lastDay . "'"),
                                                                  ],
                                                              ])->createCommand()->queryAll();
        if (0 < count($modelReturnedGoods))
        {
            $pdf                  = new ComponentsPDF([
                                                          'mode'        => Pdf::MODE_CORE,
                                                          'filename'    => date('d.m.Y') . '_' . '.pdf',
                                                          'destination' => ComponentsPDF::DEST_DOWNLOAD,
                                                          'companyName' => 'test',
                                                      ]);
            $contentReturnedGoods = $this->renderPartial('/supermarket/returned-goods/pdf-returned-goods', [
                'returnedGoodsList' => $modelReturnedGoods,
            ]);
            $pdf->api->WriteHtml($contentReturnedGoods);
            return $pdf->render();
        }
        Yii::$app->session->addFlash('error', Yii::t('app', 'Dont´t found'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the ReturnedGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ReturnedGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReturnedGoods::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
