<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Image $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="media-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

	<?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Submit</button>

	<?php ActiveForm::end() ?>

</div>
