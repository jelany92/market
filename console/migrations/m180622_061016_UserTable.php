<?php

use common\models\auth\AuthItem;
use yii\db\Migration;

/**
 * Class m180622_061016_UserTable
 */
class m180622_061016_UserTable extends Migration
{

    const ADMIN_USER_ID = 1;
    const ADMIN_PASSWD  = 'ahmadsms';
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
        echo "m180622_061016_UserTable cannot be reverted.\n";

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

        // create table admin_user and FK from auth_assignent.user_id -> admin_user.id)
        $this->createAdminUserTable();

        // create user admin in table admin_user and assign role & permission
        $this->insertAdminUser();

    }

    private function createAdminUserTable()
    {
        // remove index in order to alter column user_id of auth_assignment to integer (must match user_id's type in table admin_user
        $this->alterColumn("auth_assignment", "user_id", $this->integer(11)->notNull());

        $this->createTable('admin_user',

                           [
                               'id'                   => $this->primaryKey(),
                               'username'             => $this->string(25)->notNull()->unique(),
                               'company_name'         => $this->string()->notNull()->defaultValue('Market'),
                               'first_name'           => $this->string(25)->notNull(),
                               'last_name'            => $this->string(25)->notNull(),
                               'password'             => $this->string(),
                               'password_reset_token' => $this->string()->unique(),
                               'email'                => $this->string()->notNull()->unique(),
                               'category'             => $this->string()->notNull(),
                               'active_from'          => $this->dateTime(),
                               // allow null for deactivation
                               'active_until'         => $this->dateTime(),
                               'created_at'           => $this->dateTime()->notNull(),
                               'updated_at'           => $this->dateTime(),
                           ], $this->tableOptions);
        //FK from auth_assignment.user_id -> admin_user.id

        $this->addForeignKey("auth_assignment_user_id_admin_user_id", "auth_assignment", "user_id", "admin_user", "id");

    }

    private function insertAdminUser()
    {
        $this->insert('admin_user', [
            'id'           => self::ADMIN_USER_ID,
            'username'     => 'Ahmad',
            'company_name' => 'Adam',
            'first_name'   => 'admin',
            'last_name'    => 'admin',

            'password'             => $this->genPwd(self::ADMIN_PASSWD),
            'password_reset_token' => null,
            'email'                => 'j_robben92@hotmail.com',
            'category'             => 'Market',

            'active_from'  => date("Y-m-d H:i:s"),
            'active_until' => null,
            'created_at'   => date("Y-m-d H:i:s"),
            'updated_at'   => null,
        ], $this->tableOptions);
        // assign role & permission to admin
        $this->createAdminRoleAndPermission();
    }

    public function down()
    {
        $this->dropForeignKey("auth_assignment_user_id_admin_user_id", "auth_assignment");
        $this->removeAdminRoleAndPermission();
        // restore old column type
        $this->alterColumn('auth_assignment', 'user_id', $this->string(64)->notNull());
        $this->createIndex("auth_assignment_user_id_idx", "auth_assignment", 'user_id'); //
        $this->dropTable('admin_user');

        return true;
    }

    /**
     *
     * creates encode passwd from plain text pwd
     *
     * @param $passwd
     *
     * @return string
     * @throws \yii\base\Exception
     */
    private function genPwd($passwd)
    {
        return Yii::$app->security->generatePasswordHash($passwd);
    }

    /**
     * creates role admin for user admin and adds permission *.* to the role
     *
     * @throws Exception
     */
    private function createAdminRoleAndPermission()
    {
        // create and add role admin
        $auth  = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // create super permission
        $superPerm = $auth->createPermission(AuthItem::SUPER_PERMISSION);
        $auth->add($superPerm);

        // assign permission *.* to role admin
        $auth->addChild($admin, $superPerm);

        // assign role admin to user admin
        $auth->assign($admin, self::ADMIN_USER_ID);
    }

    private function removeAdminRoleAndPermission()
    {
        // create and add role admin
        $auth  = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $auth->remove($admin);
        $superPerm = $auth->createPermission(AuthItem::SUPER_PERMISSION);
        $auth->remove($superPerm);
        $auth->removeChild($admin, $superPerm);
    }

}
