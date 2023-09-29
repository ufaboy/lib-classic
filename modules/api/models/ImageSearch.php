<?php

namespace app\modules\api\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\api\models\Image;
use Yii;
use yii\helpers\VarDumper;

class ImageSearch extends Image {
    public string $bookName = '';

	public function attributes(): array {
		return array_merge(parent::attributes(), ['book.name']);
	}

    public function fields(): array {
		return [
			'id',
			'file_name',
			'path',
			'book_id',
		];
	}
    public function extraFields() {
		return [
			'book',
		];
	}
	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['id', 'book_id'], 'integer'],
			[['file_name', 'book_id', 'path', 'bookName', 'book.name'], 'safe'],
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
		$query = self::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$query->joinWith([
			'book' => function ($query) {
				$query->select(['id', 'name']); // Укажите нужные вам столбцы
			},
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
			'book_id' => $this->book_id,
		]);
        $query->andFilterWhere(
            ['ilike', 'book.name', $this->bookName]
        );
		$query->andFilterWhere(['ilike', 'file_name', $this->file_name])
			->andFilterWhere(['ilike', 'path', $this->path])
			->andFilterWhere(['ilike', 'book.name', $this->getAttribute('book.name')]);

		$query->groupBy('image.id');

		$dataProvider->sort->attributes['book.name'] = [
			'asc' => ['book.name' => SORT_ASC],
			'desc' => ['book.name' => SORT_DESC],
		];
		return $dataProvider;
	}
}
