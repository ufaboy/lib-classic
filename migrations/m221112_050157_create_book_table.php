<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%author}}`
 * - `{{%series}}`
 */
class m221112_050157_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(1024),
            'text' => 'MEDIUMTEXT',
            'view_count' => $this->integer()->notNull()->defaultValue(0),
            'rating' => $this->integer(),
            'bookmark' => $this->integer(),
            'source' => $this->string(1024),
            'cover' => $this->string(),
            'author_id' => $this->integer(),
            'series_id' => $this->integer(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'last_read' => $this->integer(11),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-book-author_id}}',
            '{{%book}}',
            'author_id'
        );

        // add foreign key for table `{{%author}}`
        $this->addForeignKey(
            '{{%fk-book-author_id}}',
            '{{%book}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );

        // creates index for column `series_id`
        $this->createIndex(
            '{{%idx-book-series_id}}',
            '{{%book}}',
            'series_id'
        );

        // add foreign key for table `{{%series}}`
        $this->addForeignKey(
            '{{%fk-book-series_id}}',
            '{{%book}}',
            'series_id',
            '{{%series}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%author}}`
        $this->dropForeignKey(
            '{{%fk-book-author_id}}',
            '{{%book}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-book-author_id}}',
            '{{%book}}'
        );

        // drops foreign key for table `{{%series}}`
        $this->dropForeignKey(
            '{{%fk-book-series_id}}',
            '{{%book}}'
        );

        // drops index for column `series_id`
        $this->dropIndex(
            '{{%idx-book-series_id}}',
            '{{%book}}'
        );

        $this->dropTable('{{%book}}');
    }
}
