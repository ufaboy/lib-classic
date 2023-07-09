<?php

namespace app\modules\api\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\api\models\Book;

/**
 * BookSearch represents the model behind the search form of `app\modules\api\models\Book`.
 */
class BookSearch extends Book {
	public string $tag = '';
	public string $authorName = '';
	public string $seriesName = '';

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
			'description',
			'view_count',
			'rating',
			'cover',
			'tags',
			'author',
			'series',
			'updated_at',
			'last_read',
		];
	}
	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['id', 'view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read'], 'integer'],
			[['name', 'description', 'text', 'source', 'cover', 'tag', 'authorName', 'seriesName', 'author.name', 'series.name', 'perPage', 'sort', 'page'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = self::find();
		$query->joinWith('author');
		$query->joinWith('series');
		$query->joinWith('tags');

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
		$query->select(["book.*", 'count("tag"."id") AS tag_count']);

		$query->andFilterWhere([
			'book.id' => $this->id,
			'book.view_count' => $this->view_count,
			'book.rating' => $this->rating,
			'book.bookmark' => $this->bookmark,
			'tag.name' => $this->tag,

		]);
		$query->andFilterWhere([
			'>=', 'book.created_at', $this->created_at,
			'>=', 'book.updated_at', $this->updated_at,
			'>=', 'book.last_read', $this->last_read,
		]);
		$query->andFilterWhere(['ilike', 'book.name', $this->name])
			->andFilterWhere(['ilike', 'book.description', $this->description])
			->andFilterWhere(['ilike', 'book.text', $this->text])
			->andFilterWhere(['ilike', 'book.source', $this->source])
			->andFilterWhere(['ilike', 'author.name', $this->authorName])
			->andFilterWhere(['ilike', 'series.name', $this->seriesName]);

		$query->groupBy(['book.id', 'author.name', 'series.name']);
		$dataProvider->sort->attributes['tags'] = [
			'asc' => ['tag_count' => SORT_ASC],
			'desc' => ['tag_count' => SORT_DESC],
		];
		$dataProvider->sort->attributes['author'] = [
			'asc' => ['author.name' => SORT_ASC],
			'desc' => ['author.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['series'] = [
			'asc' => ['series.name' => SORT_ASC],
			'desc' => ['series.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['rating'] = [
			'asc' => [new \yii\db\Expression('rating ASC NULLS FIRST'),],
			'desc' => [new \yii\db\Expression('rating DESC NULLS LAST'),],
		];

		return $dataProvider;
	}
}
