<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%series}}`.
 */
class m221112_050049_create_series_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%series}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'url' => $this->string(1024),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%series}}');
    }
}
