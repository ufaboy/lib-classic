<?php

namespace app\common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ImageSearch represents the model behind the search form of `app\models\Image`.
 */
class ImageSearch extends Image {
	public function attributes(): array {
		return array_merge(parent::attributes(), ['book.name']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['id', 'book_id'], 'integer'],
			[['file_name', 'path', 'book.name'], 'safe'],
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
	public function search($params): ActiveDataProvider {
		$query = Image::find();
//		$this::loadFilesFromFS();
		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
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
			'book_id' => $this->book_id,
		]);

		$query->andFilterWhere(['like', 'file_name', $this->file_name])
			->andFilterWhere(['like', 'path', $this->path])
			->andFilterWhere(['like', 'book.name', $this->getAttribute('book.name')]);
		$query->groupBy('image.id');
		$dataProvider->sort->attributes['book.name'] = [
			'asc' => ['book.name' => SORT_ASC],
			'desc' => ['book.name' => SORT_DESC],
		];
		return $dataProvider;
	}
}
