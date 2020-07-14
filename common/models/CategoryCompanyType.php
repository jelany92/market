<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "category_company_type".
 *
 * @property int $id
 * @property int $company_type_id
 * @property int $category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyType $companyType
 * @property Category $category
 */
class CategoryCompanyType extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_company_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_type_id', 'category_id'], 'required'],
            [['company_type_id', 'category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyType::class, 'targetAttribute' => ['company_type_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                           => Yii::t('app', 'ID'),
            'company_type_id'       => Yii::t('app', ' Company Type ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_at'                   => Yii::t('app', 'Erstellt am'),
            'updated_at'                   => Yii::t('app', 'Updated At'),
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
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
