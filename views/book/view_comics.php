<?php

use yii\web\YiiAsset;
use app\assets\ComicsAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
YiiAsset::register($this);
ComicsAsset::register($this);
$this->registerJsVar('id', $model->id);
?>
<div class="comics-view">
	<?php foreach ($model->medias as $key => $media): ?>
        <img src="<?= '/' . $media->path . '/' . $media->file_name; ?>" class="comics-image">
	<?php endforeach; ?>
</div>
