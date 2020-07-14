<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "function_condition".
 *
 * @property int $id
 * @property int $condition_id
 * @property int $function_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Condition $condition
 * @property Function $function
 */
class FunctionCondition extends \yii\db\ActiveRecord
{

    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'function_condition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['condition_id', 'function_id'], 'required'],
            [['condition_id', 'function_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condition::class, 'targetAttribute' => ['condition_id' => 'id']],
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
            'condition_id' => Yii::t('app', 'Condition ID'),
            'function_id'  => Yii::t('app', 'Function ID'),
            'created_at'   => Yii::t('app', 'Created At'),
            'updated_at'   => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondition()
    {
        return $this->hasOne(Condition::class, ['id' => 'condition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunction()
    {
        return $this->hasOne(Component::class, ['id' => 'function_id']);
    }
}
