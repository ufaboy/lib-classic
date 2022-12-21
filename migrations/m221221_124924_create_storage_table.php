<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%storage}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 */
class m221221_124924_create_storage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%storage}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'extension' => $this->string(),
            'size' => $this->integer(),
            'path' => $this->string(),
            'book_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-storage-book_id}}',
            '{{%storage}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-storage-book_id}}',
            '{{%storage}}',
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
            '{{%fk-storage-book_id}}',
            '{{%storage}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-storage-book_id}}',
            '{{%storage}}'
        );

        $this->dropTable('{{%storage}}');
    }
}
