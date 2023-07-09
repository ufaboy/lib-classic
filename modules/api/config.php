<?php

$db = require Yii::getAlias('@app/config/db.php');

$config = [
	'components' => [
		'user' => [
			'class' => 'yii\web\User',
			'identityClass' => 'app\modules\api\models\User',
			'enableAutoLogin' => true,
			'loginUrl' => ['auth/login'],
		],
		'log' => [
			'class' => 'yii\log\Dispatcher',
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $db,
		'request' => [
			'class' => 'yii\web\Request',
			'enableCookieValidation' => false,
			'enableCsrfValidation' => false,
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				['class' => 'yii\rest\UrlRule', 'controller' => 'auth'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'book'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'tag'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'author'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'series'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'image'],
			],
		]
	],
];
return $config;
