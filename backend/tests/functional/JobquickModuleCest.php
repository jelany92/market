<?php

namespace backend\tests\functional;

use backend\fixtures\FunctionJobquickModuleFixture;
use backend\fixtures\JobquickModuleCompanyScalePriceFixture;
use backend\fixtures\JobquickModuleFixture;
use backend\models\JobquickModule;
use backend\models\queries\JobquickModuleCompanyScalePriceQuery;
use backend\tests\FunctionalTester;
use backend\tests\util\TestUtil;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use backend\fixtures\CompanyScaleFixture;
use Yii;
class JobquickModuleCest
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
            'user'                                => [
                'class'    => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user.php',
            ],
            'auth'                                => [
                'class'    => AuthItemFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_data.php',
            ],
            'auth_child'                         => [
                'class'    => AuthItemChildFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_child_data.php',
            ],
            'authAssignment'                     => [
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
            'function_jobquick_module'     => [
                'class'    => FunctionJobquickModuleFixture::class,
                'dataFile' => codecept_data_dir() . 'function_jobquick_module_data.php'
            ],

        ];
    }

    public function viewExistingJobquickModules(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['jobquick-module']);
        $I->see('JOBquick Module', 'h1');
        $I->see('JOBquick Testmodul Nummer 1', 'td');
        $I->see('Ein richtig cooles Modul', 'td');
    }

    public function checkIfEditPageIsBuiltCorrectly(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['jobquick-module']);
        $I->click('body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(4) > a:nth-child(2)'); //First edit button
        $I->see(Yii::t('app', 'JOBquick Modul: {0} aktualisieren', 'JOBquick Testmodul Nummer 1'), 'h1');
        $I->see('0 - 50', 'td');
        $I->see('51 - 100', 'td');
        $I->seeInField('jobquickmodulform-setupprices-1-disp', '');
        $I->seeInField('jobquickmodulform-monthlyprices-1-disp', '');
        $I->seeInField('jobquickmodulform-setupprices-2-disp', '25.00');
        $I->seeInField('jobquickmodulform-monthlyprices-2-disp', '100.00');
    }

    public function checkIfViewPageIsBuiltCorrectly(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['jobquick-module']);
        $I->click('body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(4) > a:nth-child(1)'); //First view button
        $I->see('JOBquick Testmodul Nummer 1', 'h1');
        $I->see('Bearbeiten', 'a');
        $I->see('25,00', 'td');
        $I->see('100,00', 'td');
    }

    public function tryEditExistingJobquickModuleNoName(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['jobquick-module']);
        $I->click('body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(4) > a:nth-child(2)'); //First edit button
        $I->fillField('#jobquickmodulform-title', '');
        $I->click('Speichern');
        $I->see(Yii::t('app', 'Bezeichnung darf nicht leer sein.'));
    }

    public function tryEditExistingJobquickModuleTooLongName(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['jobquick-module']);
        $I->click('body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(4) > a:nth-child(2)'); //First edit button
        $I->fillField('#jobquickmodulform-title', '||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||');
        $I->click('Speichern');
        $I->see(Yii::t('app', 'Bezeichnung darf maximal 255 Zeichen enthalten.'));
    }

    public function tryDeleteExistingJobquickModule(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['jobquick-module']);
        $I->see('JOBquick Testmodul Nummer 1');
        $I->seeRecord('backend\models\JobquickModule', ['name' => "JOBquick Testmodul Nummer 1"]);
        $I->click('body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(4) > a:nth-child(3)'); //First edit button
        $I->see(Yii::t('app', 'Modul wurde gelöscht'));
        $I->dontSee('JOBquick Testmodul Nummer 1');
        $I->dontSeeRecord('common\models\Component', ['name' => "JOBquick Testmodul Nummer 1"]);
    }
}