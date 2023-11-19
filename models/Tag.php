<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 *
 * @property BookTag[] $bookTags
 * @property Book[] $books
 */
class Tag extends ActiveRecord {
	public static function getDb() {
		return Yii::$app->db2;
	}
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return 'tag';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['description'], 'string'],
			[['name'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array {
		return [
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
		];
	}

	/**
	 * Gets query for [[BookTags]].
	 *
	 * @return ActiveQuery
	 */
	public function getBookTags(): ActiveQuery {
		return $this->hasMany(BookTag::className(), ['tag_id' => 'id']);
	}

	/**
	 * Gets query for [[Books]].
	 *
	 * @return ActiveQuery
	 */
	public function getBooks(): ActiveQuery {
		return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('book_tag', ['tag_id' => 'id']);
	}
}
