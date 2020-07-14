<?php

namespace common\models;

use backend\models\FunctionJobquickModule;
use backend\models\JobquickModule;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "function".
 *
 * @property int                         $id
 * @property string                      $name
 * @property string                      $description_short
 * @property string                      $description_long
 * @property string                      $created_at
 * @property string                      $updated_at
 *
 * @property CategoryFunction[]          $categoryFunctions
 * @property Category[]                  $categories
 * @property FunctionCompanyType[]       $functionCompanyTypes
 * @property FunctionCondition[]         $functionConditions
 * @property Condition[]                 $conditions
 * @property FunctionImage[]             $functionImages
 * @property FunctionRestrictToProject[] $baseDatas
 */
class Component extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'function';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'],'required',],
            [['description_short','description_long',],'string',],
            [['name','description_short','description_long',],'trim',],
            [['created_at','updated_at',],'safe',],
            [['name'],'string','max' => 100,],
            [['name'],'unique',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'name'              => Yii::t('app', 'Bezeichnung'),
            'description_short' => Yii::t('app', 'Beschreibung Kurz'),
            'description_long'  => Yii::t('app', 'Beschreibung lang'),
            'created_at'        => Yii::t('app', 'Erstellt am'),
            'updated_at'        => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete())
        {
            return false;
        }

        // delete all Relations and update sort index
        CategoryFunctionAnswer::deleteAll(['function_id' => $this->id]);
        FunctionCompanyType::deleteAll(['function_id' => $this->id]);
        FunctionRestrictToProject::deleteAll(['function_id' => $this->id]);
        CategoryFunction::deleteAll(['function_id' => $this->id]);
        FunctionImage::deleteAll(['function_id' => $this->id]);
        FunctionJobquickModule::deleteAll(['function_id' => $this->id]);
        FunctionCondition::deleteAll(['function_id' => $this->id]);

        return true;
    }



    public function beforeSave($insert)
    {
        // remove trailing empty <p> Tags
        $this->description_long = preg_replace('/(<p>&nbsp;<\/p>)+$/', '', $this->description_long);
        $this->description_short = preg_replace('/(<p>&nbsp;<\/p>)+$/', '', $this->description_short);

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFunctions()
    {
        return $this->hasMany(CategoryFunction::class, ['function_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('category_function', ['function_id' => 'id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMainComponent()
    {
        return $this->hasOne(CategoryFunction::class, ['function_id' => 'id'])->where(['is_main_category' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionCompanyTypes()
    {
        return $this->hasMany(FunctionCompanyType::class, ['function_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDatas()
    {
        return $this->hasMany(FunctionRestrictToProject::class, ['function_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionImages()
    {
        return $this->hasMany(FunctionImage::class, ['function_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionConditions()
    {
        return $this->hasMany(FunctionCondition::class, ['function_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConditions()
    {
        return $this->hasMany(Condition::class, ['id' => 'condition_id'])
                    ->orderBy(['name' => SORT_ASC])
                    ->via('functionConditions');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionJobquickModules()
    {
        return $this->hasMany(FunctionJobquickModule::class, ['function_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobquickModules()
    {
        return $this->hasMany(JobquickModule::class, ['id' => 'jobquick_module_id'])
                    ->orderBy(['name' => SORT_ASC])
                    ->via('functionJobquickModules');
    }

    /**
     * @param $baseDataId
     *
     * @return bool
     */
    public function isRestricted($baseDataId)
    {
        $restricted = false;
        if(is_array($this->baseDatas) && count($this->baseDatas))
        {
            if(!($this->getBaseDatas()->andWhere(['base_data_id' => $baseDataId])->one() instanceof FunctionRestrictToProject))
            {
                $restricted = true;
            }
        }
        return $restricted;
    }

    /**
     * returns activeQuery for table modul_user_detail
     * {@inheritdoc}
     * @return \common\models\queries\ComponentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\ComponentQuery(get_called_class());
    }
}
