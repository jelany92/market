<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [// username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],];
    }
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Benutzername'),
            'password' => Yii::t('app', 'Passwort'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        try
        {
            if (!$this->hasErrors())
            {
                $user = $this->getUser();
                if (!$user || !$user->validatePassword($this->password))
                {
                    throw new \Exception();
                }
            }
        } catch (\Exception $e)
        {
            $this->addError($attribute, Yii::t('app','Benutzername oder Passwort falsch'));
            return false;
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
        {
            $user = $this->getUser();
            return Yii::$app->user->login($user, 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null)
        {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
