<?php
namespace frontend\models;

use common\models\User;
use kartik\password\StrengthValidator;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;
    public $username;

    /**
     * @var \common\models\User
     */
    private $user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->user = User::findByPasswordResetToken($token);
        if (!$this->user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        $this->username = $this->user->username;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [['password'], StrengthValidator::class, 'preset'=>'normal', 'min' => 10, 'max' => 64, 'lower'=> 2, 'upper'=> 2, 'digit'=> 2, 'special'=> 2],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->user;
        $user->setPassword($this->password);
        $user->password_reset_token = null;
        return $user->save();
    }


    public function attributeLabels()
    {
        return [
            'password'        => Yii::t('app', 'Passwort'),
            'password_repeat' => Yii::t('app', 'Passwort Wiederholung'),
        ];
    }
}
