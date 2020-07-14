<?php

use yii\db\Migration;
use common\models\auth\AuthItem;
use yii\db\Expression;

/**
 * Class m190131_050642_fill_auth_tables
 */
class m190131_050642_fill_auth_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('auth_item', [
            'name',
            'type',
            'description',
            'rule_name',
            'data',
            'created_at',
            'updated_at',
        ], [
                               [
                                   'attachment.*',
                                   AuthItem::TYPE_PERMISSION,
                                   'Zusätze',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'Ausschreibungen verwalten',
                                   AuthItem::TYPE_TASK,
                                   'Kann Projekte, Zusätze, Themenbereiche, Funktionen, Rollen und Firmenarten verwalten',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'base-data.*',
                                   AuthItem::TYPE_PERMISSION,
                                   'Projekte',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'category.*',
                                   AuthItem::TYPE_PERMISSION,
                                   'Themenbereiche',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'company-type.*',
                                   AuthItem::TYPE_PERMISSION,
                                   'Firmenarten',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'function.*',
                                   AuthItem::TYPE_PERMISSION,
                                   'Funktionen',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'role.*',
                                   AuthItem::TYPE_PERMISSION,
                                   'Rollen',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                               [
                                   'Vertrieb',
                                   AuthItem::TYPE_ROLE,
                                   'Kann Projekte, Zusätze, Themenbereiche, Funktionen, Rollen und Firmenarten verwalten',
                                   null,
                                   null,
                                   new Expression('UNIX_TIMESTAMP()'),
                                   new Expression('UNIX_TIMESTAMP()'),
                               ],
                           ]);

        $this->batchInsert('auth_item_child', [
            'parent',
            'child',
        ], [
                               [
                                   'Ausschreibungen verwalten',
                                   'attachment.*',
                               ],
                               [
                                   'Vertrieb',
                                   'Ausschreibungen verwalten',
                               ],
                               [
                                   'Ausschreibungen verwalten',
                                   'base-data.*',
                               ],
                               [
                                   'Ausschreibungen verwalten',
                                   'category.*',
                               ],
                               [
                                   'Ausschreibungen verwalten',
                                   'company-type.*',
                               ],
                               [
                                   'Ausschreibungen verwalten',
                                   'function.*',
                               ],
                               [
                                   'Ausschreibungen verwalten',
                                   'role.*',
                               ],
                           ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190131_150642_fill_auth_tables cannot be reverted.\n";

        return false;
    }
}
