<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Storage;

/**
 * StorageSearch represents the model behind the search form of `app\models\Storage`.
 */
class StorageSearch extends Storage {
	public function attributes() {
		// делаем поле зависимости доступным для поиска
		return array_merge(parent::attributes(), ['book.name']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id', 'size', 'book_id'], 'integer'],
			[['file_name', 'extension', 'path', 'book.name'], 'safe'],
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
		$query = Storage::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
//		$query->joinWith(['book' => function($query) { $query->from(['book' => 'book']); }]);
		$query->joinWith('book');

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'size' => $this->size,
			'book_id' => $this->book_id,
		]);

		$query->andFilterWhere(['like', 'file_name', $this->file_name])
			->andFilterWhere(['like', 'extension', $this->extension])
			->andFilterWhere(['like', 'path', $this->path])
			->andFilterWhere(['LIKE', 'book.name', $this->getAttribute('book.name')]);

		$dataProvider->sort->attributes['book.name'] = [
			'asc' => ['book.name' => SORT_ASC],
			'desc' => ['book.name' => SORT_DESC],
		];
		return $dataProvider;
	}
}
