<?php

namespace app\models\query;

use app\models\query\traits\UserTrait;
use Codeception\Step\Condition;
use yii\db\conditions\BetweenColumnsCondition;

/**
 * This is the ActiveQuery class for [[Vertrage]].
 *
 * @see Vertrage
 */
class MarketExpensesQuery extends \yii\db\ActiveQuery
{
    /**
     * @param int $userId
     *
     * @return PurchasesQuery
     */
    public function userId(int $userId): MarketExpensesQuery
    {
        return $this->andWhere(['company_id' => $userId]);
    }

}