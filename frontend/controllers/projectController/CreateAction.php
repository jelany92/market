<?php

namespace frontend\controllers\projectController;


use common\models\BaseData;
use common\models\BaseDataForm;
use common\models\CompanyType;
use common\models\Country;
use Yii;
use yii\base\Action;


class CreateAction extends Action
{

    public $view;

    /**
     * Runs the action.
     *
     * @return string result content
     * @throws \yii\base\Exception
     */
    public function run()
    {
        $model = new BaseDataForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $baseData = $model->saveBaseData();
            if ($baseData instanceof BaseData)
            {
                if (Yii::$app->id == 'faktencheck-frontend')
                {
                    return Yii::$app->controller->redirect([
                        'details',
                        'key' => $baseData->public_key,
                    ]);
                }
                elseif (Yii::$app->id == 'faktencheck-backend')
                {
                    return Yii::$app->controller->redirect([
                        'view',
                        'id' => $baseData->id,
                    ]);
                }
                Yii::$app->session->addFlash('success', Yii::t('app', 'Projekt wurde gespeichert'));
                return Yii::$app->controller->redirect([
                    'view',
                    'id' => $baseData->id,
                ]);
            }
        }
        return Yii::$app->controller->render($this->view, [
            'model'           => $model,
            'booleanList'     => BaseData::getBooleanList(),
            'salutationList'  => BaseData::getSalutationList(),
            'countryList'     => Country::getNameList(),
            'companyTypeList' => CompanyType::getNameList(),
        ]);
    }
}