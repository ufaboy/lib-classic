<?php

use app\models\Author;
use app\models\Series;
use app\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use app\assets\BookMobileTableAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
BookMobileTableAsset::register($this);
$this->title = 'Books';
$bookModels = $dataProvider->getModels()

?>
<div id="mobile-book-table" class="mobile book-index">

<!--	--><?php //Pjax::begin(); ?>
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <!--    --><?php //echo VarDumper::dumpAsString($dataProvider); ?>
    <ul class="book-list">
		<?php foreach ($bookModels as $model): ?>
            <li>
                <div class="book">
                    <div class="preview">
						<?php if($model->cover) : ?>
                            <img src="<?= $model->cover;?>" alt="">
						<?php else : ?>
							<?php echo $this->render('_icon_book', ['model' => $searchModel]); ?>
						<?php endif; ?>
                    </div>
                    <div class="info">
                        <h5>
							<?=$model->name;?>
                        </h5>
                        <h6>
                            <?php $tagNames = array();
                            foreach ($model->tags as $tag) {
                            $tagNames[] = $tag->name;
                            }
                            echo implode(', ', $tagNames);
                            ?>
                        </h6>
                    </div>
                </div>
            </li>
		<?php endforeach;?>

    </ul>
    <?php echo LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
    ]); ?>
    <div id="observer"></div>
<!--	--><?php //Pjax::end(); ?>

</div>
