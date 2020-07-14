<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "function_restrict_to_project".
 *
 * @property int $id
 * @property int $function_id
 * @property int $base_data_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BaseData $baseData
 * @property Component $function
 */
class FunctionRestrictToProject extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'function_restrict_to_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['function_id', 'base_data_id'], 'required'],
            [['function_id', 'base_data_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['base_data_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseData::class, 'targetAttribute' => ['base_data_id' => 'id']],
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
            'function_id'  => Yii::t('app', 'Function ID'),
            'base_data_id' => Yii::t('app', 'Base Data ID'),
            'created_at'   => Yii::t('app', 'Erstellt am'),
            'updated_at'   => Yii::t('app', 'Aktualisiert am'),
        ];
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
    public function getFunction()
    {
        return $this->hasOne(Component::class, ['id' => 'function_id']);
    }
}
