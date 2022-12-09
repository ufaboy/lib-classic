<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => 'favicon.svg']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
	$menuItems = [
		['label' => 'Tag', 'url' => ['/tag']],
		['label' => 'Author', 'url' => ['/author']],
		['label' => 'Series', 'url' => ['/series']],
		['label' => 'Book', 'url' => ['/book']],
	];
	if (Yii::$app->user->isGuest) {
		$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
	}
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
		'items' => $menuItems,
    ]);
	if (Yii::$app->user->isGuest) {
		echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
	} else {
		echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
			. Html::submitButton(
				'Logout (' . Yii::$app->user->identity->username . ')',
				['class' => 'btn btn-link logout text-decoration-none']
			)
			. Html::endForm();
	}
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
<!--        <?php /*if (!empty($this->params['breadcrumbs'])): */?>
            <?/*= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) */?>
        --><?php /*endif */?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!--<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?/*= date('Y') */?></div>
            <div class="col-md-6 text-center text-md-end"><?/*= Yii::powered() */?></div>
        </div>
    </div>
</footer>-->
<a id="scrollUp" href="#top" title="Scroll to top" style="position: fixed; z-index: 2147483647; display: block;"></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
