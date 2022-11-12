<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_tag}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 * - `{{%tag}}`
 */
class m221112_050208_create_junction_table_for_book_and_tag_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_tag}}', [
            'book_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'PRIMARY KEY(book_id, tag_id)',
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-book_tag-book_id}}',
            '{{%book_tag}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-book_tag-book_id}}',
            '{{%book_tag}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-book_tag-tag_id}}',
            '{{%book_tag}}',
            'tag_id'
        );

        // add foreign key for table `{{%tag}}`
        $this->addForeignKey(
            '{{%fk-book_tag-tag_id}}',
            '{{%book_tag}}',
            'tag_id',
            '{{%tag}}',
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
            '{{%fk-book_tag-book_id}}',
            '{{%book_tag}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-book_tag-book_id}}',
            '{{%book_tag}}'
        );

        // drops foreign key for table `{{%tag}}`
        $this->dropForeignKey(
            '{{%fk-book_tag-tag_id}}',
            '{{%book_tag}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-book_tag-tag_id}}',
            '{{%book_tag}}'
        );

        $this->dropTable('{{%book_tag}}');
    }
}
