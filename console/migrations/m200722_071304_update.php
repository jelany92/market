<?php

use yii\db\Migration;

/**
 * Class m200722_071304_update
 */
class m200722_071304_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('article_inventory', 'company_id', $this->integer()->notNull()->after('id')->defaultValue('3'));
        $this->addForeignKey('fk_article_inventory_user_id', 'article_inventory', 'company_id', 'admin_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200722_071304_update cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200722_071304_update cannot be reverted.\n";

        return false;
    }
    */
}
