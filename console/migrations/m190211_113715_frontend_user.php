<?php

use yii\db\Migration;
use common\models\auth\AuthItem;
use yii\db\Expression;

/**
 * Class m190211_113715_frontend_user
 */
class m190211_113715_frontend_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user',
            [
                'id'                   => $this->primaryKey(),
                'username'             => $this->string(25)->notNull()->unique(),
                'first_name'           => $this->string(25)->notNull(),
                'last_name'            => $this->string(25)->notNull(),
                'password'             => $this->string(),
                'password_reset_token' => $this->string()->unique(),
                'email'                => $this->string()->notNull()->unique(),
                'created_at'           => $this->dateTime()->notNull(),
                'updated_at'           => $this->dateTime(),
            ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->batchInsert('auth_item', [
            'name',
            'type',
            'description',
            'created_at',
            'updated_at',
        ], [
            [
                'user.*',
                AuthItem::TYPE_PERMISSION,
                "Frontend Benutzer",
                new Expression('UNIX_TIMESTAMP()'),
                new Expression('UNIX_TIMESTAMP()'),
            ],
            [
                'Frontend Verwalten',
                AuthItem::TYPE_TASK,
                "Ermöglicht das Anlegen und Löschen von Frontend Nutzern",
                new Expression('UNIX_TIMESTAMP()'),
                new Expression('UNIX_TIMESTAMP()'),
            ],
        ]);

        $this->batchInsert('auth_item_child', [
            'parent',
            'child',
        ], [
            [
                'Frontend Verwalten',
                'user.*',
            ],
            [
                'Vertrieb',
                'Frontend Verwalten',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

}
