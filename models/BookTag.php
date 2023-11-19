<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book_tag".
 *
 * @property int $book_id
 * @property int $tag_id
 *
 * @property Book $book
 * @property Tag $tag
 */
class BookTag extends ActiveRecord {
	public static function getDb() {
		return Yii::$app->db2;
	}
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return 'book_tag';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['book_id', 'tag_id'], 'required'],
			[['book_id', 'tag_id'], 'integer'],
			[['book_id', 'tag_id'], 'unique', 'targetAttribute' => ['book_id', 'tag_id']],
			[['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
			[['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array {
		return [
			'book_id' => 'Book ID',
			'tag_id' => 'Tag ID',
		];
	}

	/**
	 * Gets query for [[Book]].
	 *
	 * @return ActiveQuery
	 */
	public function getBook(): ActiveQuery {
		return $this->hasOne(Book::className(), ['id' => 'book_id']);
	}

	/**
	 * Gets query for [[Tag]].
	 *
	 * @return ActiveQuery
	 */
	public function getTag(): ActiveQuery {
		return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
	}
}
