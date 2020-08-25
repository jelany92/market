<?php

use yii\db\Migration;

/**
 * Class m200824_085846_returned_goods
 */
class m200824_085846_returned_goods extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('returned_goods', [
            'id'                    => $this->primaryKey(),
            'company_id'            => $this->integer()->notNull(),
            'current_admin_user_id' => $this->integer()->notNull(),
            'name'                  => $this->string()->notNull(),
            'count'                 => $this->integer()->notNull(),
            'price'                 => $this->double()->notNull(),
            'selected_date'         => $this->date()->notNull(),
            'created_at'            => $this->dateTime(),
            'updated_at'            => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_returned_goods_admin_user_id', 'returned_goods', 'company_id', 'admin_user', 'id');
        $this->addForeignKey('fk_returned_goods_current_admin_user_id', 'returned_goods', 'company_id', 'admin_user', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_returned_goods_admin_user_id', 'returned_goods');
        $this->dropForeignKey('fk_returned_goods_current_admin_user_id', 'returned_goods');
        $this->dropTable('returned_goods');
    }

}
