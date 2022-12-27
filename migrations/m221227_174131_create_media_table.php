<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 */
class m221227_174131_create_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'path' => $this->string(),
            'book_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-media-book_id}}',
            '{{%media}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-media-book_id}}',
            '{{%media}}',
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
            '{{%fk-media-book_id}}',
            '{{%media}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-media-book_id}}',
            '{{%media}}'
        );

        $this->dropTable('{{%media}}');
    }
}
