<?php

use app\assets\UploadAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Image $model */
UploadAsset::register($this);
$this->title = 'Update Image: ' . $model->id;
$this->registerJsVar('imageSrc', $model->path . '/' . $model->file_name);
?>
<div id="image-update" class="image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <form method="post" action="/upload/single" enctype="multipart/form-data" @submit.prevent="uploadFile">
        <label class="upload-btn">
            <span>Load images</span>
            <input type="file" hidden name="Upload[imageFile]" @input="inputFile"
                   accept="image/png, image/jpeg, image/webp">
        </label>
        <button class="upload-btn">Upload</button>
    </form>
    <img id="upload-preview" style="max-height: calc(100vh - 150px)" :src="getUrl(image)" class="preview">
</div>
