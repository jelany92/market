<?php

use common\models\BaseData;
use common\models\CompanyType;
use common\models\Country;

/* @var $model \common\models\BaseDataForm */
/* @var $key string */
?>

<div class="card mb-2">
    <h5 class="card-header">
        <a data-toggle="collapse" href="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>" id="heading<?= $key ?>" class="d-block">
            <?= Yii::t('app', 'Projektdetails') ?>
        </a>
    </h5>
    <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>" data-parent="#accordion">
        <div class="card-body">

            <?= $this->render('_form', [
                'model'           => $model,
                'key'             => $key,
                'booleanList'     => BaseData::getBooleanList(),
                'salutationList'  => BaseData::getSalutationList(),
                'countryList'     => Country::getNameList(),
                'companyTypeList' => CompanyType::getNameList(),
            ]); ?>
        </div>
    </div>
</div>