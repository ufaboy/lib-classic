<?php

namespace app\common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $url
 *
 * @property Book[] $books
 */
class Author extends ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return 'author';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name'], 'string', 'max' => 255],
			[['url'], 'string', 'max' => 1024],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array {
		return [
			'id' => 'ID',
			'name' => 'Name',
			'url' => 'Url',
		];
	}

	/**
	 * Gets query for [[Books]].
	 *
	 * @return ActiveQuery
	 */
	public function getBooks(): ActiveQuery {
		return $this->hasMany(Book::className(), ['author_id' => 'id']);
	}
}
