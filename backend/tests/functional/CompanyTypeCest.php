<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\CategoryCompanyTypeFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\CategoryFunctionFixture;
use common\fixtures\CompanyTypeFixture;
use common\fixtures\ComponentFixture;
use common\fixtures\FunctionCompanyTypeFixture;
use Yii;

class CompanyTypeCest
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
            'company_type'          => [
                'class'    => CompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'company_type_data.php',
            ],
            'category_company_type' => [
                'class'    => CategoryCompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'category_company_type_data.php',
            ],
            'function_company_type' => [
                'class'    => FunctionCompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'function_company_type_data.php',
            ],
            'category_function'     => [
                'class'    => CategoryFunctionFixture::class,
                'dataFile' => codecept_data_dir() . 'category_function_data.php',
            ],
            'function'    => [
                'class'    => ComponentFixture::class,
                'dataFile' => codecept_data_dir() . 'function_data.php',
            ],
            'category'    => [
                'class'    => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'category_data.php',
            ],

        ];
    }

    public function createCompanyType(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->see(Yii::t('app', 'Art der Firma'), 'h1');
        $I->click(Yii::t('app', 'Art der Firma anlegen'));
        $I->see(Yii::t('app', 'Art der Firma anlegen'), 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'Unternehmen1');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Art der Firma wurde erstellt'));
        $I->see('Unternehmen1', 'h1');
    }

    public function createCompanyTypeWithUsedNameFails(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->click(Yii::t('app', 'Art der Firma anlegen'));
        $I->fillField(Yii::t('app', 'Name'), 'Unternehmen');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Name {0} wird bereits verwendet.', '"Unternehmen"'));
    }

    public function updateCompany(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->see(Yii::t('app', 'Art der Firma'), 'h1');
        $I->click('//*[@id="company_type_grid"]/table/tbody/tr[1]/td[4]/a[2]'); // update icon
        $I->seeInField(Yii::t('app', 'Name'), 'Unternehmen');
        $I->fillField(Yii::t('app', 'Name'), 'Firma');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Art der Firma wurde aktualisiert'));
        $I->see('Firma', 'h1');
    }

    public function updateCompanyTypeWithUsedNameFails(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->click('//*[@id="company_type_grid"]/table/tbody/tr[1]/td[4]/a[2]'); // update icon
        $I->fillField(Yii::t('app', 'Name'), 'Behörden');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Name {0} wird bereits verwendet.', '"Behörden"'));
    }

    public function removeFunctionCompanyType(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->click('//*[@id="company_type_grid"]/table/tbody/tr[1]/td[4]/a[1]'); // view icon
        $I->see('Housing statt Hosting');
        $I->seeRecord('common\models\CategoryCompanyType', [
            'company_type_id'       => 1,
            'category_id' => 1,
        ]);
        $I->seeRecord('common\models\FunctionCompanyType', [
            'company_type_id'       => 1,
            'function_id' => 1,
        ]);
        $I->click('//*[@id="company-type"]/table/tbody/tr/td[4]/a'); // seperate icon
        $I->dontSee('Housing statt Hosting');
        $I->seeRecord('common\models\CategoryCompanyType', [
            'company_type_id'       => 1,
            'category_id' => 1,
        ]);
        $I->dontSeeRecord('common\models\FunctionCompanyType', [
            'company_type_id'       => 1,
            'function_id' => 1,
        ]);
    }

    public function clickFunctionLink(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->click('//*[@id="company_type_grid"]/table/tbody/tr[1]/td[4]/a[1]'); //view icon
        $I->seeLink('Housing statt Hosting');
        $I->click('Housing statt Hosting');
        $I->see('Housing statt Hosting','h1');
        $I->see(Yii::t('app', 'Art der Firma'));
        $I->seeLink('Unternehmen');
        $I->click('Unternehmen');
        $I->see('Unternehmen','h1');
    }

    public function clickCategoryLink(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->click('//*[@id="company_type_grid"]/table/tbody/tr[1]/td[4]/a[1]'); // view icon
        $I->seeLink('Datenschutz und Datensicherheit');
        $I->click('Datenschutz und Datensicherheit');
        $I->see('Datenschutz und Datensicherheit','h1');
    }

    public function deleteCompanyType(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['company-type']);
        $I->see('Unternehmen');
        $I->click('//*[@id="company_type_grid"]/table/tbody/tr[1]/td[4]/a[3]'); // delete icon
        $I->see(Yii::t('app','Art der Firma wurde gelöscht'));
        $I->dontSee('Unternehmen');
    }
}