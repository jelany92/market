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
use common\fixtures\CompanyTypeFixture;
use Yii;

class CategoryCest
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
            'category'    => [
                'class'    => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'category_data.php',
            ],
            'category_company_type' => [
                'class'    => CategoryCompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'category_company_type_data.php',
            ],
            'company_type'          => [
                'class'    => CompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'company_type_data.php',
            ],

        ];
    }

    public function createCategory(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see(Yii::t('app', 'Themenbereich anlegen'));
        $I->click(Yii::t('app', 'Themenbereich anlegen'));
        $I->seeInCurrentUrl('category/create');
        $I->see(Yii::t('app', 'Themenbereich anlegen'), 'h1');
        $I->fillField(Yii::t('app', 'Bezeichnung'), 'DTEn');
        $I->selectOption('//*[@id="category-status"]', 1); // Aktiv, Ja
        $I->checkOption('//*[@id="category-companytype"]/div[1]/input'); // Art der Firma, Behörden
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Themenbereich wurde erstellt'));
    }

    public function updateCategory(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see(Yii::t('app', 'Datenschutz und Datensicherheit'));
        $I->click('//*[@id="category_grid"]/table/tbody/tr[1]/td[7]/a[2]'); // update icon
        $I->see(Yii::t('app', 'Datenschutz und Datensicherheit'), 'h1');
        $I->fillField(Yii::t('app', 'Bezeichnung'), 'Daten');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Themenbereich wurde aktualisiert'));
    }

    public function updateCategoryWithoutChanges(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see('Datenschutz und Datensicherheit');
        $I->click('//*[@id="category_grid"]/table/tbody/tr[1]/td[7]/a[2]'); // update icon
        $I->see('Datenschutz und Datensicherheit', 'h1');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Themenbereich wurde aktualisiert'));
    }

    public function updateCategoryWithDuplicateName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see('Datenschutz und Datensicherheit');
        $I->click('//*[@id="category_grid"]/table/tbody/tr[1]/td[7]/a[2]'); // update icon
        $I->see('Datenschutz und Datensicherheit', 'h1');
        $I->fillField(Yii::t('app', 'Bezeichnung'), 'Bewerbungsoptionen');
        $I->click(Yii::t('app', 'Speichern'));
        $I->dontSee(Yii::t('app', 'Themenbereich wurde aktualisiert'));
        $I->see(Yii::t('app', 'Bezeichnung {0} wird bereits verwendet.', '"Bewerbungsoptionen"'));
    }

    public function updateCategoryWithDuplicateNameAndWhitespaceFails(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see('Datenschutz und Datensicherheit');
        $I->click('//*[@id="category_grid"]/table/tbody/tr[1]/td[7]/a[2]'); // update icon
        $I->see('Datenschutz und Datensicherheit', 'h1');
        $I->fillField(Yii::t('app', 'Bezeichnung'), '  Bewerbungsoptionen  ');
        $I->click(Yii::t('app', 'Speichern'));
        $I->dontSee(Yii::t('app', 'Themenbereich wurde aktualisiert'));
        $I->see(Yii::t('app', 'Bezeichnung {0} wird bereits verwendet.', '"Bewerbungsoptionen"'));
    }

    public function updateAddCompanyName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see('Bewerbungsoptionen');
        $I->click('//*[@id="category_grid"]/table/tbody/tr[2]/td[7]/a[2]'); // update icon
        $I->see('Bewerbungsoptionen', 'h1');
        $I->checkOption('//*[@id="category-companytype"]/div[1]/input'); //Art der Firma Behörden
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Themenbereich wurde aktualisiert'));

    }

    public function updateCompanyName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['category/index']);
        $I->see('Datenschutz und Datensicherheit');
        $I->click('//*[@id="category_grid"]/table/tbody/tr[1]/td[7]/a[2]'); // update icon
        $I->see('Datenschutz und Datensicherheit', 'h1');
        $I->seeRecord('common\models\CategoryCompanyType', [
            'company_type_id' => 1,
            'category_id'     => 1,
        ]);
        $I->dontSeeRecord('common\models\CategoryCompanyType', [
            'company_type_id' => 2,
            'category_id'     => 1,
        ]);
        $I->checkOption('//*[@id="category-companytype"]/div[1]/input');
        $I->uncheckOption('//*[@id="category-companytype"]/div[2]/input'); //Art der Firma Unternehmen
        $I->click(Yii::t('app', 'Speichern'));
        $I->seeRecord('common\models\CategoryCompanyType', [
            'company_type_id' => 2,
            'category_id'     => 1,
        ]);
        $I->dontSeeRecord('common\models\CategoryCompanyType', [
            'company_type_id' => 1,
            'category_id'     => 1,
        ]);
        $I->see(Yii::t('app', 'Themenbereich wurde aktualisiert'));

    }

}