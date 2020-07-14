<?php
namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\web\Application;


class CheckIfLoggedIn extends Behavior
{
    /**
     * @return array
     */
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'CheckIfLoggedIn',
        ];
    }

    /**
     * CHECK der user hat angeloggt
     * @return bool
     */
    public function checkIfLoggedIn()
    {
        if(Yii::$app->user->isGuest)
        {
            return false;
        }
        return true; // or false to not run the action
    }

}