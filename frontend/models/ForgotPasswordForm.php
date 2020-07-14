<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Forgot password form
 */
class ForgotPasswordForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'trim'],
            [['email'], 'filter', 'filter'=>'strtolower'],
            [['email'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-Mail'),
        ];
    }

    public function sendForgotPasswordMail(User $user){
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                [
                    'user' => $user,
                    'resetLink' => Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password','token' => $user->password_reset_token,]),
                ])
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject(Yii::$app->name . ' ' . Yii::t('app','Passwort vergessen'))
            ->send();
    }


}
