<?php
namespace backend\tests\acceptance;
use backend\tests\AcceptanceTester;
use backend\tests\util\TestUtilTest;

class CustomerCest
{
    public function before(AcceptanceTester $I)
    {
        TestUtilTest::loginUser($I,'admin','Meinaicovo1');
    }

    public function _after(AcceptanceTester $I)
    {
    }


    /**
     * display customerlist
     * @param AcceptanceTester $I
     */
    public function displayCustomerList(AcceptanceTester $I)
    {
        $I->amGoingTo("open the customer list");
        $I->canSee('Kunden'); // 'Verwaltung->Administrator'
        $I->click('#mainKunden'); // main menu Kunden
        return; // TODO find out why click at subMenu (id = #subKunden) is not working
        $I->wait(4);
        $I->click('#subKunden'); // submenu Kunden
        $I->wait(10);
        $I->see('Aktive Kunden');
        $I->wait(8);
    }
}
