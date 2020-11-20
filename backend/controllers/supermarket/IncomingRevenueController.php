<?php

namespace backend\controllers\supermarket;

use backend\models\History;
use backend\models\IncomingRevenue;
use backend\models\searchModel\IncomingRevenueSearch;
use common\controller\BaseController;
use Yii;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2tech\spreadsheet\Spreadsheet;

/**
 * IncomingRevenueController implements the CRUD actions for IncomingRevenue model.
 */
class IncomingRevenueController extends BaseController
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
     * Lists all IncomingRevenue models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new IncomingRevenueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/incoming-revenue/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        return $this->render('/supermarket/incoming-revenue/view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new IncomingRevenue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $date                 = Yii::$app->request->post('date');
        $model                = new IncomingRevenue();
        $model->selected_date = $date;
        $fileConfigs          = [];
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            $url = Html::a('Incoming Revenue', [
                'view',
                'id' => $model->id,
            ]);
            History::saveAutomaticHistoryEntry('Incoming Revenue', 'Gekündigt zum ', $url);
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء الدخل اليومي'));
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }

        return $this->render('/supermarket/incoming-revenue/create', [
            'model'       => $model,
            'fileConfigs' => $fileConfigs,
        ]);
    }

    /**
     * @param int $id
     *
     * @return int|mixed|string|\yii\console\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث المحتوى'));
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }

        return $this->render('/supermarket/incoming-revenue/update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdateEvent($event_id)
    {
        $model = $this->findModel($event_id);
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->save())
            {
                Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث المحتوى'));
                return $this->redirect(['site/index']);
            }
        }

        return $this->renderAjax('/supermarket/incoming-revenue/_form', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return int|mixed|\yii\console\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        $date  = $model->selected_date;
        $model->delete();
        Yii::$app->session->addFlash('success', Yii::t('app', 'تم مسح المحتوى'));
        return Yii::$app->runAction('site/view', ['date' => $date]);
    }

    /**
     * Finds the IncomingRevenue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return IncomingRevenue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IncomingRevenue::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return Response
     */
    public function actionExport(): Response
    {
        $exporter    = new Spreadsheet([
                                           'dataProvider' => new ActiveDataProvider([
                                                                                        'query' => IncomingRevenue::find()->select([
                                                                                                                                       'selected_date',
                                                                                                                                       'daily_incoming_revenue',
                                                                                                                                   ])->andWhere([
                                                                                                                                                    'company_id' => Yii::$app->user->id,
                                                                                                                                                ]),
                                                                                    ]),
                                       ]);
        $columnNames = [
            'selected_date',
            'daily_incoming_revenue',
        ];

        $exporter->columns = $columnNames;
        return $exporter->send('items.xls');
    }
}
