<?php
namespace backend\models;

use common\models\AdminUser;
use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;

/**
 * Forgot password form
 */
class ForgotPasswordForm extends Model
{
    public $email;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // @formatter:off
            [['email'], 'required'],
            [['email'], 'trim'],
            [['email'], 'filter', 'filter'=>'mb_strtolower'],
            [['email'], EmailValidator::class, 'skipOnEmpty' => false],
            //[['email'], 'validateAccountExists'],
            // @formatter:on
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @param AdminUser $user
     *
     * @return bool
     */
    public function sendForgotPasswordMail(AdminUser $user)
    {
        return Yii::$app->mailer->compose([
                                              'html' => 'passwordResetToken-html',
                                              'text' => 'passwordResetToken-text',
                                          ], [
                                              'user' => $user,
                                              'resetLink' => Yii::$app->urlManager->createAbsoluteUrl([
                                                                                                          'site/reset-password',
                                                                                                          'token' => $user->password_reset_token,
                                                                                                      ]),
                                          ])->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])->setTo($this->email)->setSubject(Yii::$app->name . ' ' . Yii::t('app', 'Passwort vergessen'))->send();
    }


    /**
     * Generates a new password_reset_token for a user and sends email
     * containing instructions on how to reset password.
     *
     * @return bool
     * @throws \Exception
     */
    public function sendPasswordResetMail(): bool
    {
        if (!($this->_user instanceof AdminUser))
        {
            throw new \Exception('ForgotPasswordForm does not contain a valid ClientUser.');
        }

        return $this->_user->sendPasswordResetMail();
    }


}
