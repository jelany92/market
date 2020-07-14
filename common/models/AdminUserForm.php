<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Class AdminUserForm
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $active_from
 * @property string $active_until
 */
class AdminUserForm extends Model
{

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_UPDATE   = 'update';

    public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $active_from;
    public $active_until;
    public $role;
    public $isNewRecord = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [[['username', 'first_name', 'last_name', 'email', 'active_from', 'role'], 'required'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 25],
            // validate username is NOT EQUAL email address
            ['username', 'compare', 'compareAttribute' => 'email', 'operator' => '!=='],
            [['username'], 'unique', 'targetClass' => AdminUser::class, 'targetAttribute' => ['username' => 'username'], 'on' => self::SCENARIO_REGISTER],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => AdminUser::class, 'targetAttribute' => ['email' => 'email'], 'on' => self::SCENARIO_REGISTER],
            [['active_until', 'active_from'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm'],
            [['active_until', 'active_from'], 'validateDateInPast', 'on' => self::SCENARIO_REGISTER],
            [['active_until', 'active_from'], 'validateDates'],
            [['role'], 'roleValidation',],

            // rules for update scenario solely
            // check if username or email, respectively, is unique for all IDs except the current one
            [['username'], 'unique', 'targetClass' => AdminUser::class, 'targetAttribute' => ['username' => 'username'], 'on' => self::SCENARIO_UPDATE, 'filter' => ['!=', 'id', Yii::$app->request->get('id')],],
            [['email'], 'unique', 'targetClass' => AdminUser::class, 'targetAttribute' => ['email' => 'email'], 'on' => self::SCENARIO_UPDATE, 'filter' => ['!=', 'id', Yii::$app->request->get('id')],],
            [['last_name'], 'safe'],];
    }

    /**
     * @param string                          $attribute the attribute currently being validated
     * @param mixed                           $params    the value of the "params" given in the rule
     * @param \yii\validators\InlineValidator $validator related InlineValidator instance.
     *                                                   This parameter is available since version 2.0.11.
     */
    public function roleValidation($attribute, $params, $validator)
    {
        $role = Yii::$app->authManager->getRole($this->$attribute);
        if (!($role instanceof yii\rbac\Role))
        {
            $this->addError($attribute, Yii::t('app', 'Rolle unbekannt'));
        }
    }

    /**
     * compare the Date with actual date
     */
    public function validateDateInPast($attribute, $params, $validator)
    {
        $currentTime  = time();
        $selectedTime = strtotime($this->$attribute);
        if ($selectedTime < $currentTime)
        {
            $this->addError($attribute, Yii::t('app', '"'.$this->getAttributeLabel($attribute).'" muss größer als das aktuelle Datum sein'));
        }
    }

    /**
     * compare Two date and validation
     */
    public function validateDates($attribute, $params, $validator)
    {
        $activeFrom  = strtotime($this->active_from);
        $activeUntil = strtotime($this->active_until);
        if (!empty($activeUntil) && $activeUntil < $activeFrom)
        {
            $this->addError('active_from', Yii::t('app', '"Aktiv von" muss kleiner als "Aktiv bis" sein'));
            $this->addError('active_until', Yii::t('app', '"Aktiv bis" muss größer als "Aktiv von" sein'));
        }
    }

    /**
     * cuts off seconds from active from field
     * @param $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function adjustActiveFrom($value)
    {
        $this->active_from = $this->adjust($value);
    }

    /**
     * cuts off seconds from active until field
     * @param $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function adjustActiveUntil($value)
    {
        $this->active_until = $this->adjust($value);
    }

    /**
     * cuts off seconds from datetime value
     *
     * @param $value
     *
     * @throws \yii\base\InvalidConfigException
     * @return datetime formatted as 'Y-m-d HH:mm'
     */
    private function adjust($value)
    {
        if (isset($value))
        {
            return Yii::$app->formatter->asDate($value, 'yyyy-MM-dd HH:mm');
        }
        else
        {
            return $value;
        }
    }

    /**
     *
     * @return array of scenarios
     */
    public function scenarios()
    {
        $scenarios                          = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'first_name', 'last_name', 'email', 'active_from', 'active_until', 'role',];
        $scenarios[self::SCENARIO_UPDATE]   = ['username', 'first_name', 'last_name', 'email', 'active_from', 'active_until', 'role',];
        return $scenarios;
    }

    /**
     * define column names
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'     => Yii::t('app', 'Benutzername'),
            'first_name'   => Yii::t('app', 'Vorname'),
            'last_name'    => Yii::t('app', 'Nachname'),
            'role'         => Yii::t('app', 'Rolle'),
            'description'  => Yii::t('app', 'Beschreibung'),
            'email'        => Yii::t('app', 'E-Mail'),
            'active_from'  => Yii::t('app', 'Aktiv von'),
            'active_until' => Yii::t('app', 'Aktiv bis'),
        ];
    }

}
