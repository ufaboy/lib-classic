<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Upload */
/* @var $form yii\widgets\ActiveForm */
/* @var $book_id integer */
?>
<?php Pjax::begin([
    // Опции Pjax
    ]);
?>
<?php $form = ActiveForm::begin([
	'options' => ['enctype' => 'multipart/form-data', 'data' => ['pjax' => true]],
	'method' => 'post',
	'action' => [
		Url::to('upload'), 'book_id' => $book_id
	]
])
?>
<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>
<?php Pjax::end() ?>
