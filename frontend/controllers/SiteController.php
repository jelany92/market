<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\ForgotPasswordForm;
use frontend\models\LoginForm;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

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
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'forgot-password', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['forgot-password', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Index action.
     *
     * @return displays retrurn url on success (Home/Dashboard) or Login form again if login data are invalid or user is inactive
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->redirect(['/site/login']);
        }
        return $this->redirect(['/project/select']);
    }

    /**
     * Login action.
     *
     * @return displays retrurn url on success (Home/Dashboard) or Login form again if login data are invalid or user is inactive
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->redirect(['/project/select']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Logout action.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * user wants to set new password
     *
     * @return \yii\web\Response display view with forgotPassword form
     */
    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::find()->where(['email'=>$model->email])->one();
            if($user instanceof User){
                $user->setForgotPasswordToken();
                $model->sendForgotPasswordMail($user);
            }
            Yii::$app->session->setFlash('success', Yii::t('app','Es wurde Ihnen eine E-Mail mit Informationen zum Zurücksetzen ihres Passworts zugesendet.'));
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
     * @param $token
     *
     * @return string|\yii\web\Response
     */
    public function actionResetPassword($token)
    {
        if (!Yii::$app->getUser()->isGuest) {
            Yii::$app->user->logout();
        }
        try {
            $model = new ResetPasswordForm($token);
        } catch (\InvalidArgumentException $e) {
            Yii::$app->session->setFlash('error', Yii::t('app',"Ungültiger Aktivierungslink, token falsch: $token"));
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app','Neues Passwort wurde gespeichert'));
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
        return $this->render('imprint');
    }

    /**
     * Show terms of service
     *
     * @return string
     */
    public function actionTos()
    {
        header("X-Robots-Tag: noindex, nofollow", true);
        return $this->render('tos');
    }
}
