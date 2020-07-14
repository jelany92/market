<?php
/**
 * Created by PhpStorm.
 * User: jelani.qattan
 * Date: 09.08.2018
 * Time: 16:04
 */

namespace common\tests\unit\models;


use Codeception\Test\Unit;
use common\models\UserSubDetail;

class UserSubDetailTest extends Unit
{
    public function testFullName()
    {
        $model       = new UserSubDetail();
        $model->anrede = 'rtt';
        $model->vorname = 'Hrtt';
        $model->nachname = 'Hrtt';
        $result               = $model->getFullName();
        $this->assertTrue($model->validate('anrede'));
        $this->assertEquals('rtt Hrtt Hrtt', $result);
    }

}