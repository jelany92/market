<?php
/**
 * Created by PhpStorm.
 * User: jelani.qattan
 * Date: 09.08.2018
 * Time: 16:04
 */

namespace common\tests\unit\models;


use backend\models\ModulUserDetailContact;
use Codeception\Test\Unit;

class ModulUserDetailContactTest extends Unit
{
    public function testTypeList()
    {
        $model       = new ModulUserDetailContact();
        $model->type = ModulUserDetailContact::TYPE_ADMIN;
        $this->assertTrue($model->validate('type'));
        $this->assertEquals(['admin' => 'Admin','contact_person' => 'Ansprechpartner','provider' => 'Dienstleister'], $model->getTypeList($showAdmin = true));
    }

}