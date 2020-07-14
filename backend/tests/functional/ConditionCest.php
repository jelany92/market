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
use Yii;

class ConditionCest
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
            'condition'    => [
                'class'    => ConditionFixture::class,
                'dataFile' => codecept_data_dir() . 'condition_data.php',
            ],
        ];
    }

    public function createCondition(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['condition/index']);
        $I->see(Yii::t('app', 'Rahmenbedingung erstellen'));
        $I->click(Yii::t('app', 'Rahmenbedingung erstellen'));
        $I->see(Yii::t('app', 'Rahmenbedingung erstellen'), 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'DTEn');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Rahmenbedingung wurde erstellt'));
    }

    public function createConditionWithUsedNameFails(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['condition/index']);
        $I->see(Yii::t('app', 'Rahmenbedingung erstellen'));
        $I->click(Yii::t('app', 'Rahmenbedingung erstellen'));
        $I->see(Yii::t('app', 'Rahmenbedingung erstellen'), 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'Intranet');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Name "Intranet" wird bereits verwendet.'));
    }

    public function updateCondition(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['condition/index']);
        $I->click('//*[@id="condition_grid"]/table/tbody/tr[1]/td[5]/a[2]'); // update icon
        $I->see('Intranet', 'h1');
        $I->fillField(Yii::t('app', 'Name'), 'Daten');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Rahmenbedingung wurde aktualisiert'));
        $I->see('Daten');
    }

    public function deleteCondition(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['condition/index']);
        $I->see(Yii::t('app','Rahmenbedingungen'));
        $I->see('Intranet');
        $I->click('//*[@id="condition_grid"]/table/tbody/tr[1]/td[5]/a[3]'); // delete icon
        $I->see(Yii::t('app', 'Rahmenbedingung wurde gelöscht'));
        $I->dontSee('Intranet');
    }

}