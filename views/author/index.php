<?php

use app\assets\TableAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
TableAsset::register($this);
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?php Pjax::begin(); ?>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
				'attribute' => 'name',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'attribute' => 'url',
				'format' => 'url',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
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
