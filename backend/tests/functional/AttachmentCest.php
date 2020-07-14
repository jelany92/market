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
use Yii;

class AttachmentCest
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
            'base_data'    => [
                'class'    => BaseDataFixture::class,
                'dataFile' => codecept_data_dir() . 'base_data_data.php',
            ],
            'attachment' => [
                'class'    => AttachmentFixture::class,
                'dataFile' => codecept_data_dir() . 'attachment_data.php',
            ],
            'company_type'          => [
                'class'    => CompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'company_type_data.php',
            ],

        ];
    }

    public function createAttachment(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['attachment/index']);
        $I->see(Yii::t('app', 'Zusatz erstellen'));
        $I->click(Yii::t('app', 'Zusatz erstellen'));
        $I->see(Yii::t('app', 'Zusatz anlegen'), 'h1');
        $I->fillField(Yii::t('app','Bezeichnung'), 'DTEn');
        $I->selectOption('//*[@id="attachment-base_data_id"]', 'Landratsamt Leipzig');
        $I->selectOption('//*[@id="attachment-category"]', 'Vorbemerkung');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Zusatz wurde erstellt'));
    }

    public function createAttachmentFailsWithDuplicateCategory(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['attachment/index']);
        $I->see(Yii::t('app', 'Zusatz erstellen'));
        $I->click(Yii::t('app', 'Zusatz erstellen'));
        $I->see(Yii::t('app', 'Zusatz anlegen'), 'h1');
        $I->fillField(Yii::t('app','Bezeichnung'), 'DTEn');
        $I->selectOption('//*[@id="attachment-base_data_id"]', 'Landratsamt Leipzig');
        $I->selectOption('//*[@id="attachment-category"]', 'Deckblatt');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Gewählte Kategorie ist in diesem Projekt schon vorhanden.'));
    }

    public function updateAttachment(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['attachment/index']);
        $I->click('//*[@id="attachment_grid"]/table/tbody/tr[1]/td[7]/a[2]'); //update icon
        $I->see(Yii::t('app', 'test1'), 'h1');
        $I->fillField('Bezeichnung', Yii::t('app','Daten'));
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Zusatz wurde aktualisiert'));
        $I->see('Daten', 'h1');
    }

    public function copyAttachment(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['attachment/index']);
        $I->see(Yii::t('app','Zusätze'));
        $I->see('test1');
        $I->click('//*[@id="attachment_grid"]/table/tbody/tr[1]/td[7]/a[3]'); // copy icon
        $I->see(Yii::t('app', 'Zusatz anlegen'));
        $I->selectOption('//*[@id="attachment-base_data_id"]','Mecklenburgische Versicherungsgruppe');
        $I->selectOption('//*[@id="attachment-category"]', 'Deckblatt');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Zusatz wurde erstellt'));
    }

    public function deleteAttachment(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['attachment/index']);
        $I->see(Yii::t('app','Zusätze'));
        $I->see('test1');
        $I->click('//*[@id="attachment_grid"]/table/tbody/tr[1]/td[7]/a[4]'); //delete icon
        $I->see(Yii::t('app', 'Zusatz wurde gelöscht'));
        $I->dontSee('test1');
    }

}