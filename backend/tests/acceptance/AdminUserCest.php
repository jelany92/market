<?php

namespace backend\tests\acceptance;

use backend\tests\AcceptanceTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;


class AdminUserCest
{

    public function _fixtures()
    {
        return [

            'user' => ['class'    => AdminUserFixture::class,
                       'dataFile' => codecept_data_dir() . 'user.php'],

            'auth' => ['class'    => AuthItemFixture::class,
                       'dataFile' => codecept_data_dir() . 'auth_data.php'],

            'auth_child' => ['class'    => AuthItemChildFixture::class,
                             'dataFile' => codecept_data_dir() . 'auth_child_data.php'],

            'authAssignment' => ['class'    => AuthAssignmentFixture::class,
                                 'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',],

        ];
    }

    // tests
    public function checkIfUserHugoHasProperRole(AcceptanceTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amGoingTo("open the update window");
        $I->canSee('Verwaltung'); // 'Verwaltung->Administrator'
        $I->clickWithLeftButton('//*[@id="w1"]/li[2]/a'); // Verwaltung
        $I->canSee('Administrator'); // 'Verwaltung->Administrator'
        $I->clickWithLeftButton('//*[@id="w3"]/li[1]/a'); // 'DropDown item Administrator'
        $I->see('Administratoren'); // Überschrift
        $I->clickWithLeftButton('#w0 > table > tbody > tr:nth-child(3) > td:nth-child(8) > a:nth-child(2)'); // User 'hugo'
        $I->see('Administrator bearbeiten:'); // 'Bearbeiten' Ansicht
        $I->wait(7);
        $I->amGoingTo("Check proper role");
        // get expected role from fixtures
        $expectedValueInFirstOfDropDownList = TestUtilTest::getRoleFromFixtures($I, 'userHugosRole');

        $I->seeOptionIsSelected('#adminuserform-role', $expectedValueInFirstOfDropDownList); // '//*[@id="adminuserform-role"]/option[2]');
    }

    public function _createTask(AcceptanceTester $I)
    {
        // passwd defined in backend/tests/_data/user.php
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");

        $I->amGoingTo("open auth-item index view");
        $I->click('.dropdown-toggle'); // Verwaltung
        $I->canSee('Rechte'); // 'Verwaltung->Rechte etc.'
        $I->click(['link' => 'Rechte & Rollen']);
        $I->see('Rechte');
        $I->amGoingTo("Create a task");
        $I->see('Eintrag Erstellen');
        $I->clickWithLeftButton('body > div.wrap > div > div > p > a'); // 'Eintrag Erstellen'
        $I->fillField("AuthItem[name]", 'handleUser');
        $I->selectOption("AuthItem[type]", 'Aufgabe');
        $I->wait(10);
        $I->clickWithLeftButton('#w0 > div.row > div > button'); // Speichern
        $I->wait(10);

    }
}
