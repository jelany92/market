<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use backend\tests\util\TestUtil;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\UserFixture;
use Yii;

class UserCest
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
            'user'           => [
                'class'    => AdminUserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin_user.php',
            ],
            'auth'           => [
                'class'    => AuthItemFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_data.php',
            ],
            'auth_child'     => [
                'class'    => AuthItemChildFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_child_data.php',
            ],
            'authAssignment' => [
                'class'    => AuthAssignmentFixture::class,
                'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',
            ],
            'frontend_user'  => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],

        ];
    }

    public function viewExistingUsers(FunctionalTester $I)
    {
        TestUtil::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['user']);
        $I->see(Yii::t('app','Frontend-Benutzer'), 'h1');
        $I->see('hans.wurst.frontend', 'body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3)');
        $I->see('Hans', 'body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(4)');
        $I->see('max.mustermann.frontend', 'body > div.wrap > div > div > div > table > tbody > tr:nth-child(2) > td:nth-child(3)');
        $I->see('peter.mueller.frontend', 'body > div.wrap > div > div > div > table > tbody > tr:nth-child(3) > td:nth-child(3)');
    }

    public function deleteExistingUser(FunctionalTester $I)
    {
        TestUtil::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['user']);
        $I->amGoingTo("delete the frontend user with id 2");
        $I->click('body > div > div > div > div > table > tbody > tr:nth-child(2) > td:nth-child(8) > a:nth-child(3)'); //delete button of second entry
        $I->see(Yii::t('app', 'Frontend-Benutzer'), 'h1');
        $I->dontSee('max.mustermann.frontend', 'body > div.wrap > div > div > div > table > tbody > tr:nth-child(2) > td:nth-child(3)');
    }

    public function editExistingUser(FunctionalTester $I)
    {
        TestUtil::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['user']);
        $I->amGoingTo("edit the frontend user with id 3");
        $I->click('body > div > div > div > div > table > tbody > tr:nth-child(3) > td:nth-child(8) > a:nth-child(2)'); //edit button of third entry
        $I->see('peter.mueller.frontend bearbeiten', 'h1');
        $I->fillField(Yii::t('app', 'Benutzername'), 'edited.username');
        $I->fillField(Yii::t('app', 'Vorname'), 'edited.firstname');
        $I->fillField(Yii::t('app', 'Nachname'), 'edited.lastname');
        $I->fillField(Yii::t('app', 'E-Mail'), 'edited.email@aicovo.com');
        $I->click(Yii::t('app', 'Speichern'));
        $I->seeInCurrentUrl('/user/view?id=3');
        $I->see(Yii::t('app','Frontend-Benutzer wurde bearbeitet'), 'div');
    }

    public function tryCreateWithExistingUsername(FunctionalTester $I)
    {
        TestUtil::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['user']);
        $I->amGoingTo("try to create a new user with an already existing username");
        $I->click(Yii::t('app', "Frontend-Benutzer anlegen"));
        $I->see(Yii::t('app', 'Frontend-Benutzer anlegen'));
        $I->fillField(Yii::t('app','Benutzername'), 'max.mustermann.frontend');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Benutzername "{0}" wird bereits verwendet.', ['max.mustermann.frontend']));
    }

    public function createNewUser(FunctionalTester $I)
    {
        TestUtil::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['user']);
        $I->amGoingTo("create a new user");
        $I->click(Yii::t('app', "Frontend-Benutzer anlegen"));
        $I->fillField(Yii::t('app', 'Benutzername'), 'test.frontend');
        $I->fillField(Yii::t('app', 'Vorname'), 'TestName');
        $I->fillField(Yii::t('app', 'Nachname'), 'TestNachname');
        $I->fillField(Yii::t('app', 'E-Mail'), 'hallo-welt@aicovo.com');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Neuer Frontend-Benutzer wurde erstellt'), 'div');
    }

    public function viewExistingUser(FunctionalTester $I)
    {
        TestUtil::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage(['user']);
        $I->amGoingTo("view the details of an existing user");
        $I->click('body > div.wrap > div > div > div > table > tbody > tr:nth-child(1) > td:nth-child(8) > a:nth-child(1)'); //view button of first entry
        $I->seeInCurrentUrl("/user/view?id=1");
        $I->see('hans.wurst.frontend', 'h1');
        $I->see(Yii::t('app', 'Bearbeiten'));
    }
}