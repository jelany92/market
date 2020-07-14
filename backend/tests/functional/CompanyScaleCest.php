<?php

namespace backend\tests\functional;

use backend\fixtures\JobquickModuleCompanyScalePriceFixture;
use backend\fixtures\JobquickModuleFixture;
use backend\tests\FunctionalTester;
use backend\tests\util\TestUtil;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use backend\fixtures\CompanyScaleFixture;
use Yii;
class CompanyScaleCest
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
            'user'                         => [
                'class'    => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user.php',
            ],
            'auth'                         => [
                'class'    => AuthItemFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_data.php',
            ],
            'auth_child'                   => [
                'class'    => AuthItemChildFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_child_data.php',
            ],
            'authAssignment'               => [
                'class'    => AuthAssignmentFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',
            ],
            'company_scale'                      => [
                'class'    => CompanyScaleFixture::class,
                'dataFile' => codecept_data_dir() . 'company_scale_data.php',
            ],
            'jobquick_module'                    => [
                'class'    => JobquickModuleFixture::class,
                'dataFile' => codecept_data_dir() . 'jobquick_module_data.php',
            ],
            'jobquick_module_company_scale_price' => [
                'class'    => JobquickModuleCompanyScalePriceFixture::class,
                'dataFile' => codecept_data_dir() . 'jobquick_module_company_scale_price_data.php',
            ],
        ];
    }

    public function viewExistingCompanyScales(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-scale']);
        $I->see(Yii::t('app', 'Staffelung für Firmengrößen anpassen'), 'h1');
        $I->see("0",   "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(1)");
        $I->see("50",  "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(2)");
        $I->see("51",  "body > div > div > div.grid-view > table > tbody > tr:nth-child(2) > td:nth-child(1)");
        $I->see("100", "body > div > div > div.grid-view > table > tbody > tr:nth-child(2) > td:nth-child(2)");
    }

    public function editExistingCompanyScale(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-scale']);
        $I->click('body > div.wrap > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(3) > a:nth-child(1)'); //Edit button
        $I->see(Yii::t('app', "einzelne Staffelung anpassen"), 'li');
        $I->fillField("#companyscale-employee_boundary", 500);
        $I->click("body > div > div > div > form > div:nth-child(3) > button"); //Save button
        $I->see("0",   "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(1)");
        $I->see("100", "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(2)");
        $I->see("101", "body > div > div > div.grid-view > table > tbody > tr:nth-child(2) > td:nth-child(1)");
        $I->see("500", "body > div > div > div.grid-view > table > tbody > tr:nth-child(2) > td:nth-child(2)");
    }

    public function deleteExistingCompanyScale(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-scale']);
        $I->click("body > div.wrap > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(3) > a:nth-child(2)");
        $I->see(Yii::t('app', "Staffelung für Firmengrößen anpassen"), "h1");
        $I->see("0", "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(1)");
        $I->see("100", "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(2)");
    }

    public function createNewCompanyScale(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-scale']);
        $I->fillField("#companyscale-employee_boundary", 25);
        $I->click(Yii::t('app', 'Staffelung hinzufügen'));
        $I->see(Yii::t('app', 'Staffelung für Firmengrößen anpassen'), 'h1');
        $I->see("0",   "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(1)");
        $I->see("25",  "body > div > div > div.grid-view > table > tbody > tr:nth-child(1) > td:nth-child(2)");
        $I->see("26",  "body > div > div > div.grid-view > table > tbody > tr:nth-child(2) > td:nth-child(1)");
        $I->see("50", "body > div > div > div.grid-view > table > tbody > tr:nth-child(2) > td:nth-child(2)");
        $I->see("51", "body > div > div > div.grid-view > table > tbody > tr:nth-child(3) > td:nth-child(1)");
        $I->see("100", "body > div > div > div.grid-view > table > tbody > tr:nth-child(3) > td:nth-child(2)");
    }

    public function tryToCreateNewInvalidCompanyScalesLetters(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['company-scale']);
        $I->fillField("#companyscale-employee_boundary", "test123");
        $I->click(Yii::t('app', 'Staffelung hinzufügen'));
        $I->see(Yii::t('app', "Staffelung muss eine Ganzzahl sein."), 'div');
    }

    public function tryToCreateNewInvalidCompanyScalesNegative(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['company-scale']);
        $I->fillField("#companyscale-employee_boundary", "-50");
        $I->click(Yii::t('app', 'Staffelung hinzufügen'));
        $I->see(Yii::t('app', "Staffelung muss größer als {0} sein.", '"0"'), 'div');
    }

    public function tryToCreateNewInvalidCompanyScalesNotUnique(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['company-scale']);
        $I->fillField("#companyscale-employee_boundary", "100");
        $I->click(Yii::t('app', 'Staffelung hinzufügen'));
        $I->see(Yii::t('app', "Staffelung {0} wird bereits verwendet.", '"100"'), 'div');
    }
}