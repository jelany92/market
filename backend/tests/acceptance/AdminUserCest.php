<?php

namespace backend\tests\acceptance;

use backend\tests\AcceptanceTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use Yii;


class AdminUserCest
{

    public function _fixtures()
    {
        return [

            'AdminUser' => [
                'class'    => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user_data.php',
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

        ];
    }

    // market view
    public function marketView(AcceptanceTester $I)
    {
        HelpTestMethod::loginMarketAdmin($I);
        $I->amOnPage('/site/view?date=' . date('Y-m-d'));
        $I->waitForText(Yii::t('app', 'Incoming Revenue'), 1);
    }

    public function marketViewIn(AcceptanceTester $I)
    {
        $this->marketView($I);
        $I->click('/html/body/div[2]/div/p/a[1]');
        $I->wait(1);
        $I->fillField('//*[@id="incomingrevenue-daily_incoming_revenue"]', 100);
        $I->click('//*[@id="w0"]/div[3]/button');

    }

}
