<?php

namespace app\modules\api;

/**
 * api module definition class
 */
class Module extends \yii\base\Module {
	/**
	 * {@inheritdoc}
	 */
	public $controllerNamespace = 'app\modules\api\controllers';

	/**
	 *
	 * {@inheritdoc}
	 */
	public function init() {
		parent::init();
		\Yii::$app->user->enableSession = false;
// инициализация модуля с помощью конфигурации, загруженной из config.php
		\Yii::configure($this, require __DIR__ . '/config.php');
	}
}
