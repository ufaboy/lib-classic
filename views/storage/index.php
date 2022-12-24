<?php

use app\models\Storage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\TableAsset;
/** @var yii\web\View $this */
/** @var app\models\StorageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Storages';
TableAsset::register($this);
?>
<div class="storage-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Storage', ['create'], ['class' => 'btn btn-success']) ?>
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
				'label' => 'Name',
				'attribute' => 'file_name',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Ext',
				'attribute' => 'extension',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Size',
				'attribute' => 'size',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Path',
				'attribute' => 'path',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
			[
				'label' => 'Book',
				'attribute' => 'book.name',
				'contentOptions' => function ($model, $key, $index, $column) {
					{
						return ['data-title' => $column->label];
					}
				}
			],
            //'book_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Storage $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
