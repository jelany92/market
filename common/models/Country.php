<?php

namespace common\models;

use common\models\traits\SortableBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 */
class Country extends \yii\db\ActiveRecord
{

    use SortableBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 255],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'sort'       => Yii::t('app', 'Sortierung'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'updated_at' => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * get list of all countries
     * @return array|Country[]
     */
    public static function getList()
    {
        return Country::find()->andWhere(['not', ['sort' => null]])->orderBy(['sort' => SORT_ASC])->all();
    }


    /**
     * make list for country with country name
     *
     * @return array
     */
    public static function getNameList()
    {
        return ArrayHelper::map(Country::getList(), 'id', 'name');
    }


}
