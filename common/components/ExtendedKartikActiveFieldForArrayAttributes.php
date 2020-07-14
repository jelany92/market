<?php
/**
 * Created by PhpStorm.
 * User: nico.nuernberger
 * Date: 20.02.2019
 * Time: 07:57
 */

namespace common\components;


use kartik\form\ActiveField;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Html;

/**
 * This class is needed to properly show errors on form fields that are not standalone model attributes but values in an array of a model
 * It requires a custom validator which writes the the error attribute name like this [errorIndex]/attributeName where errorIndex is the index number specified in the fields errorOptions
 * Example code can be found in JobquickModulForm and backend/views/jobquick-module/_form.php
 *
 * Class ExtendedKartikActiveFieldForArrayAttributes
 * @package common\components
 */
class ExtendedKartikActiveFieldForArrayAttributes extends ActiveField
{
    public function error($options = [])
    {
        if ($options === false) {
            $this->parts['{error}'] = '';
            return $this;
        }
        $options = array_merge($this->errorOptions, $options);
        $this->parts['{error}'] = static::writeErrorTag($this->model, $this->attribute, $options);

        return $this;
    }

    public static function writeErrorTag($model, $attribute, $options = [])
    {
        $attribute = BaseHtml::getAttributeName($attribute);
        $errorSource = ArrayHelper::remove($options, 'errorSource');
        $errorIndex = @$options['errorIndex'];
        if ($errorSource !== null)
        {
            $error = call_user_func($errorSource, $model, $attribute, $errorIndex);
        }
        elseif(isset($errorIndex))
        {
            $error = isset($model->errors[$errorIndex . '/' . $attribute][0]) ? $model->errors[$errorIndex . '/' . $attribute][0] : null;
        } else {
            $error = $model->getFirstError($attribute);
        }
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $encode = ArrayHelper::remove($options, 'encode', true);

        return Html::tag($tag, $encode ? Html::encode($error) : $error, $options);
    }

    /**
     * Renders the opening tag of the field container.
     * @return string the rendering result.
     */
    public function begin()
    {
        if ($this->form->enableClientScript) {
            $clientOptions = $this->getClientOptions();
            if (!empty($clientOptions)) {
                $this->form->attributes[] = $clientOptions;
            }
        }

        $inputID = $this->getInputId();
        $attribute = Html::getAttributeName($this->attribute);
        $options = $this->options;
        $class = isset($options['class']) ? (array) $options['class'] : [];
        $class[] = "field-$inputID";
        if ($this->model->isAttributeRequired($attribute)) {
            $class[] = $this->form->requiredCssClass;
        }
        $options['class'] = implode(' ', $class);
        if ($this->form->validationStateOn === ExtendedKartikActiveFormForArrayAttributes::VALIDATION_STATE_ON_CONTAINER) {
            $this->addErrorClassBS4($options);
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::beginTag($tag, $options);
    }


    /**
     * Adds Bootstrap 4 validation class to the input options if needed.
     * @param array $options
     * @throws InvalidConfigException
     */
    protected function addErrorClassBS4(&$options)
    {
        $errorIndex = @$this->errorOptions['errorIndex'];//ArrayHelper::remove($this->errorOptions, 'errorIndex');
        $attributeName = Html::getAttributeName($this->attribute);
        if ($this->form->isBs4() && $this->form->validationStateOn === ExtendedKartikActiveFormForArrayAttributes::VALIDATION_STATE_ON_CONTAINER) {
            if(isset($errorIndex) && isset($this->model->errors[$errorIndex . '/' . $attributeName][0]))
            {
                Html::addCssClass($options, 'has-error');
            }
            elseif($this->model->hasErrors($attributeName))
            {
                Html::addCssClass($options, 'is-invalid');
            }
        }
    }
}