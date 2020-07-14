<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\components\PermissionType;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\MdlContactFixture;
use common\fixtures\ModulUserDetailFixture;
use common\fixtures\UserBerechtigungFixture;
use common\fixtures\UserLoginFixture;
use common\fixtures\UserStammFixture;
use common\fixtures\UserSubDetailFixture;
use common\models\permission\IpsForm;
use common\models\permission\SmsForm;
use common\models\StaticPermissionModel;
use common\models\UserBerechtigung;

class UserStaticPermissionTest extends Unit
{

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [

            'user' => [
                'class'    => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user.php',
            ],

            'auth' => [
                'class'    => AuthItemFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_data.php',
            ],

            'auth_child' => [
                'class'    => AuthItemChildFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_child_data.php',
            ],

            'authAssignment' => [
                'class'    => AuthAssignmentFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',
            ],

            'UserStamm' => [
                'class'    => UserStammFixture::class,
                'dataFile' => codecept_data_dir() . 'user_stamm_data.php',
            ],

            'UserSubDetail' => [
                'class'    => UserSubDetailFixture::class,
                'dataFile' => codecept_data_dir() . 'user_sub_detail_data.php',
            ],

            'UserLogin' => [
                'class'    => UserLoginFixture::class,
                'dataFile' => codecept_data_dir() . 'user_login_data.php',
            ],

            'ModulUserDetail' => [
                'class'    => ModulUserDetailFixture::class,
                'dataFile' => codecept_data_dir() . 'modul_user_detail_data.php',
            ],

            'MdlContact' => [
                'class'    => MdlContactFixture::class,
                'dataFile' => codecept_data_dir() . 'mdl_contact_data.php',
            ],

            'UserBerechtigung' => [
                'class'    => UserBerechtigungFixture::class,
                'dataFile' => codecept_data_dir() . 'user_berechtigungen_data.php',
            ],

        ];
    }


    /**
     * create model for one permission and access its title
     */
    public function testGetTitle()
    {
        $model = StaticPermissionModel::createModel(StaticPermissionModel::PERMISSION_CALENDAR_MANAGEMENT);
        $this->assertNotNull($model);
        $this->assertEquals('Terminverwaltung', $model->title);
    }

    /**
     * create model for one permission and access its title
     */
    public function testGetTypeMbox()
    {
        $model = StaticPermissionModel::createModel(StaticPermissionModel::PERMISSION_MBOX);
        $this->assertNotNull($model);
        $this->assertTrue(PermissionType::PERMISSION_TYPE_MBOX === $model->type);
    }

    public function testMakeIframeString()
    {
        $model              = new UserBerechtigung();
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IFRAME;
        // starts validation
        $model->makeIframeValue();
    }

    public function testValidateIframe()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_IFRAME;
        $model->value       = 'zRu6f1gt|'; // e.g. valid: f7xH484Nn|
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IFRAME;
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateIframeWrongChar()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_IFRAME;
        // invalid character in string
        $model->value       = 'f7xH48_4Nn|';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IFRAME;
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateIframeTooLong()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_IFRAME;
        // too long
        $model->value       = 'zRu6f1gtughfhgfhfhguu|';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IFRAME;
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateIframeTooShort()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_IFRAME;
        // too short
        $model->value       = 'zR691|';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IFRAME;
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateIframeUnique()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_IFRAME;
        // user shall not append the bar but it is stored this way in database
        $model->value       = "12erfp_0i3|"; // already exists
        $model->modulid     = 11;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IFRAME;
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateMboxInputWrongDomain()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_MBOX;
        // ...joquick wrong
        $domain             = 'joquick.net';
        $model->value       = 'jobquick_742@' . $domain . ':sd%gt1';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateMboxInputDashNotValid()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_MBOX;
        // ...-net is wrong
        $model->value       = 'jobquick_742@jobquick-net:sd%gt1';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateMboxInput()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_MBOX;
        $model->value       = 'jobquick_742@jobquick.net:sd%gt1';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateMboxInputModIdOneDigit()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_MBOX;
        $model->value       = 'jobquick_7@jobquick.net:sd%gt1';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateMboxInputModIdFourDigits()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_MBOX;
        $model->value       = 'jobquick_9999@jobquick.net:sd%gt1';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateMboxInputWrongPwdLength()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_MBOX;
        // pwd has only 5 characters rather than 6
        $pwd                = 'sd%gt';
        $model->value       = 'jobquick_9999@jobquick.net:' . $pwd;
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $model->validate('value');
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateMboxInputWrongUserName()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_MBOX;
        $pwd             = 'sd%gt5';
        // username starts with digit
        $model->value       = '1jobquick_9999@jobquick.net:' . $pwd;
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_MBOX;
        $model->validate('value');
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateInternalMail()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_EMAIL_INTERNAL;
        $model->value       = 'jobquick_9999@jobquick.net';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_EMAIL_INTERNAL;
        $model->validate('value');
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateInternalMailWrong()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_EMAIL_INTERNAL;
        $model->value       = 'wrdlbrmpfd';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_EMAIL_INTERNAL;
        $model->validate('value');
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateExternalMail()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_EMAIL_EXTERNAL;
        $model->value       = 'xyz@kunde.de';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_EMAIL_EXTERNAL;
        $model->validate('value');
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateEnvelope()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_ENVELOPE_ADDRESS;
        $model->value       = 'jobquick_9999@jobquick.net';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_ENVELOPE_SENDER_ADDRESS;
        $model->validate('value');
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateEnvelopeWrong()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_ENVELOPE_ADDRESS;
        // wrong domain jjobquick.net
        $model->value       = 'jobquick_9999@jjobquick.net';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_ENVELOPE_SENDER_ADDRESS;
        $model->validate('value');
        $this->assertNotTrue($model->validate('value'));
    }

    public function testValidateSubaccounts()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_SUBACCOUNTS;
        $model->value       = '999';
        $model->modulid     = 11;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_SUBACCOUNTS;
        $model->validate('value');
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateSMSNoAmount()
    {
        $model              = new UserBerechtigung();
        $model->scenario    = UserBerechtigung::SCENARIO_SMS;
        $model->value       = 'SMS-Absender';
        $model->modulid     = 11;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_SMS_VERSAND;
        $model->validate('value');
        $this->assertTrue($model->validate('value'));
    }

    public function testValidateSMSAmount()
    {
        $model              = new SmsForm();
        $model->scenario    = UserBerechtigung::SCENARIO_SMS;
        $model->smsSender   = 'SMS-Absender';
        $model->bezeichnung = StaticPermissionModel::PERMISSION_SMS_VERSAND;
        $model->amount      = '100';
        $this->assertTrue($model->validate([
            'smsSender',
            'amount',
        ]));
    }

    public function testValidateIPS()
    {
        $model              = new IpsForm();
        $model->scenario    = UserBerechtigung::SCENARIO_IPS;
        $model->address     = '192.168.178.17';
        $model->subnet      = '255.255.0.0/16';
        $model->bezeichnung = StaticPermissionModel::PERMISSION_IPS;
        $this->assertTrue($model->validate([
            'address',
            'subnet',
        ]));
    }

    public function testValidateSubaccountsWrong()
    {
        $model           = new UserBerechtigung();
        $model->scenario = UserBerechtigung::SCENARIO_SUBACCOUNTS;
        // wrong value, must be <= '999'
        $model->value       = '1000';
        $model->modulid     = 742;
        $model->bezeichnung = StaticPermissionModel::PERMISSION_SUBACCOUNTS;
        $model->validate('value');
        $this->assertNotTrue($model->validate('value'));
    }


    /**
     * create model for one permission and access its description
     */
    public function testGetDescription()
    {
        $model = StaticPermissionModel::createModel(StaticPermissionModel::PERMISSION_APPLICANT_LOGIN);
        $this->assertNotNull($model);
        $this->assertEquals('Bewerber sollen sich einloggen können', $model->description);
    }

    /**
     * create model for one permission and access its type
     */
    public function testGetTypeEnvelope()
    {
        $model = StaticPermissionModel::createModel(StaticPermissionModel::PERMISSION_ENVELOPE_SENDER_ADDRESS);
        $this->assertNotNull($model);
        $this->assertEquals(PermissionType::PERMISSION_TYPE_ENVELOPE_ADDRESS, $model->type);
    }

    /**
     * access non existing key
     */
    public function _testNotFoundException()
    {
        try
        {
            $model = StaticPermissionModel::createModel('klklklkl');
        } catch (\Throwable $e)
        {
            return;
        }
        $this->fail('Exception not raised');
    }

    /**
     * fetch data provider, get the contained array and access an array entry
     */
    public function testGetDataProvider()
    {
        $prov = StaticPermissionModel::getDataProvider();
        $this->assertNotNull($prov);
        $data = $prov->allModels; // data array
        $this->assertNotNull($data);
        // first level has no key
        $this->assertArrayNotHasKey('permissionName', $data);
        // second level has keys permissionName, title, description
        $this->assertArrayHasKey('permissionName', $data[0]);
        $this->assertArrayHasKey('title', $data[0]);
        $this->assertArrayHasKey('description', $data[0]);
        $this->assertEquals('Bewerberlogin', $data[0]['title']);
    }

    /** test static access */
    public function testGetTitleByName()
    {
        $this->assertEquals('Anzahl Subaccounts', StaticPermissionModel::getTitleByName('subaccounts'));
    }

    /**
     * create model for one permission and access its type
     */
    public function testGetTypeBoolean()
    {
        $model = StaticPermissionModel::createModel('calendar_management');
        $this->assertNotNull($model);
        $this->assertEquals(PermissionType::PERMISSION_TYPE_BOOLEAN, $model->type);
    }

    /**
     * create model for one permission and access its type
     */
    public function testGetTypeMisc()
    {
        $model = StaticPermissionModel::createModel('eligo');
        $this->assertNotNull($model);
        $this->assertEquals(PermissionType::PERMISSION_TYPE_MISCELLANEOUS, $model->type);
    }

    /**
     * create model for one permission and access its type
     */
    public function testGetTypeText()
    {
        $model = StaticPermissionModel::createModel('email_external');
        $this->assertNotNull($model);
        $this->assertEquals(PermissionType::PERMISSION_TYPE_EMAIL_EXTERNAL, $model->type);
    }
}