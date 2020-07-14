<?php
/**
 * Created by PhpStorm.
 * User: jelani.qattan
 * Date: 09.08.2018
 * Time: 16:04
 */

namespace common\tests\unit\models;


use Codeception\Test\Unit;
use common\models\MdlContact;

class MdlContactTest extends Unit
{
    public function _testFullName()
    {
        $model                = new MdlContact();
        $model->salutation_id = MdlContact::SALUTATION_SIR;
        $model->firstname     = 'Sdf';
        $model->lastname      = 'Sdf';
        $result               = $model->getFullName();
        $this->assertTrue($model->validate('salutation_id'));
        $this->assertEquals('Herr Sdf Sdf', $result);
        //var_dump($model->getErrors());die();
    }

}