<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "series".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $url
 *
 * @property Book[] $books
 */
class Series extends ActiveRecord {
	public static function getDb() {
		return Yii::$app->db2;
	}
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return 'series';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
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
		return $this->hasMany(Book::className(), ['series_id' => 'id']);
	}
}
