<?php

use common\models\ArticleInfo;
use common\widgets\Table;

/* @var $this yii\web\View */
/* @var $returnedGoodsList array */

$tableReturnedGoods = [
    'tableArray' => [
        [
            [
                'type'  => 'th',
                'html'  => '<strong>' . Yii::t('app', 'Article Name') . '</strong>',
                'style' => 'text-align: left;',
            ],
            [
                'type'  => 'th',
                'html'  => '<strong>' . Yii::t('app', 'Article Count') . '</strong>',
                'style' => 'text-align: left;',
            ],
            [
                'type'  => 'th',
                'html'  => '<strong>' . Yii::t('app', 'Article Price') . '</strong>',
                'style' => 'text-align: left;',
            ],
            [
                'type'  => 'th',
                'html'  => '<strong>' . Yii::t('app', 'Total') . '</strong>',
                'style' => 'text-align: left;',
            ],
            [
                'type'  => 'th',
                'html'  => '<strong>' . Yii::t('app', 'Date') . '</strong>',
                'style' => 'text-align: left;',
            ],
        ],
    ],
];
foreach ($returnedGoodsList as $returnedGoods)
{
    $tableReturnedGoods['tableArray'][] = [
        [
            'type'  => 'td',
            'html'  => isset(ArticleInfo::getArticleNameList()[$returnedGoods['name']]) == true ? ArticleInfo::getArticleNameList()[$returnedGoods['name']] : $returnedGoods['name'],
            'style' => 'width:40%;',
        ],
        [
            'type'  => 'td',
            'html'  => isset($returnedGoods['count']) ? $returnedGoods['count'] : '',
            'style' => 'width:25%;',
        ],
        [
            'type'  => 'td',
            'html'  => isset($returnedGoods['price']) ? $returnedGoods['price'] : '',
            'style' => 'width:20%;',
        ],
        [
            'type'  => 'td',
            'html'  => isset($returnedGoods['count']) & isset($returnedGoods['price']) ? $returnedGoods['count'] * $returnedGoods['price'] : '',
            'style' => 'width:20%;',
        ],
        [
            'type'  => 'td',
            'html'  => isset($returnedGoods['selected_date']) ? DateTime::createFromFormat('Y-m-d', $returnedGoods['selected_date'])->format('d.m.Y') : '',
            'style' => 'width:30%;',
        ],
    ];
}
?>

<link href="/css/pdf-print.css" rel="stylesheet" type="text/css">
<div class="user-stamm-view">
    <h1><?= Yii::t('app', 'Returned Goods') ?></h1>
    <?= Table::widget($tableReturnedGoods) ?>
</div>
