<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AnswerFixture;
use common\fixtures\AttachmentFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\BaseDataFixture;
use common\fixtures\CompanyTypeFixture;
use common\fixtures\CountryFixture;
use Yii;

class BaseDataCest
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
            'user'                             => [
                'class'    => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user.php',
            ],
            'auth'                             => [
                'class'    => AuthItemFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_data.php',
            ],
            'auth_child'                       => [
                'class'    => AuthItemChildFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_child_data.php',
            ],
            'authAssignment'                   => [
                'class'    => AuthAssignmentFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',
            ],
            'country_data'                     => [
                'class'    => CountryFixture::class,
                'dataFile' => codecept_data_dir() . 'country_data.php',
            ],
            'base_data'                 => [
                'class'    => BaseDataFixture::class,
                'dataFile' => codecept_data_dir() . 'base_data_data.php',
            ],
            'attachment_data' => [
                'class'    => AttachmentFixture::class,
                'dataFile' => codecept_data_dir() . 'attachment_data.php',
            ],
            'answer'    => [
                'class'    => AnswerFixture::class,
                'dataFile' => codecept_data_dir() . 'answer_data.php',
            ],
            'company_type'          => [
                'class'    => CompanyTypeFixture::class,
                'dataFile' => codecept_data_dir() . 'company_type_data.php',
            ],
        ];
    }

    public function createBaseDataWithEmptyFormFails(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage('/base-data/index');
        $I->click(Yii::t('app', 'Projekt anlegen'));
        $I->seeInCurrentUrl('base-data/create');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Auftraggeber darf nicht leer sein.'));
    }

    public function createBaseDataWithMinimumData(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage('/base-data/create');
        $value = 'Auftraggeber';
        $I->fillField(Yii::t('app','Auftraggeber'), $value );
        $I->click(Yii::t('app', 'Speichern'));
        $I->seeInCurrentUrl('base-data/view');
        $I->see($value , 'h1');
    }

    public function createBaseDataWithDuplicateCodeFails(FunctionalTester $I)
    {
        TestUtil::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage('/base-data/create');
        $baseData = TestUtil::getFixtureElement($I, 'base_data', 1);
        $value = 'Auftraggeber';
        $I->fillField(Yii::t('app','Auftraggeber'), $value );
        $I->fillField(Yii::t('app','Projekt-Code'), strtolower($baseData['code']));
        $I->click(Yii::t('app', 'Speichern'));
        $I->seeInCurrentUrl('base-data/create');
        $I->see(Yii::t('app', 'Projekt-Code "'.$baseData['code']).'" wird bereits verwendet.');
    }

    public function updateBaseData(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $companyName = 'Landratsamt Leipzig';
        $I->seeRecord('common\models\BaseData', [
            'company_name' => $companyName,
        ]);
        $I->amOnPage(['/base-data/index']);
        $I->see(Yii::t('app','Projekte'), 'h1');
        $I->see($companyName);
        $I->click('//*[@id="base_data_grid"]/table/tbody/tr[3]/td[7]/a[4]'); // update icon
        $I->seeInCurrentUrl('base-data/update');
        $I->see($companyName, 'h1');
        $newValue = 'new Name';
        $I->fillField(Yii::t('app','Auftraggeber'), $newValue);
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Projekt wurde aktualisiert'));

        $I->dontSeeRecord('common\models\BaseData', [
            'company_name' => $companyName,
        ]);
        $I->seeRecord('common\models\BaseData', [
            'company_name' => $newValue,
        ]);
        $I->see(Yii::t('app', 'Bearbeiten'));
        $I->see(Yii::t('app', 'Löschen'));
    }

     public function showPdf(FunctionalTester $I)
     {
         // TODO fertig machen
         TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
         $I->amOnPage(['base-data/index']);
         $I->click('//*[@id="base_data_grid"]/table/tbody/tr/td[6]/a[2]');
         $I->see('PDF-Download konfigurieren', 'h1');
         $I->checkOption('//*[@id="pdfdownload-contentlist"]/div[1]/label/input');
         $I->checkOption('//*[@id="pdfdownload-contentlist"]/div[2]/label/input');
         $I->checkOption('//*[@id="pdfdownload-arranswerstoprint"]/div[10]/label/input');
         $I->checkOption('//*[@id="pdfdownload-arranswerstoprint"]/div[13]/label/input');
         $I->fillField('Headerinhalt','test');
         $I->fillField('Footerinhalt','date');
         $I->click(Yii::t('app','Herunterladen'));
     }
}