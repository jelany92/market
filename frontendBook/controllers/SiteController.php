<?php

namespace frontendBook\controllers;

use common\models\AdminUser;
use common\models\BookAuthorName;
use common\models\BookGallery;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use common\models\Subcategory;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
                'only'  => [
                    'logout',
                    'signup',
                ],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $mainCategories            = MainCategory::find()->andWhere(['company_id' => 2])->all();
        $modelDetailGalleryArticle = DetailGalleryArticle::find()->limit(8)->all();
        $modelBookAuthorName       = BookAuthorName::find()->limit(3)->all();
        $authorNames               = [];
        $detailGalleryArticleList  = [];
        foreach ($modelBookAuthorName as $bookAuthorName)
        {
            $authorNames[] = $bookAuthorName->name;
            foreach ($bookAuthorName->bookGalleries as $bookGallery)
            {
                $detailGalleryArticleList[] = $bookGallery->detailGalleryArticle;
                //var_dump($detailGalleryArticleList);
            }
        }

        //die();
        //var_dump($detailGalleryArticleList);
        return $this->render('index', [
            'mainCategories'            => $mainCategories,
            'modelDetailGalleryArticle' => $modelDetailGalleryArticle,
            'modelBookAuthorName'       => $modelBookAuthorName,
            'authorNames'               => $authorNames,
            'detailGalleryArticleList'  => $detailGalleryArticleList,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @param int      $mainCategoryId
     * @param int|null $subcategoryId
     * @param int|null $date
     *
     * @return mixed
     */
    public function actionMainCategory(int $mainCategoryId, int $subcategoryId = null, int $date = null)
    {
        //dd($date);
        $ajax = Yii::$app->request->isAjax;
        $post = Yii::$app->request->post();
        if ($ajax)
        {
            dd($ajax, $post);
        }
        $modelDetailGalleryArticle = DetailGalleryArticle::find();
        if (isset($subcategoryId))
        {
            $modelDetailGalleryArticle->innerJoinWith('gallerySaveCategory')->andWhere(['gallery_save_category.subcategory_id' => $subcategoryId]);
        }
        if (isset($date))
        {
            $modelDetailGalleryArticle->andWhere([
                                                     'YEAR(selected_date)' => $date,
                                                 ]);
        }
        $modelDetailGalleryArticle->andWhere([
                                                 'detail_gallery_article.company_id'       => AdminUser::JELANY_BOOK_CATEGORY,
                                                 'detail_gallery_article.main_category_id' => $mainCategoryId,
                                             ]);
        $mainCategoryList = MainCategory::getMainCategoryList(AdminUser::JELANY_BOOK_CATEGORY);
        $subcategoryList  = Subcategory::getSubcategoryList($mainCategoryId, AdminUser::JELANY_BOOK_CATEGORY);
        $dateList         = DetailGalleryArticle::find()->select([
                                                                     'YEAR(selected_date)',
                                                                     'date' => 'YEAR(selected_date)',
                                                                 ])->andWhere([
                                                                                  'and',
                                                                                  ['company_id' => AdminUser::JELANY_BOOK_CATEGORY],
                                                                                  [
                                                                                      'not',
                                                                                      ['selected_date' => null],
                                                                                  ],
                                                                              ])->groupBy('selected_date')->orderBy(['selected_date' => SORT_DESC])->distinct(true)->createCommand()->queryAll(\PDO::FETCH_KEY_PAIR, \PDO::FETCH_COLUMN);
        return $this->render('main-category', [
            'mainCategoryId'            => $mainCategoryId,
            'subcategoryId'             => $subcategoryId,
            'date'                      => $date,
            'modelDetailGalleryArticle' => $modelDetailGalleryArticle->all(),
            'mainCategoryList'          => $mainCategoryList,
            'subcategoryList'           => $subcategoryList,
            'dateList'                  => $dateList,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->sendEmail(Yii::$app->params['adminEmail']))
            {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }
        else
        {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionCategory(int $id)
    {
        return $this->render('category', [
            'categoryId' => $id,
        ]);
    }

    /**
     * Signs user up.
     *Statistiken F�r ganze Monat
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            var_dump($hash);
            die();
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->sendEmail())
            {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try
        {
            $model = new ResetPasswordForm($token);
        }
        catch (InvalidArgumentException $e)
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword())
        {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     *
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try
        {
            $model = new VerifyEmailForm($token);
        }
        catch (InvalidArgumentException $e)
        {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail())
        {
            if (Yii::$app->user->login($user))
            {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->sendEmail())
            {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model,
        ]);
    }
}
