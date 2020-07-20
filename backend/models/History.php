<?php

namespace backend\models;

use common\models\AdminUser;
use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int         $id
 * @property int         $company_id
 * @property int         $current_admin_user_id
 * @property string      $summary
 * @property string|null $note
 * @property string|     $type
 * @property string|null $edited_date_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AdminUser   $company
 */
class History extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'current_admin_user_id', 'summary'], 'required'],
            [['company_id', 'current_admin_user_id'], 'integer'],
            [['note'], 'string'],
            [['edited_date_at', 'created_at', 'updated_at'], 'safe'],
            [['summary', 'type'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminUser::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                     => Yii::t('app', 'ID'),
            'company_id'             => Yii::t('app', 'Company Name'),
            'current_admin_user_id'  => Yii::t('app', 'Current Admin User'),
            'summary'                => Yii::t('app', 'Summary'),
            'note'                   => Yii::t('app', 'Note'),
            'type'                   => Yii::t('app', 'Type'),
            'edited_date_at'         => Yii::t('app', 'Edited Date At'),
            'created_at'             => Yii::t('app', 'Created At'),
            'updated_at'             => Yii::t('app', 'Updated At'),
        ];
    }


    /**
     * save Automatic History Entry
     *
     * @param string $summary
     * @param string $note
     * @param string $type
     *
     * @return bool
     * @throws \Exception
     */
    public static function saveAutomaticHistoryEntry(string $summary, string $note, string $type) : bool
    {
        $dateTime                            = new \DateTime();
        $modelHistory                        = new History();
        $modelHistory->company_id            = Yii::$app->user->identity->id;
        $modelHistory->current_admin_user_id = Yii::$app->user->identity->id;
        $modelHistory->summary               = $summary;
        $modelHistory->note                  = $note;
        $modelHistory->type                  = $type;
        $modelHistory->edited_date_at        = $dateTime->format('Y-m-d H:i:s');
        return $modelHistory->save();
    }

    /**
     * Gets query for [[AdminUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdminUser()
    {
        return $this->hasOne(AdminUser::class, ['id' => 'company_id']);
    }
}
