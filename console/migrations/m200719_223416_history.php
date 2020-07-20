<?php

use yii\db\Migration;

/**
 * Class m200719_223416_history
 */
class m200719_223416_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('history', [
            'id'                     => $this->primaryKey(),
            'company_id'             => $this->integer()->notNull(),
            'current_admin_user_id'  => $this->integer()->notNull(),
            'summary'                => $this->string()->notNull(),
            'note'                   => $this->text(),
            'type'                   => $this->string()->notNull(),
            'edited_date_at'         => $this->dateTime(),
            'created_at'             => $this->dateTime(),
            'updated_at'             => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_history_admin_user_id', 'history', 'company_id', 'admin_user', 'id');


        $this->createTable('admin_history', [
            'id'            => $this->primaryKey(),
            'admin_user_id' => $this->integer()->notNull(),
            'field'         => $this->string(50)->notNull(),
            'old_name'      => $this->string(),
            'new_name'      => $this->string(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_admin_history_admin_user_id', 'admin_history', 'admin_user_id', 'admin_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_admin_history_admin_user_id', 'admin_history');
        $this->dropTable('admin_history');

        $this->dropForeignKey('fk_history_admin_user_id', 'history');
        $this->dropTable('history');
    }

}
