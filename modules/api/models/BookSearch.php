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
	public string $author_name = '';
	public string $series_name = '';

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
			[['name', 'description', 'text', 'source', 'cover', 'tag', 'author_name', 'series_name', 'author.name', 'series.name'], 'safe'],
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
				'pageSize' => $params['per-page'],
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

		// grid filtering conditions
		$query->andFilterWhere([
			'book.id' => $this->id,
			'book.view_count' => $this->view_count,
			'book.rating' => $this->rating,
			'book.bookmark' => $this->bookmark,
			'tag.name' => $this->tag,
//			'author.name' => $params['author.name'],
			'author.name' => $this->author_name,
			'series.name' => $this->series_name,
			'book.created_at' => $this->created_at,
			'book.updated_at' => $this->updated_at,
			'book.last_read' => $this->last_read,
		]);

		$query->andFilterWhere(['like', 'book.name', $this->name])
			->andFilterWhere(['like', 'book.description', $this->description])
			->andFilterWhere(['like', 'book.text', $this->text])
			->andFilterWhere(['like', 'book.source', $this->source])
			->andFilterWhere(['like', 'author.name', $this->getAttribute('author.name')])
			->andFilterWhere(['like', 'series.name', $this->getAttribute('series.name')]);

		$query->groupBy(['id']);
		$dataProvider->sort->attributes['tags'] = [
			'asc' => ['tag.name' => SORT_ASC],
			'desc' => ['tag.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['author.name'] = [
			'asc' => ['author.name' => SORT_ASC],
			'desc' => ['author.name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['series.name'] = [
			'asc' => ['series.name' => SORT_ASC],
			'desc' => ['series.name' => SORT_DESC],
		];
		return $dataProvider;
	}
}
