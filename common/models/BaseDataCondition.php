<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "base_data_condition".
 *
 * @property int $id
 * @property int $condition_id
 * @property int $base_data_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Condition $condition
 * @property BaseData $baseData
 */
class BaseDataCondition extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_data_condition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['condition_id', 'base_data_id'], 'required'],
            [['condition_id', 'base_data_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condition::class, 'targetAttribute' => ['condition_id' => 'id']],
            [['base_data_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseData::class, 'targetAttribute' => ['base_data_id' => 'id']],
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
            'base_data_id' => Yii::t('app', 'Base Data ID'),
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
    public function getBaseData()
    {
        return $this->hasOne(BaseData::class, ['id' => 'base_data_id']);
    }
}
