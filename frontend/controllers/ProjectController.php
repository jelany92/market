<?php

namespace frontend\controllers;

use common\components\ImageCarouselHelper;
use common\models\Answer;
use common\models\BaseData;
use common\models\BaseDataForm;
use common\models\Category;
use common\models\CategoryFunctionAnswer;
use common\models\Component;
use common\models\FunctionImage;
use common\models\queries\CategoryFunctionAnswerQuery;
use frontend\models\ProjectSelectForm;
use Yii;
use yii\bootstrap4\Carousel;
use yii\bootstrap4\Html;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class ProjectController extends Controller
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
            'index' => [
                'class' => 'frontend\controllers\projectController\CreateAction',
                'view'  => 'index',
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
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
     *
     *
     * @return string|\yii\web\Response
     */
    public function actionSelect()
    {
        $model = new ProjectSelectForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $baseData = $model->loadBaseData();
            return $this->redirect([
                '/project/details',
                'key' => $baseData->public_key,
            ]);
        }

        return $this->render('select', [
            'model' => $model,
        ]);
    }

    /**
     * @param $key
     *
     * @return string|\yii\web\Response
     */
    public function actionDetails($key)
    {
        $baseData = $this->findBaseDataModel($key);
        $model    = new BaseDataForm($baseData);
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $baseData = $model->saveBaseData();
            if ($baseData instanceof BaseData)
            {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Projektdetails wurden aktualisiert'));
                return $this->redirect([
                    'details',
                    'key' => $baseData->public_key,
                ]);
            }
            else
            {
                Yii::$app->session->addFlash('error', Yii::t('app', 'Projektdetails konnten nicht aktualisiert werden'));
            }
        }
        $categoryList           = Category::find()->companyType($baseData->companyType)->active()->orderBy('sort')->all();
        $answerList             = CategoryFunctionAnswer::getAnswers($baseData);
        $firstAnswerPerFunction = CategoryFunctionAnswer::getFirstAnswerForEachFunction($baseData);
        return $this->render('details', [
            'model'                  => $model,
            'dataKey'                => $key,
            'categoryList'           => $categoryList,
            'answerList'             => $answerList,
            'firstAnswerPerFunction' => $firstAnswerPerFunction,
        ]);
    }


    /**
     * Ajax action to save answers
     */
    public function actionSaveAnswer()
    {
        if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax)
        {
            $categoryList = Yii::$app->request->post('cIdList');
            $testCriteria = Yii::$app->request->post('testCriteria');
            $baseData     = BaseData::find()->andWhere(['public_key' => Yii::$app->request->post('dataKey')])->one();
            $function     = Component::find()->andWhere(['id' => Yii::$app->request->post('fId')])->one();
            $answer       = Answer::find()->andWhere(['id' => Yii::$app->request->post('value')])->one();
            if ($baseData instanceof BaseData && $function instanceof Component && $answer instanceof Answer && is_array($categoryList))
            {
                $categories = Category::find()->andWhere(['id' => $categoryList])->orderBy(new Expression('FIELD (id, ' . implode(',', $categoryList) . ')'))->all();
                foreach ($categories as $category)
                {
                    $answerModel = CategoryFunctionAnswer::find()->andWhere([
                        'base_data_id' => $baseData->id,
                        'category_id'  => $category->id,
                        'function_id'  => $function->id,
                    ])->one();
                    if (!($answerModel instanceof CategoryFunctionAnswer))
                    {
                        $answerModel               = new CategoryFunctionAnswer();
                        $answerModel->base_data_id = $baseData->id;
                        $answerModel->category_id  = $category->id;
                        $answerModel->function_id  = $function->id;
                    }
                    $answerModel->answer_id     = $answer->id;
                    $answerModel->test_criteria = $testCriteria;
                    $answerModel->save();
                }
            }
        }
    }

    /**
     * Ajax action to save SaveCheckbox
     */
    public function actionSaveCheckboxType()
    {
        if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax)
        {
            $testCriteria                               = Yii::$app->request->post('testCriteria');
            $explain                                    = Yii::$app->request->post('explain');
            $baseData                                   = BaseData::find()->andWhere(['public_key' => Yii::$app->request->post('dataKey')])->one();
            $function                                   = Component::find()->andWhere(['id' => Yii::$app->request->post('fId')])->one();
            $modelCategoryFunctionAnswer                = CategoryFunctionAnswer::find()->andWhere([
                'base_data_id' => $baseData->id,
                'function_id'  => $function,
            ])->one();
            $modelCategoryFunctionAnswer->test_criteria = $testCriteria;
            $modelCategoryFunctionAnswer->explain = $explain;
            $modelCategoryFunctionAnswer->save();
        }
    }

    public function actionLoadImageCarousel()
    {
        $functionId = Yii::$app->request->post('id');
        if (Yii::$app->request->isAjax && isset($functionId))
        {
            $function      = $this->findFunctionModel($functionId);
            $imageElements = [];
            foreach ($function->functionImages as $functionImage)
            {
                /* @var $functionImage FunctionImage */
                $imageElements[] = Html::img(Yii::$app->urlManager->createUrl($functionImage->getFullFileNameAndPath(FunctionImage::PREFIX_ORIGINAL)));
            }
            $container = "<div class=\"modal-contained-div modal-contained-backdrop\" id=\"modal-function-$function->id\" style=\"display: none\">%s</div>";
            return sprintf($container, Carousel::widget([
                'options'  => [
                    'data-interval' => 'false',
                    'id'            => "carousel-$function->id",
                ],
                'items'    => $imageElements,
                'controls' => [
                    '<img class="presentation-carousel-control" src="' . Yii::$app->urlManager->createUrl('images/chevron-left.png') . '">',
                    '<img class="presentation-carousel-control" src="' . Yii::$app->urlManager->createUrl('images/chevron-right.png') . '">',
                ],
            ]));
        }
        throw new BadRequestHttpException(Yii::t('app', 'Ungültige Anfrage'));
    }

    /**
     * Finds the Component model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Component the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findFunctionModel($id)
    {
        if (($model = Component::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the BaseData model based on its publicKey.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $publicKey
     *
     * @return BaseData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findBaseDataModel($publicKey)
    {
        if (($model = BaseData::find()->andWhere(['public_key' => $publicKey])->one()) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
