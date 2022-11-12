<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\BadRequestHttpException;

class AuthController extends \yii\web\Controller {
	public function actionIndex() {
		return $this->render('index');
	}

	public function actionLogin() {
		$data = Yii::$app->request->post();
		if (!isset($data['username'], $data['password'])) {
			throw new BadRequestHttpException('Необходимо отправить логин и пароль.');
		}
		$identity = User::findByUsername($data['username']);

		if ($identity && $identity->validatePassword($data['password'])) {
			return [
				'username' => $identity->username,
				'role' => $identity->role,
				'token' => $identity->getToken()
			];
		}
		Yii::$app->response->setStatusCode(401);
		throw new BadRequestHttpException('invalid username or password');

	}

	public function actionSignin() {
		$data = Yii::$app->request->post();
		if (!isset($data['username'], $data['password'])) {
			throw new BadRequestHttpException('Необходимо отправить логин и пароль.');
		}
		$model = new User();
		$model->username = $data['username'];
		$model->setPassword($data['password']);
		$model->role = User::ROLE_READER;
		if ($model->save()) {
			return [
				'username' => $model->username,
				'role' => $model->role,
				'token' => $model->getToken()];
		}
		Yii::$app->response->setStatusCode(401);
		return ['message' => 'В доступе отказано'];
	}
}
