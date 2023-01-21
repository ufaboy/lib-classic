<?php

namespace app\modules\api\models;
use yii\filters\auth\HttpBearerAuth;

class User extends \app\common\models\User {
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::class,
		];
		return $behaviors;
	}
}
