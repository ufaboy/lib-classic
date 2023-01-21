<?php

$db = require Yii::getAlias('@app/config/db.php');

$config = [
	'components' => [
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
			'loginUrl' => ['auth/login'],
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $db,

		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'book'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'tag'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'author'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'series'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'image'],
			],
		]
	],
];
