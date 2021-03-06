<?php

namespace backend\controllers\quiz;

use backend\models\quiz\Excercise;
use backend\models\quiz\QuizAnswerForm;
use backend\models\quiz\StudentAnswers;
use backend\models\quiz\StudentAnswersCrud;
use backend\models\quiz\Students;
use backend\models\quiz\SubmitForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class TokenController extends Controller
{
    /**
     * @inheritdoc
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model   = new SubmitForm();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $session->set('token', $model->token);
            return $this->redirect(['start-excercise']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays Summerize page.
     *
     * @return Response|string
     */
    public function actionSummary()
    {
        $summary  = Students::find()->select('COUNT(id) total_siswa, AVG(score) rata_rata')->where(['is_complete' => true])->asArray()->one();
        $nilaiMin = Students::find()->select('score, name')->asArray()->orderBy('score DESC')->one();
        $nilaiMax = Students::find()->select('score, name')->asArray()->orderBy('score ASC')->one();
        $deviasi  = 0;
        if ($summary['total_siswa'] > 1)
        {
            foreach (Students::find()->select('score')->asArray()->all() as $list)
            {
                $sDev    = pow(($list['score'] - $summary['rata_rata']), 2);
                $deviasi += ($sDev / ($summary['total_siswa'] - 1));
            }
        }
        return $this->render('summary', [
            'summary' => $summary,
            'min'     => $nilaiMax,
            'max'     => $nilaiMin,
            'deviasi' => $deviasi,
        ]);
    }

    /**
     * Displays excercise page.
     *
     * @return string
     */
    public function actionStartExcercise()
    {
        $student = Students::findOne(['token' => Yii::$app->session->get('token')]);
        if (!Yii::$app->session->get('token') || $student->is_complete)
        {
            Yii::$app->getSession()->setFlash('submit', 'Submit was completed');
            return $this->redirect('index');
        }

        $post           = Yii::$app->request->post();
        $modelForm      = [];
        $errorMessage   = [];
        $successMessage = [];
        foreach ($models = Excercise::find()->all() as $model)
        {
            $studentAnswer = StudentAnswersCrud::find()->where([
                                                                   'student_id'   => $student->id,
                                                                   'excercise_id' => $model->id,
                                                               ])->one();
            if (!$studentAnswer)
            {
                $studentAnswer = new StudentAnswersCrud();
            }
            if ($studentAnswer->load($post, $model->id))
            {
                $studentAnswer->student_id   = $student->id;
                $studentAnswer->excercise_id = $model->id;
                if ($studentAnswer->save())
                {
                    $successMessage[] = $model->id;
                }
                else
                {
                    $errorMessage[] = $model->id;
                }
            }

            $modelForm[$model->id] = $studentAnswer;
        }
        if ($successMessage)
        {
            Yii::$app->getSession()->setFlash('success', 'Submit number ' . implode(', ', $successMessage) . ' data was success');
        }
        if (count($successMessage) == Excercise::find()->count())
        {
            $student->sumCorrect();
            Yii::$app->getSession()->setFlash('submit', 'Submit was completed');
            return $this->redirect('index');
        }

        return $this->render('excercise', [
            'models'    => $models,
            'modelForm' => $modelForm,
        ]);
    }


    /**
     * Displays homepage.
     *
     * @param int $mainCategoryExerciseId
     *
     * @return string
     */
    public function actionCreateStudent(int $mainCategoryExerciseId)
    {
        $model = new Students();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->saveStudent();
            Yii::$app->session->addFlash('success', 'done');
            return $this->redirect([
                                       'quiz/token/start-exercise-without-token',
                                       'mainCategoryExerciseId' => $mainCategoryExerciseId,
                                       'token'                  => $model->token,
                                   ]);
        }

        return $this->render('create-student', [
            'model' => $model,
        ]);
    }

    /**
     * @param int    $mainCategoryExerciseId
     * @param string $token
     *
     * @return string|Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionStartExerciseWithoutToken(int $mainCategoryExerciseId, string $token)
    {
        $modelQuizAnswerForm = new QuizAnswerForm();
        $exercises           = Excercise::find()->andWhere(['main_category_exercise_id' => $mainCategoryExerciseId])->createCommand()->queryAll();
        $student             = Students::find()->andWhere(['token' => $token])->one();
        $modelStudentAnswers = StudentAnswers::find()->andWhere(['student_id' => $student->id])->createCommand()->queryAll();
        $studentAnswer       = [];
        if (0 < count($modelStudentAnswers))
        {
            foreach ($modelStudentAnswers as $modelStudentAnswer)
            {
                $studentAnswer[$modelStudentAnswer['excercise_id']] = $modelStudentAnswer['student_answer'];
            }
        }
        if (Yii::$app->request->post('Answers') && $modelQuizAnswerForm->validate())
        {
            if ($student instanceof Students)
            {
                foreach (Yii::$app->request->post('Answers') as $key => $answer)
                {
                    $modelStudentAnswers                 = new StudentAnswers();
                    $modelStudentAnswers->excercise_id   = $key;
                    $modelStudentAnswers->student_id     = $student->id;
                    $modelStudentAnswers->student_answer = $answer;
                }
                $modelStudentAnswers->save();

                $student->is_complete = 1;
                $student->save();
                $student->sumCorrect();
                Yii::$app->getSession()->setFlash('submit', 'Submit was completed');
                return $this->redirect([
                                           'quiz-result',
                                           'studentId' => $student->id,
                                       ]);
            }
            else
            {
                Yii::$app->session->addFlash('error', 'you don�t have a valid token');
                return $this->redirect('index');
            }
        }

        return $this->render('exercise-without-token', [
            'exercises'           => $exercises,
            'token'               => $token,
            'modelQuizAnswerForm' => $modelQuizAnswerForm,
            'studentAnswer'       => $studentAnswer,
            'studentId'           => $student->id,
        ]);
    }

    /**
     * @param $token
     *
     * @return array
     */
    public function actionAjaxNextQuestion($token)
    {
        $student = Students::find()->andWhere(['token' => $token])->one();
        $model   = new StudentAnswers();
        $ajax    = Yii::$app->request->isAjax;
        $post    = Yii::$app->request->post();
        if ($ajax)
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->validate())
            {
                foreach ($post['Answers'] as $key => $answer)
                {
                    $modelStudentAnswer = StudentAnswers::findOne(['excercise_id' => $key]);
                    if ($modelStudentAnswer instanceof StudentAnswers)
                    {
                        if ($modelStudentAnswer->student_answer != $answer)
                        {
                            $modelStudentAnswer->student_answer = $answer;
                            $modelStudentAnswer->save();
                        }
                    }
                    else
                    {
                        $model->excercise_id   = $key;
                        $model->student_id     = $student->id;
                        $model->student_answer = $answer;
                        $model->save();
                    }
                }
                return [
                    'data' => [
                        'success' => true,
                        'model'   => $model,
                        'message' => 'Model has been saved.',
                    ],
                    'code' => 0,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'model'   => null,
                        'message' => 'An error occured.',
                    ],
                    'code' => 1,
                ];
            }
        }
    }

    /**
     * @param int $studentId
     *
     * @return string
     */
    public function actionQuizResult(int $studentId): string
    {
        $queryStudentAnswer  = StudentAnswers::find()->andWhere(['student_id' => $studentId]);
        $dataProvider        = new ActiveDataProvider([
                                                          'query' => $queryStudentAnswer,
                                                      ]);
        $modelStudentAnswers = $queryStudentAnswer->one();
        $correctAnswer       = $modelStudentAnswers->student->correct_answer;

        return $this->render('quiz-result', [
            'dataProvider'  => $dataProvider,
            'correctAnswer' => $correctAnswer,
        ]);
    }

}
