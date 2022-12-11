<?php

use app\models\Author;
use app\models\Series;
use app\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">
	<?=
	$tags = ArrayHelper::map(Tag::find()->select('id, name')->all(), 'id', 'name');
	$authors = ArrayHelper::map(Author::find()->select('id, name')->all(), 'id', 'name');
	$series = ArrayHelper::map(Series::find()->select('id, name')->all(), 'id', 'name');
	$ratings = [
		1 => 'Bad',
		2 => 'Poor',
		3 => 'Fair',
		4 => 'Good',
		5 => 'Excellent',
	]
	?>
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'rating')->dropdownList(
		$ratings, ['prompt' => 'Select Rating']
	) ?>

	<?= $form->field($model, 'bookmark')->textInput() ?>

	<?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'cover')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'tags')->dropdownList(
		$tags, ['prompt' => 'Select Tags', 'label' => 'name', 'multiple' => true,]
	) ?>

	<?= $form->field($model, 'author_id')->dropdownList(
		$authors, ['prompt' => 'Select Author', 'label' => 'name']
	) ?>

	<?= $form->field($model, 'series_id')->dropdownList(
		$series, ['prompt' => 'Select Series', 'label' => 'name']
	) ?>


    <div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
