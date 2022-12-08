<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

/**
 * BookSearch represents the model behind the search form of `app\models\Book`.
 */
class BookSearch extends Book {

	public function attributes() {
		return array_merge(parent::attributes(), ['author.name', 'series.name']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id', 'view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read'], 'integer'],
			[['name', 'description', 'text', 'source', 'cover', 'author.name', 'series.name'], 'safe'],
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
		/*        $query = Book::find()->select([
					'id', 'name', 'description', 'source', 'cover', 'view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read'
				]);*/
		$query = self::find();
		$query->joinWith('author');
		$query->joinWith('series');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'view_count' => $this->view_count,
			'rating' => $this->rating,
			'bookmark' => $this->bookmark,
			'author_id' => $this->author_id,
			'series_id' => $this->series_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'last_read' => $this->last_read,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'text', $this->text])
			->andFilterWhere(['like', 'source', $this->source])
			->andFilterWhere(['like', 'cover', $this->cover])
			->andFilterWhere(['like', 'author.name', $this->getAttribute('author.name')])
			->andFilterWhere(['like', 'series.name', $this->getAttribute('series.name')]);

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
