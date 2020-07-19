<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "article_inventory".
 *
 * @property string articleName
 * @property string articlePrice
 * @property string articleCount
 * @property string articleGain
 *
 * @property ArticleInStored[] $articleInStoreds
 */
class ArticleIGain extends Model
{
    public $articleName;
    public $articlePrice;
    public $articleCount;
    public $articleGain;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['articlePrice', 'articleCount', 'articleGain'], 'required'],
            [['articleName'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'articleName'  => Yii::t('app', 'Article Name'),
            'articlePrice' => Yii::t('app', 'Article Price'),
            'articleCount' => Yii::t('app', 'Article Count'),
            'articleGain'  => Yii::t('app', 'Article Gain'),
        ];
    }

}
