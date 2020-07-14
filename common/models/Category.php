<?php

namespace common\models;

use common\models\queries\ComponentQuery;
use common\models\traits\SortableBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int                       $id
 * @property string                    $name
 * @property int                       $status 1 = active, 0 = inactive
 * @property string                    $sort
 * @property string                    $created_at
 * @property string                    $updated_at
 *
 * @property CategoryFunction[]  $CategoryFunctions
 * @property Component[] $components
 */
class Category extends \yii\db\ActiveRecord
{
    use SortableBehaviorTrait;

    const INACTIVE = 0;
    const ACTIVE   = 1;

    public $names = [];
    public $companyType;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'companyType'], 'required',],
            [['status', 'sort'],'integer',],
            [['created_at', 'updated_at',], 'safe',],
            [['name'], 'string', 'max' => 255],
            [['name'], 'trim'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Bezeichnung'),
            'status'     => Yii::t('app', 'Aktiv'),
            'sort'       => Yii::t('app', 'Position'),
            'companyType'=> Yii::t('app', 'Art der Firma'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'updated_at' => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(CategoryFunctionAnswer::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryCompanyTypes()
    {
        return $this->hasMany(CategoryCompanyType::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFunctions()
    {
        return $this->hasMany(CategoryFunction::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponents()
    {
        // Work wihtout hasMany so that we can use Sort in Junction Table
        $query           = Component::find();
        $query->distinct();
        $query->multiple = true;
        $query->innerJoin(CategoryFunction::tableName(), CategoryFunction::tableName() . '.function_id = ' . Component::tableName() . '.id');
        $query->andWhere([CategoryFunction::tableName() . '.category_id' => $this->id]);
        $query->orderBy([CategoryFunction::tableName() . '.sort' => SORT_ASC]);
        return $query;
    }

    /**+
     * @param BaseData $baseData
     *
     * @return ComponentQuery
     */
    public function getRestrictedComponents(BaseData $baseData)
    {
        /* @var $query ComponentQuery */
        $query = self::getComponents();
        $query->project($baseData)
              ->companyType($baseData->companyType)
              ->conditions($baseData);
        return $query;
    }

    /**
     * replace status number
     *
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::INACTIVE => Yii::t('app', 'Nein'),
            self::ACTIVE   => Yii::t('app', 'Ja'),
        ];
    }

    /**
     * return sort number
     *
     * @return int|mixed
     */
    public static function getMaxSort()
    {
        $maxSort = Category::find()->max('sort');
        if (isset($maxSort))
        {
            return $sort = $maxSort + 1;
        }
        return $sort = 0;

    }

    /**
     * Returns an ordered List of categories ids and names
     * @return array
     */
    public static function getNameList(){
        return ArrayHelper::map(Category::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    /**
     * returns activeQuery for table modul_user_detail
     * {@inheritdoc}
     * @return \common\models\queries\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\CategoryQuery(get_called_class());
    }
}
