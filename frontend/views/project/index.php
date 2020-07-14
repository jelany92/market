<?php

/* @var $modelBaseData \common\models\BaseData */
/* @var $booleanList array */
/* @var $salutationList array */
/* @var $countryList array */
/* @var $companyTypeList array */
?>
    <h1><?= Yii::t('app', 'Projekt erfassen') ?></h1>
    <br>

<?= $this->render('_form', [
    'model'           => $model,
    'companyTypeList' => $companyTypeList,
    'countryList'     => $countryList,
    'salutationList'  => $salutationList,
    'booleanList'     => $booleanList,
]); ?>