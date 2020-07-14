<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "condition".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FunctionCondition[] $functionConditions
 * @property Component[] $functions
 * @property BaseDataCondition[] $baseDataConditions
 * @property BaseData[] $baseDatas
 */
class Condition extends \yii\db\ActiveRecord
{

    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'updated_at' => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionConditions()
    {
        return $this->hasMany(FunctionCondition::class, ['condition_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctions()
    {
        return $this->hasMany(Component::class, ['id' => 'function_id'])
                    ->orderBy(['name' => SORT_ASC])
                    ->via('functionConditions');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDataConditions()
    {
        return $this->hasMany(BaseDataCondition::class, ['condition_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDatas()
    {
        return $this->hasMany(BaseData::class, ['id' => 'base_data_id'])
                    ->orderBy(['company_name' => SORT_ASC])
                    ->via('functionConditions');
    }

    /**
     * Returns an ordered List of condition ids and names
     * @return array
     */
    public static function getNameList()
    {
        return ArrayHelper::map(Condition::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }
}
