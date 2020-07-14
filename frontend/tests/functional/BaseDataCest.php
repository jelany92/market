<?php

namespace frontend\tests\functional;

use common\fixtures\BaseDataFixture;
use frontend\tests\FunctionalTester;
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

            'base_date' => [
                'class'    => BaseDataFixture::class,
                'dataFile' => codecept_data_dir() . 'base_data_data.php',
            ],

        ];
    }

    public function createBaseData(FunctionalTester $I)
    {
        $I->amOnPage(['site/index']);
        $I->see('Stammdaten');
        $I->fillField('Firma', 'company Test');
        $I->click(Yii::t('app', 'Speichern & Weiter'));
        $I->see(Yii::t('app', 'Projekt wurde gespeichert'));
        $I->seeRecord('common\models\BaseData', [
            'company_name'  => 'company Test',
            'company_count' => 1,
        ]);
    }

    public function seeLink(FunctionalTester $I)
    {
        $I->amOnPage(['site/details?key=zUqOMuUaWw9dUrWpJ8tz0XPtFAeanLiDi7D5jdDCcqoMHFtG3s']);
        $I->seeRecord('common\models\BaseData', [
            'public_key'   => 'zUqOMuUaWw9dUrWpJ8tz0XPtFAeanLiDi7D5jdDCcqoMHFtG3s',
            'company_name' => 'test Firma',
        ]);
    }

    public function saveDate(FunctionalTester $I)
    {
        $date = new \DateTime();
        $I->amOnPage(['site/index']);
        $I->see('Stammdaten');
        $I->fillField('Firma', 'company Test');
        $I->fillField('Datum', $date->format('t.m.Y'));
        $I->click(Yii::t('app', 'Speichern & Weiter'));
        $I->see(Yii::t('app', 'Stammdaten wurde gespeichert'));
        $I->seeRecord('common\models\BaseData', [
            'base_date' => $date->format('Y-m-t'),
        ]);
    }


}