<?php

namespace app\modules\api\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
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
 * @property Tag[]|null $tag_ids
 */
class BookImages extends Book {
	public $sort;
	public $perPage = 10;
	public $page = 1;

	public function attributes(): array {
		return array_merge(parent::attributes(), ['author.name', 'series.name']);
	}
	public function fields(): array {
		return [
			'id',
			'name',
			'images',
		];
	}
	public function rules(): array {
		return [
			[['id', 'view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read'], 'integer'],
			[['name', 'description', 'text', 'source', 'cover', 'tag', 'authorName', 'seriesName', 'author.name', 'series.name', 'perPage', 'sort', 'page'], 'safe'],
		];
	}
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}
	public function search($params) {
		$query = self::find();
		$query->joinWith('images');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => $params['perPage'],
			],
			'sort' => [
				'defaultOrder' => [
					'updated_at' => SORT_DESC,
				],
			],
		]);

		$this->load($params, '');

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
//		$query->select(["book.*"]);
		$query->where(['not', ['image.id' => null]]);
		$query->andFilterWhere([
			'book.id' => $this->id,
		]);

		$query->andFilterWhere(['ilike', 'book.name', $this->name]);

		$query->groupBy(['book.id', ]);

		return $dataProvider;
	}
}

