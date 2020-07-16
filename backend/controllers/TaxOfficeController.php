<?php

namespace backend\controllers;

use backend\models\TaxOffice;
use backend\models\searchModel\TaxOfficeSearch;
use common\controller\BaseController;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TaxOfficeController implements the CRUD actions for TaxOffice model.
 */
class TaxOfficeController extends BaseController
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
     * Lists all TaxOffice models.
     *
     * @return mixed
     */
    public function actionIndex(): string
    {
        $searchModel  = new TaxOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/tax-office/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return int|mixed|string|\yii\console\Response
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionCreate()
    {
        $date                 = Yii::$app->request->post('date');
        $model                = new TaxOffice();
        $model->selected_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء مسترجعات من الضرائب لليوم'));
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);

        }
        $reasonList = ArrayHelper::map(TaxOffice::find()->select('reason')->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/tax-office/create', [
            'model'      => $model,
            'reasonList' => $reasonList,

        ]);
    }

    /**
     * Updates an existing TaxOffice model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                                       '/tax-office/index',
                                   ]);
        }

        $reasonList = ArrayHelper::map(TaxOffice::find()->select('reason')->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/tax-office/update', [
            'model'      => $model,
            'reasonList' => $reasonList,
        ]);
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/tax-office/index']);
    }

    /**
     * Finds the TaxOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return TaxOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = TaxOffice::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
