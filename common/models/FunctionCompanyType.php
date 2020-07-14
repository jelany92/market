<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "function_company_type".
 *
 * @property int $id
 * @property int $company_type_id
 * @property int $function_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyType $companyType
 * @property Component $component
 */
class FunctionCompanyType extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'function_company_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_type_id', 'function_id'], 'required'],
            [['company_type_id', 'function_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyType::class, 'targetAttribute' => ['company_type_id' => 'id']],
            [['function_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['function_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'company_type_id' => Yii::t('app', ' Company Type ID'),
            'function_id'     => Yii::t('app', 'Function ID'),
            'created_at'      => Yii::t('app', 'Erstellt am'),
            'updated_at'      => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyType()
    {
        return $this->hasOne(CompanyType::class, ['id' => 'company_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::class, ['id' => 'function_id']);
    }
}
