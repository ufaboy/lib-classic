<?php

use app\assets\BookAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
YiiAsset::register($this);
BookAsset::register($this);
$this->registerJsVar('id', $model->id);
?>
<div id="book-view" class="book-view">
    <!--    <p>
        <?php /*= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */ ?>
        <?php /*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>-->
    <div id="text" class="text"><?= $model->text ?></div>
    <div class="bottom" :class="{active: bottomShow}" @click="bottomShow = true">
        <select v-model="chapterElement" @change="scrollToChapter">
            <option :value="chapter" v-for="(chapter, index) in headerChapters">{{chapter.name}}</option>
        </select>
    </div>
</div>
