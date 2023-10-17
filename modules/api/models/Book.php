<?php

namespace app\modules\api\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Book extends ActiveRecord {
	public $tag_ids;
	public $upload;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return 'book';
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors(): array {
		return [
			TimestampBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['text'], 'string'],
			[['view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read'], 'integer'],
			[['tag_ids', 'bookmark'], 'safe'],
			[['name', 'cover'], 'string', 'max' => 255],
			[['description', 'source'], 'string', 'max' => 1024],
			[['upload'], 'file', 'extensions' => 'png, jpg, jpeg, webp, gif, webm, mp4, mp3', 'checkExtensionByMimeType' => false],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
			[['series_id'], 'exist', 'skipOnError' => true, 'targetClass' => Series::className(), 'targetAttribute' => ['series_id' => 'id']],
		];
	}

	public function fields() {
		return [
			'id',
			'name',
			'description',
			'text',
			'view_count',
			'rating',
			'bookmark',
			'source',
			'cover',
//			'author',
//			'series',
			'created_at',
			'updated_at',];
	}

	public function extraFields() {
		return [
			'tags',
			'author',
			'series',
			'images',
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

		if (!$this->isNewRecord) {
			$this->unlinkAll('tags', true);
		}
		foreach ($this->tag_ids as $tag_id) {
			$tag = Tag::findOne($tag_id);
			$this->link('tags', $tag);
		}

		if (array_key_exists('text', $changedAttributes)) {
			$this->saveTextToFs();
		}
		parent::afterSave($insert, $changedAttributes);
	}

	public function afterFind() {
		parent::afterFind();
		$this->tag_ids = $this->tags;
	}

	public function saveTextToFs() {
		$filename = str_pad($this->id, 3, "0", STR_PAD_LEFT) . '.html';
		$filePath = Yii::getAlias('@app') . '/storage/books/' . $filename;
		file_put_contents($filePath, $this['text']);
	}

	/**
	 * Gets query for [[Author]].
	 *
	 * @return ActiveQuery
	 */
	public function getAuthor(): ActiveQuery {
		return $this->hasOne(Author::className(), ['id' => 'author_id']);
	}

	/**
	 * Gets query for [[BookTags]].
	 *
	 * @return ActiveQuery
	 */
	public function getBookTags(): ActiveQuery {
		return $this->hasMany(BookTag::className(), ['book_id' => 'id']);
	}

	/**
	 * Gets query for [[Series]].
	 *
	 * @return ActiveQuery
	 */
	public function getSeries(): ActiveQuery {
		return $this->hasOne(Series::className(), ['id' => 'series_id']);
	}

	/**
	 * Gets query for [[Tags]].
	 *
	 * @return ActiveQuery
	 */
	public function getTags(): ActiveQuery {
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('book_tag', ['book_id' => 'id']);
	}

	/**
	 * Gets query for [[Image]].
	 *
	 * @return ActiveQuery
	 */
	public function getImages(): ActiveQuery {
		return $this->hasMany(Image::class, ['book_id' => 'id'])->orderBy(['file_name' => SORT_ASC]);
	}
}

