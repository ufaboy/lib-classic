<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $sort yii\data\Sort */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-sort-layout">
    <div class="book-sort">
        <ul class="sort-list">
            <li class="sort-li"><?= $sort->link('id') ?></li>
            <li class="sort-li"><?= $sort->link('name') ?></li>
            <li class="sort-li"><?= $sort->link('length') ?></li>
            <li class="sort-li"><?= $sort->link('view_count') ?></li>
            <li class="sort-li"><?= $sort->link('rating') ?></li>
            <li class="sort-li"><?= $sort->link('updated_at') ?></li>
            <li class="sort-li"><?= $sort->link('last_read') ?></li>
        </ul>
		<?= Html::resetButton('Close', ['id' =>'btn-sort-reset', 'class' => 'btn btn-danger', ]) ?>
    </div>
</div>
