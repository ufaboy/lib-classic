<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $text
 * @property int|null $view_count
 * @property int|null $rating
 * @property int|null $bookmark
 * @property string|null $source
 * @property string|null $cover
 * @property int|null $author_id
 * @property int|null $series_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $last_read
 *
 * @property Author $author
 * @property BookTag[] $bookTags
 * @property Series $series
 * @property Tag[] $tags
 * @property int[]|null $tag_ids
 */
class Book extends \yii\db\ActiveRecord {
	public $tag_ids = [];

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'book';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			TimestampBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['text'], 'string'],
			[['view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read'], 'integer'],
			[['tag_ids'], 'safe'],
			[['name', 'cover'], 'string', 'max' => 255],
			[['description', 'source'], 'string', 'max' => 1024],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
			[['series_id'], 'exist', 'skipOnError' => true, 'targetClass' => Series::className(), 'targetAttribute' => ['series_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'text' => 'Text',
			'view_count' => 'View Count',
			'rating' => 'Rating',
			'bookmark' => 'Bookmark',
			'source' => 'Source',
			'cover' => 'Cover',
			'author_id' => 'Author ID',
			'series_id' => 'Series ID',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'last_read' => 'Last Read',
		];
	}

	public function afterSave($insert, $changedAttributes) {
		// If this is not a new record, unlink all records related through relationship 'activities'
		if (!$this->isNewRecord) {
			$this->unlinkAll('tags', true);
		}
		foreach ($this->tag_ids as $tag_id) {
			$tag = Tag::findOne($tag_id);
			$this->link('tags', $tag);
		}

		parent::afterSave($insert, $changedAttributes);
	}

	/**
	 * Gets query for [[Author]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthor() {
		return $this->hasOne(Author::className(), ['id' => 'author_id']);
	}

	/**
	 * Gets query for [[BookTags]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getBookTags() {
		return $this->hasMany(BookTag::className(), ['book_id' => 'id']);
	}

	/**
	 * Gets query for [[Series]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getSeries() {
		return $this->hasOne(Series::className(), ['id' => 'series_id']);
	}

	/**
	 * Gets query for [[Tags]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getTags() {
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('book_tag', ['book_id' => 'id']);
	}
}
