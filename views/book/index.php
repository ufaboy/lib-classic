<?php

use app\models\Author;
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
<div class="book-index">

    <p class="create-book-wrapper">
		<?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::button('Filter', ['id' => 'show-filter', 'class' => 'btn btn-info']) ?>
    </p>

	<?php Pjax::begin(); ?>
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<!--	--><?php //echo $this->render('_sort_form', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'tableOptions' => [
			'class' => 'table table-bordered'
		],
		'columns' => [
			[
				'label' => 'ID',
				'attribute' => 'id',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Name',
				'attribute' => 'name',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Description',
				'attribute' => 'description',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label,
							'class' => [
								'text-truncate', 'w-25', 'mobile-hide'
							]];
					}
				},
                'headerOptions' => [
					'class' => 'mobile-hide'
                ]
			],
			[
				'label' => 'Tags',
				'attribute' => 'tags',
				'value' => function($model) {
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
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'View Count',
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
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Author',
				'attribute' => 'author.name',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Series',
				'attribute' => 'series.name',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Updated',
				'attribute' => 'updated_at',
				'format' => ['date', 'php:Y-m-d'],
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Last read',
				'attribute' => 'last_read',
				'format' => ['date', 'php:Y-m-d'],
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label, 'class' => 'mobile-hide'];
					}
				},
				'headerOptions' => [
					'class' => 'mobile-hide'
				]
			],
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id' => $model->id]);
				}
			],
		],
	]); ?>
	<?php Pjax::end(); ?>

</div>
