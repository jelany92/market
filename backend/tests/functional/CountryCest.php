<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use backend\tests\util\TestUtil;
use common\fixtures\AdminUserFixture;
use common\fixtures\AttachmentFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\BaseDataFixture;
use common\fixtures\CategoryCompanyTypeFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\CompanyTypeFixture;
use common\fixtures\ConditionFixture;
use common\fixtures\CountryFixture;
use Yii;

class CountryCest
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
            'country'    => [
                'class'    => CountryFixture::class,
                'dataFile' => codecept_data_dir() . 'country_data.php',
            ],
        ];
    }

    public function createCountry(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['country/index']);
        $I->see(Yii::t('app', 'Land anlegen'));
        $I->click(Yii::t('app', 'Land anlegen'));
        $I->see(Yii::t('app', 'Land anlegen'), 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'DTEn');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Land wurde erstellt'));
    }

    public function createCountryWithUsedNameFails(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['country/index']);
        $I->see(Yii::t('app', 'Land anlegen'));
        $I->click(Yii::t('app', 'Land anlegen'));
        $I->see(Yii::t('app', 'Land anlegen'), 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'Italien');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Name {0} wird bereits verwendet.', '"Italien"'));
    }

    public function updateCountry(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['country/index']);
        $I->click('//*[@id="country_grid"]/table/tbody/tr[1]/td[4]/a[2]'); // update icon
        $I->see(Yii::t('app', 'Deutschland'), 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'Daten');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Land wurde aktualisiert'));
        $I->see('Daten');
    }

    public function deleteCountry(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['country/index']);
        $I->see(Yii::t('app','Länder'));
        $I->see('Deutschland');
        $I->click('//*[@id="country_grid"]/table/tbody/tr[1]/td[4]/a[3]'); // delete icon
        $I->see(Yii::t('app', 'Land wurde gelöscht'));
        $I->dontSee('Deutschland');
    }

}