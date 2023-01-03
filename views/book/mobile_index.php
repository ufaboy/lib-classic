<?php

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
    <ul class="book-list">
		<?php foreach ($bookModels as $model): ?>
            <li>
                <a href="/book/view?id=<?= $model->id ?>" class="book">
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
                </a>
            </li>
		<?php endforeach;?>

    </ul>
    <?php echo LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
    ]); ?>
    <div id="observer"></div>
<!--	--><?php //Pjax::end(); ?>

</div>
