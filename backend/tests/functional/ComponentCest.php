<?php

namespace backend\tests\functional;

use backend\fixtures\FunctionJobquickModuleFixture;
use backend\tests\FunctionalTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\BaseDataFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\CategoryFunctionAnswerFixture;
use common\fixtures\CategoryFunctionFixture;
use common\fixtures\CompanyTypeFixture;
use common\fixtures\ComponentFixture;
use common\fixtures\ConditionFixture;
use common\fixtures\FunctionCompanyTypeFixture;
use common\fixtures\FunctionConditionFixture;
use common\fixtures\FunctionImageFixture;
use common\fixtures\FunctionRestrictToProjectFixture;
use Yii;

class ComponentCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @return array
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user.php',
            ],
            'auth' => [
                'class' => AuthItemFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_data.php',
            ],
            'auth_child' => [
                'class' => AuthItemChildFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_child_data.php',
            ],
            'authAssignment' => [
                'class' => AuthAssignmentFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',
            ],
            'function' => [
                'class' => ComponentFixture::class,
                'dataFile' => codecept_data_dir() . 'function_data.php',
            ],
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'category_data.php',
            ],
            'category_function' => [
                'class' => CategoryFunctionFixture::class,
                'dataFile' => codecept_data_dir() . 'category_function_data.php',
            ],
            'function_company_type' => [
                'class' => FunctionCompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'function_company_type_data.php',
            ],
            'company_type' => [
                'class' => CompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'company_type_data.php',
            ],
            'base_data' => [
                'class' => BaseDataFixture::class,
                'dataFile' => codecept_data_dir() . 'base_data_data.php',
            ],
            'function_restrict_to_project' => [
                'class' => FunctionRestrictToProjectFixture::class,
                'dataFile' => codecept_data_dir() . 'function_restrict_to_project_data.php',
            ],
            'condition' => [
                'class' => ConditionFixture::class,
                'dataFile' => codecept_data_dir() . 'condition_data.php',
            ],
            'function_condition' => [
                'class' => FunctionConditionFixture::class,
                'dataFile' => codecept_data_dir() . 'function_condition_data.php',
            ],
            'function_jobquick_module' => [
                'class' => FunctionJobquickModuleFixture::class,
                'dataFile' => codecept_data_dir() . 'function_jobquick_module_data.php'
            ],
            'function_image' => [
                'class' => FunctionImageFixture::class,
                'dataFile' => codecept_data_dir() . 'function_image_data.php'
            ],
            'category_function_answer' => [
                'class' => CategoryFunctionAnswerFixture::class,
                'dataFile' => codecept_data_dir() . 'category_function_answer_data.php'
            ]
        ];
    }

    public function createFunction(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->amGoingTo('function/create');
        $I->see('Funktion anlegen');
        $I->click(Yii::t('app', 'Funktion anlegen'));
        $name = 'Housing statt';
        $I->fillField('Name', $name);
        $I->checkOption('//*[@id="functionform-companytype"]/div[1]/label/input');
        $I->selectOption('//*[@id="mainCategorySelect"]', Yii::t('app', 'Datenschutz und Datensicherheit'));
        $I->selectOption('Themenbereiche', [
            'Bewerbungsoptionen',
            'Eignungsdiagnostik - Schnittstellen',
        ]);
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde erstellt'));
        $I->see($name);
        $component = $I->grabRecord('common\models\Component', ['name' => $name]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => $component->id,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 2,
            'function_id' => $component->id,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 3,
            'function_id' => $component->id,
        ]);
    }

    public function createFunctionWithProject(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->click(Yii::t('app', 'Funktion anlegen'));
        $name = 'Housing statt';
        $I->fillField('Name', $name);
        $I->selectOption('Projekt auswählen', [
            'Landratsamt Leipzig',
        ]);
        $I->checkOption('//*[@id="functionform-companytype"]/div[1]/label/input');
        $I->selectOption('//*[@id="mainCategorySelect"]', Yii::t('app', 'Datenschutz und Datensicherheit'));
        $I->selectOption('Themenbereiche', [
            'Bewerbungsoptionen',
            'Eignungsdiagnostik - Schnittstellen',
        ]);
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde erstellt'));
        $I->see($name);
        $component = $I->grabRecord('common\models\Component', ['name' => $name]);
        $I->seeRecord('common\models\FunctionRestrictToProject', [
            'function_id' => 4,
            'base_data_id' => 1,
        ]);
    }

    public function updateFunctionWithIdentical(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting', 'h1');
        $I->selectOption('//*[@id="mainCategorySelect"]', Yii::t('app', 'Datenschutz und Datensicherheit'));
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 1,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 2,
            'function_id' => 1,
        ]);

        $componentData = TestUtilTest::getFixtureElement($I, 'function', 0);
        $I->seeInField('Name', $componentData['name']);
        $I->seeInField('Beschreibung kurz', $componentData['description_short']);
        $I->seeInField('Beschreibung lang', $componentData['description_long']);
        $I->fillField('Name', 'House statt Host');

        $I->selectOption('Themenbereiche', [
            'Eignungsdiagnostik - Schnittstellen',
        ]);
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde aktualisiert'));
        $I->see('House statt Host', 'h1');
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 1,
        ]);
        $I->dontSeeRecord('common\models\CategoryFunction', [
            'category_id' => 2,
            'function_id' => 1,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 3,
            'function_id' => 1,
        ]);
    }

    public function updateFunctionWithNotIdentical(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting', 'h1');
        $componentData = TestUtilTest::getFixtureElement($I, 'function', 0);
        $I->seeInField('Name', $componentData['name']);
        $I->seeInField('Beschreibung kurz', $componentData['description_short']);
        $I->seeInField('Beschreibung lang', $componentData['description_long']);
        $I->fillField('Name', 'House statt Host');
        $I->selectOption('Projekt auswählen', [
            'Landratsamt Leipzig',
        ]);
        $I->selectOption('//*[@id="mainCategorySelect"]', Yii::t('app', 'Bewerbungsoptionen'));
        $I->selectOption('Themenbereiche', [
            'Eignungsdiagnostik - Schnittstellen',
        ]);
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde aktualisiert'));
        $I->see('House statt Host', 'h1');
        $I->dontSeeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 1,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 2,
            'function_id' => 1,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 3,
            'function_id' => 1,
        ]);
    }

    public function checkIfChangedMainCategory(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Without Main Category');
        $I->seeRecord('common\models\Component', ['name' => "Without Main Category"]);
        $I->click('//*[@id="function_grid"]/table/tbody/tr[3]/td[7]/a[2]');
        $I->seeOptionIsSelected('//*[@id="mainCategorySelect"]', 'Bitte wählen');
        $I->checkOption('//*[@id="functionform-companytype"]/div[2]/label/input');
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 3,
            'is_main_category' => 0,
        ]);
        $I->selectOption('//*[@id="mainCategorySelect"]', 'Datenschutz und Datensicherheit');
        $I->click(Yii::t('app', 'Speichern'));
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 3,
            'is_main_category' => 1,
        ]);
    }

    public function updateFunctionWithNotWithSameCategoryAndChangeMainCategory(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting', 'h1');
        $componentData = TestUtilTest::getFixtureElement($I, 'function', 0);
        $I->seeInField('Name', $componentData['name']);
        $I->seeInField('Beschreibung kurz', $componentData['description_short']);
        $I->seeInField('Beschreibung lang', $componentData['description_long']);
        $I->fillField('Name', 'House statt Host');
        $I->selectOption('//*[@id="mainCategorySelect"]', 'Bewerbungsoptionen');
        $I->selectOption('Themenbereiche', [
            'Eignungsdiagnostik - Schnittstellen',
        ]);
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde aktualisiert'));
        $I->see('House statt Host', 'h1');

    }

    public function updateFunctionWithSameName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting', 'h1');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde aktualisiert'));
    }

    public function updateFunctionWithDuplicateName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting', 'h1');
        $I->fillField('Name', 'Lückenlose Änderungshistorie');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see('Housing statt Hosting');
        $I->dontSee(Yii::t('app', 'Funktion wurde aktualisiert'));
        $I->see(Yii::t('app', 'Name "Lückenlose Änderungshistorie" wird bereits verwendet.'));
    }

    public function updateFunctionWithDuplicateNameAndWhitespace(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting', 'h1');
        $I->fillField('Name', '   Lückenlose Änderungshistorie   ');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see('Housing statt Hosting');
        $I->dontSee(Yii::t('app', 'Funktion wurde aktualisiert'));
        $I->see(Yii::t('app', 'Name "Lückenlose Änderungshistorie" wird bereits verwendet.'));
    }

    public function copyFunction(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[3]');
        $componentData = TestUtilTest::getFixtureElement($I, 'function', 0);

        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 1,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 2,
            'function_id' => 1,
        ]);

        $I->dontSeeRecord('common\models\Component', [
            'id' => 4,
        ]);

        $I->seeInField('Name', $componentData['name']);
        $I->seeInField('Beschreibung kurz', $componentData['description_short']);
        $I->seeInField('Beschreibung lang', $componentData['description_long']);
        $I->seeOptionIsSelected('//*[@id="mainCategorySelect"]', 'Datenschutz und Datensicherheit');
        //$I->seeOptionIsSelected('//*[@id="mainCategorySelect"]', 'Bewerbungsoptionen'); soll das auch ausgewählt aber nimmt nicht multi option
        $I->dontSeeOptionIsSelected('//*[@id="categorySelect"]', 'Eignungsdiagnostik - Schnittstellen');
        $I->fillField('Name', 'Hosting');

        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde erstellt'));
        $I->see('Hosting');

        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 1,
            'function_id' => 4,
        ]);
        $I->seeRecord('common\models\CategoryFunction', [
            'category_id' => 2,
            'function_id' => 4,
        ]);
    }

    public function deleteFunction(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->seeRecord('common\models\Component', ['name' => "Lückenlose Änderungshistorie"]);
        $I->click('//*[@id="function_grid"]/table/tbody/tr[2]/td[7]/a[4]');
        $I->dontSee(Yii::t('app', 'Lückenlose Änderungshistorie'));
        $I->see(Yii::t('app', 'Funktion wurde gelöscht'));
        $I->dontSeeRecord('common\models\Component', ['name' => "Lückenlose Änderungshistorie"]);
    }

    public function deleteFunctionWithRelations(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->see('Housing statt Hosting');
        $I->seeRecord('common\models\Component', ['name' => "Housing statt Hosting"]);
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[9]/a[4]'); // delete icon
        $I->see(Yii::t('app', 'Funktion wurde gelöscht'));
        $I->dontSee('Housing statt Hosting');
        $I->dontSeeRecord('common\models\Component', ['name' => "Housing statt Hosting"]);
    }

    public function updateCompanyName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['function/index']);
        $I->click('//*[@id="function_grid"]/table/tbody/tr[1]/td[7]/a[2]');
        $I->see('Housing statt Hosting');
        $I->seeRecord('common\models\FunctionCompanyType', [
            'company_type_id' => 1,
            'function_id'     => 1,
        ]);
        $I->dontSeeRecord('common\models\FunctionCompanyType', [
            'company_type_id' => 2,
            'function_id'     => 1,
        ]);
        $I->uncheckOption('//*[@id="functionform-companytype"]/div[1]/label/input');
        $I->checkOption('//*[@id="functionform-companytype"]/div[2]/label/input');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Funktion wurde aktualisiert'));
        $I->see('Housing statt Hosting');
        $I->seeRecord('common\models\FunctionCompanyType', [
            'company_type_id' => 2,
            'function_id'     => 1,
        ]);
        $I->dontSeeRecord('common\models\FunctionCompanyType', [
            'company_type_id' => 1,
            'function_id'     => 1,
        ]);

    }

}