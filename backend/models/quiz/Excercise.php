<?php

namespace backend\models\quiz;

use common\models\ArticleInfo;
use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\ActiveQuery;

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
 * @property string $created_at
 * @property string $updated_at
 *
 * @property StudentAnswers[] $studentAnswers
 */
class Excercise extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    public $answer;

    const QUESTION_TYPE_TOW_CHOICE  =  1;
    const QUESTION_TYPE_FOUR_CHOICE =  2;
    const QUESTION_TYPE_TEXT        =  3;
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
            [['question_type', 'question', 'correct_answer'], 'required'],
            [['question'], 'string'],
            [['question_type'], 'integer'],
            [['created_at', 'updated_at', 'answer'], 'safe'],
            [['answer_a', 'answer_b', 'answer_c', 'answer_d'], 'string', 'max' => 255],
            [['correct_answer'], 'string', 'max' => 10],
            [['main_category_exercise_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategoryExercise::class, 'targetAttribute' => ['main_category_exercise_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'main_category_exercise_id' => Yii::t('app', 'main_category_exercise_id'),
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
     * Gets query for [[MainCategoryExercise]].
     *
     * @return ActiveQuery
     */
    public function getMainCategoryExercise() : ActiveQuery
    {
        return $this->hasOne(MainCategoryExercise::class, ['id' => 'main_category_exercise_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudentAnswers() : ActiveQuery
    {
        return $this->hasMany(StudentAnswers::class, ['excercise_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getQuestionType() : array
    {
        return [
            self::QUESTION_TYPE_TOW_CHOICE  => Yii::t('app', 'Tow Choice'),
            self::QUESTION_TYPE_FOUR_CHOICE => Yii::t('app', 'Four Choice'),
            self::QUESTION_TYPE_TEXT        => Yii::t('app', 'Text'),
        ];
    }

    /**
     * @return array
     */
    public static function getDefaultAnswerList()
    {
        return [
            'right'  => Yii::t('app', 'True or False'),
        ];
    }

    /**
     * @param string|null $questionType
     * @return array|string[]
     */
    public static function getCorrectAnswerOptionList(string $questionType = null): array
    {
        if ($questionType == self::QUESTION_TYPE_TOW_CHOICE)
        {
            $correctAnswer = [
                'answer_a'=> 'A',
                'answer_b'=> 'B',
            ];
        }
        else if ($questionType == self::QUESTION_TYPE_FOUR_CHOICE)
        {
            $correctAnswer = [
                'answer_a' => 'A',
                'answer_b' => 'B',
                'answer_c' => 'C',
                'answer_d' => 'D',
            ];
        }
        else if ($questionType == self::QUESTION_TYPE_TEXT)
        {
            $correctAnswer = [];
        }
        return $correctAnswer;
    }

    /**
     * @param string $questionType
     *
     * @return array
     */
    public static function getCorrectAnswerOption(string $questionType): array
    {
        if ($questionType == self::QUESTION_TYPE_TOW_CHOICE)
        {
            $correctAnswer = [
                ['id' => 'answer_a', 'name' => 'A'],
                ['id' => 'answer_b', 'name' => 'B'],
            ];
        }
        else if ($questionType == self::QUESTION_TYPE_FOUR_CHOICE)
        {
            $correctAnswer = [

                ['id' => 'answer_a', 'name' => 'A'],
                ['id' => 'answer_b', 'name' => 'B'],
                ['id' => 'answer_c', 'name' => 'C'],
                ['id' => 'answer_d', 'name' => 'D'],
            ];
        }
        else if ($questionType == self::QUESTION_TYPE_TEXT)
        {
            $correctAnswer = [

            ];
        }
        return $correctAnswer;
    }

    public function setValueFromFormToModel($modelForm)
    {
        $this->question                  = $modelForm->question;
        $this->answer_a                  = $modelForm->answer_a;
        $this->answer_b                  = $modelForm->answer_b;
        $this->answer_c                  = $modelForm->answer_c;
        $this->answer_d                  = $modelForm->answer_d;
        $this->correct_answer            = $modelForm->correct_answer;
        $this->question_type             = $modelForm->question_type;
        $this->save();
        var_dump($this->question, $modelForm->question);die();
    }
}
