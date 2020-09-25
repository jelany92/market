<?php

namespace common\components;

use DateTime;
use DateInterval;
use yii\bootstrap4\Html;

class ListeHelper
{

    /**
     * @return string
     */
    public static function YearList(): string
    {

        $dateBeforeYears   = new DateTime();
        $beforeTenYears    = $dateBeforeYears->sub(new DateInterval('P10Y'));
        $dateAfterOneYears = new DateTime();
        $afterOneYears     = $dateAfterOneYears->add(new DateInterval('P1Y'));
        $years             = [];
        for ($i = $beforeTenYears->format('Y'); $i <= $afterOneYears->format('Y'); $i++)
        {
            $years[$i] = $i;
        }
        return Html::dropDownList('year', [
            'id'   => 'pdfId',
            'name' => 'pdfName',
        ], $years, [
                                      'id'       => 'yearId',
                                      'class'    => 'btn btn-primary',
                                      'onchange' => 'myFunctionYear()',
                                      'prompt'   => \Yii::t('app', 'Choose Year'),
                                  ]);

    }

    /**
     * @param null $year
     * @param null $month
     *
     * @return string
     */
    public static function monthList($year = null, $month = null)
    {
        return Html::dropDownList('month', [
            'id'   => 'pdfId',
            'name' => 'pdfName',
        ], (\Yii::$app->params['months']), [
                                      'id'       => $month,
                                      'class'    => 'btn btn-primary selectElement',
                                      'onchange' => 'myFunctionMonth(' . $year . ')',
                                      //'style'    => $month == $m ? 'background-color: #40a7ff;' : '',
                                      'prompt'   => \Yii::t('app', 'Choose Month'),
                                  ]);

    }
}