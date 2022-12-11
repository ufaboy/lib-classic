<?php

use app\assets\BookAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
BookAsset::register($this);
?>
<div class="book-view">
<!--    <p>
        <?/*= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>-->
    <div><?= $model->text ?></div>

<!--    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'text:ntext',
            'view_count',
            'rating',
            'bookmark',
            'source',
            'cover',
            'author_id',
            'series_id',
            'created_at',
            'updated_at',
            'last_read',
        ],
    ])-->

</div>
