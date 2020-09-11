<?php

use yii\db\Migration;

/**
 * Class m200911_141043_working_form
 */
class m200911_141043_working_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('working_form_request', [
            'id'          => $this->primaryKey(),
            'token'       => $this->string(),
            'name'        => $this->string(),
            'is_complete' => $this->boolean(),
            'created_at'  => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('working_form_main_category_question', [
            'id'                          => $this->primaryKey(),
            'main_category_question_name' => $this->string(100)->notNull(),
            'description'                 => $this->text(),
            'question_type'               => $this->string(),
            'created_at'                  => $this->dateTime(),
            'updated_at'                  => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('working_form_question', [
            'id'                        => $this->primaryKey(),
            'main_category_question_id' => $this->integer(),
            'question'                  => $this->text(),
            'created_at'                => $this->dateTime(),
            'updated_at'                => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('quiz_exercise_main_question_exercise_id', 'working_form_question', 'main_category_question_id', 'working_form_main_category_question', 'id');

        $this->createTable('working_form_answers', [
            'id'             => $this->primaryKey(),
            'question_id'    => $this->integer(),
            'request_id'     => $this->integer(),
            'request_answer' => $this->string(10),
            'created_at'     => $this->dateTime(),
            'updated_at'     => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        //         add foreign key for table `students`
        $this->addForeignKey('fk_sworking_form_answers_question_id', 'working_form_answers', 'question_id', 'working_form_request', 'id', 'CASCADE');
        $this->addForeignKey('fk_working_form_answers_request_id', 'working_form_answers', 'request_id', 'working_form_question', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('quiz_exercise_main_question_exercise_id', 'working_form_question');
        $this->dropTable('working_form_main_category_question');
        $this->dropForeignKey('fk_sworking_form_answers_question_id', 'working_form_answers');
        $this->dropForeignKey('fk_working_form_answers_request_id', 'working_form_answers');
        $this->dropTable('working_form_answers');
        $this->dropTable('working_form_question');
        $this->dropTable('working_form_request');
    }

}
