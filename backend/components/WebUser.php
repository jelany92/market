<?php
/**
 * Created by PhpStorm.
 * User: jelani.qattan
 * Date: 17.07.2018
 * Time: 11:59
 */

namespace backend\components;


class WebUser extends \yii\web\User
{
    /**
     * @param string $permissionName , not used
     * @param array  $params         ['action' => actionValue, 'controller' => controllerValue]
     * @param bool   $allowCaching   optional
     *
     * @return bool
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        $params     = explode('.', $permissionName);
        $action     = $params[1];
        $controller = $params[0];
        $retVal     =
            parent::can("*.*", null, $allowCaching) ||
            parent::can($controller . ".*", null, $allowCaching) ||
            parent::can($controller . "." . $action, null, $allowCaching);
        return $retVal;
    }
}