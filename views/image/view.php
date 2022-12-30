<?php

use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Image $model */

$this->title = $model->id;
YiiAsset::register($this);
?>
<div class="media-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <img style="height: calc(100vh - 150px)" src="<?= '/' . $model->path . '/' . $model->file_name ?>" alt="">

</div>
