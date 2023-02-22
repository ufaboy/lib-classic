<?php

use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use app\assets\BookMobileTableAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
BookMobileTableAsset::register($this);
$this->title = 'Books';
$bookModels = $dataProvider->getModels();
$this->registerJsVar('count', $dataProvider->getCount());
?>
<div id="mobile-book-table" class="mobile book-index">

<!--	--><?php //Pjax::begin(); ?>
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php echo $this->render('_sort', ['model' => $searchModel, 'sort' => $dataProvider->sort]); ?>
    <ul class="book-list">
		<?php foreach ($bookModels as $index => $model): ?>
            <li>
                <div class="book">
                    <label class="preview" for="<?= $model->id;?>">
						<?php if($model->cover) : ?>
                            <img src="<?= $model->cover;?>" alt="">
						<?php else : ?>
							<?php echo $this->render('_icon_book', ['model' => $model]); ?>
						<?php endif; ?>
                    </label>
                    <input type="checkbox" hidden id="<?= $model->id;?>">
                    <a href="/book/view?id=<?= $model->id ?>" class="info">
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
                        <div class="info-collapsed">
                            <p>
                                <span>Rating:
                                <?php if($model->rating) : ?>
									<?= $model->rating;?>
								<?php else : ?>
                                    none
								<?php endif; ?>
                            </span>
                                <span>Count: <?= $model->view_count ?></span>
                            </p>
                            <p class="description">
								<?=$model->description;?>
                            </p>
                        </div>
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
