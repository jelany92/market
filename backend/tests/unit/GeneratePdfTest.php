<?php

namespace backend\tests\util;

use backend\components\GeneratePDFFiles;
use common\fixtures\AdminUserFixture;
use common\fixtures\AuthAssignmentFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\fixtures\BaseDataFixture;
use common\models\BaseData;

class GeneratePdfTest extends \Codeception\Test\Unit
{
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
            'base_data'      => [
                'class'    => BaseDataFixture::class,
                'dataFile' => codecept_data_dir() . 'base_data_data.php',
            ],

        ];
    }

    public function testGeneratePdfFilename()
    {
        $model               = new BaseData();
        $model->company_name = 'ttssd    dd';
        $generatePdf         = new GeneratePDFFiles();
        $this->assertEquals($generatePdf->generatePdfFilename($model), '2019_01_25_Leistungskatalog_ttssd____dd.pdf');
    }

}