<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use Yii;

class AdminUserCest
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

        ];
    }

    public function createUser(FunctionalTester $I)
    {
        $now = new \DateTime();
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->click('Neuen Benutzer erstellen');
        $I->see('Neuen Benutzer erstellen', 'h1');
        $I->fillField('Benutzername', 'neu.user');
        $I->fillField('Vorname', 'neu Vorname');
        $I->fillField('Nachname', 'neu Nachname');
        $I->fillField('E-Mail', 'neuuser@g.com');
        $I->fillField('Aktiv von', $now->format('Y-m-t H:i'));
        $I->selectOption('Rolle', 'Ausschreibungen');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Neuer Benutzer wurde erstellt'));
    }

    public function createUserFailsWithWrongDate(FunctionalTester $I)
    {
        $now = new \DateTime();
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->click('Neuen Benutzer erstellen');
        $I->fillField('Benutzername', 'neu.user');
        $I->fillField('Vorname', 'neu vorname');
        $I->fillField('Nachname', 'neu Nachname');
        $I->fillField('E-Mail', 'neuuser@g.com');
        $I->selectOption('Rolle', 'Ausschreibungen');
        $I->fillField('Aktiv von', $now->format('2018-m-t H:i'));
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', '"Aktiv von" muss größer als das aktuelle Datum sein'));
        $I->fillField('Aktiv von', $now->format('Y-m-t H:i'));
        $I->fillField('Aktiv bis', $now->format('2018-m-t H:i'));
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', '"Aktiv bis" muss größer als das aktuelle Datum sein'));
    }

    public function createUserFailsWithWrongActiveTimes(FunctionalTester $I)
    {
        $now = new \DateTime();
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->click('Neuen Benutzer erstellen');
        $I->fillField('Benutzername', 'neu.user');
        $I->fillField('Vorname', 'neu vorname');
        $I->fillField('Nachname', 'neu Nachname');
        $I->fillField('E-Mail', 'neuuser@g.com');
        $I->selectOption('Rolle', 'Ausschreibungen');
        $I->fillField('Aktiv von', $now->format('2020-m-t H:i'));
        $I->fillField('Aktiv bis', $now->format('2020-m-1 H:i'));
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', '"Aktiv von" muss kleiner als "Aktiv bis" sein'));
        $I->see(Yii::t('app', '"Aktiv bis" muss größer als "Aktiv von" sein'));
    }

    public function createUserFailsWithDuplicateName(FunctionalTester $I)
    {
        $now = new \DateTime();
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->click('Neuen Benutzer erstellen');
        $I->fillField('Benutzername', 'user');
        $I->fillField('Vorname', 'neu vorname');
        $I->fillField('Nachname', 'neu Nachname');
        $I->fillField('E-Mail', 'neuuser@g.com');
        $I->fillField('Aktiv von', $now->format('2018-m-t H:i'));
        $I->selectOption('Rolle', 'Ausschreibungen');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Benutzername "user" wird bereits verwendet.'));
    }

    public function updateUserName(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->click('//*[@id="admin_user_grid"]/table/tbody/tr[2]/td[7]/a[2]');
        $I->see('Benutzer bearbeiten: user', 'h1');
        $I->fillField('Benutzername', 'TestUser');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Benutzer wurde aktualisiert'));
        $I->see('TestUser', 'h1');
    }

    public function deleteUser(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->see('deactivate');
        $I->seeRecord('common\models\AdminUser', [
            'id'           => 4,
            'username'     => 'deactivate',
            'active_until' => date('Y-m-d H:i',strtotime("-1 month")),
        ]);
        $I->click('//*[@id="admin_user_grid"]/table/tbody/tr[4]/td[7]/a[3]');
        $I->see(Yii::t('app', 'Benutzer wurde erfolgreich gelöscht'));
        $I->dontSeeRecord('common\models\AdminUser', [
            'id'       => 4,
            'username' => 'deactivate',
        ]);
    }

    public function activateDeactivatedUser(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->see('deactivate');
        $I->click('//*[@id="admin_user_grid"]/table/tbody/tr[4]/td[7]/a[1]');
        $I->see('deactivate', 'h1');
        $I->seeLink('sofort Aktivieren');
        $I->seeRecord('common\models\AdminUser', [
            'id'           => 4,
            'username'     => 'deactivate',
            'active_until' => date('Y-m-d H:i',strtotime("-1 month")),
        ]);
        $I->click('sofort Aktivieren');
        $I->see(Yii::t('app', 'Benutzer wurde aktiviert'));
        $I->seeRecord('common\models\AdminUser', [
            'id'           => 4,
            'username'     => 'deactivate',
            'active_until' => null,
        ]);
    }

    public function deactivateActiveUser(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'user', 'Meinaicovo1');
        $I->click('Logout');
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->see('user');
        $I->click('//*[@id="admin_user_grid"]/table/tbody/tr[2]/td[7]/a[1]');
        $I->seeLink(Yii::t('app', 'Deaktivieren'));
        $I->click('Deaktivieren');
        $I->see(Yii::t('app', 'Benutzer wurde deaktiviert'));
        $I->seeRecord('common\models\AdminUser', [
            'id'          => 2,
            'username'    => 'user',
            'active_from' => null,
        ]);
        $I->click('Logout');
        $I->fillField('Benutzername', 'user');
        $I->fillField('Passwort', 'Meinaicovo1');
        $I->click('login-button');
        $I->see(Yii::t('app', 'Benutzername oder Passwort falsch'));
    }

    public function requestPassword(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $I->amOnPage('/admin-user/index');
        $I->see('user');
        $I->seeRecord('common\models\AdminUser', [
            'id'                   => 2,
            'username'             => 'user',
            'password_reset_token' => null,
        ]);
        $I->click('//*[@id="admin_user_grid"]/table/tbody/tr[2]/td[7]/a[1]');
        $I->click(Yii::t('app', 'Passwort anfordern'));
        $I->see(Yii::t('app', 'Neues Passwort wurde angefordert'));
        $I->cantSeeRecord('common\models\AdminUser', [
            'id'                   => 2,
            'username'             => 'user',
            'password_reset_token' => null,
        ]);
    }

    public function setPassword(FunctionalTester $I)
    {
        $I->seeRecord('common\models\AdminUser', [
            'id'                   => 5,
            'username'             => 'set.password',
            'password_reset_token' => 'VClDZXmLGlx9n8cOadytE828yRZxLknC_' . time(),
        ]);
        $I->amOnPage('/site/login');
        $I->fillField('Benutzername', 'set.password');
        $I->fillField('Passwort', 'Meinaicovo1');
        $I->click('login-button');
        $I->see(Yii::t('app', 'Benutzername oder Passwort falsch'));
        $I->amOnPage('/site/reset-password?token=VClDZXmLGlx9n8cOadytE828yRZxLknC_' . time());
        $I->see(Yii::t('app', 'Passwort setzen'), 'h1');
        $I->fillField('Passwort', 'Meinaicovo1');
        $I->fillField('Passwort Wiederholung', 'Meinaicovo1');
        $I->click(Yii::t('app', 'Speichern'));
        $I->see(Yii::t('app', 'Neues Passwort wurde gespeichert'));
        TestUtilTest::loginUser($I, 'set.password', 'Meinaicovo1');
        $I->see('Logout (set.password)');
        $I->seeRecord('common\models\AdminUser', [
            'id'                   => 5,
            'username'             => 'set.password',
            'password_reset_token' => null,
        ]);
    }

    public function setPasswordFailsWithWrongToken(FunctionalTester $I)
    {
        $I->amOnPage('/site/reset-password?token=VClDZXmLGlx9n8cOadytE828yRZxLknC');
        $I->see(Yii::t('app','Ungültiger Aktivierungslink, token falsch: VClDZXmLGlx9n8cOadytE828yRZxLknC'));
    }


}