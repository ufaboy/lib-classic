<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 */
class m221227_174131_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'path' => $this->string(),
            'book_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-image-book_id}}',
            '{{%image}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-image-book_id}}',
            '{{%image}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-image-book_id}}',
            '{{%image}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-image-book_id}}',
            '{{%image}}'
        );

        $this->dropTable('{{%image}}');
    }
}
