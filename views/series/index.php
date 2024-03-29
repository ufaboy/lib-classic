<?php

use app\assets\TableAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SeriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
TableAsset::register($this);
$this->title = 'Series';
TableAsset::register($this);
?>
<div class="series-index">
    <p>
        <?= Html::a('Create Series', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'pager' => [
			'firstPageLabel' => 'First',
			'lastPageLabel'  => 'Last'
		],
		'tableOptions' => [
			'class' => 'table table-mobile table-bordered'
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
				'label' => 'Url',
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
