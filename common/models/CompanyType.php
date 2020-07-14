<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company_type".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class CompanyType extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'trim'],
            [['name'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'updated_at' => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryCompanyTypes()
    {
        return $this->hasMany(CategoryCompanyType::class, ['company_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionCompanyTypes()
    {
        return $this->hasMany(FunctionCompanyType::class, ['company_type_id' => 'id']);
    }

    /**
     * Returns an ordered List of company type ids and names
     * @return array
     */
    public static function getNameList()
    {
        return ArrayHelper::map(CompanyType::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }
}