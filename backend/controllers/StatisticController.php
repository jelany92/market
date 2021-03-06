<?php

namespace backend\controllers;

use backend\models\MarketExpense;
use backend\models\Purchases;
use common\components\QueryHelper;
use common\controller\BaseController;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class StatisticController extends BaseController
{
    public function actionMonthIncome($year, $month)
    {
        $dailyInfo                   = QueryHelper::getDailyInfo($year, $month, 'incoming_revenue', 'daily_incoming_revenue', 'id');
        $dataProviderIncomingRevenue = new ArrayDataProvider
        ([
             'allModels'  => $dailyInfo,
             'pagination' => false,
         ]);

        return $this->render('month-details/income', [
            'month'                => $month,
            'year'                 => $year,
            'modelIncomingRevenue' => $dataProviderIncomingRevenue,
            'queryDailyInfo'       => $dailyInfo,
        ]);
    }

    public function actionMonthPurchases($year, $month)
    {
        $dataProviderPurchases = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'purchases', 'purchases', 'reason'),
             'pagination' => false,
         ]);


        return $this->render('month-details/purchases', [
            'month'          => $month,
            'year'           => $year,
            'modelPurchases' => $dataProviderPurchases,
        ]);
    }

    public function actionMonthPurchasesGroup($year, $month)
    {
        $dataProviderPurchasesGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month, 'reason'),
             'pagination' => false,
         ]);
        return $this->render('month-details/purchases-group', [
            'month'                      => $month,
            'year'                       => $year,
            'dataProviderPurchasesGroup' => $dataProviderPurchasesGroup,
        ]);
    }

    public function actionMonthMarketExpense($year, $month)
    {
        $staticDailyInfoMarketExpenseList = QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason', '');
        $dataProviderMarketExpense        = new ArrayDataProvider
        ([
             'allModels'  => $staticDailyInfoMarketExpenseList,
             'pagination' => false,
         ]);

        return $this->render('month-details/market-expense', [
            'month'                            => $month,
            'year'                             => $year,
            'dataProviderMarketExpense'        => $dataProviderMarketExpense,
            'staticDailyInfoMarketExpenseList' => $staticDailyInfoMarketExpenseList,
        ]);
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return string
     */
    public function actionMonthDailyResult(int $year, int $month)
    {
        $dataProviderDailyCash = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getResult($year, $month),
             'pagination' => false,
         ]);

        return $this->render('month-details/daily-result', [
            'month'                 => $month,
            'year'                  => $year,
            'dataProviderDailyCash' => $dataProviderDailyCash,
        ]);
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return string
     */
    public function actionBreadGain(int $year, int $month)
    {
        $from       = $year . '-' . $month . '-01';
        $to         = date("Y-m-t", strtotime($from));
        $breadCount = QueryHelper::sumsSearchResult('purchases', 'purchases', 'reason', 'خبز', $from, $to);

        return $this->render('month-details/bread-gain', [
            'month'      => $month,
            'year'       => $year,
            'breadCount' => $breadCount,
        ]);
    }


    public function actionYearIncome(int $year)
    {
        $yearData = QueryHelper::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue');
        $provider = new ArrayDataProvider([
                                              'allModels' => $yearData,
                                          ]);
        for ($month = 1; $month <= 12; $month++)
        {
            $modelIncomingRevenue[] = [QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue')];
        }
        $dataProvider = new ArrayDataProvider([
                                                  'allModels'  => $modelIncomingRevenue,
                                                  'pagination' => false,
                                              ]);

        return $this->render('year-details/income', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'dataProvider'           => $dataProvider,
        ]);
    }


    public function actionYearPurchases($year)
    {
        $yearData = QueryHelper::getYearData($year, 'purchases', 'purchases');
        $provider = new ArrayDataProvider([
                                              'allModels' => $yearData,
                                          ]);
        for ($month = 1; $month <= 12; $month++)
        {
            $modelIncomingRevenue[] = [QueryHelper::getMonthData($year, $month, 'purchases', 'purchases')];
        }

        $dataProvider = new ArrayDataProvider([
                                                  'allModels'  => $modelIncomingRevenue,
                                                  'pagination' => false,
                                              ]);

        return $this->render('year-details/purchases', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'dataProvider'           => $dataProvider,
        ]);
    }

    public function actionYearMarketExpense($year)
    {
        $yearData = QueryHelper::getYearData($year, 'market_expense', 'expense');
        $provider = new ArrayDataProvider([
                                              'allModels' => $yearData,
                                          ]);
        for ($month = 1; $month <= 12; $month++)
        {
            $modelIncomingRevenue[] = [QueryHelper::getMonthData($year, $month, 'market_expense', 'expense')];
        }

        $dataProvider = new ArrayDataProvider([
                                                  'allModels'  => $modelIncomingRevenue,
                                                  'pagination' => false,
                                              ]);

        return $this->render('year-details/market-expense', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'dataProvider'           => $dataProvider,
        ]);
    }
}