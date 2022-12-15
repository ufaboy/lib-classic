<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
			'class' => 'form-book'
        ],
    ]); ?>
	<?php $ratings = [
    1 => 'Bad',
    2 => 'Poor',
    3 => 'Fair',
    4 => 'Good',
    5 => 'Excellent',
    ] ?>
	<?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

    <?php // $form->field($model, 'description') ?>

    <?php // $form->field($model, 'text') ?>

    <?= $form->field($model, 'view_count') ?>

    <?php  echo $form->field($model, 'rating')->dropdownList(
		$ratings, ['prompt' => 'Select Rating']
	) ?>

    <?php  echo $form->field($model, 'tag_name') ?>

    <?php // echo $form->field($model, 'bookmark') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'cover') ?>

    <?php echo $form->field($model, 'author.name')->label('Author') ?>

    <?php echo $form->field($model, 'series.name')->label('Series') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'last_read') ?>

    <div class="form-group actions">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
