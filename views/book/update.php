<?php

use app\models\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\BookUpdateAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $uploadModel app\models\Upload */
BookUpdateAsset::register($this);
$uploadModel = new Upload;
$this->registerJsVar('storages', $model->storages);
?>
<div class="book-update">
    <div class="left">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
    </div>
    <div id="storage-manager" class="right" v-scope="">
<!--		--><?php /*$this->render('@app/views/storage/upload', [
			'book_id' => $model->id,
			'model' => $uploadModel,
		]) */?>
<!--		<?php /*$form = ActiveForm::begin(['action' => '/upload', 'options' => ['enctype' => 'multipart/form-data']]) */?>

		<?/*= $form->field($uploadModel, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) */?>

        <button>Submit</button>

		--><?php /*ActiveForm::end() */?>
        <form method="post" enctype="multipart/form-data" @submit.prevent="uploadFiles">
            <label class="upload-btn" >
                <span>Load images</span>
                <input type="file" multiple hidden name="Upload[imageFiles][]" @input="inputFiles"
                       accept="image/png, image/jpeg, image/webp">
            </label>
            <button class="upload-btn">Upload</button>
        </form>
        <div class="images-wrapper">
            <ol class="images">
                <li v-for="(image, index) in images" :key="index" class="image-element">
                    <button class="copy-btn btn"
                            :class="{'btn-outline-primary': !image.id, 'btn-outline-success': image.id }"
                            @click="copyUrl(image)">{{getName(image)}}</button>
                    <img :src="getUrl(image)" class="preview">
                </li>
            </ol>
        </div>
    </div>


</div>
