<?php
/**
 * Created by PhpStorm.
 * User: uwe.janssen
 * Date: 15.06.2018
 * Time: 09:41
 */

namespace backend\tests\util;

use backend\tests\AcceptanceTester;
use yii\test\Fixture;

class TestUtilTest
{
    public static function loginUser($I, $user, $passwd)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Benutzername', $user);
        $I->fillField('Passwort', $passwd);
        $I->click('login-button');
        if ($I instanceof AcceptanceTester)
        {
            $I->wait(6);
        }
        $I->see("Logout ($user)", 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }

    /**
     * @param $I
     * @param $fixtureName
     * @param $instance
     * @param $index
     *
     * @return Fixture element specified by parameters
     */
    public static function getFixtureElement($I, $fixtureName, $instance, $index = null)
    {
        $fixtures = $I->grabFixtures();
        $fixture  = $fixtures[$fixtureName];
        if(is_null($index)){
            $retVal   = $fixture[$instance];
        }else{
            $retVal   = $fixture[$instance][$index];
        }
        return $retVal;
    }

    public static function getRoleFromFixtures($I, $role)
    {
        return self::getAuthAssignments($I)[$role];
    }

    private static function getAuthAssignments($I)
    {
        $a = $I->grabFixtures()['authAssignment'];
        return $a;
    }
}
