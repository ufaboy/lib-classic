<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class VueAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $js = [
		'https://unpkg.com/petite-vue',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
/*	public $jsOptions = [
		'defer' => true,
		'init' => true,
	];*/
}
