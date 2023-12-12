<?php

namespace app\modules\api\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Author {
	public $sort;
	public $perPage = 10;
	public $page = 1;
	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['id'], 'integer'],
			[['name', 'url', 'perPage', 'sort', 'page'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios(): array {
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
	public function search(array $params): ActiveDataProvider {
		$query = Author::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => $params['perPage'],
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
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
			'id' => $this->id,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'url', $this->url]);

		return $dataProvider;
	}
}
