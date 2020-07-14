<?php

namespace frontend\models;

use common\models\BaseData;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ProjectSelectForm extends Model
{
    public $project_code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [// username and password are both required
            [['project_code'], 'required'],
            [['project_code'], 'filter', 'filter'=>'strtoupper'],
            [['project_code'], 'exist', 'targetClass' => BaseData::class, 'targetAttribute' => 'code'],
            ];
    }

    public function attributeLabels()
    {
        return [
            'project_code' => Yii::t('app', 'Projekt-Code'),
        ];
    }

    /**
     * Load Project to given code
     *
     * @return common\models\BaseData|null
     */
    public function loadBaseData(){
        if (($model = BaseData::find()->where(['code' => $this->project_code])->one()) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
