<?php

namespace backend\tests\acceptance;

use backend\tests\AcceptanceTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use Yii;


class HelpTestMethod
{
    // login
    public static function loginMarketAdmin(AcceptanceTester $I)
    {
        $I->amOnPage('/site/login');
        $I->wait(1);
        $I->fillField('//*[@id="loginform-username"]', 'ahmad'); //username
        $I->fillField('//*[@id="loginform-password"]', 'ahmadsms'); //password
        $I->click('//*[@id="login-form"]/div[4]/button'); //login
        $I->waitForText(Yii::t('app', 'Total income for the month'), 1);
    }

}
