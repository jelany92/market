<?php

namespace common\models;

use common\models\queries\CategoryFunctionAnswerQuery;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "category_function_answer".
 *
 * @property int $id
 * @property int $base_data_id
 * @property int $category_id
 * @property int $function_id
 * @property int $answer_id
 * @property int $test_criteria
 * @property int $explain
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BaseData $baseData
 * @property Answer $answer
 * @property Category $category
 * @property Component $component
 */
class CategoryFunctionAnswer extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_function_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base_data_id', 'category_id', 'function_id', 'answer_id','test_criteria', 'explain'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['base_data_id', 'category_id', 'function_id'], 'unique', 'targetAttribute' => ['base_data_id', 'category_id', 'function_id']],
            [['base_data_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseData::class, 'targetAttribute' => ['base_data_id' => 'id']],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::class, 'targetAttribute' => ['answer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['function_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['function_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'base_data_id' => Yii::t('app', ' Base Data ID'),
            'category_id'  => Yii::t('app', 'Category ID'),
            'function_id'  => Yii::t('app', 'Function ID'),
            'answer_id'    => Yii::t('app', 'Answer ID'),
            'created_at'   => Yii::t('app', 'Created At'),
            'updated_at'   => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Hole alle Antworten zum Dokument einer BaseData via id
     *
     * @param BaseData $baseData
     *
     * @return array
     */
    public static function getAnswers(BaseData $baseData)
    {
        $output = [];
        $test = self::find()->andWhere(['base_data_id' => $baseData->id])->asArray()->all();
        foreach ($test as $arr)
        {
            $output[$arr['category_id']][$arr['function_id']] = $arr['answer_id'];
        }
        return $output;
    }

    /**
     * Find first answer in category_function_answer for each function by base_data_id
     *
     * @param BaseData $baseData
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getFirstAnswerForEachFunction(BaseData $baseData)
    {
        return CategoryFunctionAnswer::find()->distinct()->groupBy(['function_id','base_data_id'])->having(['base_data_id' => $baseData->id])->orderBy('id')->indexBy('function_id')->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseData()
    {
        return $this->hasOne(BaseData::class, ['id' => 'base_data_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::class, ['id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::class, ['id' => 'function_id']);
    }

    /**
     * @return CategoryFunctionAnswerQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new CategoryFunctionAnswerQuery(get_called_class());
    }
}
