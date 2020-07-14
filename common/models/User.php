<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'username', 'first_name', 'last_name'], 'trim'],
            [['username', 'first_name', 'last_name', 'email'], 'required'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 25],
            [['password', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'filter', 'filter'=>'strtolower'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return[
            'id'                   => Yii::t('app', 'ID'),
            'username'             => Yii::t('app', 'Benutzername'),
            'first_name'           => Yii::t('app', 'Vorname'),
            'last_name'            => Yii::t('app', 'Nachname'),
            'password'             => Yii::t('app', 'Passwort'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email'                => Yii::t('app', 'E-Mail'),
            'created_at'           => Yii::t('app', 'Erstellt am'),
            'updated_at'           => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert)
        {
            $this->setForgotPasswordToken();
            return Yii::$app->mailer->compose([
                'html' => 'passwordResetToken-html',
                'text' => 'passwordResetToken-text',
            ], [
                'user'      => $this,
                'resetLink' => Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/reset-password','token' => $this->password_reset_token,])
            ])
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject(Yii::$app->name . ' ' . Yii::t('app', 'Frontend Account Aktivierung'))
                ->send();
        }
        return true;
    }

    /**
     * Set Token for password reset function
     */
    public function setForgotPasswordToken()
    {
        $this->password_reset_token = $this->generatePasswordResetToken();
        $this->save();
    }

    /**
     * Generates new password reset token with timestamp for validation check
     */
    protected function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token))
        {
            return null;
        }

        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token))
        {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire    = Yii::$app->params['user.passwordResetTokenExpire'];
        return time() <= $timestamp + $expire;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


}
