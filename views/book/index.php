<?php

use app\models\Author;
use app\models\Series;
use app\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\BookTableAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
BookTableAsset::register($this);

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $ratings = [
	1 => 'Bad',
	2 => 'Poor',
	3 => 'Fair',
	4 => 'Good',
	5 => 'Epic',
] ?>
<div class="book-index">
    <!--	--><?php //Pjax::begin(); ?>
    <!--	--><?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <!--	--><?php //echo $this->render('_sort_form', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'tableOptions' => [
			'class' => 'table table-bordered'
		],
		'summary' => '',
		'columns' => [
			[
				'label' => 'ID',
				'attribute' => 'id',
				'content' => function ($model, $key, $index, $column) {
					return Html::a($model->id, Url::to(['book/update', 'id' => $model->id]));
				},
			],
			[
				'label' => 'Name',
				'attribute' => 'name',
				/*				'content' => function ($model, $key, $index, $column) {
									return Html::a($model->name, Url::to(['book/view', 'id' => $model->id]));
								},*/
			],
			[
				'label' => 'Size',
				'attribute' => 'length',
				'value' => function ($model, $key, $index, $column) {
					if ($model->length < 50000) {
						return 'S';
					} elseif ($model->length < 300000) {
						return 'M';
					} elseif ($model->length < 800000) {
						return 'L';
					} else    return 'XL';
				},
//				'filterInputOptions' => ['prompt' => 'All', 'class' => 'form-control',],
				'filter' => ['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL']
			],
			[
				'label' => 'Description',
				'attribute' => 'description',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return [
							'title' => $model->description,
							'class' => [
								'text-truncate', 'w-20', 'mobile-hide'
							]];
					}
				},
				'headerOptions' => [
					'class' => 'mobile-hide'
				],
				'filterOptions' => [
					'class' => 'mobile-hide'
				],
			],
			[
				'label' => 'Tags',
				'attribute' => 'tags',
				'value' => function ($model) {
					$tagNames = array();
					foreach ($model->tags as $tag) {
						$tagNames[] = $tag->name;
					}
					return implode(', ', $tagNames);
				},
				'filterAttribute' => 'tag',
				'filter' => Tag::find()->select(['name', 'id'])->indexBy('id')->column(),
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label, 'prompt' => 'Select Tag'];
					}
				}
			],
			[
				'label' => 'Count',
				'attribute' => 'view_count',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Rating',
				'attribute' => 'rating',
				'filter' => $ratings,
				'value' => function ($model) {
					if ($model->rating === 5) {
						return 'Epic';
					} elseif ($model->rating === 4) {
						return 'Good';
					} elseif ($model->rating === 3) {
						return 'Fair';
					} elseif ($model->rating === 2) {
						return 'Poor';
					} elseif ($model->rating === 1) {
						return 'Bad';
					} else return '(not set)';
				},
				'contentOptions' => function ($model) {
					{
						if (!$model->rating) {
							return ['class' => 'not-set'];
						} else return [];
					}
				}
			],
			[
				'label' => 'Author',
				'attribute' => 'author.name',
				'filter' => Author::find()->select(['name'])->orderBy('name ASC')->indexBy('name')->column(),
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Series',
				'attribute' => 'series.name',
				'filter' => Series::find()->select(['name'])->orderBy('name ASC')->indexBy('name')->column(),
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Updated',
				'attribute' => 'updated_at',
				'format' => ['date', 'php:Y/m/d'],
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label, 'class' => 'text-nowrap'];
					}
				}
			],
			[
				'label' => 'Last read',
				'attribute' => 'last_read',
				'format' => ['date', 'php:Y/m/d'],
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label, 'class' => 'text-nowrap mobile-hide'];
					}
				},
				'headerOptions' => [
					'class' => 'mobile-hide'
				],
				'filterOptions' => [
					'class' => 'mobile-hide'
				],
			],
			/*			[
							'class' => ActionColumn::className(),
							'visibleButtons' => [
								'view' => false,
								'update' => true,
								'delete' => false
							],
							'urlCreator' => function ($action, $model, $key, $index, $column) {
								return Url::toRoute([$action, 'id' => $model->id]);
							}
						],*/
		],
	]); ?>
    <!--	--><?php //Pjax::end(); ?>

</div>
