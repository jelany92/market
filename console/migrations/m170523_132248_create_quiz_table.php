<?php

use yii\db\Migration;

/**
 * Handles the creation of table `students`.
 */
class m170523_132248_create_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('quiz_students', [
            'id'             => $this->primaryKey(),
            'token'          => $this->string(),
            'name'           => $this->string(),
            'correct_answer' => $this->smallInteger(),
            'wrong_answer'   => $this->smallInteger(),
            'score'          => $this->smallInteger(),
            'is_complete'    => $this->boolean(),
            'created_at'     => $this->dateTime(),
            'updated_at'     => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('quiz_main_category_exercise', [
            'id'                          => $this->primaryKey(),
            'main_category_exercise_name' => $this->string(100)->notNull(),
            'description'                 => $this->text(),
            'question_type'               => $this->string(),
            'created_at'                  => $this->dateTime(),
            'updated_at'                  => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('quiz_exercise', [
            'id'                        => $this->primaryKey(),
            'main_category_exercise_id' => $this->integer(),
            'question'                  => $this->text(),
            'answer_a'                  => $this->string(),
            'answer_b'                  => $this->string(),
            'answer_c'                  => $this->string(),
            'answer_d'                  => $this->string(),
            'correct_answer'            => $this->string(10),
            'created_at'                => $this->dateTime(),
            'updated_at'                => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('quiz_exercise_main_category_exercise_id', 'quiz_exercise', 'main_category_exercise_id', 'quiz_main_category_exercise', 'id');

        $this->createTable('quiz_student_answers', [
            'id'             => $this->primaryKey(),
            'excercise_id'   => $this->integer(),
            'student_id'     => $this->integer(),
            'student_answer' => $this->string(10),
            'created_at'     => $this->dateTime(),
            'updated_at'     => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        //         add foreign key for table `students`
        $this->addForeignKey('fk-student_answers-student_id', 'quiz_student_answers', 'student_id', 'quiz_students', 'id', 'CASCADE');
        $this->addForeignKey('fk-student_answers-excercise_id', 'quiz_student_answers', 'excercise_id', 'quiz_exercise', 'id', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('quiz_exercise_main_category_exercise_id', 'quiz_exercise');
        $this->dropTable('quiz_main_category_exercise');
        $this->dropForeignKey('fk-student_answers-excercise_id', 'quiz_student_answers');
        $this->dropForeignKey('fk-student_answers-student_id', 'quiz_student_answers');
        $this->dropTable('quiz_student_answers');
        $this->dropTable('quiz_exercise');
        $this->dropTable('quiz_students');

    }
}
