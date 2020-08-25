<?php

namespace backend\models;

use common\models\AdminUser;
use common\models\ArticleInfo;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "returned_goods".
 *
 * @property int $id
 * @property int $company_id
 * @property int $current_admin_user_id
 * @property string $name
 * @property int $count
 * @property float $price
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AdminUser $company
 * @property AdminUser $company0
 */
class ReturnedGoods extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'returned_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'count', 'price', 'selected_date'], 'required'],
            [['company_id', 'current_admin_user_id', 'count'], 'integer'],
            [['price'], 'number'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminUser::class, 'targetAttribute' => ['company_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminUser::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'company_id'            => Yii::t('app', 'Company ID'),
            'current_admin_user_id' => Yii::t('app', 'Current Admin User'),
            'name'                  => Yii::t('app', 'Name'),
            'count'                 => Yii::t('app', 'Count'),
            'price'                 => Yii::t('app', 'Price'),
            'selected_date'         => Yii::t('app', 'Selected Date'),
            'created_at'            => Yii::t('app', 'Created At'),
            'updated_at'            => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(AdminUser::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Company0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany0()
    {
        return $this->hasOne(AdminUser::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[ArticleInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleInfo()
    {
        return $this->hasOne(ArticleInfo::class, ['id' => 'article_info_id']);
    }
}
