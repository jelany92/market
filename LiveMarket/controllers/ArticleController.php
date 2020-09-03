<?php

namespace LiveMarket\controllers;

use common\models\ArticleInfo;
use common\models\LoginForm;
use common\models\MainCategory;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ArticleController extends Controller
{
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
        return $this->render('view', [
            'model'                    => $this->findModel($id),
            'dataProviderArticlePrice' => $dataProviderArticlePrice,
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
