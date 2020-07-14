<?php

use yii\db\Migration;

/**
 * Class m180712_042951_admin_user_login_log
 */
class m180712_042951_admin_user_login_log extends Migration
{
    private $tableOptions;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('admin_user_login_log', [
            'id'       => $this->primaryKey(),
            'user_id'  => $this->integer(11)->notNull(),
            'ip'       => $this->string(128)->notNull(),
            'login_at' => 'datetime DEFAULT CURRENT_TIMESTAMP',
        ], $this->tableOptions);

        //FK from admin_user_log.user_id -> admin_user.id
        $this->addForeignKey("admin_user_login_log_user_id_admin_user_id", "admin_user_login_log", "user_id", "admin_user", "id");

        $this->createTable('role', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(100)->notNull(),
            'description' => $this->text(),
            'sort'        => $this->integer(11)->notNull()->unsigned(),
            'created_at'  => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('role');
        $this->dropTable('admin_user_login_log');
    }


}
