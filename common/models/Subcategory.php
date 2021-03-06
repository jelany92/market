<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\bootstrap4\Html;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "subcategory".
 *
 * @property int $id
 * @property int|null $main_category_id
 * @property string $subcategory_name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property MainCategory $mainCategory
 */
class Subcategory extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_category_id'], 'integer'],
            [['subcategory_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['subcategory_name'], 'string', 'max' => 50],
            [['subcategory_name'], 'unique'],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::class, 'targetAttribute' => ['main_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'main_category_id' => Yii::t('app', 'Main Category ID'),
            'subcategory_name' => Yii::t('app', 'Subcategory Name'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[MainCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::class, ['id' => 'main_category_id']);
    }

    /**
     * Gets query for [[GallerySaveCategory]].
     *
     * @return ActiveQuery
     */
    public function getGallerySaveCategory() : ActiveQuery
    {
        return $this->hasMany(GallerySaveCategory::class, ['subcategory_id' => 'id']);
    }

    /**
     * @param int|null $mainCategoryId
     * @param int|null $companyId
     *
     * @return array
     */
    public static function getSubcategoryList(int $mainCategoryId = null, int $companyId = null): array
    {
        if (isset($mainCategoryId))
        {
            $all = self::find()->innerJoinWith('mainCategory')->andWhere([
                                                                             'main_category_id' => $mainCategoryId,
                                                                             'company_id'       => isset($companyId) ? $companyId : Yii::$app->user->id,
                                                                         ])->orderBy(['subcategory.subcategory_name' => SORT_ASC])->distinct(true)->all();
        }
        else
        {
            $all = self::find()->innerJoinWith('mainCategory')->orderBy(['subcategory_name' => SORT_ASC])->distinct(true)->andWhere(['company_id' => isset($companyId) ? $companyId : Yii::$app->user->id])->all();
        }
        return ArrayHelper::map($all, 'id', 'subcategory_name');
    }

    /**
     * @param int $mainCategoryId
     *
     * @return array
     */
    public static function getSubcategoryWithMainCategoryIdList(int $mainCategoryId) : array
    {
        return self::find()->select(['id', 'name' => 'subcategory_name'])->andWhere(['main_category_id' => $mainCategoryId])->asArray()->all();
    }

    /**
     * @param int    $mainCategoryId
     * @param string $name
     */
    public function saveSubcategory(int $mainCategoryId, string $name)
    {
        $this->main_category_id = $mainCategoryId;
        $this->subcategory_name = $name;
        $this->save();
    }

    /**
     * @param array      $nameList
     * @param array|null $option
     *
     * @return string
     */
    public static function getSubcategoryLink(array $nameList, array $option = null): string
    {
        $subcategory = [];
        foreach ($nameList as $key => $name)
        {
            $subcategory[] = Html::a($name, [
                'book-info/subcategory',
                'subcategoryId' => $key,
            ], $option);
        }
        return implode(', ', $subcategory);
    }
}
