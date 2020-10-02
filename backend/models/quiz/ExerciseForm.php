<?php

namespace backend\models\quiz;

use common\models\ArticleInfo;
use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%excercise}}".
 *
 * @property int $id
 * @property int $main_category_exercise_id
 * @property string $question
 * @property string $answer_a
 * @property string $answer_b
 * @property string $answer_c
 * @property string $answer_d
 * @property string $correct_answer
 * @property int    $question_type
 *
 * @property StudentAnswers[] $studentAnswers
 */
class ExerciseForm extends \yii\base\Model
{

    public $answer;
    public $question_type;
    public $question;
    public $answer_a;
    public $answer_b;
    public $answer_c;
    public $answer_d;
    public $correct_answer;

    const QUESTION_TYPE_TOW_CHOICE  =  1;
    const QUESTION_TYPE_FOUR_CHOICE =  2;
    const QUESTION_TYPE_TEXT        =  3;

    public $locations;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_exercise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['question_type', 'question', 'correct_answer'], 'required'],
            [['question'], 'string'],
            [['question_type'], 'integer'],
            [['created_at', 'updated_at', 'answer'], 'safe'],
            [['answer_a', 'answer_b', 'answer_c', 'answer_d'], 'string', 'max' => 255],
            [['correct_answer'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'question'                  => Yii::t('app', 'Question'),
            'answer_a'                  => Yii::t('app', 'Answer A'),
            'answer_b'                  => Yii::t('app', 'Answer B'),
            'answer_c'                  => Yii::t('app', 'Answer C'),
            'answer_d'                  => Yii::t('app', 'Answer D'),
            'correct_answer'            => Yii::t('app', 'Correct Answer'),
            'question_type'             => Yii::t('app', 'Question Type'),
            'created_at'                => Yii::t('app', 'Created At'),
            'updated_at'                => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array  $multipleModels
     *
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (!empty($multipleModels))
        {
            $keys           = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post))
        {
            foreach ($post as $i => $item)
            {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']]))
                {
                    $models[] = $multipleModels[$item['id']];
                }
                else
                {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);
        return $models;
    }

    public function setValueFromModelToForm(Excercise $model)
    {
        $this->question                  = $model->question;
        $this->answer_a                  = $model->answer_a;
        $this->answer_b                  = $model->answer_b;
        $this->answer_c                  = $model->answer_c;
        $this->answer_d                  = $model->answer_d;
        $this->correct_answer            = $model->correct_answer;
        $this->question_type             = $model->question_type;
    }
}
