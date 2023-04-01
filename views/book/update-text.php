<?php

use app\models\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\BookUpdateTextAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $uploadModel app\models\Upload */
BookUpdateTextAsset::register($this);
$uploadModel = new Upload;
$this->registerJsVar('book', $model);
$this->registerJsVar('images', $model->images);
?>
<?php
$form = ActiveForm::begin([
	'id' => 'bookForm',
	'options' => ['class' => 'form-horizontal'],
]) ?>
<?= $form->field($model, 'text')->textInput(['hidden' => true])->label('', ['hidden' => true]) ?>
<button id="form-send-btn" type="submit" hidden=""></button>

<div class="form-group">
	<?= Html::submitButton('Save', [ 'id' => 'book-save-btn', 'class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>
<div id="book-update-text" class="book-update-text">
    <div id="text" class="text" contenteditable="true" @drop="dropHandler"><?= $model->text ?></div>
</div>
