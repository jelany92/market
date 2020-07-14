<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Answer[] $answers
 */
class Answer extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const NAME_NOT_NEEDED      = 1;
    const NAME_UNIMPORTANT     = 2;
    const NAME_LATER_IMPORTANT = 3;
    const NAME_IMPORTANT       = 4;
    const NAME_K_O             = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'sort'], 'required'],
            [['sort'], 'integer'],
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
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Name'),
            'sort'       => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'updated_at' => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function Answer()
    {
        return $this->hasMany(CategoryFunctionAnswer::class, ['answer_id' => 'id']);
    }

    /**
     * @return array
     */
    public static Function getNameList()
    {
        return ArrayHelper::map(Answer::find()->orderBy(['sort' => SORT_ASC])->all(),'id', 'name');
    }
}
