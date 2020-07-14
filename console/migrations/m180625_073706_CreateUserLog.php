<?php

use yii\db\Migration;

/**
 * Class m180625_073706_CreateUserLog
 */
class m180625_073706_CreateUserLog extends Migration
{

    private $tableOptions;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180625_073706_CreateUserLog cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createAdminUserLogTable();
    }

    public function down()
    {
        $this->dropTable('admin_user_role_log');
    }

    private function createAdminUserLogTable()
    {
        $this->createTable('admin_user_role_log', [
            'id'          => $this->primaryKey(),
            'user_id'     => $this->integer(11)->notNull(),
            'modified_at' => 'datetime DEFAULT CURRENT_TIMESTAMP',
            'role'        => $this->string(64)->notNull(),
            // equal to auth_item.name's type
        ], $this->tableOptions);

        //FK from admin_user_role_log.user_id -> admin_user.id
        $this->addForeignKey("admin_user_role_log_user_id_admin_user_id", "admin_user_role_log", "user_id", "admin_user", "id");
    }

}
