<?php

namespace backend\controllers;

use backend\models\History;
use common\components\QueryHelper;
use common\controller\BaseController;
use Yii;
use backend\models\MarketExpense;
use backend\models\searchModel\MarketExpenseSearch;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarketExpenseController implements the CRUD actions for MarketExpense model.
 */
class MarketExpenseController extends BaseController
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
     * Lists all MarketExpense models.
     *
     * @return mixed
     */
    public function actionIndexGroup()
    {
        $query        = MarketExpense::find()->select([
                                                          'expense' => 'SUM(expense)',
                                                          'reason',
                                                          'selected_date',
                                                      ])->andWhere(['company_id' => \Yii::$app->user->id])->groupBy('reason');
        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                               ]);
        return $this->render('/supermarket/market-expense/index-group', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MarketExpense models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $modelMarketExpense = new MarketExpense();
        $result             = '';
        $show               = false;
        if ($modelMarketExpense->load(Yii::$app->request->post()))
        {
            $show   = true;
            $result = QueryHelper::sumsSearchResult(MarketExpense::tableName(), 'expense', 'reason', $modelMarketExpense->reason, $modelMarketExpense->from, $modelMarketExpense->to);
        }
        $searchModel                      = new MarketExpenseSearch();
        $dataProvider                     = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['selected_date' => SORT_DESC];
        return $this->render('/supermarket/market-expense/index', [
            'model'        => $modelMarketExpense,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'result'       => $result,
            'show'         => $show,
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
        return $this->render('/supermarket/market-expense/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return int|mixed|string|\yii\console\Response
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionCreate()
    {
        $model                = new MarketExpense();
        $date                 = Yii::$app->request->post('date');
        $model->selected_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            $url = Html::a($model->reason, [
                'view',
                'id' => $model->id,
            ]);
            History::saveAutomaticHistoryEntry('Market expense', 'Market expense', $url);
            Yii::$app->session->addFlash('success', Yii::t('app', 'Market expense was created for today') . ' ' . $model->selected_date);
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }
        $reasonList = ArrayHelper::map(MarketExpense::find()->select('reason')->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/market-expense/create', [
            'model'      => $model,
            'reasonList' => $reasonList,
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
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث مصروف للماركت لليوم') . ' ' . $model->selected_date);
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }

        $reasonList = ArrayHelper::map(MarketExpense::find()->select('reason')->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/market-expense/update', [
            'model'      => $model,
            'reasonList' => $reasonList,

        ]);
    }

    /**
     * @param $id
     *
     * @return int|mixed|\yii\console\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $date  = $model->selected_date;
        $model->delete();
        Yii::$app->session->addFlash('success', Yii::t('app', 'تم حذف مصروف لليوم') . ' ' . $model->selected_date);
        return Yii::$app->runAction('site/view', ['date' => $date]);
    }

    /**
     * Finds the MarketExpense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return MarketExpense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MarketExpense::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
