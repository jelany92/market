<?php

namespace common\tests\unit\models;

use backend\models\LoginForm;
use common\fixtures\AdminUserFixture;
use common\fixtures\AdminUserLoginLogFixture;
use Yii;

/**
 * Login form test
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return ['user'      => ['class'    => AdminUserFixture::class,
                                'dataFile' => codecept_data_dir() . 'admin_user.php'],
                'login_log' => ['class'    => AdminUserLoginLogFixture::class,
                                'dataFile' => codecept_data_dir() . 'admin_user_login_log.php']
        ];
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm(['username' => 'not_existing_username',
                                'password' => 'not_existing_password',]);

        expect('model should not login user', $model->login())->false();
        expect('user should not be logged in', Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm(['username' => 'bayer.hudson',
                                'password' => 'wrong_password',]);

        expect('model should not login user', $model->login())->false();
        expect('error message should be set', $model->errors)->hasKey('password');
        expect('user should not be logged in', Yii::$app->user->isGuest)->true();
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm(['username' => 'admin',
                                'password' => 'Meinaicovo1',]);

        expect('model should login user', $model->login())->true();
        expect('error message should not be set', $model->errors)->hasntKey('password');
        expect('user should be logged in', Yii::$app->user->isGuest)->false();
    }
}
