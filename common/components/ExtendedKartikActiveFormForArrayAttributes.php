<?php
/**
 * Created by PhpStorm.
 * User: nico.nuernberger
 * Date: 20.02.2019
 * Time: 08:02
 */

namespace common\components;



use kartik\form\ActiveForm;
use yii\base\Model;

/*
 * This extended class is needed to reroute to the custom ActiveField class ExtendedKartikActiveFieldForArrayAttributes
 */
/* @method ExtendedKartikActiveFieldForArrayAttributes field(Model $model, \string $attribute, array $options = [])*/
class ExtendedKartikActiveFormForArrayAttributes extends ActiveForm
{
    /**
     * @inheritdoc
     */
    public $fieldClass = 'common\components\ExtendedKartikActiveFieldForArrayAttributes';
}