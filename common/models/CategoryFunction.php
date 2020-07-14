<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "category_function".
 *
 * @property int $id
 * @property int $category_id
 * @property int $function_id
 * @property string $sort
 * @property int $is_main_category
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property Component $component
 */
class CategoryFunction extends \yii\db\ActiveRecord
{
    // can't use sortabletrait because of one to many relation is sorted
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => 'sjaakp\sortable\Sortable',
                'orderAttribute' => [
                    'category_id' => 'sort'
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_function';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'function_id', 'sort'], 'required'],
            [['category_id', 'function_id', 'is_main_category', 'sort', 'is_main_category'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_id', 'function_id'], 'unique', 'targetAttribute' => ['category_id', 'function_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['function_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['function_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'category_id'      => Yii::t('app', 'Themenbereich'),
            'function_id'      => Yii::t('app', 'Funktion'),
            'sort'             => Yii::t('app', 'Sort'),
            'is_main_category' => Yii::t('app', 'Hauptkategorie'),
            'created_at'       => Yii::t('app', 'Erstellt am'),
            'updated_at'       => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::class, ['id' => 'function_id']);
    }
}
