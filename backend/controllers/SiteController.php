<?php

namespace backend\controllers;

use backend\components\DummyData;
use backend\models\Capital;
use backend\models\EstablishMarket;
use backend\models\ForgotPasswordForm;
use backend\models\IncomingRevenue;
use backend\models\LoginForm;
use backend\models\MarketExpense;
use backend\models\PurchaseInvoices;
use backend\models\Purchases;
use backend\models\ResetPasswordForm;
use backend\models\TaxOffice;
use common\components\QueryHelper;
use common\models\AdminUser;
use common\models\ArticleInfo;
use common\models\auth\AuthAssignment;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'error',
                            'create-company',
                        ],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'demo-data',
                            'index',
                            'get-events',
                            'view',
                            'month-view',
                            'month-income',
                            'month-view-pdf',
                            'year-view',
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDemoData()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $userId            = Yii::$app->user->id;
            $dummyDateCategory = DummyData::getDummyDateMainCategory($userId);
            //insert category (category)
            Yii::$app->db->createCommand()->batchInsert(MainCategory::tableName(), array_keys($dummyDateCategory[0]), $dummyDateCategory)->execute();

            $categoryId           = Yii::$app->db->getLastInsertID();
            $dummyDateArticleInfo = DummyData::getDummyDateArticleInfo($userId, $categoryId);
            Yii::$app->db->createCommand()->batchInsert(ArticleInfo::tableName(), array_keys($dummyDateArticleInfo[0]), $dummyDateArticleInfo)->execute();

            $dummyDateCapital = DummyData::getDummyDataCapital($userId);
            Yii::$app->db->createCommand()->batchInsert(Capital::tableName(), array_keys($dummyDateCapital[0]), $dummyDateCapital)->execute();

            $dummyDateIncomingRevenue = DummyData::getDummyDataIncomingRevenue($userId);
            Yii::$app->db->createCommand()->batchInsert(IncomingRevenue::tableName(), array_keys($dummyDateIncomingRevenue[0]), $dummyDateIncomingRevenue)->execute();

            $dummyDateMarketExpense = DummyData::getDummyDataMarketExpense($userId);
            Yii::$app->db->createCommand()->batchInsert(MarketExpense::tableName(), array_keys($dummyDateMarketExpense[0]), $dummyDateMarketExpense)->execute();

            $dummyDatePurchases = DummyData::getDummyDataPurchases($userId);
            Yii::$app->db->createCommand()->batchInsert(Purchases::tableName(), array_keys($dummyDatePurchases[0]), $dummyDatePurchases)->execute();

            $dummyDatePurchaseInvoices = DummyData::getDummyDataPurchaseInvoices($userId);
            Yii::$app->db->createCommand()->batchInsert(PurchaseInvoices::tableName(), array_keys($dummyDatePurchaseInvoices[0]), $dummyDatePurchaseInvoices)->execute();

            $dummyDateTaxOffice = DummyData::getDummyDataTaxOffice($userId);
            Yii::$app->db->createCommand()->batchInsert(TaxOffice::tableName(), array_keys($dummyDateTaxOffice[0]), $dummyDateTaxOffice)->execute();

            Yii::$app->session->addFlash('success', Yii::t('app', 'تم اضافة معلومات وهمية للمتجر'));
            $transaction->commit();
        }
        catch (\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Displays homepage.
     *
     * @param int    $mainCategory mainCategoryId
     * @param int    $subcategory  subcategoryId
     * @param string $author       authorName
     *
     * @return string
     */
    public function actionIndex(int $mainCategory = null, int $subcategory = null, string $author = null): string
    {
        $userId         = Yii::$app->user->id;
        $modelUserModel = AdminUser::find()->andWhere(['id' => $userId])->one();
        if ($modelUserModel->category == AdminUser::MARKET_PROJECT)
        {
            $staticDailyInfoIncomingList      = QueryHelper::getDailyInfo(date('Y'), date('m'), 'incoming_revenue', 'daily_incoming_revenue', 'id');
            $staticDailyInfoMarketExpenseList = QueryHelper::getDailyInfo(date('Y'), date('m'), 'market_expense', 'expense', 'id', 'selected_date');
            $staticDailyInfoPurchasesList     = QueryHelper::getDailyInfo(date('Y'), date('m'), 'purchases', 'purchases', 'id', 'selected_date');
            return $this->render('supermarket/market', [
                'staticDailyInfoIncomingList'      => $staticDailyInfoIncomingList,
                'staticDailyInfoMarketExpenseList' => $staticDailyInfoMarketExpenseList,
                'staticDailyInfoPurchasesList'     => $staticDailyInfoPurchasesList,

            ]);
        }
        if ($modelUserModel->category == AdminUser::YII_LEARN)
        {
            $this->layout = 'mainLearn';
            return $this->render('learn/index', []);
        }
        if ($modelUserModel->category == AdminUser::BOOK_GALLERY_PROJECT)
        {
            $this->layout = 'mainGalleryBook';
            if (isset($mainCategory))
            {
                $modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere([
                                                                                        //'company_id'       => Yii::$app->user->id,
                                                                                        'main_category_id' => $mainCategory,
                                                                                    ]);
            }
            elseif (isset($subcategory))
            {
                $modelDetailGalleryArticle = DetailGalleryArticle::find()->innerJoinWith('gallerySaveCategory')->andWhere([
                                                                                                                              //'company_id'     => Yii::$app->user->id,
                                                                                                                              'subcategory_id' => $subcategory,
                                                                                                                          ]);
            }
            elseif (isset($author))
            {
                $modelDetailGalleryArticle = DetailGalleryArticle::find()->innerJoinWith('bookGalleries')->innerJoinWith('bookAuthorName')->andWhere([
                                                                                                                                                         //'company_id'     => Yii::$app->user->id,
                                                                                                                                                         'like',
                                                                                                                                                         'name',
                                                                                                                                                         $author,
                                                                                                                                                     ]);
            }
            else
            {
                $modelDetailGalleryArticle = DetailGalleryArticle::find();
                //->andWhere(['company_id' => Yii::$app->user->id]);

            }
            $pages = new Pagination(['totalCount' => $modelDetailGalleryArticle->count()]);
            $modelDetailGalleryArticle->offset($pages->offset)->limit($pages->limit);
            return $this->render('book-gallery', [
                'modelDetailGalleryArticle' => $modelDetailGalleryArticle->all(),
                'pages'                     => $pages,
            ]);
        }
        return $this->render('supermarket/market', [

        ]);
    }


    /**
     * @return array
     */
    public function actionGetEvents(): array
    {
        if (!(Yii::$app->request->isAjax))
        {
            die();
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $incomingRevenues            = IncomingRevenue::find()->userId(Yii::$app->user->id)->all();
        $purchases                   = Purchases::find()->userId(Yii::$app->user->id)->all();
        $marketExpense               = MarketExpense::find()->userId(Yii::$app->user->id)->all();
        $events                      = [];

        // Zeigt all ArbeitsZeit für eingeloggt user von wann bis wann
        foreach ($incomingRevenues as $time)
        {
            $Event         = new \yii2fullcalendar\models\Event();
            $Event->id     = $time->id;
            $Event->title  = 'الايراد: ' . $time->daily_incoming_revenue;
            $Event->start  = $time->selected_date;
            $Event->color  = '#36a6fc';
            $Event->allDay = true;
            $events[]      = $Event;
        }

        foreach ($incomingRevenues as $time)
        {
            $manyPurchasesInOneDay = (new Query())->from(['purchases'])->select(['result' => 'SUM(purchases)'])->andWhere([
                                                                                                                              'selected_date' => $time['selected_date'],
                                                                                                                              'company_id'    => Yii::$app->user->id,
                                                                                                                          ])->one();
            $expense               = (new Query())->from(['market_expense'])->select(['result' => 'SUM(expense)'])->andWhere([
                                                                                                                                 'selected_date' => $time['selected_date'],
                                                                                                                                 'company_id'    => Yii::$app->user->id,
                                                                                                                             ])->one();
            $dailyResult           = $time->daily_incoming_revenue - $manyPurchasesInOneDay['result'] - $expense['result'];
            $resultSum             = $dailyResult;
            $Event                 = new \yii2fullcalendar\models\Event();
            $Event->id             = $time['id'];
            $Event->title          = 'الناتج اليومي: ' . $resultSum;
            $Event->start          = $time['selected_date'];
            $Event->color          = '#03c94c'; // green
            $Event->allDay         = true;
            $events[]              = $Event;
        }

        foreach ($purchases as $time)
        {
            $Event         = new \yii2fullcalendar\models\Event();
            $Event->id     = $time->id;
            $Event->title  = $time->reason . ': ' . $time->purchases;
            $Event->start  = $time->selected_date;
            $Event->color  = '#ff6666';
            $Event->allDay = true;
            $events[]      = $Event;
        }

        foreach ($marketExpense as $time)
        {
            $Event         = new \yii2fullcalendar\models\Event();
            $Event->id     = $time->id;
            $Event->title  = $time->reason . ': ' . $time->expense;
            $Event->start  = $time->selected_date;
            $Event->color  = '#ffc133';
            $Event->allDay = true;
            $events[]      = $Event;
        }

        return $events;
    }

    /**
     * Ansicht für Monat
     *
     * @param $year
     * @param $month
     * @param $year
     * @param $month
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionMonthView($year, $month, $view = 'supermarket/month')
    {
        $provider                    = new ArrayDataProvider([
                                                                 'allModels' => QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue'),
                                                             ]);
        $dataProviderIncomingRevenue = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'incoming_revenue', 'daily_incoming_revenue', 'id'),
             'pagination' => false,
         ]);
        $dataProviderPurchases       = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'purchases', 'purchases', 'reason'),
             'pagination' => false,
         ]);

        $dataProviderMarketExpense = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason'),
             'pagination' => false,
         ]);

        $dailyIncomingRevenue  = QueryHelper::getResult($year, $month);
        $dataProviderDailyCash = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getResult($year, $month),
             'pagination' => false,
         ]);

        $dataProviderMarketExpenseGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(MarketExpense::tableName(), 'expense', $year, $month, 'reason'),
             'pagination' => false,
         ]);

        $dataProviderPurchasesGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month, 'reason'),
             'pagination' => false,
         ]);

        return $this->render($view, [
            'statistikMonatProvider'         => $provider,
            'month'                          => $month,
            'year'                           => $year,
            'modelIncomingRevenue'           => $dataProviderIncomingRevenue,
            'modelPurchases'                 => $dataProviderPurchases,
            'dataProviderMarketExpense'      => $dataProviderMarketExpense,
            'dataProviderMarketExpenseGroup' => $dataProviderMarketExpenseGroup,
            'dataProviderPurchasesGroup'     => $dataProviderPurchasesGroup,
            'dataProviderDailyCash'          => $dataProviderDailyCash,
        ]);
    }

    /**
     * @param $year
     * @param $month
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionMonthViewPdf($year, $month)
    {
        $date                      = date('d.m.Y');
        $dataProviderMarketExpense = QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason');
        $content                   = $this->render('supermarket/month-pdf', [
            'year'                      => $year,
            'month'                     => $month,
            'dataProviderMarketExpense' => $dataProviderMarketExpense,
        ]);
        $pdf                       = Yii::$app->pdf;
        $mpdf                      = $pdf->api;
        $mpdf->SetHeader($date . ' Kattan Shop');
        print_r($content);
        die();
        $mpdf->WriteHtml($content);
        return $mpdf->Output($date, 'D');

    }

    /**
     * Ansicht für Jahr
     *
     * @param $year
     *
     * @return string
     * @throws \Exception
     */
    public function actionYearView($year)
    {
        $monthData = QueryHelper::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue');
        $provider  = new ArrayDataProvider([
                                               'allModels' => $monthData,
                                           ]);
        for ($month = 1; $month <= 12; $month++)
        {
            $modelIncomingRevenue[] = [QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue')];
        }
        $dataProvider = new ArrayDataProvider([
                                                  'allModels'  => $modelIncomingRevenue,
                                                  'pagination' => false,
                                              ]);

        return $this->render('supermarket/year', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'dataProvider'           => $dataProvider,
        ]);
    }

    /**
     * @param string $date
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionView(string $date): string
    {

        $date = \DateTime::createFromFormat('Y-m-d', $date);
        if (!($date instanceof \DateTime))
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $dataProvider = new ArrayDataProvider
        ([
             'allModels'  => IncomingRevenue::getDailyInformation($date->format('Y-m-d')),
             'pagination' => false,
         ]);
        Yii::$app->session->set('returnDate', $date->format('Y-m-d'));
        $showIncomingRevenue     = true;
        $isIncomingRevenueIWrote = IncomingRevenue::find()->forDate($date)->userId(Yii::$app->user->id)->exists();
        if ($isIncomingRevenueIWrote)
        {
            $showIncomingRevenue = false;
        }
        $dailyResult                      = QueryHelper::getDailySum($date);
        $establishMarketAmount            = EstablishMarket::find()->select(['amount' => 'sum(amount)'])->andWhere(['company_id' => Yii::$app->user->id])->createCommand()->queryOne();
        $staticDailyInfoIncomingList      = QueryHelper::getDailyInfo($date->format('Y'), $date->format('m'), 'incoming_revenue', 'daily_incoming_revenue', 'id');
        $staticDailyInfoMarketExpenseList = QueryHelper::getDailyInfo($date->format('Y'), $date->format('m'), 'market_expense', 'expense', 'id', 'selected_date');
        $staticDailyInfoPurchasesList     = QueryHelper::getDailyInfo($date->format('Y'), $date->format('m'), 'purchases', 'purchases', 'id', 'selected_date');
        return $this->render('supermarket/view', [
            'date'                             => $date->format('Y-m-d'),
            'showCreateIncomingRevenue'        => $showIncomingRevenue,
            'dataProvider'                     => $dataProvider,
            'dailyResult'                      => $dailyResult,
            'establishMarketAmount'            => $establishMarketAmount,
            'staticDailyInfoIncomingList'      => $staticDailyInfoIncomingList,
            'staticDailyInfoMarketExpenseList' => $staticDailyInfoMarketExpenseList,
            'staticDailyInfoPurchasesList'     => $staticDailyInfoPurchasesList,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تسحيل الدخول'));
            return $this->goBack();
        }
        else
        {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * create customer action.
     *
     * @return string
     */
    function actionCreateCompany()
    {
        $modelAdminUser              = new AdminUser();
        $date                        = new \DateTime();
        $modelAdminUser->active_from = $date->format('Y-m-d H:i');
        $modelAdminUser->category    = 'Market';
        if ($modelAdminUser->load(Yii::$app->request->post()) && $modelAdminUser->validate())
        {
            $modelAdminUser->password = Yii::$app->security->generatePasswordHash($modelAdminUser->password);
            $modelAdminUser->save();
            $modelAdminUser->checkAndWriteAssignment('admin-market');
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء حساب جديد'));
            return $this->render('login', [
                'model' => new LoginForm(),
            ]);
        }

        return $this->render('create-company', [
            'model' => $modelAdminUser,
        ]);
    }

    /**
     * user wants to set new password
     *
     * @return display view with forgotPassword form
     */
    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user = AdminUser::find()->where(['email' => $model->email])->one();
            if ($user instanceof AdminUser && $user->isActive())
            {
                $user->setForgotPasswordToken();
                $model->sendForgotPasswordMail($user);
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Es wurde Ihnen eine E-Mail mit Informationen zum Zurücksetzen ihres Passworts zugesendet.'));
            $model->email = '';
        }
        return $this->render('forgotPassword', [
            'model' => $model,
        ]);
    }


    /**
     * Resets password.
     * Initiated by user email's link
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        if (!Yii::$app->getUser()->isGuest)
        {
            Yii::$app->user->logout();
        }
        try
        {
            $model = new ResetPasswordForm($token);
        }
        catch (InvalidArgumentException $e)
        {
            Yii::$app->session->setFlash('error', Yii::t('app', "Ungültiger Aktivierungslink, token falsch: $token"));
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword())
        {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Neues Passwort wurde gespeichert'));
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * Show imprint
     *
     * @return string
     */
    public function actionImprint()
    {
        header("X-Robots-Tag: noindex, nofollow", true);
        return $this->render('@frontend/views/site/imprint');
    }

    /**
     * Show terms of service
     *
     * @return string
     */
    public function actionTos()
    {
        header("X-Robots-Tag: noindex, nofollow", true);
        return $this->render('@frontend/views/site/tos');
    }
}
