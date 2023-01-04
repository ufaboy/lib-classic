<?php

use app\models\Author;
use app\models\Series;
use app\models\Tag;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
/* @var $ratings array */
?>
<?php
$ratings = [
	1 => 'Bad',
	2 => 'Poor',
	3 => 'Fair',
	4 => 'Good',
	5 => 'Excellent',
]
?>
<div class="book-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'rating')->dropdownList(
		$ratings, ['prompt' => 'Select Rating']
	) ?>

	<?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'cover')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'tag_ids')->dropdownList(
		Tag::find()->select(['name', 'id'])->orderBy('name ASC')->indexBy('id')->column(),
        ['prompt' => 'Select Tags', 'label' => 'name', 'multiple' => true,]
	) ?>

	<?= $form->field($model, 'author_id')->dropdownList(
		Author::find()->select(['name', 'id'])->orderBy('name ASC')->indexBy('id')->column(),
        ['prompt' => 'Select Author', 'label' => 'name']
	) ?>

	<?= $form->field($model, 'series_id')->dropdownList(
		Series::find()->select(['name', 'id'])->orderBy('name ASC')->indexBy('id')->column(),
        ['prompt' => 'Select Series', 'label' => 'name']
	) ?>


    <div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
