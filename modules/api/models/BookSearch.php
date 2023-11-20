<?php

namespace app\modules\api\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\api\models\Book;
use yii\db\Expression;

/**
 * BookSearch represents the model behind the search form of `app\modules\api\models\Book`.
 */
class BookSearch extends Book {
	public string $tag = '';
	public int|null $length = null;
	public string|null $size = null;
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
			'length',
			'updated_at',
			'last_read',
			'text_length'
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['id', 'view_count', 'rating', 'bookmark', 'author_id', 'series_id', 'created_at', 'updated_at', 'last_read', 'text_length'], 'integer'],
			[['name', 'description', 'text', 'source', 'cover', 'tag', 'authorName', 'seriesName', 'author.name', 'series.name', 'perPage', 'sort', 'page', 'size'], 'safe'],
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
		$sizeStart = null;
		$sizeLast = null;

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

		if ($this->size === 'S') {
			$sizeStart = 0;
			$sizeLast = 49999;
		} elseif ($this->size === 'M') {
			$sizeStart = 50000;
			$sizeLast = 299999;
		} elseif ($this->size === 'L') {
			$sizeStart = 300000;
			$sizeLast = 499999;
		} elseif ($this->size === 'XL') {
			$sizeStart = 500000;
			$sizeLast = 999999999;
		}

//		$query->select(["book.*", 'count("tag"."id") AS tag_count', 'LENGTH(book.text) as length']);
		$query->select(["book.id",
			'book.name',
			'book.description',
			'book.view_count',
			'book.rating',
			'book.cover',
			'book.author_id',
			'book.series_id',
			'book.updated_at',
			'book.last_read',
			'book.text_length']);

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
		$query->andFilterWhere(['like', 'book.name', $this->name])
			->andFilterWhere(['like', 'book.description', $this->description])
			->andFilterWhere(['like', 'book.text', $this->text])
			->andFilterWhere(['like', 'book.source', $this->source])
			->andFilterWhere(['like', 'author.name', $this->authorName])
			->andFilterWhere(['like', 'series.name', $this->seriesName]);

		$query->andFilterWhere([
			'between', 'book.text_length', $sizeStart, $sizeLast
		]);

		$query->groupBy(['book.id', 'author.name', 'series.name']);
		$dataProvider->sort->attributes['text_length'] = [
			'asc' => ['text_length' => SORT_ASC, 'book.id' => SORT_ASC],
			'desc' => ['text_length' => SORT_DESC, 'book.id' => SORT_DESC],
		];
//		$dataProvider->sort->attributes['tags'] = [
//			'asc' => [Tag::tableName() . '.name' => SORT_ASC, 'book.id' => SORT_ASC],
//			'desc' => [Tag::tableName() . '.name' => SORT_DESC, 'book.id' => SORT_DESC],
//		];
		$dataProvider->sort->attributes['author'] = [
			'asc' => ['author.name' => SORT_ASC, 'book.id' => SORT_ASC],
			'desc' => ['author.name' => SORT_DESC, 'book.id' => SORT_DESC],
		];
		$dataProvider->sort->attributes['series'] = [
			'asc' => ['series.name' => SORT_ASC, 'book.id' => SORT_ASC],
			'desc' => ['series.name' => SORT_DESC, 'book.id' => SORT_DESC],
		];
		$dataProvider->sort->attributes['rating'] = [
			'asc' => [new Expression('rating ASC'), 'book.id' => SORT_ASC],
			'desc' => [new Expression('rating DESC'), 'book.id' => SORT_DESC],
		];
		$dataProvider->sort->attributes['updated_at'] = [
			'asc' => [new Expression('updated_at ASC'), 'book.id' => SORT_ASC],
			'desc' => [new Expression('updated_at DESC'), 'book.id' => SORT_DESC],
		];
		$dataProvider->sort->attributes['view_count'] = [
			'asc' => [new Expression('view_count ASC'), 'book.id' => SORT_ASC],
			'desc' => [new Expression('view_count DESC'), 'book.id' => SORT_DESC],
		];
		$dataProvider->sort->attributes['last_read'] = [
			'asc' => [new Expression('last_read ASC'), 'book.id' => SORT_ASC],
			'desc' => [new Expression('last_read DESC'), 'book.id' => SORT_DESC],
		];
		return $dataProvider;
	}
}

/*$dataProvider->sort->attributes['rating'] = [
	'asc' => [new Expression('rating ASC NULLS FIRST'), 'book.id' => SORT_ASC],
	'desc' => [new Expression('rating DESC NULLS LAST'), 'book.id' => SORT_DESC],
];*/
