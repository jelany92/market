<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use backend\tests\util\TestUtilTest;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use Yii;

class AuthCest
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

            'user' => ['class'    => AdminUserFixture::class,
                       'dataFile' => codecept_data_dir() . 'admin_user.php'],

            'auth' => ['class'    => AuthItemFixture::class,
                       'dataFile' => codecept_data_dir() . 'auth_data.php'],

            'auth_child' => ['class'    => AuthItemChildFixture::class,
                             'dataFile' => codecept_data_dir() . 'auth_child_data.php'],

            'authAssignment' => ['class'    => AuthAssignmentFixture::class,
                                 'dataFile' => codecept_data_dir() . 'auth_assigment_data.php',],];
    }

    public function createTask(FunctionalTester $I)
    {

        // passwd defined in backend/tests/_data/admin_user.php
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $task = 'handleUser';
        $I->amGoingTo('open auth-item index view');
        $I->amOnPage('/auth-item/index');
        $I->canSee(Yii::t('app', 'Rechte & Rollen'), 'h1');
        $I->canSee(Yii::t('app', 'Aufgaben'));

        $I->amGoingTo('Create a task');
        $I->canSee(Yii::t('app', 'Eintrag Erstellen'));
        $I->amOnPage('/auth-item/create');
        $I->see(Yii::t('app', 'Speichern'));
        $I->fillField(Yii::t('app','Name'), $task);
        $I->selectOption(Yii::t('app','Typ'), 'Aufgabe');
        $I->click(Yii::t('app','Speichern'));
        $I->see(Yii::t('app','Eintrag wurde erstellt'));
        $I->see(Yii::t('app', 'Aufgabe: ' ). $task);
    }
    /**
     * user with role 'admin' creates new Task
     *
     * @param FunctionalTester $I
     */
    public function createTaskFailsWithEmptyForm(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, "admin", "Meinaicovo1");
        $I->amOnPage(['/auth-item/index']);
        $I->see(Yii::t('app','Rechte & Rollen')); // 'Verwaltung->Rechte etc.'
        $I->see(Yii::t('app','Eintrag erstellen'));
        $I->click(Yii::t('app','Eintrag erstellen'));
        $I->submitForm('//*[@id="auth-item-form"]', []);
        $I->expectTo('see validations errors');
        $I->see(Yii::t('app','Name darf nicht leer sein.'));
    }

    public function viewRole(FunctionalTester $I)
    {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $role = 'praktikant';
        $I->amGoingTo('open auth-item/viewid=praktikant');
        $I->amOnPage('/auth-item/view?id=' . $role);
        $I->canSee(Yii::t('app', 'Rolle: ' . $role));
    }

    /**
     * 1. Display view of role 'praktikant'
     * 2. Click 'update' button
     * 3. check if update form opens
     *
     * @param FunctionalTester $I
     */

    public function updateRoleFromView(FunctionalTester $I ) {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $role = 'praktikant';
        $I->amGoingTo('update role');
        $I->amOnPage('/auth-item/view?id=' . $role);
        $I->canSee(Yii::t('app', 'Rolle: ' . $role));
        $I->amGoingTo('click on update button');
        $I->click(Yii::t('app','Rolle bearbeiten'));
        $I->canSee(Yii::t('app', 'Bearbeiten: ' . $role));
        $I->fillField(Yii::t('app','Beschreibung'),'test');
        $I->click(Yii::t('app','Speichern'));
        $I->see(Yii::t('app','Eintrag wurde aktualisiert'));
    }

    /**
     * 1. Display auth-item  index
     * 2. Click 'update' icon in action column
     * 3. check if update form opens
     *
     * @param FunctionalTester $I
     */

    public function updateRoleFromIndex(FunctionalTester $I ) {
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $role = 'praktikant';
        $I->amGoingTo('update role');
        $I->amOnPage('/auth-item/index');
        $I->canSee(Yii::t('app', 'Rechte & Rollen'));
        $I->canSee(Yii::t('app', $role));
        $I->amGoingTo('click on update button');
        $I->click('//*[@data-key="praktikant"]/td[3]/a[2]');
        $I->canSee(Yii::t('app', 'Bearbeiten: '). $role);
        $I->fillField(Yii::t('app','Beschreibung'),'praktikant');
        $I->click(Yii::t('app','Speichern'));
        $I->see(Yii::t('app','Eintrag wurde aktualisiert'));
        $I->see(Yii::t('app','Rolle: ') .$role,'h2');
    }

    public function deleteTask(FunctionalTester $I)
    {
        // passwd defined in backend/tests/_data/admin_user.php
        TestUtilTest::loginUser($I, 'admin', 'Meinaicovo1');
        $role = 'praktikant';
        $I->amGoingTo('open auth-item index view');
        $I->amOnPage('/auth-item/index');
        $I->canSee(Yii::t('app', 'Rollen'));
        $I->canSee(Yii::t('app', 'Aufgaben'));
        $I->canSee(Yii::t('app', 'Rechte'));
        $I->amGoingTo('Delete a task');
        $I->amOnPage('/auth-item/view?id=' . $role);
        $I->canSee(Yii::t('app', 'Rolle: ' . $role), 'h2');
        $I->click(Yii::t('app','Löschen'));
        $I->canSee(Yii::t('app', $role . ' erfolgreich gelöscht'));
    }

 }