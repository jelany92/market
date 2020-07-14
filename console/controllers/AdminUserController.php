<?php
namespace console\controllers;

use common\models\AdminUser;
use yii\console\Controller;
use yii\data\ActiveDataProvider;

/**
 * All functions for AdminUser
 *
 * Class AdminUserController
 * @package console\controllers
 */
class AdminUserController extends Controller
{
    /**
     * Activates AdminUser
     */
    public function actionActivate()
    {
        $dataProvider = new ActiveDataProvider([
            'query'      => AdminUser::find()->toActivate(),
            'pagination' => false,
        ]);
        foreach ($dataProvider->getModels() AS $user){
            $user->activate();
        }
    }
}