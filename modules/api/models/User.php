<?php

namespace app\modules\api\models;

use Yii;
use yii\filters\auth\HttpBearerAuth;

class User extends \app\common\models\User {
	public function behaviors()	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::class,
		];
		return $behaviors;
	}
	public function getToken() {
		$this->access_token = Yii::$app->getSecurity()->generateRandomString();
		$this->save();
		return $this->access_token;
	}
}
