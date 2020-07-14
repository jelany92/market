<?php
/**
 * Created by PhpStorm.
 * User: jelani.qattan
 * Date: 09.08.2018
 * Time: 16:04
 */

namespace common\tests\unit\models;


use Codeception\Test\Unit;
use common\models\UserStamm;

class UserStammTest extends Unit
{

    public function testFullName()
    {
        $model           = new UserStamm();
        $model->anrede   = 'rtt';
        $model->vorname  = 'Hrtt';
        $model->nachname = 'Hrtt';
        $result          = $model->getFullName();
        $this->assertTrue($model->validate('anrede'));
        $this->assertEquals('Rtt Hrtt Hrtt', $result);

    }

/*    public function testLogoUpload()
    {
        // Create Copy of test upload file so that we can reuse it
        $pathToTestFile = \Yii::getAlias('@common') . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . '_upload' . DIRECTORY_SEPARATOR;
        $test_file = $pathToTestFile . 'logo.jpg';
        $temp_file = $pathToTestFile . 'logo_temp.jpg';
        $this->fileExists($test_file);
        // Delete old copy of file
        if(file_exists($temp_file)){
            unlink($temp_file);
        }
        chmod($test_file,0755);
        copy($test_file, $temp_file);
        $this->fileExists($temp_file);#
        // Change rights so that this file can be moved and deleted in our Test
        // Prepare $_FILES for test
        $attribute = 'logoFile';
        $test = [
            'UserStamm' => [
                'name'     => [$attribute => 'logo.jpg'],
                'type'     => [$attribute => 'image/jpeg'],
                'tmp_name' => [$attribute => $temp_file],
                'error'    => [$attribute => 0],
                'size'     => [$attribute => filesize($temp_file)],
            ],
        ];
        $_FILES = $test;

        $model = new UserStamm();
        $this->assertEmpty($model->logo);
        $model->logoUpload();
        $this->assertNotEmpty($model->logo);
    }*/

}